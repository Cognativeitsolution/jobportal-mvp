<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frontend extends Model
{
    protected $casts = [
        'data_values' => 'object',
        'seo_content' => 'object',
    ];

    public static function scopeGetContent($data_keys)
    {
        return Frontend::where('data_keys', $data_keys);
    }

    public function faqs()
    {
        return $this->morphMany(Faq::class, 'faqable');
    }
}
