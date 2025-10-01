<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, UserNotify;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ver_code',
        'balance',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address'           => 'object',
        'ver_code_send_at'  => 'datetime',
        'language'          => 'object',
        'skill'             => 'object',
        'social_links'      => 'object',
        'profile_update_percent_list' => 'array',
        'permanent_address' => 'array',
    ];

    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function jobApplies()
    {
        return $this->hasMany(JobApply::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function employment()
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function education()
    {
        return $this->hasMany(EducationalQualification::class);
    }

    public function userItSkills()
    {
        return $this->hasMany(UserItSkill::class);
    }

    public function userProjects()
    {
        return $this->hasMany(UserProject::class);
    }

    public function userOnlineProfiles()
    {
        return $this->hasMany(UserOnlineProfile::class);
    }

    public function userPublications()
    {
        return $this->hasMany(UserPublication::class);
    }

    public function userPresentations()
    {
        return $this->hasMany(UserPresentation::class);
    }

    public function userPatents()
    {
        return $this->hasMany(UserPatent::class);
    }

    public function userCertifications()
    {
        return $this->hasMany(UserCertification::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function userLanguages()
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function userSkills()
    {
        return $this->hasMany(UserSkill::class);
    }

    public function favoriteItems()
    {
        return $this->hasMany(FavoriteItem::class);
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

    public function workStatusValue(): Attribute
    {
        return new Attribute(
            get: fn() => @$this->work_status == Status::WORK_STATUS_FRESHER ? trans('Fresher') : $this->designation,
        );
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
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
}
