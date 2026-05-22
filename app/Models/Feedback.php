<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'name',
        'mobile_number',
        'area',
        'title',
        'message',
        'rating',
        'status',
        'is_featured',
        'avatar_path',
    ];

    public function images()
    {
        return $this->hasMany(FeedbackImage::class, 'feedback_id');
    }
}
