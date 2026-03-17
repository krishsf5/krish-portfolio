<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'full_name',
        'title',
        'bio',
        'location',
        'email',
        'github_url',
        'linkedin_url',
        'website_url',
        'years_experience',
        'availability',
        'avatar',
    ];

    protected $casts = [
        'years_experience' => 'integer',
    ];
}
