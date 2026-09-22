<?php
/**
 * Reproduction réelle (HTTP + cookies + CSRF) de l'enregistrement des paramètres.
 * 1) Login  2) GET admin/parametres  3) PUT multipart (comportement AJAX actuel)
 * 4) POST multipart + _method=PUT (correctif proposé)  5) restauration.
 */

$base = 'http://127.0.0.1:8000';
$jar = sys_get_temp_dir() . '/enef_ck.txt';
@unlink($jar);

function req($url, $opt = [])
{
    $ch = curl_init($url);
    $def = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_COOKIEJAR => $GLOBALS['jar'],
        CURLOPT_COOKIEFILE => $GLOBALS['jar'],
        CURLOPT_HEADER => false,
        CURLOPT_FOLLOWLOCATION => false,
    ];
    curl_setopt_array($ch, $def + $opt);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $loc = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    curl_close($ch);
    return [$code, $loc, $body];
}

function tokenFrom($html)
{
    if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $html, $m)) return $m[1];
    if (preg_match('/<input[^>]*name="_token"[^>]*value="([^"]+)"/', $html, $m)) return $m[1];
    return null;
}

function sloganFrom($html)
{
    if (preg_match('/<input[^>]*id="slogan"[^>]*value="([^"]*)"/', $html, $m)) return html_entity_decode($m[1], ENT_QUOTES);
    return null;
}

$jar = sys_get_temp_dir() . '/enef_ck.txt';

// ---- 1) Login ----
[$c, , $html] = req($base . '/login');
$tok = tokenFrom($html);
echo "1) GET /login -> $c | token: " . ($tok ? 'oui' : 'NON') . "\n";

[$c, $loc, $body] = req($base . '/login', [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query(['_token' => $tok, 'email' => 'admin@enef.bf', 'password' => '123456789']),
]);
echo "2) POST /login -> $c | Location: " . var_export($loc, true) . "\n";

// ---- 2) Page admin parametres ----
[$c, , $html] = req($base . '/admin/parametres');
$tok2 = tokenFrom($html);
$slogan0 = sloganFrom($html);
preg_match('/<form id="parametresForm"[^>]*action="([^"]+)"/', $html, $mAction);
$action = $mAction[1] ?? null;
echo "3) GET /admin/parametres -> $c | slogan actuel : " . var_export($slogan0, true) . "\n";
echo "   action : " . ($action ?? 'INTROUVABLE') . "\n";

// ---- 3) PUT multipart (comportement du JS actuel : type=PUT + FormData) ----
$fieldsPut = [
    '_token' => $tok2,
    'nom_site' => 'ENEF - École Nationale des Eaux et Forêts',
    'slogan' => $slogan0 . ' [TEST-PUT]',
    'email_contact' => 'infos@enef.gov.bf',
    'liens_utiles[titre][]' => 'Gouvernement',
    'liens_utiles[url][]' => 'https://www.gouvernement.gov.bf',
];
[$c, , $body] = req($action, [
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => $fieldsPut, // tableau = multipart/form-data
]);
[$c2, , $html2] = req($base . '/admin/parametres');
$slogan1 = sloganFrom($html2);
echo "\n4) PUT multipart -> $c | slogan après PUT : " . var_export($slogan1, true) . "\n";
echo "   => PUT multipart " . ($slogan1 === $slogan0 ? 'NON PERSISTÉ (root cause confirmé)' : 'persisté?!') . "\n";

// ---- 4) POST multipart + _method=PUT (correctif) ----
$fieldsPost = [
    '_token' => $tok2,
    '_method' => 'PUT',
    'nom_site' => 'ENEF - École Nationale des Eaux et Forêts',
    'slogan' => $slogan0 . ' [TEST-POST]',
    'email_contact' => 'infos@enef.gov.bf',
    'liens_utiles[titre][]' => 'Gouvernement',
    'liens_utiles[url][]' => 'https://www.gouvernement.gov.bf',
];
[$c, , $body] = req($action, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $fieldsPost, // multipart
]);
[$c2, , $html3] = req($base . '/admin/parametres');
$slogan2 = sloganFrom($html3);
echo "\n5) POST+_method=PUT multipart -> $c | slogan après : " . var_export($slogan2, true) . "\n";
echo "   => correctif " . ($slogan2 === $slogan0 . ' [TEST-POST]' ? 'PERSISTÉ ✔' : 'NON persisté') . "\n";

// ---- 5) Restauration ----
$fieldsBack = [
    '_token' => $tok2,
    '_method' => 'PUT',
    'nom_site' => 'ENEF - École Nationale des Eaux et Forêts',
    'slogan' => $slogan0,
    'email_contact' => 'infos@enef.gov.bf',
    'liens_utiles[titre][]' => 'Gouvernement du Burkina Faso',
    'liens_utiles[url][]' => 'https://www.gouvernement.gov.bf',
    'liens_utiles[titre][]' => 'ENEF — Facebook',
    'liens_utiles[url][]' => 'https://www.facebook.com/enef2021',
    // force explicitement l'array vide côté PHP ? non : on envoie 2 liens
];
req($action, [CURLOPT_POST => true, CURLOPT_POSTFIELDS => $fieldsBack]);
[$c, , $html4] = req($base . '/admin/parametres');
echo "\n6) Restauration slogan : " . var_export(sloganFrom($html4), true) . "\n";

echo "\nFIN" . PHP_EOL;