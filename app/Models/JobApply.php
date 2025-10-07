<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class JobApply extends Model
{
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn() => $this->badgeData(),
        );
    }

    public function badgeData()
    {
        $html = '';
        if ($this->status == Status::JOB_APPLY_PENDING) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } elseif ($this->status == Status::JOB_APPLY_APPROVED) {
            $html = '<span class="badge badge--success">' . trans('Received') . '</span>';
        } elseif ($this->status == Status::JOB_APPLY_DRAFT) {
            $html = '<span class="badge badge--danger">' . trans('Drafted') . '</span>';
        }
        return $html;
    }

    public function scopeReceived($query)
    {
        return $query->where('status', Status::JOB_APPLY_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::JOB_APPLY_PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', Status::JOB_APPLY_REJECTED);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', Status::JOB_APPLY_DRAFT);
    }

    public function scopeTotalApplicants($query, $jobId)
    {
        return $query->where('job_id', $jobId)->count();
    }

    public function scopeTotalPending($query, $jobId)
    {
        return $query->where('job_id', $jobId)->where('status', Status::JOB_APPLY_PENDING)->count();
    }

    public function scopeTotalReceived($query, $jobId)
    {
        return $query->where('job_id', $jobId)->where('status', Status::JOB_APPLY_APPROVED)->count();
    }

    public function scopeTotalRejected($query, $jobId)
    {
        return $query->where('job_id', $jobId)->where('status', Status::JOB_APPLY_REJECTED)->count();
    }

    public function scopeTotalDraft($query, $jobId)
    {
        return $query->where('job_id', $jobId)->where('status', Status::JOB_APPLY_DRAFT)->count();
    }

    public function scopeCheckApprovedJob($query)
    {
        return $query->whereHas('job', function ($job) {
            $job->where('status', Status::JOB_APPROVED);
        });
    }

    public function scopeCheckEmployerJobs($query, $id)
    {
        return $query->whereHas('job', function ($job) use ($id) {
            $job->where('employer_id', $id);
        });
    }

    public function scopeEmployerTotalApplicants($query, $employerId)
    {
        return $query->whereHas('job', function ($job) use ($employerId) {
            $job->where('employer_id', $employerId);
        })->count();
    }
}
