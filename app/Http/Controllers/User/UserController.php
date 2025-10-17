<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\GoogleAuthenticator;
use App\Models\DeviceToken;
use App\Models\Employer;
use App\Models\FavoriteItem;
use App\Models\Frontend;
use App\Models\Job;
use App\Models\JobApply;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle       = 'Dashboard';
        $user            = authUser();
        $blogs           = Frontend::where('data_keys', 'blog.element')->take(10)->orderByDesc('id')->get();
        $recommendedJobs = Job::active()->approved();
        $topCompanies    = Employer::active();
        if ($user->industry_id) {
            $recommendedJobs = $recommendedJobs->whereHas('employer', function ($employer) {
                $employer->where('industry_id', authUser()->industry_id);
            });
            $topCompanies = $topCompanies->where('industry_id', $user->industry_id);
        }
        $recommendedJobs = $recommendedJobs->with('employer', 'type', 'city', 'location', 'role')
            ->orderByDesc('id')
            ->take(10)
            ->get();
        $topCompanies = $topCompanies->take(10)->orderByDesc('id')->get();
        return view('Template::user.dashboard', compact('pageTitle', 'recommendedJobs', 'blogs', 'topCompanies'));
    }

    public function show2faForm()
    {
        $ga        = new GoogleAuthenticator();
        $user      = authUser();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Security';
        return view('Template::user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = authUser();
        $request->validate([
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $user     = authUser();
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

    public function userData()
    {
        $user = authUser();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = authUser();
        if ($user->profile_complete == Status::YES) {
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
            'mobile'       => ['required', 'regex:/^([0-9]*)$/', Rule::unique('users')->where('dial_code', $request->mobile_code)],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code     = $request->country_code;
        $user->mobile           = $request->mobile;
        $user->username         = $request->username;
        $user->address          = $request->address;
        $user->city             = $request->city;
        $user->state            = $request->state;
        $user->zip              = $request->zip;
        $user->country_name     = @$request->country;
        $user->dial_code        = $request->mobile_code;
        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }

    public function addDeviceToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $user        = authUser();
        $deviceToken = DeviceToken::where('user_id', $user->id)->where('token', $request->token)->first();
        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = $user->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function jobApplication()
    {
        $pageTitle    = "Applications";
        $user         = authUser();
        $applications = JobApply::where('user_id', $user->id)->checkApprovedJob()->with('job', 'job.employer')->orderByDesc('id')->paginate(getPaginate());
        return view('Template::user.job.job_apply', compact('pageTitle', 'applications', 'user'));
    }

    public function favoriteJobs()
    {
        $pageTitle = "Favorite Jobs";
        $user      = authUser();
        $favorites = FavoriteItem::where('user_id', $user->id)->checkApprovedJob()->with('job')->orderByDesc('id')->paginate(getPaginate());
        return view('Template::user.job.favorite', compact('pageTitle', 'favorites', 'user'));
    }

    public function applyJob(Request $request, $id)
    {
        $user = authUser();
        $job  = Job::where('status', Status::JOB_APPROVED)->where('id', $id)->firstOrFail();

        $eligibility = true;
        // if ($job->gender && $user->gender != $job->gender) {
        //     $eligibility = false;
        // }

        // $birthDate = $user->birth_date;
        // $userAge   = (int) Carbon::parse($user->birth_date)->diffInYears(now());
        // if ($job->min_age > 0 && $job->min_age > $userAge) {
        //     $eligibility = false;
        // }

        // if ($job->max_age > 0 && $job->max_age < $userAge) {
        //     $eligibility = false;
        // }

        // if (!$eligibility) {
        //     $notify[] = ['error', 'You are not eligible to apply for this job'];
        //     return back()->withNotify($notify);
        // }

        if (jobApply::where('job_id', $job->id)->where('user_id', $user->id)->exists()) {
            $notify[] = ['error', 'You have already applied for this job'];
            return back()->withNotify($notify);
        }

        $request->validate([
            'expected_salary' => 'required|integer|gt:0',
            'resume'           => ['required', new FileTypeValidate(['pdf', 'doc', 'docx', 'rtf']), 'max:2048'],
            'full_name'       => 'required|string|max:255',
            'resume_options'  => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:255',
        ], [
            'resume.max' => 'The resume must not exceed 2 MB.',
        ]);

        // Salary range checks
        // if ($job->salary_type == Status::RANGE) {
        //     if ($request->expected_salary > $job->salary_to) {
        //         $notify[] = ['error', 'Expected salary must be less than or equal to job maximum salary'];
        //         return back()->withNotify($notify);
        //     }

        //     if ($request->expected_salary < $job->salary_from) {
        //         $notify[] = ['error', 'Expected salary must be greater or equal to job minimum salary'];
        //         return back()->withNotify($notify);
        //     }
        // }

        // Handle resume upload
        $resume = null;
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');

            // Get original filename (e.g. "my_cv.pdf")
            $originalFileName = $request->resume->getClientOriginalName();
            $file->move(getFilePath('resume'), $originalFileName);

            // File path you can store in DB
            $resume = $originalFileName;
        }

        // Save job application
        $jobApply = new JobApply();
        $jobApply->job_id          = $id;
        $jobApply->user_id         = $user->id;
        $jobApply->full_name       = $request->full_name;
        $jobApply->email           = $request->email;
        $jobApply->phone           = $request->phone;
        $jobApply->resume          = $resume;
        $jobApply->expected_salary = $request->expected_salary;
        $jobApply->status          = 0; // pending
        $jobApply->save();

        // Notify employer (if needed)
        notify($job->employer, 'JOB_APPLICATION', [
            'title'           => @$job->title,
            'fullname'        => $user->fullname,
            'expected_salary' => $jobApply->expected_salary,
            'created_at'      => $jobApply->created_at,
            'site_name'       => gs('site_name'),
        ]);

        $notify[] = ['success', 'You have applied for this job successfully'];
        $notify[] = ['info', 'You will be notified when employer accept your application'];
        return back()->withNotify($notify);
    }

    public function addToFavorite($id)
    {
        $job          = Job::approved()->findOrFail($id);
        $user         = authUser();
        $favoriteItem = FavoriteItem::where('user_id', $user->id)->where('job_id', $job->id)->first();

        if ($favoriteItem) {
            $favoriteItem->delete();
            return response()->json([
                'notify' => ['success' => 'Remove job from favorite list successfully'],
                'icon'   => '<i class="far fa-bookmark"></i>',
            ]);
        }

        $favoriteItem          = new FavoriteItem();
        $favoriteItem->user_id = $user->id;
        $favoriteItem->job_id  = $id;
        $favoriteItem->save();

        return response()->json([
            'notify' => ['success' => 'Favorite job added successfully'],
            'icon'   => '<i class="fas fa-bookmark"></i>',
        ]);
    }

    public function favoriteJobDelete($id)
    {
        $favoriteItem = FavoriteItem::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $favoriteItem->delete();

        $notify[] = ['success', "Favorite job deleted successfully"];
        return back()->withNotify($notify);
    }
}
