<?php

namespace App\Http\Controllers\Employer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\GoogleAuthenticator;
use App\Models\DeviceToken;
use App\Models\FavoriteItem;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployerController extends Controller {
    public function home() {
        $pageTitle                    = "Employer Dashboard";
        $employer                     = authUser('employer');
        $widget['total_job']          = Job::where('employer_id', $employer->id)->count();
        $widget['pending_job']        = Job::pending()->where('employer_id', $employer->id)->count();
        $widget['approved_job']       = Job::approved()->where('employer_id', $employer->id)->count();
        $widget['rejected_job']       = Job::rejected()->where('employer_id', $employer->id)->count();
        $widget['total_applicants']   = JobApply::employerTotalApplicants(authUser('employer')->id);
        $widget['total_transactions'] = Transaction::where('employer_id', $employer->id)->count();
        $widget['total_visitor']      = Visitor::employerVisitor($employer->id)->sum('count');
        $widget['total_favorites']    = FavoriteItem::whereHasEmployerJob($employer->id)->count();

        $jobs             = Job::approved()->where('employer_id', $employer->id)->orderByDesc('id')->get();
        $recentApplicants = JobApply::checkEmployerJobs($employer->id)->with('job', 'user')->orderByDesc('id')->limit(6)->get();

        return view('Template::employer.dashboard', compact('pageTitle', 'employer', 'widget', 'jobs', 'recentApplicants'));
    }

    public function depositHistory(Request $request) {
        $pageTitle = 'Payment History';
        $deposits  = authUser('employer')->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::employer.payment_history', compact('pageTitle', 'deposits'));
    }
    public function visitorChart() {
        $visitor = Visitor::whereHas('job', function ($job) {
            $job->where('id', request('id'))->approved();
        })->get();
        $data = [];
        foreach ($visitor as $date) {
            $data[] = [
                'categories' => $date->date,
                'values'     => $date->count,
            ];
        }

        $data                 = collect($data);
        $report['categories'] = $data->pluck('categories');
        $report['values']     = [
            [
                'data' => $data->pluck('values'),
            ],
        ];
        return response()->json($report);
    }

    public function show2faForm() {
        $general   = gs();
        $ga        = new GoogleAuthenticator();
        $employer  = authUser('employer');
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($employer->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view('Template::employer.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl', 'employer'));
    }

    public function create2fa(Request $request) {
        $request->validate([
            'key'  => 'required',
            'code' => 'required',
        ]);

        $user     = authUser('employer');
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request) {
        $request->validate([
            'code' => 'required',
        ]);

        $user     = authUser('employer');
        $response = verifyG2fa($user, $request->code);

        if ($response) {
            $user->tsc = null;
            $user->ts  = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function userData() {
        $employer = authUser('employer');
        if ($employer->profile_complete == Status::YES) {
            return to_route('employer.home');
        }
        $pageTitle  = 'Employer Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('Template::employer.employer_data', compact('pageTitle', 'employer', 'countries', 'mobileCode', 'info'));
    }
    public function userDataSubmit(Request $request) {
        $employer = authUser('employer');
        if ($employer->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'company_name' => 'required',
            'slug'         => 'required|string|max:255',
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $employer->country_code     = $request->country_code;
        $employer->mobile           = $request->mobile;
        $employer->username         = $request->username;
        $employer->address          = $request->address;
        $employer->city             = $request->city;
        $employer->state            = $request->state;
        $employer->zip              = $request->zip;
        $employer->country_name     = @$request->country;
        $employer->dial_code        = $request->mobile_code;
        $employer->profile_complete = Status::YES;
        $employer->company_name     = $request->company_name;
        $employer->slug             = $request->slug;
        $employer->save();

        return to_route('employer.home');
    }

    public function transactions(Request $request) {
        $pageTitle    = 'Transactions';
        $remarks      = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('employer_id', auth()->guard('employer')->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::employer.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function addDeviceToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('employer_id', auth()->guard('employer')->id())->where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken              = new DeviceToken();
        $deviceToken->employer_id = authUser('employer')->id;
        $deviceToken->token       = $request->token;
        $deviceToken->is_app      = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function applications() {
        $pageTitle   = 'All Applications';
        $appliedJobs = JobApply::checkEmployerJobs(authUser('employer')->id)
            ->searchable(['user:username'])
            ->filter(['job_id'])
            ->with('user', 'job')
            ->paginate(getPaginate());
        $jobList = Job::approved()->where('employer_id', authUser('employer')->id)->get();
        return view('Template::employer.applications', compact('pageTitle', 'appliedJobs', 'jobList'));
    }

    public function applicantDetails($id) {
        $user = User::find($id);

        $view = view('Template::partials.applicant_profile', compact('user'))->render();
        return response()->json(['view' => $view]);
    }

    public function attachmentDownload($fileHash) {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title     = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }
}
