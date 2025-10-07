<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use GlobalStatus;

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function scopeWhereHasJobs($query)
    {
        return $query->whereHas('jobs', function ($jobs) {
            $jobs->approved();
        });
    }

    public function scopeWithJobCount($query)
    {
        return $query->withCount(['jobs' => function ($job) {
            $job->approved();
        }]);
    }

    public function scopeWhereHasFeaturedJobs($query)
    {
        return $query->whereHas('jobs', function ($jobs) {
            $jobs->approved()->featured();
        });
    }

    public function scopeWithFeaturedJobCount($query)
    {
        return $query->withCount(['jobs' => function ($job) {
            $job->approved()->featured();
        }]);
    }
}
