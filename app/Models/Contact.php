<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['first_name', 'last_name', 'mobile_number', 'email', 'designation', 'address', 'notes'])]
class Contact extends Model
{
    use HasFactory;

    /**
     * Get the contact's full name.
     */
    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
