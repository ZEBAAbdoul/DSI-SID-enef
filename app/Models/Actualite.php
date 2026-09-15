<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Actualite extends Model
{
    protected $table = 'actualites';
    
    protected $fillable = [
        'slug',
        'titre',
        'chapo',
        'contenu',
        'image_couverture_url',
        'type',
        'ordre_menu',
        'is_publiee',
        'meta_description',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_publiee' => 'boolean',
        'ordre_menu' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method pour générer automatiquement le slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($actualite) {
            if (empty($actualite->slug)) {
                $actualite->slug = Str::slug($actualite->titre) . '-' . Str::random(6);
            }
        });
        
        static::updating(function ($actualite) {
            if ($actualite->isDirty('titre')) {
                $actualite->slug = Str::slug($actualite->titre) . '-' . Str::random(6);
            }
        });
    }

    // Relations
    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function moderateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // Scopes
    public function scopePubliees($query)
    {
        return $query->where('is_publiee', true);
    }

    public function scopeNonPubliees($query)
    {
        return $query->where('is_publiee', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdonnees($query)
    {
        return $query->orderBy('ordre_menu', 'asc');
    }

    public function scopeRecentes($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    // Accesseurs
    public function getTypeLibelleAttribute(): string
    {
        $types = [
            'institutionnelle' => 'Institutionnelle',
            'formation' => 'Formation',
            'evenement' => 'Événement',
            'partenariat' => 'Partenariat',
            'communique' => 'Communiqué'
        ];
        return $types[$this->type] ?? $this->type;
    }

    public function getTypeBadgeAttribute(): string
    {
        $badges = [
            'institutionnelle' => 'badge-primary',
            'formation' => 'badge-success',
            'evenement' => 'badge-warning',
            'partenariat' => 'badge-info',
            'communique' => 'badge-danger'
        ];
        return $badges[$this->type] ?? 'badge-secondary';
    }

    public function getStatutLibelleAttribute(): string
    {
        return $this->is_publiee ? 'Publiée' : 'Brouillon';
    }

    public function getStatutBadgeAttribute(): string
    {
        return $this->is_publiee ? 'badge-success' : 'badge-secondary';
    }

    public function getResumeAttribute(): string
    {
        return Str::limit(strip_tags($this->contenu), 150);
    }

    public function getImageAttribute()
    {
        if ($this->image_couverture_url) {
            return asset($this->image_couverture_url);
        }
        return asset('images/default-news.jpg');
    }

    // Mutateurs
    public function setTitreAttribute($value)
    {
        $this->attributes['titre'] = trim($value);
    }

    public function setChapoAttribute($value)
    {
        $this->attributes['chapo'] = $value ? trim($value) : null;
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    // Méthodes utilitaires
    public function estPubliee(): bool
    {
        return $this->is_publiee === true;
    }

    public function publier(): void
    {
        $this->is_publiee = true;
        $this->save();
    }

    public function depublier(): void
    {
        $this->is_publiee = false;
        $this->save();
    }
}