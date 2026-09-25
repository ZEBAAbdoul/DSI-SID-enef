@extends('layouts.site')

@section('title', 'Politique de confidentialité — ENEF')

@section('content')

    <section style="padding:60px 0;">
        <div class="container">
            <div class="legal-page">

                <div class="eyebrow-line eyebrow-line--dark"><span class="rule"></span> Informations légales</div>
                <h1>Politique de confidentialité</h1>
                <p class="legal-updated">Dernière mise à jour : {{ now()->translatedFormat('d F Y') }}</p>

                <div class="legal-body">

                    <h2>1. Objet</h2>
                    <p>
                        La présente politique de confidentialité a pour objet d'informer les utilisateurs de la
                        plateforme de l'École Nationale des Eaux et Forêts (« ENEF ») de la manière dont leurs
                        données à caractère personnel sont collectées, utilisées, conservées et protégées, dans le
                        cadre de la création d'un compte candidat et du dépôt d'un dossier de candidature.
                    </p>

                    <h2>2. Données collectées</h2>
                    <p>
                        Dans le cadre de l'inscription et du suivi de candidature, l'ENEF collecte notamment les
                        données suivantes : nom, prénom(s), sexe, date et lieu de naissance, nationalité,
                        coordonnées (adresse e-mail, téléphone, adresse postale), numéro de pièce d'identité
                        (CNIB ou passeport), ainsi que les pièces justificatives transmises dans le cadre du
                        dossier de candidature (diplômes, relevés de notes, photographies, etc.).
                    </p>

                    <h2>3. Finalités du traitement</h2>
                    <p>
                        Les données collectées sont utilisées exclusivement pour :
                    </p>
                    <ul>
                        <li>la création et la gestion du compte candidat ;</li>
                        <li>l'instruction et le suivi des dossiers de candidature ;</li>
                        <li>la vérification de l'identité et de l'éligibilité des candidats ;</li>
                        <li>la communication avec le candidat concernant l'état de son dossier ;</li>
                        <li>l'établissement de statistiques internes anonymisées.</li>
                    </ul>

                    <h2>4. Base légale</h2>
                    <p>
                        Le traitement des données repose sur l'exécution des démarches nécessaires à l'instruction
                        de la candidature à laquelle l'utilisateur consent en créant son compte, ainsi que, le cas
                        échéant, sur le respect d'obligations légales et réglementaires applicables à l'ENEF en
                        tant qu'établissement public.
                    </p>

                    <h2>5. Destinataires des données</h2>
                    <p>
                        Les données sont destinées exclusivement aux services habilités de l'ENEF en charge du
                        traitement des candidatures. Elles ne sont ni vendues, ni cédées, ni communiquées à des
                        tiers à des fins commerciales. Elles peuvent, le cas échéant, être transmises aux
                        autorités compétentes lorsque la loi l'exige.
                    </p>

                    <h2>6. Durée de conservation</h2>
                    <p>
                        Les données sont conservées pendant la durée nécessaire au traitement de la candidature et,
                        en cas d'admission, pendant la durée de la scolarité et le temps requis par les obligations
                        archivistiques de l'établissement. Les dossiers des candidats non retenus sont conservés
                        pendant une durée limitée avant suppression ou anonymisation.
                    </p>

                    <h2>7. Sécurité des données</h2>
                    <p>
                        L'ENEF met en œuvre des mesures techniques et organisationnelles raisonnables (contrôle
                        d'accès, mots de passe, hébergement sécurisé) afin de protéger les données personnelles
                        contre tout accès non autorisé, perte, altération ou divulgation.
                    </p>

                    <h2>8. Droits des personnes concernées</h2>
                    <p>
                        Conformément à la réglementation applicable en matière de protection des données
                        personnelles au Burkina Faso, tout utilisateur dispose d'un droit d'accès, de
                        rectification, et, dans les limites prévues par la loi, de suppression de ses données. Ces
                        droits peuvent être exercés en contactant l'ENEF via les coordonnées indiquées sur la page
                        « Contact » du site.
                    </p>

                    <h2>9. Cookies</h2>
                    <p>
                        La plateforme peut utiliser des cookies techniques nécessaires à son bon fonctionnement
                        (maintien de session, sécurité). Ces cookies ne sont pas utilisés à des fins publicitaires
                        ou de traçage.
                    </p>

                    <h2>10. Modification de la politique</h2>
                    <p>
                        La présente politique de confidentialité peut être mise à jour à tout moment afin de
                        refléter l'évolution du service ou de la réglementation. Les utilisateurs sont invités à la
                        consulter régulièrement.
                    </p>

                    <h2>11. Contact</h2>
                    <p>
                        Pour toute question relative au traitement de vos données personnelles, vous pouvez
                        contacter l'ENEF via les coordonnées disponibles sur la page « Contact » du site.
                    </p>

                </div>

                <a href="{{ url()->previous() }}" class="btn btn-outline" style="margin-top:32px;">
                    ← Retour
                </a>

            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .legal-page {
            max-width: 780px;
            margin: 0 auto;
        }

        .legal-page h1 {
            font-size: 32px;
            margin: 14px 0 6px;
            color: var(--ink);
        }

        .legal-updated {
            color: var(--ink-soft);
            font-size: 13px;
            margin-bottom: 32px;
        }

        .legal-body h2 {
            font-size: 18px;
            color: var(--forest-deep);
            margin: 30px 0 10px;
        }

        .legal-body p,
        .legal-body li {
            font-size: 14.5px;
            line-height: 1.7;
            color: var(--ink-soft);
        }

        .legal-body ul {
            margin: 4px 0 4px 20px;
        }

        .legal-body li {
            margin-bottom: 6px;
        }

        .eyebrow-line--dark {
            color: #000;
        }
    </style>
@endpush
