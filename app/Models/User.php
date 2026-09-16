<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * UUID comme clé primaire
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Champs remplissables
     */
    protected $fillable = [
        'personne_id',
        'email',
        'password',
        'mode',
        'email_verified_at', // utile si vérification email
    ];

    /**
     * Champs masqués (JSON / API)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime:d/m/Y H:i',
        'updated_at'        => 'datetime:d/m/Y H:i',
    ];

    /**
     * Génération automatique UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /* =====================================================
     |                    RELATIONS
     ===================================================== */

    /**
     * L'état civil rattaché à ce compte
     */
    public function personne()
    {
        return $this->belongsTo(Personne::class);
    }

    /* =====================================================
     |                    SCOPES
     ===================================================== */

    /**
     * Scope : filtre par rôle
     */
    public function scopeByRole($query, $role)
    {
        if ($role) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }
        return $query;
    }

    /**
     * Scope : filtre par date de création
     */
    public function scopeCreatedOn($query, $date)
    {
        if ($date) {
            $query->whereDate('created_at', $date);
        }
        return $query;
    }

    /* =====================================================
     |                ATTRIBUTS VIRTUELS
     ===================================================== */

    /**
     * Rôles formatés (DataTable / Vue)
     */
    public function getRolesBadgeAttribute()
    {
        if ($this->roles->isEmpty()) {
            return '<span class="badge bg-secondary">Aucun</span>';
        }

        return $this->roles
            ->map(
                fn($role) =>
                '<span class="badge bg-info mr-1">' . e($role->name) . '</span>'
            )
            ->implode(' ');
    }

    /**
     * Nom complet, lu depuis la personne rattachée.
     * Conserve la compatibilité avec le code / les vues
     * qui appellent encore $user->name.
     */
    public function getNameAttribute()
    {
        return $this->personne?->nom_complet;
    }

    /**
     * Nom + Email (utile pour listes / logs)
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->name ?? '—';

        return "{$name} ({$this->email})";
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }
    
}
