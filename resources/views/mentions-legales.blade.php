{{-- resources/views/mentions-legales.blade.php --}}
@php
    /*
    |--------------------------------------------------------------------------
    | INFORMATIONS À COMPLÉTER (un seul endroit)
    |--------------------------------------------------------------------------
    | Toute valeur vide s'affiche à l'écran en jaune : « [À compléter : … ] ».
    | Les valeurs adresse / téléphone / e-mail sont lues dans $parametresSite si elles existent
    | (adapte les noms de colonnes à ta table de paramètres).
    */
    $m = [
        'denomination' => 'École Nationale des Eaux et Forêts (ENEF)',
        'statut' => null, // ex. : nature juridique et autorité de tutelle
        'adresse' => $parametresSite->adresse ?? null,
        'telephone' => $parametresSite->telephone ?? null,
        'email' => $parametresSite->email ?? null,
        'directeur_publication' => null, // nom et fonction du directeur de la publication
        'hebergeur_nom' => null,
        'hebergeur_adresse' => null,
        'concepteur' => null, // société ou personne qui a conçu / développé le site
        'mise_a_jour' => '24 septembre 2026',
    ];

    // Affiche la valeur (échappée) ou un repère jaune si elle n'est pas renseignée
$champ = fn($cle, $libelle) => filled($m[$cle] ?? null)
    ? e($m[$cle])
    : '<span class="ml-todo">[À compléter : ' . e($libelle) . ']</span>';
