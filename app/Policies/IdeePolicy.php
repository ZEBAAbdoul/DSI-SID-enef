<?php

namespace App\Policies;

use App\Models\Idee;
use App\Models\User;

class IdeePolicy
{
    /** Personnel : tout le monde sauf le DG (et les élèves/candidats). */
    /** Tout le monde peut proposer une idée, sauf le DG. */
public function soumettre(User $user): bool
{
    return ! $user->hasRole('dg');
}

    /** DG et SG voient et traitent toutes les idées. */
    public function voirToutes(User $user): bool
    {
        return $user->hasAnyRole(['dg', 'sg', 'super-admin']);
    }

    public function traiter(User $user): bool
    {
        return $this->voirToutes($user);
    }

    public function view(User $user, Idee $idee): bool
    {
        return $idee->user_id === $user->id || $this->voirToutes($user);
    }

    public function update(User $user, Idee $idee): bool
    {
        return $idee->user_id === $user->id
            && $idee->estModifiable()
            && $this->soumettre($user);
    }

    public function delete(User $user, Idee $idee): bool
    {
        return $this->update($user, $idee);
    }
}