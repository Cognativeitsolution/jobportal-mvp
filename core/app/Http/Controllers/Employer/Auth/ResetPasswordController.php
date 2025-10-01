<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function __construct()
    {
        parent::__construct();
    }

    public function showResetForm(Request $request, $token = null)
    {
        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;

        if (PasswordReset::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return to_route('employer.password.request')->withNotify($notify);
        }
        return view('Template::employer.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email, 'pageTitle' => 'Reset Password']
        );
    }

    public function reset(Request $request)
    {
        session()->put('fpass_email', $request->email);
        $request->validate($this->rules(), $this->validationErrorMessages());
        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();

        if (!$reset) {
            $notify[] = ['error', 'Invalid verification code'];
            return to_route('employer.login')->withNotify($notify);
        }

        $employer           = Employer::where('email', $reset->email)->first();
        $employer->password = Hash::make($request->password);
        $employer->save();

        $employerIpInfo  = getIpInfo();
        $employerBrowser = osBrowser();

        notify($employer, 'PASS_RESET_DONE', [
            'operating_system' => @$employerBrowser['os_platform'],
            'browser'          => @$employerBrowser['browser'],
            'ip'               => @$employerIpInfo['ip'],
            'time'             => @$employerIpInfo['time']
        ], ['email']);

        $notify[] = ['success', 'Password changed successfully'];
        return to_route('employer.login')->withNotify($notify);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        $passwordValidation = Password::min(6);
        $general            = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => ['required', 'confirmed', $passwordValidation],
        ];
    }
}
