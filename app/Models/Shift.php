<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use GlobalStatus;

    public function job()
    {
        return $this->hasMany(Job::class, 'shift_id')->where('status', Status::YES);
    }

    public function scopeWhereHasJob($query)
    {
        $query->whereHas('job', function ($job) {
            $job->approved();
        });
    }

    public function scopeWithJobCount($query)
    {
        $query->withCount(['job' => function ($job) {
            $job->approved();
        }]);
    }

    public function scopeWhereHasFeaturedJob($query)
    {
        $query->whereHas('job', function ($job) {
            $job->approved()->featured();
        });
    }

    public function scopeWithFeaturedJobCount($query)
    {
        $query->withCount(['job' => function ($job) {
            $job->approved()->featured();
        }]);
    }
}
