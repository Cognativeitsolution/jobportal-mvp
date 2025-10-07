<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_keyword');
    }

    public function scopeWhereHasJobs($query)
    {
        return $query->whereHas('jobs', function ($job) {
            $job->approved();
        });
    }

    public function scopeWhereHasFeaturedJobs($query)
    {
        return $query->whereHas('jobs', function ($job) {
            $job->approved()->featured();
        });
    }
}
