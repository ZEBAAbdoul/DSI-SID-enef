<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RechercheInnovation extends Model
{
    use HasFactory;

    protected $table = 'recherches_innovations';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'slug',
        'titre',
        'chapo',
        'contenu',
        'photo',
        'url_video',
        'document',
        'type',
        'is_publiee',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'photo' => 'array',
        'is_publiee' => 'boolean',
    ];

    /**
     * Génération automatique du UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rechercheInnovation) {
            if (empty($rechercheInnovation->id)) {
                $rechercheInnovation->id = (string) Str::uuid();
            }

            if (empty($rechercheInnovation->slug) && !empty($rechercheInnovation->titre)) {
                $rechercheInnovation->slug = Str::slug($rechercheInnovation->titre) . '-' . Str::lower(Str::random(6));
            }
        });
    }

    /**
     * Utilisateur ayant créé l'enregistrement
     */
    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Utilisateur ayant effectué la dernière modification
     */
    public function modificateur()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSEURS
    |--------------------------------------------------------------------------
    */

    /**
     * Libellé du type : Recherche ou Innovation
     */
    public function getTypeLibelleAttribute(): string
    {
        return $this->type === 'innovation' ? 'Innovation' : 'Recherche';
    }

    /**
     * Badge Bootstrap du type
     */
    public function getTypeBadgeAttribute(): string
    {
        return $this->type === 'innovation' ? 'bg-success' : 'bg-info';
    }

    /**
     * Liste des chemins des photos (compatible ancienne valeur simple ou JSON)
     */
    public function getPhotoListAttribute(): array
    {
        $photo = $this->photo;

        if (is_array($photo)) {
            return array_values(array_filter($photo));
        }

        if (is_string($photo) && $photo !== '') {
            return [$photo];
        }

        return [];
    }

    /**
     * URLs publiques de toutes les photos
     */
    public function getPhotosAttribute(): array
    {
        return array_map(
            fn (string $chemin) => asset('storage/' . $chemin),
            $this->photo_list
        );
    }

    /**
     * Première photo (couverture), ou null si absente
     */
    public function getImageAttribute(): ?string
    {
        return $this->photos[0] ?? null;
    }

    /**
     * Libellé du statut de publication
     */
    public function getStatutLibelleAttribute(): string
    {
        return $this->is_publiee ? 'Publiée' : 'Brouillon';
    }

    /**
     * Badge Bootstrap du statut
     */
    public function getStatutBadgeAttribute(): string
    {
        return $this->is_publiee ? 'bg-success' : 'bg-secondary';
    }

    /**
     * Nom affichable du document joint (sans le chemin)
     */
    public function getDocumentNomAttribute(): ?string
    {
        if (!$this->document) {
            return null;
        }

        $parties = explode('/', $this->document);

        return rawurldecode(end($parties));
    }

    /**
     * URL d'intégration (iframe) pour YouTube, Vimeo ou Dailymotion.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $url = trim($this->url_video ?? '');

        if (!$url) {
            return null;
        }

        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([\w-]{6,})~i', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/' . $m[1];
        }

        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~i', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        if (preg_match('~(?:dailymotion\.com/video/|dai\.ly/)([a-z0-9]+)~i', $url, $m)) {
            return 'https://www.dailymotion.com/embed/video/' . $m[1];
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Recherche par mot-clé sur le titre, le chapô ou le contenu.
     */
    public function scopeRecherche($query, ?string $terme)
    {
        if (!$terme) {
            return $query;
        }

        return $query->where(function ($q) use ($terme) {
            $q->where('titre', 'ILIKE', "%{$terme}%")
                ->orWhere('chapo', 'ILIKE', "%{$terme}%")
                ->orWhere('contenu', 'ILIKE', "%{$terme}%");
        });
    }

    /**
     * Filtre par type (recherche | innovation).
     */
    public function scopeDeType($query, ?string $type)
    {
        return $type ? $query->where('type', $type) : $query;
    }

    /**
     * Uniquement les contenus publiés.
     */
    public function scopePubliees($query)
    {
        return $query->where('is_publiee', true);
    }

    /**
     * Uniquement les brouillons.
     */
    public function scopeNonPubliees($query)
    {
        return $query->where('is_publiee', false);
    }

    /**
     * Filtre par statut (publiee | brouillon).
     */
    public function scopeDeStatut($query, ?string $statut)
    {
        if ($statut === 'publiee') {
            return $query->where('is_publiee', true);
        }

        if ($statut === 'brouillon') {
            return $query->where('is_publiee', false);
        }

        return $query;
    }
}
