<?php

namespace App\Http\Controllers\Gateway;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\PlanController;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Employer;
use App\Models\GatewayCurrency;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function deposit() {
        abort_if(!session()->has('job_id'), 404);
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->active();
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Payment Methods';
        return view('Template::employer.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request, $id = null) {
        $request->validate([
            'amount'   => 'required|numeric|gt:0',
            'gateway'  => 'required',
            'currency' => 'required',
        ]);

        $employer = authUser('employer');
        $amount   = $request->amount;
        if ($id) {
            $plan = Plan::active()->findOrFail($id);
            if (Deposit::where('plan_id', '!=', 0)->pending()->where('employer_id', $employer->id)->latest()->first()) {
                $notify[] = ['error', 'You have already submit a request to subscribe a plan.'];
                return back()->withNotify($notify);
            }
            $subscription = Subscription::where('employer_id', $employer->id)->approved()->first();
            if ($subscription && $employer->job_post_count) {
                $notify[] = ['error', 'You already subscribed a plan'];
                return back()->withNotify($notify);
            }
            if ($request->amount != $plan->price) {
                $notify[] = ['error', 'Invalid amount to subscribe plan'];
                return back()->withNotify($notify);
            }
            $amount = $plan->price;
            $jobId  = 0;
        } else {
            if ($request->amount != gs('fee_per_job_post')) {
                $notify[] = ['error', 'Invalid amount to create job.'];
                return back()->withNotify($notify);
            }
            $amount = gs('fee_per_job_post');
            $jobId  = session()->get('job_id');
        }

        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->active();
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $amount || $gate->max_amount < $amount) {
            $notify[] = ['error', 'Please follow payment limit'];
            return back()->withNotify($notify);
        }

        $charge      = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable     = $amount + $charge;
        $finalAmount = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->user_id         = 0;
        $data->employer_id     = $employer->id;
        $data->plan_id         = @$id ?? 0;
        $data->job_id          = @$jobId ?? null;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amount    = $finalAmount;
        $data->btc_amount      = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->success_url     = urlPath('employer.transactions');
        $data->failed_url      = urlPath('employer.transactions');
        $data->save();

        session()->put('Track', $data->trx);
        session()->forget('job_id');
        return to_route('employer.deposit.confirm');
    }

    public function depositConfirm() {
        $track   = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->initiated()->with('gateway')->orderByDesc('id')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('employer.deposit.manual.confirm');
        }

        $dirName = $deposit->gateway->alias;
        $new     = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);

        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return back()->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view("Template::$data->view", compact('data', 'pageTitle', 'deposit'));
    }

    public static function userDataUpdate($deposit, $isManual = null) {
        if ($deposit->status == Status::PAYMENT_INITIATE || $deposit->status == Status::PAYMENT_PENDING) {
            $deposit->status = Status::PAYMENT_SUCCESS;
            $deposit->save();

            $employer = Employer::find($deposit->employer_id);
            $employer->balance += $deposit->amount;
            $employer->save();

            $methodName = $deposit->methodName();

            $transaction               = new Transaction();
            $transaction->user_id      = 0;
            $transaction->employer_id  = $deposit->employer_id;
            $transaction->amount       = $deposit->amount;
            $transaction->post_balance = $employer->balance;
            $transaction->charge       = $deposit->charge;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Payment Via ' . $methodName;
            $transaction->trx          = $deposit->trx;
            $transaction->remark       = 'payment';
            $transaction->save();

            if (!$isManual) {
                $adminNotification            = new AdminNotification();
                $adminNotification->user_id   = $employer->id;
                $adminNotification->title     = 'Payment successful via ' . $methodName;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            if ($deposit->plan_id) {
                PlanController::planSubscribe($deposit->plan, $employer);
            }

            if ($deposit->job_id) {
                $job                   = $deposit->job;
                $job->redirect_payment = Status::NO;
                $job->save();

                $notify[] = JobController::postJobs($job, $employer, balance: true);
                $deposit->save();
            }

            notify($employer, $isManual ? 'DEPOSIT_APPROVE' : 'DEPOSIT_COMPLETE', [
                'method_name'     => $methodName,
                'method_currency' => $deposit->method_currency,
                'method_amount'   => showAmount($deposit->final_amount, currencyFormat: false),
                'amount'          => showAmount($deposit->amount, currencyFormat: false),
                'charge'          => showAmount($deposit->charge, currencyFormat: false),
                'rate'            => showAmount($deposit->rate, currencyFormat: false),
                'trx'             => $deposit->trx,
                'post_balance'    => showAmount($employer->balance),
            ]);
        }
    }

    public function manualDepositConfirm() {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->initiated()->where('trx', $track)->first();
        abort_if(!$data, 404);

        if ($data->method_code > 999) {
            $pageTitle = 'Confirm Payment';
            $method    = $data->gatewayCurrency();
            $gateway   = $method->method;
            return view('Template::employer.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request) {
        $track = session()->get('Track');
        $data  = Deposit::with('gateway')->initiated()->where('trx', $track)->first();
        abort_if(!$data, 404);

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway         = $gatewayCurrency->method;
        $formData        = $gateway->form->form_data;

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = Status::PAYMENT_PENDING;
        $data->save();

        $adminNotification              = new AdminNotification();
        $adminNotification->employer_id = $data->employer->id;
        $adminNotification->title       = 'Payment request from ' . $data->employer->username;
        $adminNotification->click_url   = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->employer, 'DEPOSIT_REQUEST', [
            'method_name'     => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount'   => showAmount($data->final_amount, currencyFormat: false),
            'amount'          => showAmount($data->amount, currencyFormat: false),
            'charge'          => showAmount($data->charge, currencyFormat: false),
            'rate'            => showAmount($data->rate, currencyFormat: false),
            'trx'             => $data->trx,
        ]);

        $notify[] = ['success', 'You have payment request has been taken'];
        return to_route('employer.plan.index')->withNotify($notify);
    }
}
