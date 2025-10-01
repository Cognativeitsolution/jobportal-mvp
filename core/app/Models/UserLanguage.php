<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model {
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function proficientBadge(): Attribute {
        return new Attribute(function () {
            $html = '';
            if ($this->proficiency == Status::LANGUAGE_BEGINNER) {
                $html = '<span class="badge badge--danger">' . trans('Beginner') . '</span>';
            } else if ($this->proficiency == Status::LANGUAGE_PROFICIENT) {
                $html = '<span class="badge badge--warning">' . trans('Proficient') . '</span>';
            } else {
                $html = '<span class="badge badge--success">' . trans('Expert') . '</span>';
            }
            return $html;
        });
    }
}
