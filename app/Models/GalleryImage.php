<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'image_path',
        'category',
        'caption_en',
        'caption_gu',
        'caption_hi',
    ];

    public function getCaptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"caption_{$locale}"} ?? $this->caption_gu;
    }
}
