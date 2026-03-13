<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'live_url',
        'repo_url',
        'tags',
        'status',
        'is_visible',
        'sort_order',
    ];

    protected $casts = [
        'tags'       => AsArray::class,
        'is_visible' => 'boolean',
    ];
}
