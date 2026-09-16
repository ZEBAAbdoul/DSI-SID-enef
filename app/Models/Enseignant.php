<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Enseignant extends Model
{
    use HasUuids;

    protected $table = 'enseignants';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'matricule',
        'specialite',
        'telephone',
        'statut',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'statut_libelle',
        'statut_badge',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT : génération automatique du matricule
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($enseignant) {
            if (empty($enseignant->matricule)) {
                $enseignant->matricule = 'ENS-' . strtoupper(Str::random(6));
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSEUR : personne (via user.personne)
    |--------------------------------------------------------------------------
    |
    | Ce n'est pas une relation Eloquent — enseignants.user_id -> users.id
    | puis users.personne_id -> personnes.id sont deux "belongsTo" imbriqués,
    | pas une chaîne compatible avec hasOneThrough. On charge donc "user.personne"
    | en eager loading côté contrôleur, et cet accesseur expose juste le résultat.
    |--------------------------------------------------------------------------
    */
    public function getPersonneAttribute()
    {
        return $this->user?->personne;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeByStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    public function scopeRecherche($query, $terme)
    {
        return $query->where(function ($q) use ($terme) {
            $q->where('matricule', 'ILIKE', "%{$terme}%")
                ->orWhere('specialite', 'ILIKE', "%{$terme}%")
                ->orWhereHas('user.personne', function ($sousQuery) use ($terme) {
                    $sousQuery->where('nom', 'ILIKE', "%{$terme}%")
                        ->orWhere('prenom', 'ILIKE', "%{$terme}%");
                });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSEURS
    |--------------------------------------------------------------------------
    */
    public function getStatutLibelleAttribute(): string
    {
        $statuts = [
            'actif'    => 'Actif',
            'inactif'  => 'Inactif',
            'suspendu' => 'Suspendu',
        ];

        return $statuts[$this->statut] ?? $this->statut;
    }

    public function getStatutBadgeAttribute(): string
    {
        $badges = [
            'actif'    => 'badge-success',
            'inactif'  => 'badge-secondary',
            'suspendu' => 'badge-danger',
        ];

        return $badges[$this->statut] ?? 'badge-secondary';
    }

    public function getNomCompletAttribute(): string
    {
        return $this->user?->name ?? $this->matricule;
    }
}
