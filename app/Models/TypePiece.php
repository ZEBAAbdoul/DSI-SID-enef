<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypePiece extends Model
{
    protected $table = 'types_pieces';

    protected $fillable = [
        'code',
        'libelle',
        'obligatoire',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'obligatoire' => 'boolean',
        'actif'       => 'boolean',
        'ordre'       => 'integer',
    ];

    public function pieces(): HasMany
    {
        return $this->hasMany(PieceInscription::class, 'type_piece', 'code');
    }

    public function scopeActifs($query)
    {
        return $query->where('actif', true)->orderBy('ordre');
    }

    public function scopeObligatoires($query)
    {
        return $query->where('obligatoire', true);
    }
}