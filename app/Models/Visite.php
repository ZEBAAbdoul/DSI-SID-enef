<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Journal des visites du site public : une ligne par page vue.
 */
class Visite extends Model
{
    protected $table = 'visites';

    protected $fillable = [
        'visite_a',
        'date',
        'page',
        'session_id',
        'ip',
        'pays',
        'pays_code',
        'region',
        'ville',
    ];

    protected $casts = [
        'visite_a' => 'datetime',
        'date' => 'date',
    ];
}