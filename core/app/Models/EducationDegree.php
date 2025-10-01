<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class EducationDegree extends Model
{
    use GlobalStatus;

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
