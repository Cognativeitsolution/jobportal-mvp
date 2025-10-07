<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Subscription;
use App\Models\Deposit;
use App\Models\Visitor;
use App\Models\Employer;
use App\Models\Industry;
use App\Models\JobApply;
use App\Constants\Status;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\NotificationLog;
use App\Rules\FileTypeValidate;
use App\Models\NumberOfEmployees;
use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;

class ManageEmployeeController extends Controller
{
    public function all()
    {
        $pageTitle = 'All Employers';
        $employers = $this->employerData();
        return view('admin.employers.list', compact('pageTitle', 'employers'));
    }

    public function active()
    {
        $pageTitle = 'Active Employers';
        $employers = $this->employerData('active');
        return view('admin.employers.list', compact('pageTitle', 'employers'));
    }
    public function banned()
    {
        $pageTitle = 'Banned Employers';
        $employers = $this->employerData('banned');
        return view('admin.employers.list', compact('pageTitle', 'employers'));
    }

    public function emailUnverified()
    {
        $pageTitle = 'Email Unverified Employers';
        $employers = $this->employerData('emailUnverified');
        return view('admin.employers.list', compact('pageTitle', 'employers'));
    }

    public function mobileUnverified()
    {
        $pageTitle = 'Mobile Unverified Employers';
        $employers = $this->employerData('mobileUnverified');
        return view('admin.employers.list', compact('pageTitle', 'employers'));
    }
    public function withBalance()
    {
        $pageTitle = 'Employers With Balance';
        $employers = $this->employerData('withBalance');
        return view('admin.employers.list', compact('pageTitle', 'employers'));
    }

    public function detail($id)
    {
        $employer = Employer::findOrFail($id);
        $pageTitle = 'Employer Detail - ' . $employer->company_name;
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $industries = Industry::active()->get();
        $numberOfEmployees = NumberOfEmployees::active()->get();
        $subscription = Subscription::where('employer_id', $employer->id)->where('status', Status::SUBSCRIPTION_APPROVED)->with('plan')->first();

        $widget['successful_deposit'] = Deposit::successful()->where('employer_id', $employer->id)->sum('final_amount');
        $widget['pending_deposit']    = Deposit::pending()->where('employer_id', $employer->id)->sum('final_amount');
        $widget['total_transaction']  = $employer->transactions->count();
        $widget['total_job']          = Job::where('employer_id', $employer->id)->count();
        $widget['pending_job']        = Job::pending()->where('employer_id', $employer->id)->count();
        $widget['approved_job']       = Job::approved()->where('employer_id', $employer->id)->count();
        $widget['rejected_job']       = Job::rejected()->where('employer_id', $employer->id)->count();
        $widget['total_visitor']      = Visitor::employerVisitor($employer->id)->sum('count');
        $widget['total_applicants']   = JobApply::employerTotalApplicants($employer->id);
        $widget['total_ticket']       = SupportTicket::where('employer_id', $employer->id)->count();
        $widget['subscribed_plan']    = @$subscription->plan->name ?? 'N/A';

        return view('admin.employers.detail', compact('pageTitle', 'employer', 'countries', 'industries', 'widget', 'numberOfEmployees'));
    }

