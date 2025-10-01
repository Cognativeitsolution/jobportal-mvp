<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\EmployerNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employer extends Authenticatable
{
    use EmployerNotify, GlobalStatus;

    protected $casts = [
        'social_media' => 'object',
        'ver_code_send_at' => 'datetime'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function numberOfEmployee()
    {
        return $this->belongsTo(NumberOfEmployees::class, 'number_of_employees_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn() => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function mobileNumber(): Attribute
    {
        return new Attribute(
            get: fn() => $this->dial_code . $this->mobile,
        );
    }

    public function featuredBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->is_featured == Status::YES) {
                $html = '<span class="badge badge--success">' . trans('Yes') . '</span>';
            } elseif ($this->is_featured == Status::NO) {
                $html = '<span class="badge badge--dark">' . trans('No') . '</span>';
            }
            return $html;
        });
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::NO);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::NO);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }
    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }

    public function scopeActiveSubscription($query)
    {
        return $query->whereHas('subscriptions', function ($subscription) {
            $subscription->approved();
        });
    }

    public function scopeFeaturedEmployer($query)
    {
        return $query->where('is_featured', Status::YES);
    }

    public function scopeSubscriptionApproved($query)
    {
        return $query->where('subscription_status', Status::SUBSCRIPTION_APPROVED);
    }

    public function scopeWhereHasActiveIndustry($query)
    {
        return $query->whereHas('industry', function ($industry) {
            $industry->active();
        });
    }
}
