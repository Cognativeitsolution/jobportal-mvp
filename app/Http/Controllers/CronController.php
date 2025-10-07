<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\Job;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;

class CronController extends Controller {
    public function cron() {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];

                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }

    public function jobExpired() {
        $general = gs();
        try {
            Job::where('status', '!=', Status::JOB_EXPIRED)->whereDate('deadline', '<', Carbon::now()->toDateString())->update(['status' => Status::JOB_EXPIRED]);
            $general->last_cron          = now();
            $general->cron_error_message = null;
        } catch (Exception $ex) {
            $general->last_cron          = now();
            $general->cron_error_message = $ex->getMessage();
        }
        $general->save();
    }

    public function planExpired() {
        $general = gs();
        try {
            $subscriptions = Subscription::where('status', '!=', Status::SUBSCRIPTION_EXPIRED)
                ->whereDate('expired_date', '<', now()->format('Y-m-d'))
                ->with('employer')
                ->get();

            foreach ($subscriptions as $subscription) {
                $subscription->status = Status::SUBSCRIPTION_EXPIRED;
                $subscription->save();

                $employer = $subscription->employer;
                $employer->subscription_status == Status::SUBSCRIPTION_EXPIRED;
                $employer->save();
            }
            $general->last_cron          = now();
            $general->cron_error_message = null;
        } catch (Exception $ex) {
            $general->last_cron          = now();
            $general->cron_error_message = $ex->getMessage();
        }
        $general->save();
    }
}
