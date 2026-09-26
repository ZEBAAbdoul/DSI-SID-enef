@extends('layouts.site')

@section('title', 'ENEF — Unités pédagogiques et de production')

@section('content')

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Formation pratique</div>
            <h1>Unités pédagogiques et de production</h1>
            <p class="hero-lede">La formation à l'ENEF repose sur une alternance étroite entre enseignements
                théoriques et travaux pratiques, conduits au sein de {{ $unites->count() }} unités pédagogiques et de
                production spécialisées — de véritables espaces réels d'apprentissage où les connaissances sont
                mises en pratique à travers des situations professionnelles concrètes.</p>
            <div style="margin-top:20px;">
                {{-- <a href="{{ url('/') }}#dg" class="btn btn-outline btn-sm">&larr; Retour à l'accueil</a> --}}
            </div>
        </div>
    </section>
    

    <!-- ===================== UNITÉS ===================== -->
    <section id="unites-liste" class="alt">
        <div class="container">
            <div class="catalogue-accordion">
                @forelse ($unites as $unite)
                    <details class="module-card" @if ($loop->first) open @endif>
                        <summary>
                            @if ($unite->photo_url)
                                <img src="{{ $unite->photo_url }}" alt="{{ $unite->titre }}" class="module-thumb">
                            @endif
                            <span class="module-code">N°{{ $unite->numero }}</span>
                            <span class="module-title">{{ $unite->titre }}</span>
                            @if (!empty($unite->note))
                                <span class="badge carte">{{ $unite->note }}</span>
                            @endif
                            <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" width="18" height="18">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </summary>

                        <div class="module-body">
                            @if ($unite->photo_url)
                                <img src="{{ $unite->photo_url }}" alt="{{ $unite->titre }}" class="module-photo">
                            @endif

                            <p class="module-resume">{{ $unite->concept }}</p>

                            <h5>Objectif général</h5>
                            <p class="module-text">{{ $unite->objectif_general }}</p>

                            @if (!empty($unite->objectifs_specifiques))
                                <h5>Objectifs spécifiques</h5>
                                <ul>
                                    @foreach ($unite->objectifs_specifiques as $obj)
                                        <li>{{ $obj }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @if (!empty($unite->sous_unites))
                                <h5>Sous-unités</h5>
                                <div class="sous-unites-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sous-unité</th>
                                                @if (collect($unite->sous_unites)->contains(fn($su) => !empty($su['etat'])))
                                                    <th>État</th>
                                                @endif
                                                <th>Applications / thématiques</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($unite->sous_unites as $su)
                                                <tr>
                                                    <td>{{ $su['nom'] }}</td>
                                                    @if (collect($unite->sous_unites)->contains(fn($s) => !empty($s['etat'])))
                                                        <td>{{ $su['etat'] ?? '—' }}</td>
                                                    @endif
                                                    <td>{{ $su['apps'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </details>
                @empty
                    <p class="text-center text-muted py-5">Aucune unité pédagogique disponible pour le moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            #unites-liste {
                padding: 40px 0 80px;
            }

            .catalogue-accordion {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .module-card {
                border: 1px solid var(--line);
                background: var(--white);
            }

            .module-card summary {
                list-style: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 16px 20px;
            }

            .module-card summary::-webkit-details-marker {
                display: none;
            }

            .module-thumb {
                width: 40px;
                height: 40px;
                object-fit: cover;
                border-radius: 4px;
                flex-shrink: 0;
            }

            .module-photo {
                width: 100%;
                max-height: 320px;
                object-fit: cover;
                margin-bottom: 18px;
            }

            .module-code {
                font-family: "Fraunces", serif;
                font-weight: 700;
                color: var(--forest-deep);
                background: var(--paper-alt);
                padding: 2px 8px;
                font-size: 12px;
                flex-shrink: 0;
            }

            .module-title {
                flex: 1;
                font-weight: 600;
                font-size: 15px;
            }

            .module-card .chev {
                flex-shrink: 0;
                transition: transform .2s ease;
            }

            .module-card[open] .chev {
                transform: rotate(180deg);
            }

            .module-body {
                padding: 0 20px 22px;
                border-top: 1px solid var(--line);
                padding-top: 18px;
            }

            .module-body h5 {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--water);
                margin: 16px 0 8px;
            }

            .module-body p,
            .module-body .module-text,
            .module-body ul {
                font-size: 14px;
                color: var(--ink);
                line-height: 1.6;
            }

            .module-body ul {
                padding-left: 18px;
            }

            .module-body li {
                margin-bottom: 4px;
            }

            .sous-unites-table {
                overflow-x: auto;
            }

            .sous-unites-table table {
                width: 100%;
                border-collapse: collapse;
                font-size: 13px;
            }

            .sous-unites-table th {
                text-align: left;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--ink-soft);
                padding: 8px 10px;
                background: var(--paper-alt);
                border-bottom: 1px solid var(--line);
            }

            .sous-unites-table td {
                padding: 10px;
                border-bottom: 1px solid var(--line);
                vertical-align: top;
                color: var(--ink);
            }

            .sous-unites-table tr:last-child td {
                border-bottom: none;
            }
        </style>
    @endpush

@endsection