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
        'tags',
        'status',
        'is_visible',
        'sort_order',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (! $project->slug) {
                $base = Str::slug($project->title);

                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $project->slug = $slug;
            }
        });
    }

    protected $casts = [
        'tags' => 'array',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
    ];
}