@endphp
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentions légales — ENEF</title>
    <meta name="description"
        content="Mentions légales du site de l'École Nationale des Eaux et Forêts (ENEF) : éditeur, hébergement, propriété intellectuelle, protection des données personnelles.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --vert: #2e7d32;
            --vert-fonce: #1b5e20;
            --vert-clair: #eaf6ec;
            --texte: #26332a;
            --texte-doux: #5f6f63;
            --bordure: #dfe7e0;
            --fond: #f3f6f3;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--fond);
            color: var(--texte);
            font-family: 'Poppins', 'Segoe UI', system-ui, -apple-system, Arial, sans-serif;
            line-height: 1.7;
        }

        a {
            color: var(--vert);
        }

        a:hover {
            color: var(--vert-fonce);
        }

        .ml-skip {
            position: absolute;
            left: -999px;
            top: 0;
            background: #fff;
            padding: .6rem 1rem;
            z-index: 100;
        }

        .ml-skip:focus {
            left: 1rem;
            top: 1rem;
        }

        /* ---------- En-tête ---------- */
        .ml-header {
            background: #fff;
            border-bottom: 1px solid var(--bordure);
        }

        .ml-header-inner {
            max-width: 1140px;
            margin: 0 auto;
            padding: .8rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .ml-brand {
            display: flex;
            align-items: center;
            gap: .8rem;
            text-decoration: none;
            color: var(--texte);
        }

        .ml-brand img {
            height: 52px;
            width: auto;
        }

        .ml-brand strong {
            display: block;
            font-size: 1.1rem;
            letter-spacing: 1.5px;
            color: var(--vert-fonce);
            line-height: 1.1;
        }

        .ml-brand span {
            display: block;
            font-size: .75rem;
            color: var(--texte-doux);
        }

        .ml-back {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem 1rem;
            border: 1.5px solid var(--vert);
            border-radius: 50rem;
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .ml-back:hover {
            background: var(--vert);
            color: #fff;
        }

        /* ---------- Bandeau titre ---------- */
        .ml-hero {
            background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 60%, #3f9443 100%);
            color: #fff;
            padding: 2.75rem 1.25rem 3.25rem;
        }

        .ml-hero-inner {
            max-width: 1140px;
            margin: 0 auto;
        }

        .ml-hero small {
            display: block;
            margin-bottom: .4rem;
            font-size: .75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: .85;
        }

        .ml-hero h1 {
            margin: 0 0 .5rem;
            font-size: clamp(1.7rem, 4vw, 2.4rem);
            font-weight: 700;
        }

        .ml-hero p {
            margin: 0;
            opacity: .9;
            font-size: .95rem;
        }

        /* ---------- Mise en page ---------- */
        .ml-wrap {
            max-width: 1140px;
            margin: -1.75rem auto 3rem;
            padding: 0 1.25rem;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 1.75rem;
            align-items: start;
        }

        .ml-toc {
            position: sticky;
            top: 1rem;
            background: #fff;
            border: 1px solid var(--bordure);
            border-radius: 14px;
            padding: 1.25rem 1.1rem;
            box-shadow: 0 8px 24px rgba(20, 60, 30, .07);
        }

        .ml-toc h2 {
            margin: 0 0 .7rem;
            font-size: .75rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--texte-doux);
        }

        .ml-toc ol {
            margin: 0;
            padding-left: 1.2rem;
            font-size: .88rem;
        }

        .ml-toc li {
            margin: .15rem 0;
        }

        .ml-toc a {
            display: block;
            padding: .25rem .5rem;
            border-radius: 6px;
            color: var(--texte);
            text-decoration: none;
        }

        .ml-toc a:hover {
            background: var(--vert-clair);
        }

        .ml-toc a.is-active {
            background: var(--vert-clair);
            color: var(--vert-fonce);
            font-weight: 600;
        }

        .ml-print {
            width: 100%;
            margin-top: .9rem;
            padding: .55rem;
            border: 1.5px solid var(--bordure);
            border-radius: 10px;
            background: #fff;
            color: var(--texte);
            font: inherit;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
        }

        .ml-print:hover {
            border-color: var(--vert);
            color: var(--vert);
        }

        /* ---------- Contenu ---------- */
        .ml-content {
            background: #fff;
            border: 1px solid var(--bordure);
            border-radius: 14px;
            padding: 2.25rem 2.5rem;
            box-shadow: 0 8px 24px rgba(20, 60, 30, .07);
            counter-reset: section;
        }

        .ml-section {
            scroll-margin-top: 1rem;
            padding-bottom: 1.75rem;
            margin-bottom: 1.75rem;
            border-bottom: 1px solid var(--bordure);
        }

        .ml-section:last-of-type {
            border-bottom: 0;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .ml-section h2 {
            counter-increment: section;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 0 0 1rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--vert-fonce);
        }

        .ml-section h2::before {
            content: counter(section);
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--vert-clair);
            color: var(--vert);
            font-size: .95rem;
        }

        .ml-section h3 {
            margin: 1.25rem 0 .4rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--texte);
        }

        .ml-section p {
            margin: 0 0 .8rem;
        }

        .ml-section ul {
            margin: 0 0 .8rem;
            padding-left: 1.25rem;
        }

        .ml-section li {
            margin-bottom: .3rem;
        }

        /* Fiche d'identité (libellé / valeur) */
        .ml-dl {
            display: grid;
            grid-template-columns: 200px 1fr;
            margin: 0;
            border: 1px solid var(--bordure);
            border-radius: 10px;
            overflow: hidden;
        }

        .ml-dl dt,
        .ml-dl dd {
            margin: 0;
            padding: .7rem 1rem;
            border-bottom: 1px solid var(--bordure);
        }

        .ml-dl dt {
            background: #f6f9f6;
            font-weight: 600;
            font-size: .88rem;
            color: var(--texte-doux);
        }

        .ml-dl dt:last-of-type,
        .ml-dl dd:last-of-type {
            border-bottom: 0;
        }

        .ml-note {
            margin: 1rem 0 0;
            padding: .85rem 1rem;
            border-left: 4px solid var(--vert);
            background: var(--vert-clair);
            border-radius: 0 10px 10px 0;
            font-size: .9rem;
        }

        /* Champ non renseigné : bien visible pour ne pas l'oublier avant la mise en ligne */
        .ml-todo {
            background: #fff3bf;
            color: #7a5b00;
            padding: 0 .35rem;
            border-radius: 4px;
            font-size: .85em;
            font-weight: 600;
        }

        /* ---------- Pied de page ---------- */
        .ml-footer {
            background: var(--vert-fonce);
            color: #fff;
            padding: 1.5rem 1.25rem;
            text-align: center;
            font-size: .82rem;
        }

        .ml-footer a {
            color: #fff;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 900px) {
            .ml-wrap {
                grid-template-columns: 1fr;
            }

            .ml-toc {
                position: static;
            }

            .ml-content {
                padding: 1.5rem 1.25rem;
            }

            .ml-dl {
                grid-template-columns: 1fr;
            }

            .ml-dl dt {
                border-bottom: 0;
                padding-bottom: .1rem;
            }

            .ml-brand span {
                display: none;
            }
        }

        /* ---------- Impression ---------- */
        @media print {

            .ml-header,
            .ml-toc,
            .ml-footer,
            .ml-skip {
                display: none !important;
            }

            body {
                background: #fff;
            }

            .ml-hero {
                background: none;
                color: #000;
                padding: 0 0 1rem;
            }

            .ml-wrap {
                display: block;
                margin: 0;
                padding: 0;
            }

            .ml-content {
                border: 0;
                box-shadow: none;
                padding: 0;
            }

            .ml-section {
                break-inside: avoid;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }
    </style>
</head>

<body>
    <a href="#contenu" class="ml-skip">Aller au contenu</a>

    {{-- ===================== EN-TÊTE ===================== --}}
    <header class="ml-header">
        <div class="ml-header-inner">
            <a href="{{ url('/') }}" class="ml-brand" aria-label="Retour à l'accueil de l'ENEF">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo de l'ENEF">
                <div>
                    <strong>ENEF</strong>
                    <span>École Nationale des Eaux et Forêts</span>
                </div>
            </a>

            <a href="{{ url('/') }}" class="ml-back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Retour à l'accueil
            </a>
        </div>
    </header>

    {{-- ===================== BANDEAU TITRE ===================== --}}
    <section class="ml-hero">
        <div class="ml-hero-inner">
            <small>Informations légales</small>
            <h1>Mentions légales</h1>
            <p>Dernière mise à jour : {{ $m['mise_a_jour'] }}</p>
        </div>
    </section>

    <div class="ml-wrap">

        {{-- ===================== SOMMAIRE ===================== --}}
        <aside class="ml-toc" aria-label="Sommaire">
            <h2>Sommaire</h2>
            <ol>
                <li><a href="#editeur">Éditeur du site</a></li>
                <li><a href="#hebergement">Hébergement</a></li>
                <li><a href="#conception">Conception et réalisation</a></li>
                <li><a href="#propriete">Propriété intellectuelle</a></li>
                <li><a href="#donnees">Données personnelles</a></li>
                <li><a href="#cookies">Cookies</a></li>
                <li><a href="#liens">Liens hypertextes</a></li>
                <li><a href="#responsabilite">Responsabilité</a></li>
                <li><a href="#droit">Droit applicable</a></li>
                <li><a href="#contact">Contact</a></li>
            </ol>

            <button type="button" class="ml-print" onclick="window.print()">
                <i class="fas fa-print" aria-hidden="true"></i> Imprimer cette page
            </button>
        </aside>

        {{-- ===================== CONTENU ===================== --}}
        <main id="contenu" class="ml-content">

            {{-- 1 --}}
            <section id="editeur" class="ml-section">
                <h2>Éditeur du site</h2>
                <p>Le présent site est édité par :</p>

                <dl class="ml-dl">
                    <dt>Dénomination</dt>
                    <dd>{!! $champ('denomination', 'dénomination') !!}</dd>

                    <dt>Statut</dt>
                    <dd>{!! $champ('statut', 'statut juridique et autorité de tutelle') !!}</dd>

                    <dt>Adresse</dt>
                    <dd>{!! $champ('adresse', 'adresse postale') !!}</dd>

                    <dt>Téléphone</dt>
                    <dd>{!! $champ('telephone', 'numéro de téléphone') !!}</dd>

                    <dt>Adresse e-mail</dt>
                    <dd>{!! $champ('email', 'adresse e-mail de contact') !!}</dd>

                    <dt>Directeur de la publication</dt>
                    <dd>{!! $champ('directeur_publication', 'nom et fonction') !!}</dd>
                </dl>
            </section>

            {{-- 2 --}}
            <section id="hebergement" class="ml-section">
                <h2>Hébergement</h2>
                <p>Le site est hébergé par :</p>

                <dl class="ml-dl">
                    <dt>Hébergeur</dt>
                    <dd>{!! $champ('hebergeur_nom', "nom de l'hébergeur") !!}</dd>

                    <dt>Adresse</dt>
                    <dd>{!! $champ('hebergeur_adresse', "adresse de l'hébergeur") !!}</dd>
                </dl>
            </section>

            {{-- 3 --}}
            <section id="conception" class="ml-section">
                <h2>Conception et réalisation</h2>
                <p>
                    Conception, développement et maintenance de la plateforme :
                    {!! $champ('concepteur', 'nom du concepteur / prestataire') !!}.
                </p>
            </section>

            {{-- 4 --}}
            <section id="propriete" class="ml-section">
                <h2>Propriété intellectuelle</h2>
                <p>
                    L'ensemble des éléments présents sur ce site (textes, logos, illustrations, photographies,
                    vidéos, documents, structure et code) est protégé par la législation en vigueur relative
                    à la propriété intellectuelle. Ils sont, sauf mention contraire, la propriété de l'ENEF
                    ou de ses partenaires.
                </p>
                <p>
                    Toute reproduction, représentation, modification, diffusion ou exploitation, totale ou
                    partielle, de ces éléments sans l'autorisation écrite préalable de l'ENEF est interdite.
                    Les documents mis à disposition en téléchargement sont réservés à un usage personnel et
                    non commercial.
                </p>
            </section>

            {{-- 5 --}}
            <section id="donnees" class="ml-section">
                <h2>Protection des données personnelles</h2>

                <p>
                    L'ENEF traite les données personnelles collectées sur ce site dans le respect de la
                    législation burkinabè applicable en matière de protection des données à caractère
                    personnel et sous le contrôle de la Commission de l'Informatique et des Libertés (CIL).
                </p>

                <h3>Responsable du traitement</h3>
                <p>{!! $champ('denomination', 'dénomination') !!}, à l'adresse indiquée dans la rubrique « Éditeur du site ».</p>

                <h3>Données collectées</h3>
                <ul>
                    <li>Identité : nom, prénom(s), sexe, date et lieu de naissance, nationalité.</li>
                    <li>Pièce d'identité : type et numéro.</li>
                    <li>Coordonnées : adresse e-mail, téléphone, adresse, ville et pays de résidence.</li>
                    <li>Dossier de candidature : formation et session choisies, pièces justificatives déposées,
                        statut du dossier.</li>
                    <li>Pour les enseignants : fichiers de notes déposés sur la plateforme.</li>
                    <li>Données de connexion : identifiant, mot de passe (conservé sous forme chiffrée).</li>
                </ul>

                <h3>Finalités</h3>
                <ul>
                    <li>Création et gestion des comptes utilisateurs.</li>
                    <li>Réception, instruction et suivi des candidatures et des inscriptions aux formations.</li>
                    <li>Vérification des pièces justificatives.</li>
                    <li>Communication avec les utilisateurs (notifications et messages liés à leur dossier).</li>
                    <li>Gestion pédagogique et sécurité de la plateforme.</li>
                </ul>

                <h3>Destinataires</h3>
                <p>
                    Les données sont destinées exclusivement au personnel habilité de l'ENEF (direction,
                    scolarité, ressources humaines, enseignants concernés). Elles ne sont ni vendues ni cédées
                    à des tiers à des fins commerciales. Les prestataires techniques intervenant sur la
                    plateforme sont tenus à une obligation de confidentialité.
                </p>

                <h3>Durée de conservation</h3>
                <p>
                    Les données sont conservées pendant la durée nécessaire aux finalités ci-dessus, puis
                    archivées ou supprimées conformément aux règles applicables.
                    <span class="ml-todo">[À compléter : durées de conservation précises]</span>
                </p>

                <h3>Sécurité</h3>
                <p>
                    L'ENEF met en œuvre des mesures techniques et organisationnelles appropriées pour protéger
                    les données : mots de passe stockés sous forme chiffrée, accès limité selon les rôles des
                    utilisateurs, journalisation des opérations sensibles.
                </p>

                <h3>Vos droits</h3>
                <p>
                    Vous disposez d'un droit d'accès, de rectification, d'opposition et de suppression des
                    données vous concernant, dans les conditions prévues par la loi. Pour l'exercer, adressez
                    votre demande à {!! $champ('email', 'adresse e-mail de contact') !!}, en joignant une
                    copie d'une pièce d'identité. Vous pouvez également introduire une réclamation auprès de
                    la Commission de l'Informatique et des Libertés (CIL).
                </p>
            </section>

            {{-- 6 --}}
            <section id="cookies" class="ml-section">
                <h2>Cookies</h2>
                {{-- Si un outil d'analyse d'audience ou un service tiers est ajouté au site, le mentionner ici. --}}
                <p>
                    Ce site utilise uniquement des cookies techniques strictement nécessaires à son
                    fonctionnement : maintien de la session de connexion et protection contre les
                    requêtes frauduleuses (jeton de sécurité). Ces cookies ne servent ni à la publicité ni au
                    suivi de votre navigation et ne nécessitent pas de consentement préalable.
                </p>
                <p>Vous pouvez les supprimer depuis les paramètres de votre navigateur ; certaines fonctions
                    du site (connexion, dépôt de dossier) risquent alors de ne plus être disponibles.</p>
            </section>

            {{-- 7 --}}
            <section id="liens" class="ml-section">
                <h2>Liens hypertextes</h2>
                <p>
                    Le site peut contenir des liens vers des sites tiers. L'ENEF n'exerce aucun contrôle sur
                    leur contenu et décline toute responsabilité quant aux informations qui y figurent.
                    La création d'un lien vers ce site est soumise à l'accord préalable de l'ENEF.
                </p>
            </section>

            {{-- 8 --}}
            <section id="responsabilite" class="ml-section">
                <h2>Responsabilité</h2>
                <p>
                    L'ENEF s'efforce d'assurer l'exactitude et la mise à jour des informations publiées
                    (formations, sessions, dates, conditions d'admission), mais ne saurait garantir qu'elles
                    soient exemptes d'erreurs ou d'omissions. Ces informations sont données à titre indicatif
                    et peuvent être modifiées sans préavis.
                </p>
                <p>
                    L'accès au site peut être interrompu, notamment pour des raisons de maintenance ou de
                    force majeure. L'ENEF ne peut être tenue responsable des dommages résultant de l'utilisation
                    du site ou de l'impossibilité d'y accéder. Chaque utilisateur est responsable de la
                    confidentialité de ses identifiants.
                </p>
            </section>

            {{-- 9 --}}
            <section id="droit" class="ml-section">
                <h2>Droit applicable</h2>
                <p>
                    Les présentes mentions légales sont régies par le droit burkinabè. En cas de litige, et
                    à défaut de résolution amiable, les juridictions burkinabè compétentes seront seules
                    saisies.
                </p>
            </section>

            {{-- 10 --}}
            <section id="contact" class="ml-section">
                <h2>Contact</h2>
                <p>Pour toute question relative au site ou aux présentes mentions légales :</p>

                <dl class="ml-dl">
                    <dt>E-mail</dt>
                    <dd>{!! $champ('email', 'adresse e-mail de contact') !!}</dd>

                    <dt>Téléphone</dt>
                    <dd>{!! $champ('telephone', 'numéro de téléphone') !!}</dd>

                    <dt>Adresse</dt>
                    <dd>{!! $champ('adresse', 'adresse postale') !!}</dd>
                </dl>

                <p class="ml-note">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    L'ENEF se réserve le droit de modifier les présentes mentions légales à tout moment.
                    La date de dernière mise à jour figure en haut de cette page.
                </p>
            </section>

        </main>
    </div>

    {{-- ===================== PIED DE PAGE ===================== --}}
    <footer class="ml-footer">
        &copy; {{ date('Y') }} ENEF — École Nationale des Eaux et Forêts, Burkina Faso. Tous droits réservés.
        &nbsp;·&nbsp; <a href="{{ url('/') }}">Accueil</a>
    </footer>

    <script>
        // Sommaire : met en évidence la section affichée
        (function() {
            if (!('IntersectionObserver' in window)) return;

            var liens = [].slice.call(document.querySelectorAll('.ml-toc a'));
            var parId = {};
            liens.forEach(function(l) {
                parId[l.getAttribute('href').slice(1)] = l;
            });

            var observer = new IntersectionObserver(function(entrees) {
                entrees.forEach(function(e) {
                    if (!e.isIntersecting) return;
                    liens.forEach(function(l) {
                        l.classList.remove('is-active');
                    });
                    if (parId[e.target.id]) parId[e.target.id].classList.add('is-active');
                });
            }, {
                rootMargin: '-15% 0px -75% 0px'
            });

            document.querySelectorAll('.ml-section').forEach(function(s) {
                observer.observe(s);
            });
        })();
    </script>
</body>

</html>
