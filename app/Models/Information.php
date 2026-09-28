<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasUuids;

    protected $table = 'informations';

    protected $fillable = [
        'titre', 'contenu', 'cible', 'fichier_path', 'fichier_nom',
        'est_publie', 'publie_le', 'created_by',
    ];

    protected $casts = [
        'est_publie' => 'boolean',
        'publie_le'  => 'datetime',
    ];

    public const CIBLES = [
        'tous'       => 'Elèves et enseignants',
        'user'       => 'Elèves uniquement',
        'enseignant' => 'Enseignants uniquement',
    ];

    /** Informations publiées et destinées à cet utilisateur. */
    public function scopePourUtilisateur($query, $user)
    {
        $cibles = ['tous'];

        if ($user->hasRole('user')) {
            $cibles[] = 'user';
        }
        if ($user->hasRole('enseignant')) {
            $cibles[] = 'enseignant';
        }

        return $query->where('est_publie', true)->whereIn('cible', $cibles);
    }

    public function estVisiblePar($user): bool
    {
        return self::pourUtilisateur($user)->whereKey($this->id)->exists();
    }
}