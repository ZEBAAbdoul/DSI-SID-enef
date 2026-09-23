<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceInscription extends Model
{
    use HasFactory;

    protected $table = 'pieces_inscription';

    protected $fillable = [
        'inscription_id',
        'type_piece',
        'fichier_url',
        'format_fichier',
        'taille_fichier_ko',
        'statut_verification',
        'commentaire',

        'resoumis',
        'verifie_le',
    ];

    protected $casts = [
        'taille_fichier_ko' => 'integer',
        
        'resoumis' => 'boolean',
        'verifie_le' => 'datetime',
    ];

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function typePiece(): BelongsTo
    {
        return $this->belongsTo(TypePiece::class, 'type_piece', 'code');
    }

    public function getTypePieceLibelleAttribute(): string
    {
        return $this->typePiece?->libelle ?? 'Autre document';
    }

    public function estConforme(): bool
    {
        return $this->statut_verification === 'conforme';
    }

    public function estNonConforme(): bool
    {
        return $this->statut_verification === 'non_conforme';
    }

    public function estEnAttente(): bool
    {
        return $this->statut_verification === 'en_attente';
    }
}
