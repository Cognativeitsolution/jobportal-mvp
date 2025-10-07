<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Lib\Intended;
use App\Constants\Status;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $username;
    protected $employername;

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->findUsername();
    }

    public function showLoginForm()
    {
        $pageTitle = "Login";
        Intended::identifyRoute();
        return view('Template::employer.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        Intended::reAssignSession();

        return $this->sendFailedLoginResponse($request);
    }

    public function findUsername()
    {
        $login = request()->input('username');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function validateLogin($request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            Intended::reAssignSession();
            $validator->validate();
        }
    }

    public function logout()
    {
        $this->guard('employer')->logout();
        request()->session()->invalidate();
        $notify[] = ['success', 'You have been logged out.'];
        return to_route('employer.login')->withNotify($notify);
    }

    protected function guard()
    {
        return auth()->guard('employer');
    }

    public function authenticated(Request $request, $employer)
    {
        $employer->tv = $employer->ts == Status::VERIFIED ? Status::UNVERIFIED : Status::VERIFIED;
        $employer->save();

        $ip = getRealIP();
        $exist = UserLogin::where('user_ip', $ip)->first();
        $employerLogin = new UserLogin();
        if ($exist) {
            $employerLogin->longitude =  $exist->longitude;
            $employerLogin->latitude =  $exist->latitude;
            $employerLogin->city =  $exist->city;
            $employerLogin->country_code = $exist->country_code;
            $employerLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $employerLogin->longitude =  @implode(',', $info['long']);
            $employerLogin->latitude =  @implode(',', $info['lat']);
            $employerLogin->city =  @implode(',', $info['city']);
            $employerLogin->country_code = @implode(',', $info['code']);
            $employerLogin->country =  @implode(',', $info['country']);
        }

        $employerAgent              = osBrowser();
        $employerLogin->employer_id = $employer->id;
        $employerLogin->user_ip     = $ip;
        $employerLogin->browser = @$employerAgent['browser'];
        $employerLogin->os      = @$employerAgent['os_platform'];
        $employerLogin->save();

        $redirection = Intended::getRedirection();

        return $redirection ? $redirection : to_route('employer.home');
    }
}
