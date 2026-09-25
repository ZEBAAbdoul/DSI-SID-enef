<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fraîcheur de la géolocalisation (secondes)
    |--------------------------------------------------------------------------
    | Durée entre deux recherches de la position d'une adresse IP (réseau local
    | et IP publiques). Plus la valeur est courte, plus les lieux des visiteurs
    | sont récupérés « en temps réel ».
    |
    | ⚠️  Le service gratuit ip-api.com limite à 45 requêtes/minute : une valeur
    | trop basse peut déclencher un refus temporaire (403). 300 s (5 min) est
    | un bon compromis entre fraîcheur et limite du service.
    */
    'geo_ttl_secondes' => (int) env('STATISTIQUES_GEO_TTL', 300),
];