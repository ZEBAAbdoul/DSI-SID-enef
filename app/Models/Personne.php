<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'nationalite_type',
        'pays_nationalite',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'piece_type',
        'piece_numero',
        'telephone_indicatif',
        'telephone',
        'adresse',
        'ville',
        'pays_residence',
    ];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
        ];
    }

    /**
     * Le compte utilisateur rattaché à cette personne.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Nom complet pour affichage (ex. dashboard, e-mails).
     */
    public function getNomCompletAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    /**
     * Numéro de téléphone complet avec indicatif.
     */
    public function getTelephoneCompletAttribute(): string
    {
        return trim("{$this->telephone_indicatif} {$this->telephone}");
    }
}