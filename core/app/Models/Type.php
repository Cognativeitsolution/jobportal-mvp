<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use GlobalStatus;

    public function job()
    {
        return $this->hasMany(Job::class, 'type_id')->where('status', Status::YES);
    }

    public function scopeWithJobCount($query)
    {
        return $query->withCount(['job' => function ($job) {
            $job->approved();
        }]);
    }

    public function scopeWhereHasJob($query)
    {
        return $query->whereHas('job', function ($job) {
            $job->approved();
        });
    }

    public function scopeWithFeaturedJobCount($query)
    {
        return $query->withCount(['job' => function ($job) {
            $job->approved()->featured();
        }]);
    }

    public function scopeWhereHasFeaturedJob($query)
    {
        return $query->whereHas('job', function ($job) {
            $job->approved()->featured();
        });
    }
}
