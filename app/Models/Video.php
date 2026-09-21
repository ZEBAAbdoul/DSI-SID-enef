<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'url',
        'ordre',
        'est_visible',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'est_visible' => 'boolean',
    ];
}
