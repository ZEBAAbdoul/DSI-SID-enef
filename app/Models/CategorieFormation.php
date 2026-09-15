<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CategorieFormation extends Model
{
    use HasUuids;

    protected $table = 'categories_formation';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nom',
        'slug',
        'id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method pour générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($categorie) {
            if (empty($categorie->slug)) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });
        
        static::updating(function ($categorie) {
            if ($categorie->isDirty('nom')) {
                $categorie->slug = Str::slug($categorie->nom);
            }
        });
    }

    // Relation avec les formations
    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class, 'categorie_id');
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

    // Mutateur pour le nom (auto-formatage)
    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = trim($value);
    }
}