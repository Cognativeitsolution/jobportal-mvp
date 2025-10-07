<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function scopeEmployerVisitor($query, $employerId)
    {
        $query->whereHas('job', function ($job) use ($employerId) {
            $job->where('employer_id', $employerId);
        });
    }
}
