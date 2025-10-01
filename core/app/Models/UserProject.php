<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserProject extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::PROJECT_RUNNING) {
                $html = '<span class="badge badge--warning">' . trans('Running') . '</span>';
            } else {
                $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
            }
            return $html;
        });
    }
}
