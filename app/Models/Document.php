<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'categorie_id',
        'titre',
        'description',
        'type',
        'fichier_url',
        'format_fichier',
        'taille_fichier_ko',
        'acces',
        'version',
        'nombre_telechargements',
        'publie_le',
        'publie_par',
    ];

    protected $casts = [
        'publie_le' => 'datetime',
        'taille_fichier_ko' => 'integer',
        'nombre_telechargements' => 'integer',
        'publie_par' => 'string', // UUID
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(CategorieDocument::class, 'categorie_id');
    }

    public function publiePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'publie_par');
    }
}