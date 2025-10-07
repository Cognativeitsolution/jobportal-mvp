<?php

namespace App\Http\Controllers\Employer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthorizationController extends Controller
{
    protected function checkCodeValidity($employer, $addMin = 2)
    {
        if (!$employer->ver_code_send_at) {
            return false;
        }
        if ($employer->ver_code_send_at->addMinutes($addMin) < Carbon::now()) {
            return false;
        }
        return true;
    }

    public function authorizeForm()
    {
        $employer = auth()->guard('employer')->user();
        if (!$employer->status) {
            $pageTitle = 'Banned';
            $type      = 'ban';
        } else if (!$employer->ev) {
            $type           = 'email';
            $pageTitle      = 'Verify Email';
            $notifyTemplate = 'EVER_CODE';
        } else if (!$employer->sv) {
            $type           = 'sms';
            $pageTitle      = 'Verify Mobile Number';
            $notifyTemplate = 'SVER_CODE';
        } else if (!$employer->tv) {
            $pageTitle = '2FA Verification';
            $type      = '2fa';
        } else {
            return to_route('employer.home');
        }

        if (!$this->checkCodeValidity($employer) && ($type != '2fa') && ($type != 'ban')) {
            $employer->ver_code         = verificationCode(6);
            $employer->ver_code_send_at = Carbon::now();
            $employer->save();
            notify($employer, $notifyTemplate, [
                'code' => $employer->ver_code,
            ], [$type]);
        }

        return view('Template::employer.auth.authorization.' . $type, compact('employer', 'pageTitle'));
    }

    public function sendVerifyCode($type)
    {
        $employer = authUser('employer');
        if ($this->checkCodeValidity($employer)) {
            $targetTime = $employer->ver_code_send_at->addMinutes(2)->timestamp;
            $delay      = $targetTime - time();
            throw ValidationException::withMessages(['resend' => 'Please try after ' . $delay . ' seconds']);
        }

        $employer->ver_code         = verificationCode(6);
        $employer->ver_code_send_at = Carbon::now();
        $employer->save();

        if ($type == 'email') {
            $type           = 'email';
            $notifyTemplate = 'EVER_CODE';
        } else {
            $type           = 'sms';
            $notifyTemplate = 'SVER_CODE';
        }

        notify($employer, $notifyTemplate, [
            'code' => $employer->ver_code,
        ], [$type]);

        $notify[] = ['success', 'Verification code sent successfully'];
        return back()->withNotify($notify);
    }

    public function emailVerification(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $employer = auth()->guard('employer')->user();

        if ($employer->ver_code == $request->code) {
            $employer->ev               = Status::VERIFIED;
            $employer->ver_code         = null;
            $employer->ver_code_send_at = null;
            $employer->save();
            return to_route('employer.home');
        }
        throw ValidationException::withMessages(['code' => 'Verification code didn\'t match!']);
    }

    public function mobileVerification(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);

        $employer = auth()->guard('employer')->user();
        if ($employer->ver_code == $request->code) {
            $employer->sv               = Status::VERIFIED;
            $employer->ver_code         = null;
            $employer->ver_code_send_at = null;
            $employer->save();
            return to_route('employer.home');
        }
        throw ValidationException::withMessages(['code' => 'Verification code didn\'t match!']);
    }

    public function g2faVerification(Request $request)
    {
        $employer = auth()->guard('employer')->user();
        $request->validate([
            'code' => 'required',
        ]);
        $response = verifyG2fa($employer, $request->code);
        if ($response) {
            $notify[] = ['success', 'Verification successful'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }
}
