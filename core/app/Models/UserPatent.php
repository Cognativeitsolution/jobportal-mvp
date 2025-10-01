<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserPatent extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::PATENT_ISSUED) {
                $html = '<span class="badge badge--success">' . trans('Issued') . '</span>';
            } else {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            }
            return $html;
        });
    }
}
