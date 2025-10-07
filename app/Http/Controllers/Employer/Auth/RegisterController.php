<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\AdminNotification;
use App\Models\Employer;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        parent::__construct();
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Register";
        Intended::identifyRoute();
        return view('Template::employer.auth.register', compact('pageTitle'));
    }

    protected function validator(array $data)
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agree = 'nullable';
        if (gs('agree')) {
            $agree = 'required';
        }

        $validate     = Validator::make($data, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|string|email|unique:users',
            'password'  => ['required', 'confirmed', $passwordValidation],
            'captcha'   => 'sometimes|required',
            'agree'     => $agree
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required' => 'The last name field is required'
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        if (!gs('registration')) {
            $notify[] = ['error', 'Registration not allowed'];
            return back()->withNotify($notify);
        }

        $this->validator($request->all())->validate();

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        event(new Registered($employer = $this->create($request->all())));

        auth()->guard('employer')->login($employer);

        return $this->registered($request, $employer)
            ?: redirect($this->redirectPath());
    }

    protected function create(array $data)
    {
        //User Create
        $employer            = new Employer();
        $employer->email     = strtolower($data['email']);
        $employer->firstname = $data['firstname'];
        $employer->lastname  = $data['lastname'];
        $employer->password  = Hash::make($data['password']);

        $employer->ev = gs('ev') ? Status::NO : Status::YES;
        $employer->sv = gs('sv') ? Status::NO : Status::YES;
        $employer->ts = Status::DISABLE;
        $employer->tv = Status::ENABLE;
        $employer->free_job_post_limit = gs('free_job_post_limit');
        $employer->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $employer->id;
        $adminNotification->title     = 'New employer registered';
        $adminNotification->click_url = urlPath('admin.employers.detail', $employer->id);
        $adminNotification->save();

        //Login Log Create
        $ip        = getRealIP();
        $exist     = UserLogin::where('user_ip', $ip)->first();
        $employerLogin = new UserLogin();

        if ($exist) {
            $employerLogin->longitude    = $exist->longitude;
            $employerLogin->latitude     = $exist->latitude;
            $employerLogin->city         = $exist->city;
            $employerLogin->country_code = $exist->country_code;
            $employerLogin->country      = $exist->country;
        } else {
            $info                    = json_decode(json_encode(getIpInfo()), true);
            $employerLogin->longitude    = @implode(',', $info['long']);
            $employerLogin->latitude     = @implode(',', $info['lat']);
            $employerLogin->city         = @implode(',', $info['city']);
            $employerLogin->country_code = @implode(',', $info['code']);
            $employerLogin->country      = @implode(',', $info['country']);
        }

        $userAgent          = osBrowser();
        $employerLogin->user_id = $employer->id;
        $employerLogin->user_ip = $ip;
        $employerLogin->browser = @$userAgent['browser'];
        $employerLogin->os      = @$userAgent['os_platform'];
        $employerLogin->save();

        return $employer;
    }

    public function checkEmployer(Request $request)
    {
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = Employer::where('email', $request->email)->exists();
            $exist['type'] = 'email';
            $exist['field'] = 'Email';
        }
        if ($request->mobile) {
            $exist['data'] = Employer::where('mobile', $request->mobile)->where('dial_code', $request->mobile_code)->exists();
            $exist['type'] = 'mobile';
            $exist['field'] = 'Mobile';
        }
        if ($request->username) {
            $exist['data'] = Employer::where('username', $request->username)->exists();
            $exist['type'] = 'username';
            $exist['field'] = 'Username';
        }
        return response($exist);
    }

    public function registered()
    {
        return to_route('employer.home');
    }
}
