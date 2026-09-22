<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FormationInformation extends Model
{
    protected $table = 'formation_informations';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'categorie',
        'libelle',
        'valeur',
        'ordre',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->id ??= (string) Str::uuid();
        });
    }
}