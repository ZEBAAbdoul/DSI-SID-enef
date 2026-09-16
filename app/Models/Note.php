<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'enseignant_id',
        'formation_id',
        'session_formation_id',
        'matiere_id',
        'type_evaluation',
        'fichier',
        'nom_original',
        'mime_type',
        'taille',
        'commentaire',
        'date_evaluation',
    ];

    protected $casts = [
        'date_evaluation' => 'date',
    ];

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function session()
    {
        return $this->belongsTo(SessionFormation::class, 'session_formation_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
