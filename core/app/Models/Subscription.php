<?php

namespace App\Models;

use App\Constants\Status;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subscription extends Model
{
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::SUBSCRIPTION_PENDING);
    }
    public function scopeApproved($query)
    {
        return $query->where('status', Status::SUBSCRIPTION_APPROVED);
    }
    public function scopeExpired($query)
    {
        return $query->where('status', Status::SUBSCRIPTION_EXPIRED);
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
        if ($this->status == Status::SUBSCRIPTION_APPROVED) {
            $html = '<span class="badge badge--success">' . trans('Approved') . '</span>';
        } elseif ($this->status == Status::SUBSCRIPTION_PENDING) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } else {
            $html = '<span class="badge badge--danger">' . trans('Expired') . '</span>';
        }
        return $html;
    }
}
