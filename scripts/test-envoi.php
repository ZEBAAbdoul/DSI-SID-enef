<?php

/*
 * Test d'envoi du formulaire de contact vers infos@enef.gov.bf.
 *
 * À exécuter depuis le serveur de production :
 *     php scripts/test-envoi.php
 *
 * Il faut que le .env soit configuré (relais SMTP, ex. Gmail) dans MAIL_HOST.
 * Affiche aussi si l'IP publique locale est sur la liste noire Barracuda
 * (b.barracudacentral.org) — utile si le serveur gov.bf refuse une IP.
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

// 1) Réputation de l'IP sortante (facultatif ; nécessite un accès Internet)
$ip = (string) @file_get_contents('https://api.ipify.org');
if ($ip === '') {
    echo "IP publique : non détectée (pas d'accès à apify/Internet)\n";
} else {
    echo "IP publique : $ip\n";
    $reversed = implode('.', array_reverse(explode('.', $ip)));
    $listed = @dns_get_record("$reversed.b.barracudacentral.org", DNS_A);
    echo $listed
        ? "Barracuda RBL : IP LISTÉE -> le serveur gov.bf refusera l'envoi.\n"
        : "Barracuda RBL : IP non listée -> envoi possible.\n";
}

// 2) Envoi réel
echo "Envoi d'un message de test vers infos@enef.gov.bf ...\n";

try {
    Mail::raw(
        "Test d'envoi direct du formulaire de contact ENEF depuis le serveur.",
        function ($m) {
            $m->from(env('MAIL_FROM_ADDRESS', 'infos@enef.gov.bf'), env('MAIL_FROM_NAME', 'ENEF'));
            $m->to('infos@enef.gov.bf');
            $m->subject('[TEST] Formulaire contact ENEF');
        }
    );
    echo "ENVOI_OK : le message a été accepté par mg01.gov.bf.\n";
} catch (\Throwable $e) {
    echo "ENVOI_ECHEC : " . $e->getMessage() . "\n";
}