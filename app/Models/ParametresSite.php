<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametresSite extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parametres_site';

    /**
     * La clé primaire est un UUID (non auto-incrémentée).
     *
     * @var string
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_site',
        'slogan',
        'logo_url',
        'favicon_url',
        'mot_dg_titre',
        'mot_dg_contenu',
        'mot_dg_photo_url',
        'mot_dg_nom',
        'adresse',
        'telephone',
        'email_contact',
        'annee_creation',
        'personne_forme',
        'facebook_url',
        'linkedin_url',
        'liens_utiles',
        'meta_description',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'annee_creation' => 'integer',
        'personne_forme' => 'integer',
        'liens_utiles' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who last updated the record.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}