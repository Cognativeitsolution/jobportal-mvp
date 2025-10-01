<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use GlobalStatus;

    public function job() {
        return $this->hasMany(Job::class)->where('status', Status::JOB_APPROVED);
    }

    public function jobs() {
        return $this->hasMany(Job::class);
    }

    public function scopeWithJobCount($query) {
        return $query->withCount(['job' => function ($job) {
            $job->approved();
        }]);
    }

    public function scopeWhereHasJobs($query) {
        return $query->whereHas('job', function ($job) {
            $job->approved();
        });
    }

    public function scopeWithFeaturedJobCount($query) {
        return $query->withCount(['job' => function ($job) {
            $job->approved()->featured();
        }]);
    }

    public function scopeWhereHasFeaturedJobs($query) {
        return $query->whereHas('job', function ($job) {
            $job->approved()->featured();
        });
    }
}
