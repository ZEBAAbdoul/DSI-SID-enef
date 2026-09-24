<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Cache de géolocalisation par adresse IP (évite un appel externe à chaque requête).
 */
class StatistiqueGeo extends Model
{
    protected $table = 'statistiques_geo';

    protected $primaryKey = 'ip';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'ip',
        'pays',
        'pays_code',
        'region',
        'ville',
        'recherche_a',
    ];

    protected $casts = [
        'recherche_a' => 'datetime',
    ];
}