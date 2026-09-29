@extends('layouts.site')

@section('title', 'Mot du Directeur Général — ENEF')

@section('content')

    <section style="padding:60px 0;">
        <div class="container dg-section">
            <div class="dg-portrait">
                @if ($param_site && $param_site->mot_dg_photo_url)
                    <img src="{{ asset($param_site->mot_dg_photo_url) }}"
                        alt="Photo du {{ $param_site->mot_dg_nom ?? 'Directeur Général' }}" class="dg-photo">
                @else
                    <img src="{{ asset('images/DG.jpg') }}" alt="Photo du Directeur Général" class="dg-photo">
                @endif

                <span class="cap">
                    <b>{{ $param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO' }}</b> Directeur Général de l'École Nationale des Eaux et Forêts
                    {{-- {{ $param_site->mot_dg_titre ?? "Directeur Général de l'ENEF" }} --}}
                </span>
            </div>
            <div>
                <span class="section-head kicker" style="display:block;">Mot du Directeur Général</span>
                <div class="dg-message">
                    @foreach (preg_split("/\r\n|\n|\r/", trim($param_site->mot_dg_contenu ?? '')) as $paragraph)
                        @if (trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>

                {{-- <div class="dg-signoff">
                    <b>{{ $param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO' }}</b>
                    Directeur Général de l'École Nationale des Eaux et Forêts
                </div> --}}
                <div style="margin-top:24px;">
                    <a href="{{ url('/') }}#dg" class="back-link">&larr; Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .dg-message {
                font-family: "Fraunces", serif;
                font-size: 18px;
                line-height: 1.7;
                color: var(--ink);
                margin: 18px 0 24px;
            }

            .back-link {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--water);
                text-decoration: none;
                transition: color .2s ease, gap .2s ease;
            }

            .back-link:hover {
                color: var(--forest-deep);
                gap: 9px;
            }

            .dg-message {
                font-family: "Fraunces", serif;
                font-size: 18px;
                line-height: 1.8;
                color: var(--ink);
                margin: 18px 0 24px;
                text-align: justify;
            }

            .dg-message p {
                margin: 0 0 24px;
            }

            /* Lettrine : première lettre de chaque paragraphe */
            .dg-message p::first-letter {
                float: left;
                font-size: 1.5em;
                line-height: 0.8;
                font-weight: 700;
                color: var(--forest-deep);
                margin-right: 0px;
                margin-top: 2px;
                font-family: "Fraunces", serif;
            }
        </style>
    @endpush

@endsection
