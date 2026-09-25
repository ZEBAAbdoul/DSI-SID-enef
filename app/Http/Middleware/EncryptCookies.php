<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Cookie posé par les pages publiques : IP publique révélée par le
        // navigateur, utilisée pour géolocaliser les visites locales
        // (localhost/LAN) avec la vraie ville du visiteur.
        'enef_ip_pub',
        // Identifiant stable de visiteur : posé par le middleware TrackVisite,
        // lu à cru pour ne pas compter deux fois le même visiteur le même jour.
        'enef_visiteur',
    ];
}
