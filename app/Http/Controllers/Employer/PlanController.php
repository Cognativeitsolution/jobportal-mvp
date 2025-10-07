<?php

namespace App\Http\Controllers\Employer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\GatewayCurrency;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\Transaction;
use Carbon\Carbon;

class PlanController extends Controller {
    public function index() {
        $pageTitle = 'All Plans';
        $plans     = Plan::active()
            ->with(['subscriptions' => function ($subscriptions) {
                $subscriptions->approved()->where('employer_id', authUser('employer')->id);
            }])->get();
        $gatewayCurrency = GatewayCurrency::with('method')
            ->whereHas('method', function ($gate) {
                $gate->where('status', Status::ENABLE);
            })->orderby('method_code')->get();

        return view('Template::employer.plan.index', compact('pageTitle', 'plans', 'gatewayCurrency'));
    }

    public static function planSubscribe($plan, $employer) {
        $expiredDate = Carbon::now()->addMonth($plan->duration)->format("Y-m-d");
        $employer->balance -= $plan->price;
        $employer->job_post_count      = $plan->job_post;
        $employer->plan_id             = $plan->id;
        $employer->expired_date        = $expiredDate;
        $employer->subscription_status = Status::SUBSCRIPTION_APPROVED;
        $employer->save();

        $subscription               = new Subscription();
        $subscription->plan_id      = $plan->id;
        $subscription->job_post     = $plan->job_post;
        $subscription->amount       = $plan->price;
        $subscription->employer_id  = $employer->id;
        $subscription->order_number = getTrx();
        $subscription->status       = Status::SUBSCRIPTION_APPROVED;
        $subscription->expired_date = $expiredDate;
        $subscription->save();

        $subscriber = new Subscriber();
        $subscriber->email = $employer->email;
        $subscriber->created_at = Carbon::now();
        $subscriber->save();

        $transaction               = new Transaction();
        $transaction->employer_id  = $employer->id;
        $transaction->amount       = $subscription->amount;
        $transaction->post_balance = $employer->balance;
        $transaction->trx_type     = '-';
        $transaction->details      = $plan->name . ' ' . 'Plan Subscription';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'plan_subscription';
        $transaction->save();

        $adminNotification              = new AdminNotification();
        $adminNotification->employer_id = $employer->id;
        $adminNotification->title       = 'Plan subscriber';
        $adminNotification->click_url   = urlPath('admin.plan.subscriber.list', $plan->id);
        $adminNotification->save();

        notify($employer, 'PLAN_SUBSCRIBE', [
            'plan_name'          => $plan->name,
            'order_number'       => $subscription->order_number,
            'company_name'       => $employer->company_name,
            'plan_price'         => showAmount($plan->price, currencyFormat: false),
            'total_job_post'     => $plan->job_post,
            'subscribe_duration' => $plan->duration,
        ]);
    }
}
