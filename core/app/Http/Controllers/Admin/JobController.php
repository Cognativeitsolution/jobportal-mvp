<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\Transaction;
use Illuminate\Http\Request;

class JobController extends Controller {
    public function all() {
        $pageTitle = 'All Jobs';
        $jobs      = $this->jobData();
        return view('admin.job.index', compact('pageTitle', 'jobs'));
    }
    public function pending() {
        $pageTitle = 'Pending Jobs';
        $jobs      = $this->jobData('pending');
        return view('admin.job.index', compact('pageTitle', 'jobs'));
    }
    public function approved() {
        $pageTitle = 'Approved Jobs';
        $jobs      = $this->jobData('approved');
        return view('admin.job.index', compact('pageTitle', 'jobs'));
    }
    public function expired() {
        $pageTitle = 'Expired Jobs';
        $jobs      = $this->jobData('expired');
        return view('admin.job.index', compact('pageTitle', 'jobs'));
    }
    public function rejected() {
        $pageTitle = 'Rejected Jobs';
        $jobs      = $this->jobData('rejected');
        return view('admin.job.index', compact('pageTitle', 'jobs'));
    }

    public function approve($id) {
        $job         = Job::pending()->findOrFail($id);
        $job->status = Status::JOB_APPROVED;
        $job->save();

        notify($job->employer, 'JOB_APPROVED', [
            'username'      => @$job->employer->username,
            'title'         => $job->title,
            'created_at'    => showDateTime($job->created_at),
            'approved_date' => showDateTime(now()),
        ]);

        $notify[] = ['success', 'Job approved successfully'];
        return back()->withNotify($notify);
    }
    public function reject(Request $request, $id) {
        $request->validate(['reject_reason' => 'required']);
        $job                = Job::pending()->findOrFail($id);
        $job->status        = Status::JOB_REJECTED;
        $job->reject_reason = $request->reject_reason;
        $job->save();

        $employer = $job->employer;

        if ($job->amount > 0) {
            $employer->balance += $job->amount;
            $employer->save();

            $transaction               = new Transaction();
            $transaction->user_id      = 0;
            $transaction->employer_id  = $employer->id;
            $transaction->amount       = $job->amount;
            $transaction->post_balance = $employer->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Refund for job reject';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'refund';
            $transaction->save();
        } else {
            if ($job->is_free) {
                $employer->free_job_post_limit += 1;
            } else {
                $employer->job_post_count += 1;
            }
            $employer->save();
        }

        notify($job->employer, 'JOB_APPLICATION_REJECTED', [
            'company_name' => @$job->employer->username,
            'job_title'    => $job->title,
        ]);

        $notify[] = ['success', 'Job rejected successfully'];
        return back()->withNotify($notify);
    }

    public function details($id) {
        $job       = Job::findOrFail($id);
        $pageTitle = "Job Details";
        return view('admin.job.details', compact('pageTitle', 'job'));
    }

    public function applyList($id) {
        $job             = Job::findORFail($id);
        $jobApplications = JobApply::where('job_id', $job->id)->with('job:id,category_id,title,employer_id', 'job.category:id,name', 'user')->paginate(getPaginate());
        $pageTitle       = "Job application list";
        return view('admin.job.job_apply', compact('pageTitle', 'jobApplications'));
    }

    public function featured($id) {
        $job = Job::findORFail($id);
        if ($job->featured) {
            $job->featured = Status::NO;
            $message       = "Job UnFeatured successfully";
        } else {
            $job->featured = Status::YES;
            $message       = "Job Featured successfully";
        }
        $job->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    private function jobData($scope = null) {
        if ($scope) {
            $employers = Job::$scope();
        } else {
            $employers = Job::query();
        }

        return $employers->orderBy('id', 'DESC')->searchable(['title', 'employer:company_name'])->filter(['category_id', 'type_id', 'shift_id', 'location_id'])->with(['employer', 'category'])->withCount('jobApplication as total_apply')->paginate(getPaginate());
    }

    public function applicants($id) {
        $pageTitle  = 'Applicants';
        $job        = Job::whereIn('status', [Status::JOB_APPROVED, Status::JOB_EXPIRED])->findOrFail($id);
        $applicants = JobApply::where('job_id', $job->id)->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.job.applicants', compact('applicants', 'pageTitle'));
    }
}
