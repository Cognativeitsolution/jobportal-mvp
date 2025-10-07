<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model {
    use GlobalStatus;

    public function employers() {
        return $this->hasMany(Employer::class);
    }

    public function jobs() {
        return $this->hasManyThrough(Job::class, Employer::class);
    }
    public function companyJobs() {
        return $this->hasManyThrough(Job::class, Employer::class, 'industry_id', 'employer_id', 'id', 'id');
    }

    public function scopeJobCount($query) {
        return $query->withCount('jobs');
    }

    public function scopeWhereHasEmployers($query) {
        $query->whereHas('employers.jobs', function ($jobs) {
            $jobs->approved();
        });
    }

    public function scopeWithEmployers($query) {
        $query->with('employers', function ($employers) {
            $employers->whereHas('jobs', function ($jobs) {
                $jobs->approved();
            });
        });
    }
}
