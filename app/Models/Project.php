<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'live_url',
        'repo_url',
        'tags'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (!$project->slug) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    protected $casts = [
        'tags' => 'array'
    ];
}
