@extends('layouts.site')

@section('title', 'Mot du Directeur Général — ENEF')

@php
    $dgNom = $param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO';

    // Découpage du message en paragraphes (lignes vides ignorées)
    $paragraphes = collect(preg_split('/\R/u', trim($param_site->mot_dg_contenu ?? '')))
        ->map(fn ($ligne) => trim($ligne))
        ->filter()
        ->values();
@endphp

@section('content')

    <section style="padding:60px 0;">
        <div class="container dg-section">

            {{-- =========================================================
                 PHOTO DU DIRECTEUR GÉNÉRAL (inchangée)
            ========================================================== --}}
            <div class="dg-portrait">

                @if ($param_site && $param_site->mot_dg_photo_url)

                    <img
                        src="{{ asset($param_site->mot_dg_photo_url) }}"
                        alt="Photo du {{ $param_site->mot_dg_nom ?? 'Directeur Général' }}"
                        class="dg-photo"
                    >

                @else

                    <img
                        src="{{ asset('images/DG.jpg') }}"
                        alt="Photo du Directeur Général"
                        class="dg-photo"
                    >

                @endif

                <span class="cap">
                    <b>
                        {{ $dgNom }}
                    </b>
                    Directeur Général de l'École Nationale des Eaux et Forêts
                </span>

            </div>


            {{-- =========================================================
                 MESSAGE DU DIRECTEUR GÉNÉRAL
            ========================================================== --}}
            <div>

                <span class="section-head kicker">
                    Mot du Directeur Général
                </span>

                <div class="dg-message">

                    @forelse ($paragraphes as $paragraphe)
                        <p>{{ $paragraphe }}</p>
                    @empty
                        <p class="dg-empty">Le message du Directeur Général sera bientôt disponible.</p>
                    @endforelse

                </div>

                @if ($paragraphes->isNotEmpty())
                    <div class="dg-signature">
                        <span class="dg-signature__name">{{ $dgNom }}</span>
                        <span class="dg-signature__role">Directeur Général de l'ENEF</span>
                    </div>
                @endif

                <div class="dg-back">
                    <a href="{{ url('/') }}#dg" class="back-link">
                        <span aria-hidden="true">&larr;</span>
                        Retour à l'accueil
                    </a>
                </div>

            </div>

        </div>
    </section>


    @push('styles')

        <style>

            /* =========================================================
               MESSAGE DU DIRECTEUR GÉNÉRAL — TEXTE UNIQUEMENT
            ========================================================== */

            .dg-message {
                position: relative;
                max-width: 70ch;
                margin: 22px 0 0;
                padding-left: 22px;
                border-left: 3px solid var(--water, #2a7f9e);

                font-family: "Fraunces", serif;
                font-size: 18px;
                line-height: 1.8;
                color: var(--ink, #1c2421);

                text-align: justify;
                text-justify: inter-word;
                hyphens: auto;
                -webkit-hyphens: auto;
                overflow-wrap: break-word;
                text-wrap: pretty;
            }

            /* Guillemet décoratif en filigrane */
            .dg-message::before {
                content: "\201C";
                position: absolute;
                top: -34px;
                right: 6px;
                font-family: "Fraunces", Georgia, serif;
                font-size: 150px;
                line-height: 1;
                color: var(--forest-deep, #1d3a2b);
                opacity: .07;
                pointer-events: none;
                user-select: none;
            }

            .dg-message p {
                position: relative;
                margin: 0 0 1.15em;
                text-indent: 1.8em;

                opacity: 0;
                transform: translateY(8px);
                animation: dgFade .6s ease forwards;
            }

            .dg-message p:nth-child(2) { animation-delay: .08s; }
            .dg-message p:nth-child(3) { animation-delay: .16s; }
            .dg-message p:nth-child(4) { animation-delay: .24s; }
            .dg-message p:nth-child(n+5) { animation-delay: .32s; }

            @keyframes dgFade {
                to { opacity: 1; transform: none; }
            }


            /* ---------- Chapeau : premier paragraphe ---------- */

            .dg-message p:first-child {
                text-indent: 0;
                font-size: 1.14em;
                line-height: 1.7;
                color: var(--forest-deep, #1d3a2b);
                margin-bottom: 1.3em;
            }

            /* Premiers mots en petites capitales (esprit éditorial) */
            .dg-message p:first-child::first-line {
                font-variant: small-caps;
                letter-spacing: .04em;
            }

            /* Lettrine — repli universel */
            .dg-message p:first-child::first-letter {
                float: left;
                margin: .06em .12em 0 0;
                font-size: 3.6em;
                line-height: .8;
                font-weight: 700;
                color: var(--water, #2a7f9e);
            }

            @supports (initial-letter: 2) {
                .dg-message p:first-child::first-letter {
                    float: none;
                    margin: 0 .12em 0 0;
                    font-size: inherit;
                    line-height: inherit;
                    initial-letter: 2;
                }
            }

            /* Message de secours */
            .dg-message .dg-empty {
                text-indent: 0;
                font-size: 1em;
                font-style: italic;
                color: inherit;
                opacity: .7;
                animation: none;
            }

            .dg-message .dg-empty::first-line { font-variant: normal; letter-spacing: 0; }
            .dg-message .dg-empty::first-letter { all: unset; }


            /* =========================================================
               SIGNATURE
            ========================================================== */

            .dg-signature {
                display: flex;
                flex-direction: column;
                gap: 3px;
                margin: 26px 0 0 25px;
            }

            .dg-signature::before {
                content: "";
                width: 56px;
                height: 2px;
                margin-bottom: 12px;
                background: var(--water, #2a7f9e);
                border-radius: 2px;
            }

            .dg-signature__name {
                font-family: "Fraunces", serif;
                font-size: 20px;
                font-style: italic;
                font-weight: 600;
                color: var(--forest-deep, #1d3a2b);
            }

            .dg-signature__role {
                font-size: 11.5px;
                font-weight: 700;
                letter-spacing: .09em;
                text-transform: uppercase;
                color: var(--ink, #1c2421);
                opacity: .65;
            }


            /* =========================================================
               RETOUR À L'ACCUEIL
            ========================================================== */

            .dg-back {
                margin-top: 26px;
                padding-left: 25px;
            }

            .back-link {
                display: inline-flex;
                align-items: center;
                gap: 7px;

                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;

                color: var(--water, #2a7f9e);
                text-decoration: none;

                transition: color .2s ease, gap .2s ease;
            }

            .back-link:hover,
            .back-link:focus-visible {
                color: var(--forest-deep, #1d3a2b);
                gap: 10px;
            }


            /* =========================================================
               RESPONSIVE
            ========================================================== */

            @media (max-width: 768px) {

                .dg-message {
                    font-size: 17px;
                    line-height: 1.75;
                    padding-left: 16px;
                    text-align: left;          /* pas de justification sur petit écran */
                }

                .dg-message::before { font-size: 110px; top: -24px; }
                .dg-message p { text-indent: 1.2em; }
                .dg-signature, .dg-back { margin-left: 19px; padding-left: 0; }
                .dg-back { margin-left: 19px; }
            }

            @media (max-width: 480px) {

                .dg-message {
                    font-size: 16px;
                    line-height: 1.7;
                }

                .dg-signature__name { font-size: 18px; }
            }


            /* =========================================================
               ACCESSIBILITÉ / IMPRESSION
            ========================================================== */

            @media (prefers-reduced-motion: reduce) {
                .dg-message p { animation: none; opacity: 1; transform: none; }
                .back-link { transition: none; }
            }

            @media print {
                .dg-message p { opacity: 1; transform: none; animation: none; }
                .dg-message::before, .dg-back { display: none; }
            }

        </style>

    @endpush

@endsection