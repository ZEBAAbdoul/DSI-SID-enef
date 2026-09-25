@extends('layouts.site')

@section('title', 'ENEF — Catalogue de formations')

@section('content')

    <!-- ===================== EN-TÊTE CATALOGUE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Formation initiale et formation continue</div>
            <h1>Catalogue de formations continues</h1>
            <p class="hero-lede">Cycles de formation initiale (Eaux et Forêts, Environnement) et formation continue
                2025-2026 — formations programmées à dates fixes et modules à la carte, conçus pour les
                professionnels de l'environnement et des ressources naturelles.</p>
            <div class="hero-ctas">
                {{-- <a href="{{ url('/') }}#admissions" class="btn btn-ghost-light">&larr; Retour à l'accueil</a> --}}
            </div>
        </div>
    </section>

    <!-- ===================== CATALOGUE ===================== -->
    <section id="catalogue-complet">
        <div class="container">

            <div class="tabs" role="tablist">
                {{-- <button class="tab-btn" role="tab" aria-selected="true" data-filter-group="initiale">
                    Formations initiales <span class="count">({{ $formationsInitiales->count() }})</span>
                </button> --}}
                <button class="tab-btn" role="tab" aria-selected="true" data-filter-group="programmee">
                    Formations programmées <span class="count">({{ $formationsProgrammees->count() }})</span>
                </button>
                <button class="tab-btn" role="tab" aria-selected="false" data-filter-group="carte">
                    Formations à la carte <span class="count">({{ $formationsALaCarte->count() }})</span>
                </button>
            </div>

            <!-- ---------- Formations initiales ---------- -->
            {{-- <div class="catalogue-group" data-group-panel="initiale">
                <div class="catalogue-accordion">
                    @forelse ($formationsInitiales as $item)
                        @php
                            // Diplôme et conditions d'accès sont stockés dans objectifs / public_cible (voir seeder)
                            $diplome = \Illuminate\Support\Str::of($item->objectifs ?? '')
                                ->after('Diplôme délivré :')
                                ->trim()
                                ->rtrim('.');
                            $conditions = trim(\Illuminate\Support\Str::after($item->public_cible ?? '', 'Conditions d’accès :'));
                        @endphp
                        <details class="module-card">
                            <summary>
                                <span class="module-code">{{ $item->code_module }}</span>
                                <span class="module-title">{{ $item->titre }}</span>
                                <span class="module-meta">
                                    @if ($item->duree)
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 3" /></svg>
                                        {{ $item->duree }}
                                    @endif
                                </span>
                                <span class="badge prog">Formation initiale</span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M6 9l6 6 6-6" /></svg>
                            </summary>

                            <div class="module-body">
                                @if ($item->resume)
                                    <p class="module-resume">{{ $item->resume }}</p>
                                @endif

                                @if ($item->contenu_programme)
                                    <h5>Contenu de la formation</h5>
                                    <p class="module-text">{!! nl2br(e($item->contenu_programme)) !!}</p>
                                @endif

                                <div class="module-infos">
                                    @if ($diplome->isNotEmpty())
                                        <div><span class="lbl">Diplôme</span><span>{{ $diplome }}</span></div>
                                    @endif
                                    @if ($item->duree)
                                        <div><span class="lbl">Durée de la formation</span><span>{{ $item->duree }}</span></div>
                                    @endif
                                    @if ($conditions !== '')
                                        <div><span class="lbl">Conditions d'accès</span><span>{!! nl2br(e($conditions)) !!}</span></div>
                                    @endif
                                    @if ($item->cout_indicatif)
                                        <div><span class="lbl">Frais de scolarité</span><span>{{ number_format($item->cout_indicatif, 0, ',', ' ') }} F CFA / an</span></div>
                                    @endif
                                </div>

                                <a href="{{ route('formations.show', $item->slug) }}" class="btn btn-outline btn-sm">Voir la fiche du cycle</a>
                            </div>
                        </details>
                    @empty
                        <p style="color:var(--ink-soft);">Aucune formation initiale disponible pour le moment.</p>
                    @endforelse
                </div>
            </div> --}}

            <!-- ---------- Formations programmées ---------- -->
            <div class="catalogue-group" data-group-panel="programmee">
                <div class="catalogue-accordion">
                    @forelse ($formationsProgrammees as $item)
                        <details class="module-card">
                            <summary>
                                {{-- <span class="module-code">{{ $item->code_module }}</span> --}}
                                <span class="module-title">{{ $item->titre }}</span>
                                <span class="module-meta">
                                    @if ($item->duree)
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            width="14" height="14">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 7v5l3 3" />
                                        </svg>
                                        {{ $item->duree }}
                                    @endif
                                </span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" width="18" height="18">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </summary>

                            <div class="module-body">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="module-content flex-grow-1">
                                        @if ($item->resume)
                                            <p class="module-resume">{{ $item->resume }}</p>
                                        @endif

                                        @if ($item->objectifs)
                                            <h5>Objectifs</h5>
                                            <p class="module-text">{!! nl2br(e($item->objectifs)) !!}</p>
                                        @endif

                                        @if ($item->contenu_programme)
                                            <h5>Contenu de la formation</h5>
                                            <p class="module-text">{!! nl2br(e($item->contenu_programme)) !!}</p>
                                        @endif

                                        <div class="module-infos">
                                            @if ($item->duree)
                                                <div><span class="lbl">Volume
                                                        horaire</span><span>{{ $item->duree }}</span></div>
                                            @endif
                                            @if ($item->public_cible)
                                                <div><span class="lbl">Public
                                                        cible</span><span>{{ $item->public_cible }}</span></div>
                                            @endif
                                            @if ($item->techniques)
                                                <div><span
                                                        class="lbl">Techniques</span><span>{{ $item->techniques }}</span>
                                                </div>
                                            @endif
                                            @if ($item->places_min || $item->places_max)
                                                <div><span class="lbl">Places par
                                                        session</span><span>{{ $item->places_min }} à
                                                        {{ $item->places_max }} personnes</span></div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- <div class="module-action">
                                        <a class="btn btn-primary"
                                            href="mailto:infos@enef.gov.bf?subject={{ rawurlencode('Demande de formation : ' . $item->titre) }}">
                                            Demander cette formation
                                        </a>
                                        <a class="btn btn-outline" href="{{ route('formations.informations') }}">
                                            Voir les conditions
                                        </a>
                                    </div> --}}


                                    
                                </div>
                            </div>
                        </details>
                    @empty
                        <p style="color:var(--ink-soft);">Aucune formation programmée disponible pour le moment.</p>
                    @endforelse
                </div>
            </div>

            <!-- ---------- Formations à la carte ---------- -->
            <div class="catalogue-group" data-group-panel="carte" hidden>
                <div class="catalogue-accordion">
                    @forelse ($formationsALaCarte as $item)
                        <details class="module-card">
                            <summary>
                                <span class="module-code">{{ $item->code_module }}</span>
                                <span class="module-title">{{ $item->titre }}</span>
                                <span class="badge carte">À la carte</span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" width="18" height="18">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </summary>

                            <div class="module-body d-flex">
                                <div class="module-content flex-grow-1">
                                    @if ($item->resume)
                                        <p class="module-resume">{{ $item->resume }}</p>
                                    @endif

                                    @if ($item->objectifs)
                                        <h5>Objectifs</h5>
                                        <p class="module-text">{!! nl2br(e($item->objectifs)) !!}</p>
                                    @endif

                                    @if ($item->contenu_programme)
                                        <h5>Contenu de la formation</h5>
                                        <p class="module-text">{!! nl2br(e($item->contenu_programme)) !!}</p>
                                    @endif

                                    <div class="module-infos">
                                        @if ($item->duree)
                                            <div><span class="lbl">Volume
                                                    horaire</span><span>{{ $item->duree }}</span>
                                            </div>
                                        @endif
                                        @if ($item->public_cible)
                                            <div><span class="lbl">Public
                                                    cible</span><span>{{ $item->public_cible }}</span></div>
                                        @endif
                                        @if ($item->techniques)
                                            <div><span
                                                    class="lbl">Techniques</span><span>{{ $item->techniques }}</span>
                                            </div>
                                        @endif
                                        @if ($item->places_min || $item->places_max)
                                            <div><span class="lbl">Places par
                                                    session</span><span>{{ $item->places_min }} à
                                                    {{ $item->places_max }} personnes</span></div>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="module-action ms-3">
                                    <a class="btn btn-primary">
                                        Demander cette formation
                                    </a>
                                </div> --}}
                                
                            </div>
                        </details>
                    @empty
                        <p style="color:var(--ink-soft);">Aucun module à la carte disponible pour le moment.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    @push('styles')
        <style>
            #catalogue-complet {
                padding: 40px 0 80px;
            }

            .tab-btn .count {
                opacity: .65;
                font-size: .9em;
            }

            .catalogue-accordion {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 28px;
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

            .module-meta {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 12.5px;
                color: var(--ink-soft);
                white-space: nowrap;
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
            .module-body .module-text {
                font-size: 14px;
                color: var(--ink);
                line-height: 1.6;
            }

            .module-infos {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 12px;
                margin: 18px 0;
                background: var(--paper-alt);
                padding: 14px 16px;
            }

            .module-infos .lbl {
                display: block;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--ink-soft);
                margin-bottom: 2px;
            }

            .module-infos>div span:last-child {
                font-size: 13.5px;
            }

            /* style du buton a droite  */
            .module-layout {
                display: flex;
                align-items: flex-start;
                gap: 24px;
            }

            .module-content {
                flex: 1;
                min-width: 0;
            }

            .module-action {
                flex-shrink: 0;
            }

            @media (max-width: 640px) {
                .module-layout {
                    flex-direction: column;
                }

                .module-action,
                .module-action .btn {
                    width: 100%;
                }
            }

            /* ===================== INFOS COMPLÉMENTAIRES ===================== */
            #infos-complementaires {
                --clay: #b5654a;
                --clay-soft: #f7e9e2;
                --water-soft: #e6f0f2;
                --forest-soft: #e9f1e9;
                padding: 56px 0 24px;
            }

            #infos-complementaires .infos-section {
                margin-bottom: 44px;
            }

            #infos-complementaires .section-head {
                max-width: 640px;
                margin-bottom: 20px;
            }

            #infos-complementaires .kicker {
                display: inline-block;
                font-family: "Fraunces", serif;
                font-weight: 700;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: .06em;
                padding: 4px 10px;
                margin-bottom: 10px;
                border-radius: 2px;
            }

            #infos-complementaires .kicker-clay {
                background: var(--clay-soft);
                color: var(--clay);
            }

            #infos-complementaires .kicker-water {
                background: var(--water-soft);
                color: var(--water);
            }

            #infos-complementaires .kicker-forest {
                background: var(--forest-soft);
                color: var(--forest-deep);
            }

            #infos-complementaires .section-head h2 {
                font-family: "Fraunces", serif;
                font-size: 24px;
                margin: 0 0 8px;
                color: var(--ink);
            }

            #infos-complementaires .section-head .desc {
                font-size: 14px;
                line-height: 1.6;
                color: var(--ink-soft);
                margin: 0;
            }

            /* --- Blocs (cartes) --- */
            #infos-complementaires .infos-block {
                background: var(--white);
                border: 1px solid var(--line);
                border-left: 4px solid var(--line);
                padding: 4px;
            }

            #infos-complementaires .infos-block--accent-clay {
                border-left-color: var(--clay);
            }

            #infos-complementaires .infos-block--accent-water {
                border-left-color: var(--water);
            }

            #infos-complementaires .infos-block--accent-forest {
                border-left-color: var(--forest-deep);
            }

            #infos-complementaires .infos-cols {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 16px;
            }

            #infos-complementaires .infos-block-label {
                font-family: "Fraunces", serif;
                font-weight: 700;
                font-size: 13px;
                color: var(--ink);
                padding: 12px 16px 6px;
            }

            /* --- Tableaux --- */
            #infos-complementaires .infos-table {
                width: 100%;
                border-collapse: collapse;
            }

            #infos-complementaires .infos-table tr:not(:last-child) td {
                border-bottom: 1px solid var(--line);
            }

            #infos-complementaires .infos-table td {
                padding: 12px 16px;
                font-size: 14px;
                vertical-align: top;
            }

            #infos-complementaires .infos-table .lbl-cell {
                color: var(--ink-soft);
                font-weight: 600;
                width: 55%;
            }

            #infos-complementaires .infos-table .val-cell {
                color: var(--ink);
                text-align: right;
                font-weight: 600;
            }

            #infos-complementaires .infos-table .empty-cell {
                text-align: center;
                color: var(--ink-soft);
                font-style: italic;
                padding: 20px;
            }

            /* --- Liste "composition du dossier" --- */
            #infos-complementaires .infos-dossier-list {
                list-style: none;
                margin: 0;
                padding: 6px;
            }

            #infos-complementaires .infos-dossier-list li {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 12px 16px;
                font-size: 14px;
                color: var(--ink);
            }

            #infos-complementaires .infos-dossier-list li:not(:last-child) {
                border-bottom: 1px solid var(--line);
            }

            #infos-complementaires .dossier-num {
                flex-shrink: 0;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                background: var(--forest-soft);
                color: var(--forest-deep);
                font-family: "Fraunces", serif;
                font-weight: 700;
                font-size: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* --- Bandeau de contact --- */
            #infos-complementaires .infos-cta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
                background: var(--forest-deep);
                color: #fff;
                padding: 28px 32px;
                margin-top: 32px;
            }

            #infos-complementaires .infos-cta h3 {
                font-family: "Fraunces", serif;
                font-size: 18px;
                margin: 0 0 4px;
            }

            #infos-complementaires .infos-cta p {
                margin: 0;
                font-size: 14px;
                opacity: .85;
            }

            #infos-complementaires .infos-cta .btn-primary {
                background: #fff;
                color: var(--forest-deep);
                border: none;
            }

            #infos-complementaires .infos-cta .btn-primary:hover {
                background: var(--paper-alt);
            }

            @media (max-width: 640px) {
                #infos-complementaires .infos-table .val-cell {
                    text-align: left;
                }

                #infos-complementaires .infos-cta {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function() {
                var tabs = document.querySelectorAll('#catalogue-complet .tab-btn[data-filter-group]');
                var panels = document.querySelectorAll('#catalogue-complet .catalogue-group[data-group-panel]');

                tabs.forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        tabs.forEach(function(t) {
                            t.setAttribute('aria-selected', 'false');
                        });
                        tab.setAttribute('aria-selected', 'true');

                        var target = tab.dataset.filterGroup;
                        panels.forEach(function(panel) {
                            panel.hidden = panel.dataset.groupPanel !== target;
                        });
                    });
                });
            })();
        </script>
    @endpush

@endsection
