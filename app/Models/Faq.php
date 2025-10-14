<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;
    use GlobalStatus;

    protected $fillable = [
        'faqable_id',
        'faqable_type',
        'question',
        'answer',
        'status',
    ];

    /**
     * Polymorphic relation
     */
    public function faqable()
    {
        return $this->morphTo();
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', Status::ENABLE);
    }

    public function scopeNotDefault($query)
    {
        return $query->where('is_default', Status::DISABLE);
    }
}
