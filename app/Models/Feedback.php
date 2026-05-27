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
        'message',
        'rating',
        'status',
        'is_featured',
    ];
}
