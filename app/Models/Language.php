<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function scopeDefault($query)
    {
        return $query->where('is_default', Status::ENABLE);
    }

    public function scopeNotDefault($query)
    {
        return $query->where('is_default', Status::DISABLE);
    }
}
