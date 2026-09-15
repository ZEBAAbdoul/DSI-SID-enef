<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'enseignant_id',
        'eleve_id',
        'formation_id',
        'session_formation_id',
        'matiere_id',
        'type_evaluation',
        'note',
        'note_max',
        'commentaire',
        'date_evaluation',
    ];

    protected $casts = [
        'note' => 'decimal:2',
        'note_max' => 'decimal:2',
        'date_evaluation' => 'date',
    ];

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(User::class, 'eleve_id');
    }

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(SessionFormation::class, 'session_formation_id');
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function getNoteSur20Attribute(): float
    {
        return round(($this->note / $this->note_max) * 20, 2);
    }
}