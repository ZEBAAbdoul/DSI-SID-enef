<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UnitePedagogique extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'unites_pedagogiques';

    protected $fillable = [
        'numero',
        'titre',
        'slug',
        'note',
        'photo',
        'concept',
        'objectif_general',
        'objectifs_specifiques',
        'sous_unites',
        'ordre',
        'est_publie',
    ];

    protected $casts = [
        'objectifs_specifiques' => 'array',
        'sous_unites'           => 'array',
        'est_publie'            => 'boolean',
    ];

    /**
     * URL publique de la photo (ou null si aucune photo).
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }

    public function scopePubliees($query)
    {
        return $query->where('est_publie', true);
    }
}