<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidat_id',
        'formation_id',
        'session_formation_id',
        'numero_dossier',
        'statut',
        'motif_rejet',
        'date_soumission',
        'date_traitement',
        'traite_par',
    ];

    protected $casts = [
        'date_soumission' => 'datetime',
        'date_traitement' => 'datetime',
    ];

    /* -----------------------------------------------------------------
     |  Génération du numéro de dossier
     | -----------------------------------------------------------------
     */

    public static function genererNumeroDossier(): string
    {
        $annee = now()->format('Y');

        do {
            $numero = sprintf('INS-%s-%06d', $annee, random_int(1, 999999));
        } while (self::where('numero_dossier', $numero)->exists());

        return $numero;
    }

    /* -----------------------------------------------------------------
     |  Relations
     | -----------------------------------------------------------------
     */

    public function candidat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidat_id');
    }

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(SessionFormation::class, 'session_formation_id');
    }

    public function pieces(): HasMany
    {
        return $this->hasMany(PieceInscription::class);
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    public function scopeEnCours($query)
    {
        return $query->whereIn('statut', ['depose', 'en_cours']);
    }

    /* -----------------------------------------------------------------
     |  Complétude / validation du dossier (pilotées par TypePiece)
     | -----------------------------------------------------------------
     */

    public function typesPiecesManquants()
    {
        $codesRequis = TypePiece::actifs()->obligatoires()->pluck('code');
        $codesDeposes = $this->pieces->pluck('type_piece')->unique();

        return $codesRequis->diff($codesDeposes)->values();
    }

    public function dossierComplet(): bool
    {
        return $this->typesPiecesManquants()->isEmpty();
    }

    public function dossierValide(): bool
    {
        if (! $this->dossierComplet()) {
            return false;
        }

        return TypePiece::actifs()->obligatoires()->get()
            ->every(fn ($type) => $this->pieces
                ->where('type_piece', $type->code)
                ->contains(fn ($piece) => $piece->estConforme())
            );
    }
}