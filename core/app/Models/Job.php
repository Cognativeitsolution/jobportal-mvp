<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Job extends Model {
    use GlobalStatus;

    protected $casts = [
        'skills'   => 'array',
        'keywords' => 'object',
    ];

    public function employer() {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function experience() {
        return $this->belongsTo(Experience::class, 'job_experience_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function city() {
        return $this->belongsTo(Location::class, 'city_id');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    public function salaryPeriod() {
        return $this->belongsTo(SalaryPeriod::class, 'salary_period');
    }

    public function jobApplication() {
        return $this->hasMany(JobApply::class, 'job_id');
    }

    public function favoriteItems() {
        return $this->hasMany(FavoriteItem::class);
    }

    public function jobKeywords() {
        return $this->belongsToMany(Keyword::class, 'job_keyword');
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function deposit() {
        return $this->belongsTo(Deposit::class);
    }

    public function statusBadge(): Attribute {
        return new Attribute(
            get: fn() => $this->badgeData(),
        );
    }

    public function badgeData() {
        $html = '';
        if ($this->status == Status::JOB_PENDING) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } else if ($this->status == Status::JOB_APPROVED) {
            $html = '<span class="badge badge--success">' . trans('Approved') . '</span>';
        } else if ($this->status == Status::JOB_EXPIRED) {
            $html = '<span class="badge badge--danger">' . trans('Expired') . '</span>';
        } else if ($this->status == Status::JOB_REJECTED) {
            $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
        } else {
            $html = '<span class="badge badge--dark">' . trans('Incomplete') . '</span>';
        }
        return $html;
    }

    public function jobLocationName() {
        if ($this->job_location_type == Status::ONSITE) {
            return trans('On-site');
        } else if ($this->job_location_type == Status::REMOTE) {
            return trans('Remote');
        } else if ($this->job_location_type == Status::FIELD) {
            return trans('Field');
        } else {
            return trans('Hybrid');
        }
    }

    public function getGender() {
        if ($this->gender == Status::MALE) {
            return trans('Male');
        } else if ($this->gender == Status::FEMALE) {
            return trans('Female');
        } else if ($this->gender == Status::OTHERS) {
            return trans('Others');
        } else {
            return trans('Any');
        }
    }

    public function getSalaryAmountAttribute() {
        if ($this->salary_type != Status::RANGE) {
            return trans('Negotiable');
        }

        $currencySymbol = gs('cur_sym');
        $decimalPlaces  = 0;
        $options        = [
            'kFormat'        => true,
            'currencyFormat' => false,
        ];

        $from = $currencySymbol . showAmount($this->salary_from, $decimalPlaces, ...$options);
        $to   = $currencySymbol . showAmount($this->salary_to, $decimalPlaces, ...$options);

        return "$from - $to";
    }

    public function scopeFeatured($query) {
        return $query->where('featured', Status::YES);
    }

    public function scopePending($query) {
        return $query->where('status', Status::JOB_PENDING);
    }

    public function scopeApproved($query) {
        return $query->where('status', Status::JOB_APPROVED);
    }

    public function scopeExpired($query) {
        return $query->where('status', Status::JOB_EXPIRED);
    }

    public function scopeRejected($query) {
        return $query->where('status', Status::JOB_REJECTED);
    }

    public function scopeIncomplete($query) {
        return $query->where('status', Status::JOB_INCOMPLETE);
    }

    public function scopeWhereHasActiveCategory($query) {
        return $query->whereHas('category', function ($category) {
            $category->active();
        });
    }

    public function scopeWhereHasActiveRole($query) {
        return $query->whereHas('role', function ($role) {
            $role->active();
        });
    }
}
