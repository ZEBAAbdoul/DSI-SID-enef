<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Formation extends Model
{
    use HasUuids;

    protected $table = 'formations';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'filiere_id',
        'categorie_id',
        'titre',
        'slug',
        'resume',
        'objectifs',
        'contenu_programme',
        'duree',
        'public_cible',
        'cout_indicatif',
        'image_url',
        'mots_cles',
        'statut',
        'created_by',
    ];

    // app/Models/Formation.php

    protected $appends = [
        'type_libelle',
        'statut_libelle',
        'statut_badge',
        'cout_formate',
        'duree_formatee',
        'mots_cles_array',
    ];

    protected $casts = [
        'cout_indicatif' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method pour générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($formation) {
            if (empty($formation->slug)) {
                $formation->slug = Str::slug($formation->titre) . '-' . Str::random(6);
            }
        });

        static::updating(function ($formation) {
            if ($formation->isDirty('titre')) {
                $formation->slug = Str::slug($formation->titre) . '-' . Str::random(6);
            }
        });
    }

    // Relations
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(CategorieFormation::class, 'categorie_id');
    }

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // Scopes
    public function scopeOuvertes($query)
    {
        return $query->where('statut', 'ouverte');
    }

    public function scopeCloturees($query)
    {
        return $query->where('statut', 'cloturee');
    }

    public function scopeBrouillons($query)
    {
        return $query->where('statut', 'brouillon');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByFiliere($query, $filiereId)
    {
        return $query->where('filiere_id', $filiereId);
    }

    public function scopeByCategorie($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    public function scopeRecherche($query, $terme)
    {
        return $query->where('titre', 'LIKE', "%{$terme}%")
            ->orWhere('resume', 'LIKE', "%{$terme}%")
            ->orWhere('mots_cles', 'LIKE', "%{$terme}%");
    }

    // Accesseurs
    public function getTypeLibelleAttribute(): string
    {
        $types = [
            'academique' => 'Académique',
            'continue_programmee' => 'Continue Programmée',
            'continue_a_la_carte' => 'Continue à la Carte'
        ];
        return $types[$this->type] ?? $this->type;
    }

    public function getStatutLibelleAttribute(): string
    {
        $statuts = [
            'ouverte' => 'Ouverte',
            'cloturee' => 'Clôturée',
            'brouillon' => 'Brouillon'
        ];
        return $statuts[$this->statut] ?? $this->statut;
    }

    public function getStatutBadgeAttribute(): string
    {
        $badges = [
            'ouverte' => 'badge-success',
            'cloturee' => 'badge-danger',
            'brouillon' => 'badge-warning'
        ];
        return $badges[$this->statut] ?? 'badge-secondary';
    }

    public function getCoutFormateAttribute(): string
    {
        if ($this->cout_indicatif === null) {
            return 'Sur devis';
        }
        return number_format($this->cout_indicatif, 0, ',', ' ') . ' FCFA';
    }

    public function getDureeFormateAttribute(): string
    {
        if (empty($this->duree)) {
            return 'Non spécifiée';
        }
        // Si c'est un nombre (heures)
        if (is_numeric($this->duree)) {
            return $this->duree . ' heure' . ($this->duree > 1 ? 's' : '');
        }
        // Sinon (ex: "3 mois"), on renvoie tel quel
        return $this->duree;
    }

    public function getMotsClesArrayAttribute(): array
    {
        if (empty($this->mots_cles)) {
            return [];
        }
        return array_map('trim', explode(',', $this->mots_cles));
    }

    // Mutateurs
    public function setTitreAttribute($value)
    {
        $this->attributes['titre'] = trim($value);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setMotsClesAttribute($value)
    {
        $this->attributes['mots_cles'] = trim($value);
    }

    // Méthodes utilitaires
    public function estOuverte(): bool
    {
        return $this->statut === 'ouverte';
    }

    public function estCloturee(): bool
    {
        return $this->statut === 'cloturee';
    }

    public function estBrouillon(): bool
    {
        return $this->statut === 'brouillon';
    }


    public function sessions(): HasMany
    {
        return $this->hasMany(SessionFormation::class);
    }
}