    private function employerData($scope = null)
    {
        $employers = $scope ? Employer::$scope() : Employer::query();
        return $employers->searchable(['username', 'email', 'mobile', 'company_name'])->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function update(Request $request, $id)
    {
        $employer    = Employer::findOrFail($id);
        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array) $countryData;
        $countries    = implode(',', array_keys($countryArray));

        $request->validate([
            'company_name'        => 'required|max:40',
            'company_ceo'         => 'required|max:50',
            'email'               => 'required|email|max:90|unique:employers,email,' . $employer->id,
            'mobile'              => 'required|unique:employers,mobile,' . $employer->id,
            'website'             => 'nullable|url',
            'fax'                 => 'nullable|unique:employers,fax,' . $employer->id,
            'industry'            => 'nullable|exists:industries,id',
            'number_of_employees' => 'nullable|exists:number_of_employees,id',
            'founding_date'       => 'nullable',
            'description'         => 'nullable',
            'address'             => 'nullable|string',
            'city'                => 'nullable|string',
            'state'               => 'nullable|string',
            'zip'                 => 'nullable|string',
            'country'             => 'required|in:' . $countries,
            'social_media'        => 'nullable|array',
            'social_media.*.'     => 'nullable|url',
        ]);

        $employer->company_name           = $request->company_name;
        $employer->ceo_name               = $request->company_ceo;
        $employer->email                  = $request->email;
        $employer->mobile                 = $request->mobile;
        $employer->website                = $request->website;
        $employer->fax                    = $request->fax;
        $employer->industry_id            = $request->industry;
        $employer->number_of_employees_id = $request->number_of_employees;
        $employer->founding_date          = Carbon::parse($request->founding_date);
        $employer->address                = $request->address;
        $employer->city                   = $request->city;
        $employer->state                  = $request->state;
        $employer->zip                    = $request->zip;
        $employer->country_code           = $request->country;
        $employer->social_media           = $request->social_media ?? null;
        $employer->description            = $request->description;
        $employer->ev                     = $request->ev ? Status::YES : Status::NO;
        $employer->sv                     = $request->sv ? Status::YES : Status::NO;
        $employer->ts                     = $request->ts ? Status::YES : Status::NO;
        $employer->save();

        $notify[] = ['success', 'Employer profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function status(Request $request, $id)
    {
        $employer = Employer::findOrFail($id);

        if ($employer->status == Status::EMPLOYER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $employer->status     = Status::EMPLOYER_BAN;
            $employer->ban_reason = $request->reason;
            $notify[] = ['success', 'Employer banned successfully.'];
        } else {
            $employer->status     = Status::EMPLOYER_ACTIVE;
            $employer->ban_reason = null;
            $notify[] = ['success', 'Employer unbanned successfully.'];
        }
        $employer->save();
        return back()->withNotify($notify);
    }

    public function login($id)
    {
        $employer = Employer::findOrFail($id);
        if (auth()->check()) {
            auth()->guard('web')->logout();
        }
        auth()->guard('employer')->loginUsingId($employer->id);
        return to_route('employer.home');
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act'    => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $employer = Employer::findOrFail($id);
        $amount   = $request->amount;

        $general  = gs();
        $trx      = getTrx();

        $transaction = new Transaction();
        if ($request->act == 'add') {
            $employer->balance     += $amount;

            $transaction->trx_type = '+';
            $transaction->remark   = 'balance_add';
            $notifyTemplate        = 'BAL_ADD';

            $notify[] = ['success', $general->cur_sym . $amount . ' added successfully'];
        } else {
            if ($amount > $employer->balance) {
                $notify[] = ['error', $employer->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $employer->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark   = 'balance_subtract';
            $notifyTemplate        = 'BAL_SUB';

            $notify[] = ['success', $general->cur_sym . $amount . ' subtracted successfully'];
        }

        $employer->save();

        $transaction->employer_id  = $employer->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $employer->balance;
        $transaction->charge       = 0;
        $transaction->trx          = $trx;
        $transaction->details      = $request->remark;
        $transaction->save();

        notify($employer, $notifyTemplate, [
            'trx'          => $trx,
            'amount'       => showAmount($amount),
            'remark'       => $request->remark,
            'post_balance' => showAmount($employer->balance)
        ]);

        return back()->withNotify($notify);
    }

    public function notificationLog($id)
    {
        $employer  = Employer::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $employer->username;
        $logs      = NotificationLog::where('employer_id', $id)->with('user', 'employer')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'employer'));
    }

    public function showNotificationSingleForm($id)
    {
        $employer = Employer::findOrFail($id);
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.employers.detail', $employer->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $employer->username;
        return view('admin.employers.notification_single', compact('pageTitle', 'employer'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
            'via'     => 'required|in:email,sms,push',
            'subject' => 'required_if:via,email,push',
            'image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $imageUrl = null;
        if ($request->via == 'push' && $request->hasFile('image')) {
            $imageUrl = fileUploader($request->image, getFilePath('push'));
        }

        $template = NotificationTemplate::where('act', 'DEFAULT')->where($request->via . '_status', Status::ENABLE)->exists();
        if (!$template) {
            $notify[] = ['warning', 'Default notification template is not enabled'];
            return back()->withNotify($notify);
        }

        $employer = Employer::findOrFail($id);
        notify($employer, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ], [$request->via], pushImage: $imageUrl);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToEmployer = Employer::notifyToEmployer();
        $employers        = Employer::active()->count();
        $pageTitle    = 'Notification to Verified Employers';

        if (session()->has('SEND_NOTIFICATION') && !request()->email_sent) {
            session()->forget('SEND_NOTIFICATION');
        }

        return view('admin.employers.notification_all', compact('pageTitle', 'employers', 'notifyToEmployer'));
    }

    public function sendNotificationAll(Request $request)
    {
        $request->validate([
            'via'                          => 'required|in:email,sms,push',
            'message'                      => 'required',
            'subject'                      => 'required_if:via,email,push',
            'start'                        => 'required|integer|gte:1',
            'batch'                        => 'required|integer|gte:1',
            'being_sent_to'                => 'required',
            'cooling_time'                 => 'required|integer|gte:1',
            'number_of_top_deposited_user' => 'required_if:being_sent_to,topDepositedUsers|integer|gte:0',
            'number_of_days'               => 'required_if:being_sent_to,notLoginUsers|integer|gte:0',
            'image'                        => ["nullable", 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'number_of_days.required_if'               => "Number of days field is required",
            'number_of_top_deposited_user.required_if' => "Number of top deposited user field is required",
        ]);

        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $template = NotificationTemplate::where('act', 'DEFAULT')->where($request->via . '_status', Status::ENABLE)->exists();
        if (!$template) {
            $notify[] = ['warning', 'Default notification template is not enabled'];
            return back()->withNotify($notify);
        }

        if ($request->being_sent_to == 'selectedUsers') {
            if (session()->has("SEND_NOTIFICATION")) {
                $request->merge(['user' => session()->get('SEND_NOTIFICATION')['user']]);
            } else {
                if (!$request->user || !is_array($request->user) || empty($request->user)) {
                    $notify[] = ['error', "Ensure that the user field is populated when sending an email to the designated user group"];
                    return back()->withNotify($notify);
                }
            }
        }

        $scope          = $request->being_sent_to;
        $employerQuery      = Employer::oldest()->active()->$scope();

        if (session()->has("SEND_NOTIFICATION")) {
            $totalEmployerCount = session('SEND_NOTIFICATION')['total_employer'];
        } else {
            $totalEmployerCount = (clone $employerQuery)->count() - ($request->start - 1);
        }


        if ($totalEmployerCount <= 0) {
            $notify[] = ['error', "Notification recipients were not found among the selected user base."];
            return back()->withNotify($notify);
        }

        $imageUrl = null;

        if ($request->via == 'push' && $request->hasFile('image')) {
            if (session()->has("SEND_NOTIFICATION")) {
                $request->merge(['image' => session()->get('SEND_NOTIFICATION')['image']]);
            }
            if ($request->hasFile("image")) {
                $imageUrl = fileUploader($request->image, getFilePath('push'));
            }
        }

        $employers = (clone $employerQuery)->skip($request->start - 1)->limit($request->batch)->get();
        foreach ($employers as $user) {
            notify($user, 'DEFAULT', [
                'subject' => $request->subject,
                'message' => $request->message,
            ], [$request->via], pushImage: $imageUrl);
        }

        return $this->sessionForNotification($totalEmployerCount, $request);
    }

    private function sessionForNotification($totalEmployerCount, $request)
    {
        if (session()->has('SEND_NOTIFICATION')) {
            $sessionData                = session("SEND_NOTIFICATION");
            $sessionData['total_sent'] += $sessionData['batch'];
        } else {
            $sessionData               = $request->except('_token');
            $sessionData['total_sent'] = $request->batch;
            $sessionData['total_employer'] = $totalEmployerCount;
        }

        $sessionData['start'] = $sessionData['total_sent'] + 1;

        if ($sessionData['total_sent'] >= $totalEmployerCount) {
            session()->forget("SEND_NOTIFICATION");
            $message = ucfirst($request->via) . " notifications were sent successfully";
            $url     = route("admin.employers.notification.all");
        } else {
            session()->put('SEND_NOTIFICATION', $sessionData);
            $message = $sessionData['total_sent'] . " " . $sessionData['via'] . "  notifications were sent successfully";
            $url     = route("admin.employers.notification.all") . "?email_sent=yes";
        }
        $notify[] = ['success', $message];
        return redirect($url)->withNotify($notify);
    }

    public function countBySegment($methodName)
    {
        return Employer::active()->$methodName()->count();
    }

    public function list()
    {
        $query = Employer::active();

        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%')->orWhere('username', 'like', '%' . request()->search . '%');
            });
        }
        $employers = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'success' => true,
            'employers'   => $employers,
            'more'    => $employers->hasMorePages()
        ]);
    }

    public function featuredEmployer($id)
    {
        return Employer::changeStatus($id, 'is_featured');
    }
}
