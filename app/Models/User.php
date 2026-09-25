<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Rôles dont les comptes sont masqués de la gestion des utilisateurs (noms en minuscules).
     */
    public const ROLES_MASQUES = ['super-admin'];


    /**
     * UUID comme clé primaire
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Valeurs par défaut (évite que est_actif soit null sur un utilisateur
     * tout juste créé, avant rechargement depuis la base)
     */
    protected $attributes = [
        'est_actif' => true,
    ];

    /**
     * Champs remplissables
     * (est_actif n'y figure volontairement pas : il ne se modifie que via toggle())
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
        'est_actif'         => 'boolean',
        'password' => 'hashed',

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

    /**
     * Scope : filtre par statut du compte ('actif' | 'inactif' | vide = tous)
     */
    public function scopeByStatut($query, $statut)
    {
        return match ($statut) {
            'actif'   => $query->where('est_actif', true),
            'inactif' => $query->where('est_actif', false),
            default   => $query,
        };
    }

    /**
     * Scope : exclut les comptes ayant un rôle masqué (ex. super-admin)
     */
    public function scopeVisibles($query)
    {
        $table = config('permission.table_names.roles', 'roles');

        return $query->whereDoesntHave(
            'roles',
            fn($r) => $r->whereIn(DB::raw("LOWER({$table}.name)"), self::ROLES_MASQUES)
        );
    }

    /**
     * Scopes raccourcis
     */
    public function scopeActifs($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeInactifs($query)
    {
        return $query->where('est_actif', false);
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

    /**
     * Ce compte est-il masqué de la liste des utilisateurs (rôle super-admin) ?
     */
    public function estMasque(): bool
    {
        return $this->roles->contains(
            fn($role) => in_array(mb_strtolower($role->name), self::ROLES_MASQUES, true)
        );
    }

    /**
     * Le compte est-il autorisé à se connecter ?
     */
    public function estActif(): bool
    {
        return (bool) $this->est_actif;
    }

    public function enseignant()
    {
        return $this->hasOne(Enseignant::class);
    }
}
