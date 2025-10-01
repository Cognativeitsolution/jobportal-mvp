<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    use GlobalStatus;

    public function EducationDegrees()
    {
        return $this->hasMany(EducationDegree::class);
    }
}
