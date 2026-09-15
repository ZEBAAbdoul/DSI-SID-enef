<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matiere extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'filiere_id',
        'nom',
        'code',
        'coefficient',
        'volume_horaire',
    ];

   protected $casts = [
    'coefficient' => 'decimal:2',
    'volume_horaire' => 'integer',
    'filiere_id' => 'string', // UUID
];

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}