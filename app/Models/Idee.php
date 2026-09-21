<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Idee extends Model
{
    use HasUuids;

    protected $table = 'idees';

    protected $fillable = [
        'user_id', 'titre', 'description', 'categorie',
        'statut', 'reponse', 'traitee_par', 'traitee_le',
    ];

    protected $casts = ['traitee_le' => 'datetime'];

    public const STATUTS = [
        'soumise'  => ['label' => 'Soumise',      'badge' => 'secondary'],
        'en_etude' => ['label' => 'En étude',     'badge' => 'info'],
        'acceptee' => ['label' => 'Acceptée',     'badge' => 'success'],
        'realisee' => ['label' => 'Réalisée',     'badge' => 'primary'],
        'refusee'  => ['label' => 'Non retenue',  'badge' => 'danger'],
    ];

    public const CATEGORIES = [
        'pedagogie'       => 'Pédagogie et formation',
        'administration'  => 'Administration et organisation',
        'infrastructures' => 'Infrastructures et équipements',
        'numerique'       => 'Numérique et outils',
        'vie_ecole'       => "Vie de l'école",
        'autre'           => 'Autre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traiteePar()
    {
        return $this->belongsTo(User::class, 'traitee_par');
    }

    public function getStatutLibelleAttribute(): string
    {
        return self::STATUTS[$this->statut]['label'] ?? $this->statut;
    }

    public function getStatutBadgeAttribute(): string
    {
        return self::STATUTS[$this->statut]['badge'] ?? 'secondary';
    }

    public function getCategorieLibelleAttribute(): ?string
    {
        return self::CATEGORIES[$this->categorie] ?? null;
    }

    /** Nom de l'auteur, lu dans la fiche personne (à adapter : prenom / nom). */
    public function getAuteurNomAttribute(): string
    {
        $personne = $this->user?->personne;
        $nom = trim(($personne->prenom ?? '') . ' ' . ($personne->nom ?? ''));

        return $nom !== '' ? $nom : ($this->user?->email ?? 'Utilisateur supprimé');
    }

    /** L'auteur ne peut modifier son idée que tant qu'elle n'a pas été examinée. */
    public function estModifiable(): bool
    {
        return $this->statut === 'soumise';
    }
}