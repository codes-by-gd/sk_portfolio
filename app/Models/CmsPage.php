<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = [
        'key',
        'content_en',
        'content_gu',
        'content_hi',
    ];

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"content_{$locale}"} ?? $this->content_gu;
    }

    public static function getContentByKey($key)
    {
        $page = self::where('key', $key)->first();
        return $page ? $page->content : '';
    }
}
