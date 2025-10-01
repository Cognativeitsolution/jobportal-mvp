<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalQualification extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class);
    }

    public function educationDegree()
    {
        return $this->belongsTo(EducationDegree::class);
    }

    public function educationGroup()
    {
        return $this->belongsTo(EducationGroup::class);
    }
}
