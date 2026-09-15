<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionFormation extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sessions_formation';

    // UUID : pas d'auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'formation_id',
        'date_debut',
        'date_fin',
        'lieu',
        'places_totales',
        'places_disponibles',
        'statut',
        'created_by',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
    ];

    /**
     * Formation associée à la session.
     */
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    /**
     * Utilisateur qui a créé la session.
     */
    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope : sessions ouvertes.
     */
    public function scopeOuvertes($query)
    {
        return $query->where('statut', 'ouverte');
    }
}