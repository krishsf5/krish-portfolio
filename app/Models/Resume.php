<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'size_kb',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'size_kb'   => 'integer',
    ];
}
