<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'image_url',
        'ordre',
        'est_visible',
    ];

    protected $casts = [
        'est_visible' => 'boolean',
        'ordre' => 'integer',
    ];
}