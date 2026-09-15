<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Filiere extends Model
{
        use HasUuids;
    protected $table = 'filieres';
    

    // AJOUTER CES DEUX LIGNES :
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'code',
        'responsable',
        'email_contact',
        'est_active'
    ];

    protected $casts = [
        'est_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method pour générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($filiere) {
            if (empty($filiere->slug)) {
                $filiere->slug = Str::slug($filiere->nom);
            }
        });
        
        static::updating(function ($filiere) {
            if ($filiere->isDirty('nom')) {
                $filiere->slug = Str::slug($filiere->nom);
            }
        });
    }

    // Relation avec les formations
    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class, 'filiere_id');
    }

    // Scope pour les filières actives
    public function scopeActive($query)
    {
        return $query->where('est_active', true);
    }

    // Scope pour les filières inactives
    public function scopeInactive($query)
    {
        return $query->where('est_active', false);
    }

    // Scope pour rechercher par code
    public function scopeWhereCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Scope pour rechercher par slug
    public function scopeWhereSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Accesseur pour le nom formaté
    public function getNomFormateAttribute(): string
    {
        return ucfirst($this->nom);
    }

    // Accesseur pour savoir si la filière a des formations
    public function getHasFormationsAttribute(): bool
    {
        return $this->formations()->count() > 0;
    }

    // Accesseur pour le nombre de formations
    public function getNombreFormationsAttribute(): int
    {
        return $this->formations()->count();
    }

    // Mutateur pour le nom (auto-formatage)
    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = trim($value);
    }

    // Mutateur pour le code (mise en majuscule)
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(trim($value));
    }

    // Mutateur pour l'email (nettoyage)
    public function setEmailContactAttribute($value)
    {
        $this->attributes['email_contact'] = strtolower(trim($value));
    }
}