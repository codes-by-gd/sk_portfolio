<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevelopmentWork extends Model
{
    protected $fillable = [
        'title_en',
        'title_gu',
        'title_hi',
        'description_en',
        'description_gu',
        'description_hi',
        'location',
        'before_image',
        'after_image',
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_gu;
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_gu;
    }
}
