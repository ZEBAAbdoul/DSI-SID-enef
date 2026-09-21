<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temoignage extends Model
{
    use HasFactory, HasUuids;

    /**
     * Le nom de la table associée.
     */
    protected $table = 'temoignages';

    /**
     * Indique que la clé primaire n'est pas auto-incrémentée.
     */
    public $incrementing = false;

    /**
     * Le type de la clé primaire.
     */
    protected $keyType = 'string';

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'user_id',
        'contenu',
        'auteur',
        'fonction',
        'note',
        'formation_concernee',
        'image_url',
        'est_publie',
        'ordre',
    ];

    /**
     * Conversion des types d'attributs.
     */
    protected function casts(): array
    {
        return [
            'note' => 'integer',
            'est_publie' => 'boolean',
            'ordre' => 'integer',
        ];
    }

    /**
     * Relation avec l'utilisateur ayant créé le témoignage.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope : uniquement les témoignages publiés.
     */
    public function scopePublies($query)
    {
        return $query->where('est_publie', true);
    }

    /**
     * Scope : trier par ordre d'affichage.
     */
    public function scopeOrdonnes($query)
    {
        return $query->orderBy('ordre');
    }
}