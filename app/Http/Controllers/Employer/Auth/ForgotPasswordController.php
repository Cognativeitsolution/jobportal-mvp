<?php

namespace App\Http\Controllers\Employer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        $pageTitle = "Account Recovery";
        return view('Template::employer.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'value' => 'required'
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $fieldType = $this->findFieldType();
        $employer  = Employer::where($fieldType, $request->value)->first();

        if (!$employer) {
            $notify[] = ['error', 'Couldn\'t find any account with this information'];
            return back()->withNotify($notify);
        }

        PasswordReset::where('email', $employer->email)->delete();

        $code                 = verificationCode(6);
        $password             = new PasswordReset();
        $password->email      = $employer->email;
        $password->token      = $code;
        $password->created_at = Carbon::now();
        $password->save();

        $employerIpInfo      = getIpInfo();
        $employerBrowserInfo = osBrowser();

        notify($employer, 'PASS_RESET_CODE', [
            'code'             => $code,
            'operating_system' => @$employerBrowserInfo['os_platform'],
            'browser'          => @$employerBrowserInfo['browser'],
            'ip'               => @$employerIpInfo['ip'],
            'time'             => @$employerIpInfo['time']
        ], ['email']);

        $email = $employer->email;
        session()->put('pass_res_mail', $email);
        $notify[] = ['success', 'Password reset email sent successfully'];
        return to_route('employer.password.code.verify')->withNotify($notify);
    }

    public function findFieldType()
    {
        $input = request()->input('value');
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }

    public function codeVerify()
    {
        $pageTitle = 'Verify Email';
        $email     = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error', 'Oops! session expired'];
            return to_route('employer.password.request')->withNotify($notify);
        }
        return view('Template::employer.auth.passwords.code_verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code'  => 'required',
            'email' => 'required'
        ]);

        $code       = str_replace(' ', '', $request->code);
        $tokenMatchCount = PasswordReset::where('token', $code)->where('email', $request->email)->count();
        if ($tokenMatchCount != 1) {
            $notify[] = ['error', 'Verification code doesn\'t match'];
            return to_route('employer.password.request')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return to_route('employer.password.reset', $code)->withNotify($notify);
    }
}
