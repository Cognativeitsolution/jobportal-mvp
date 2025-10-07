<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;

class FavoriteItem extends Model
{
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCheckApprovedJob($query)
    {
        return $query->whereHas('job', function ($job) {
            $job->where('status', Status::JOB_APPROVED);
        });
    }

    public function scopeWhereHasEmployerJob($query, $id)
    {
        return $query->whereHas('job', function ($job) use ($id) {
            $job->whereHas('employer', function ($employer) use ($id) {
                $employer->where('id', $id);
            });
        });
    }
}
