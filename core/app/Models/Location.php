<?php

namespace App\Models;

use App\Traits\GlobalStatus;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use GlobalStatus;

    public function town()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function address()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function scopeCity($query)
    {
        return $query->where('parent_id', 0);
    }

    public function scopeLocation($query)
    {
        return $query->where('parent_id', '!=', 0);
    }
}
