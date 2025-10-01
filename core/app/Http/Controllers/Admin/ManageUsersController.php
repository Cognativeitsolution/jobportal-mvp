<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\User;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Industry;
use App\Models\JobApply;
use App\Models\Location;
use App\Constants\Status;
use App\Models\Department;
use App\Models\Transaction;
use App\Models\FavoriteItem;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\NotificationLog;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
// use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Auth;
use App\Lib\UserNotificationSender;

class ManageUsersController extends Controller
{
    public function allUsers()
    {
        $pageTitle = 'All Users';
        $users = $this->userData();
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function activeUsers()
    {
        $pageTitle = 'Active Users';
        $users = $this->userData('active');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function bannedUsers()
    {
        $pageTitle = 'Banned Users';
        $users = $this->userData('banned');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function emailUnverifiedUsers()
    {
        $pageTitle = 'Email Unverified Users';
        $users = $this->userData('emailUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function emailVerifiedUsers()
    {
        $pageTitle = 'Email Verified Users';
        $users = $this->userData('emailVerified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function mobileUnverifiedUsers()
    {
        $pageTitle = 'Mobile Unverified Users';
        $users = $this->userData('mobileUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function mobileVerifiedUsers()
    {
        $pageTitle = 'Mobile Verified Users';
        $users = $this->userData('mobileVerified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    protected function userData($scope = null)
    {
        $users = $scope ? User::$scope() : User::query();
        return $users->searchable(['username', 'email'])->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = 'User Detail - ' . ($user->username == '' ? $user->fullname : $user->username);
        $widget['total_job_application'] = JobApply::where('user_id', $user->id)->count();
        $widget['received_job_application'] = JobApply::received()->where('user_id', $user->id)->count();
        $widget['pending_job_application'] = JobApply::pending()->where('user_id', $user->id)->count();
        $widget['rejected_job_application'] = JobApply::rejected()->where('user_id', $user->id)->count();
        $widget['mark_favorite'] = FavoriteItem::where('user_id', $user->id)->count();
        $widget['total_ticket'] = SupportTicket::where('user_id', $user->id)->count();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $skills    = Skill::active()->get();

        $industries = Industry::active()->orderByDesc('id')->get();
        $departments = Department::active()->orderByDesc('id')->get();
        $types = Type::active()->orderByDesc('id')->get();
        $cities = Location::active()->city()->orderByDesc('id')->get();
        $shifts = Shift::active()->orderByDesc('id')->get();
        return view('admin.users.detail', compact('pageTitle', 'user', 'widget', 'countries', 'skills', 'industries', 'departments', 'types', 'cities', 'shifts'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $countryData  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray = (array)$countryData;
        $countries    = implode(',', array_keys($countryArray));
        $countryCode  = $request->country;
        $country      = $countryData->$countryCode->country;
        $dialCode     = $countryData->$countryCode->dial_code;
        $bloodGroup   = ['A +', 'A -', 'B +', 'B -', 'O +', 'O -', 'AB +', 'AB -'];

        $request->validate([
            'firstname'        => 'required|string|max:40',
            'lastname'         => 'required|string|max:40',
            'email'            => 'required|email|string|max:40|unique:users,email,' . $user->id,
            'mobile'           => 'required|string|max:40',
            'country'          => 'required|in:' . $countries,
            'resume_headline'  => 'nullable|string|max:255',
            'summary'          => 'nullable|string',
            'industry_id'      => 'nullable|integer|exists:industries,id',
            'department_id'    => 'nullable|integer|exists:departments,id',
            'desired_job_type' => 'nullable|integer|in:' . Status::PERMANENT . ',' . Status::CONTRACTUAL,
            'type_id'          => 'nullable|integer|exists:types,id',
            'shift_id'         => 'nullable|integer|exists:shifts,id',
            'location_id'      => 'nullable|integer|exists:locations,id',
            'expected_salary'  => 'nullable|numeric|gt:0',
            'gender'           => 'nullable|in:' . Status::MALE . ',' . Status::FEMALE . ',' . Status::OTHERS,
            'married_status'   => 'nullable|in:' . Status::SINGLE . ',' . Status::MARRIED . ',' . Status::DIVORCED . ',' . Status::SEPARATED,
            'career_break'     => 'nullable|in:' . Status::YES . ',' . Status::NO,
            'birth_date'       => 'nullable|date_format:m/d/Y|before:today',
            'national_id'      => 'nullable|string|max:255',
            'blood_group'      => 'nullable|string|in:' .  implode(',', $bloodGroup)
        ]);

        $exists = User::where('mobile', $request->mobile)->where('dial_code', $dialCode)->where('id', '!=', $user->id)->exists();
        if ($exists) {
            $notify[] = ['error', 'The mobile number already exists.'];
            return back()->withNotify($notify);
        }

        $user->mobile           = $request->mobile;
        $user->firstname        = $request->firstname;
        $user->lastname         = $request->lastname;
        $user->email            = $request->email;
        $user->address          = $request->address;
        $user->city             = $request->city;
        $user->state            = $request->state;
        $user->zip              = $request->zip;
        $user->country_name     = @$country;
        $user->dial_code        = $dialCode;
        $user->country_code     = $countryCode;
        $user->resume_headline  = $request->resume_headline ?? null;
        $user->summary          = $request->summary ?? null;
        $user->industry_id      = $request->industry_id ?? 0;
        $user->department_id    = $request->department_id ?? 0;
        $user->desired_job_type = $request->desired_job_type ?? 0;
        $user->type_id          = $request->type_id ?? 0;
        $user->shift_id         = $request->shift_id ?? 0;
        $user->location_id      = $request->location_id ?? 0;
        $user->expected_salary  = $request->expected_salary ?? 0;
        $user->gender           = $request->gender ?? 0;
        $user->married_status   = $request->married_status ?? 0;
        $user->career_break     = $request->career_break ?? 0;
        $user->birth_date       = $request->birth_date ?? null;
        $user->blood_group      = $request->blood_group ?? '';
        $user->national_id      = $request->national_id ?? '';
        $user->ev               = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $user->sv               = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $user->ts               = $request->ts ? Status::ENABLE : Status::DISABLE;
        $user->save();

        if ($user->ev == Status::UNVERIFIED) {
            $profileUpdatePercentList = $user->profile_update_percent_list;
            $profileUpdatePercentList['email_verification'] = gs('resume_percentage')['email_verification'];
            $user->profile_update_percent -= gs('resume_percentage')['email_verification'];
            $user->profile_update_percent_list = $profileUpdatePercentList;
            $user->save();
        }

        if ($user->sv == Status::UNVERIFIED) {
            $profileUpdatePercentList = $user->profile_update_percent_list;
            $profileUpdatePercentList['mobile_verification'] = gs('resume_percentage')['mobile_verification'];
            $user->profile_update_percent -= gs('resume_percentage')['mobile_verification'];
            $user->profile_update_percent_list = $profileUpdatePercentList;
            $user->save();
        }

        $notify[] = ['success', 'User details updated successfully'];
        return back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act' => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $amount = $request->amount;
        $trx = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $user->balance += $amount;

            $transaction->trx_type = '+';
            $transaction->remark = 'balance_add';

            $notifyTemplate = 'BAL_ADD';

            $notify[] = ['success', 'Balance added successfully'];
        } else {
            if ($amount > $user->balance) {
                $notify[] = ['error', $user->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $user->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark = 'balance_subtract';

            $notifyTemplate = 'BAL_SUB';
            $notify[] = ['success', 'Balance subtracted successfully'];
        }

        $user->save();

        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx =  $trx;
        $transaction->details = $request->remark;
        $transaction->save();

        notify($user, $notifyTemplate, [
            'trx' => $trx,
            'amount' => showAmount($amount, currencyFormat: false),
            'remark' => $request->remark,
            'post_balance' => showAmount($user->balance, currencyFormat: false)
        ]);

        return back()->withNotify($notify);
    }

    public function login($id)
    {
        if (auth()->guard('employer')->check()) {
            auth()->guard('employer')->logout();
        }
        Auth::loginUsingId($id);
        return to_route('user.home');
    }

    public function status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $user->status = Status::USER_BAN;
            $user->ban_reason = $request->reason;
            $notify[] = ['success', 'User banned successfully'];
        } else {
            $user->status = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $notify[] = ['success', 'User unbanned successfully'];
        }
        $user->save();
        return back()->withNotify($notify);
    }

    public function showNotificationSingleForm($id)
    {
        $user = User::findOrFail($id);
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.users.detail', $user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $user->username;
        return view('admin.users.notification_single', compact('pageTitle', 'user'));
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

        return (new UserNotificationSender())->notificationToSingle($request, $id);
    }

    public function showNotificationAllForm()
    {
        if (!gs('en') && !gs('sn') && !gs('pn')) {
            $notify[] = ['warning', 'Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }

        $notifyToUser = User::notifyToUser();
        $users        = User::active()->count();
        $pageTitle    = 'Notification to Verified Users';

        if (session()->has('SEND_NOTIFICATION') && !request()->email_sent) {
            session()->forget('SEND_NOTIFICATION');
        }

        return view('admin.users.notification_all', compact('pageTitle', 'users', 'notifyToUser'));
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

        return (new UserNotificationSender())->notificationToAll($request);
    }

    public function countBySegment($methodName)
    {
        return User::active()->$methodName()->count();
    }

    public function list()
    {
        $query = User::active();
        if (request()->search) {
            $query->where(function ($q) {
                $q->where('email', 'like', '%' . request()->search . '%')->orWhere('username', 'like', '%' . request()->search . '%');
            });
        }
        $users = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'success' => true,
            'users'   => $users,
            'more'    => $users->hasMorePages()
        ]);
    }

    public function notificationLog($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $user->username;
        $logs = NotificationLog::where('user_id', $id)->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle', 'logs', 'user'));
    }
}
