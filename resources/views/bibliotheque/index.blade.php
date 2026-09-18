@extends('layouts.site')

@section('title', 'ENEF — Bibliothèque documentaire')

@php
    // Icône + couleur d'accent par type de document — aucune image à uploader.
    // Clés alignées sur BibliothequeController::$typeLabels.
    $docTypeStyles = [
        'rapport' => [
            'color' => '#2f6b4f',
            'icon'  => '<path d="M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 16.5h6M9 9.5h3"/>',
        ],
        'brochure' => [
            'color' => '#3a7ca5',
            'icon'  => '<path d="M4 5.5C6 4.3 8.5 4 12 5v14c-3.5-1-6-.7-8 .5V5.5z"/><path d="M20 5.5C18 4.3 15.5 4 12 5v14c3.5-1 6-.7 8 .5V5.5z"/>',
        ],
        'texte_reglementaire' => [
            'color' => '#8a5a2b',
            'icon'  => '<circle cx="12" cy="8" r="5"/><path d="M9 12.5 6 21l6-3 6 3-3-8.5"/>',
        ],
        'support_pedagogique' => [
            'color' => '#6b4fa0',
            'icon'  => '<path d="M22 9 12 4 2 9l10 5 10-5z"/><path d="M6 11v5c0 1.5 2.7 3 6 3s6-1.5 6-3v-5"/>',
        ],
        'default' => [
            'color' => '#5c6b5f',
            'icon'  => '<path d="M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M14 3v5h5"/>',
        ],
    ];
@endphp

@section('content')

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Bibliothèque documentaire</div>
            <h1>Rapports, brochures et supports pédagogiques</h1>
            <p class="hero-lede">Consultez le catalogue des ressources publiées par l'ENEF.</p>
        </div>
    </section>

    <!-- ===================== FILTRES + RÉSULTATS ===================== -->
    <section id="liste-documents" class="alt">
        <div class="container biblio-page">

            <!-- Colonne filtres -->
            <aside class="biblio-filters">
                <form action="{{ route('bibliotheque.index') }}" method="GET" id="biblio-filter-form">
                    <div class="filter-block">
                        <label for="q">Rechercher</label>
                        <input type="text" id="q" name="q" value="{{ request('q') }}"
                            placeholder="Titre, mot-clé…">
                    </div>

                    <div class="filter-block">
                        <label for="type">Type de document</label>
                        <select id="type" name="type" onchange="this.form.submit()">
                            <option value="">Tous les types</option>
                            @foreach ($typeLabels as $value => $label)
                                <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-block">
                        <label for="categorie_id">Catégorie</label>
                        <select id="categorie_id" name="categorie_id" onchange="this.form.submit()">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id }}" @selected(request('categorie_id') == $categorie->id)>
                                    {{ $categorie->nom }}
                                </option>
                                @foreach ($categorie->enfants as $enfant)
                                    <option value="{{ $enfant->id }}" @selected(request('categorie_id') == $enfant->id)>
                                        &nbsp;&nbsp;— {{ $enfant->nom }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm" style="width:100%;">Filtrer</button>

                    @if (request()->anyFilled(['q', 'type', 'categorie_id']))
                        <a href="{{ route('bibliotheque.index') }}" class="btn btn-outline btn-sm"
                            style="width:100%;margin-top:10px;text-align:center;">Réinitialiser</a>
                    @endif
                </form>

                <div class="biblio-adresse">
                    <span class="kicker" style="display:block;margin-bottom:8px;">Bibliothèque physique</span>
                    <p>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        École Nationale des Eaux et Forêts, Bobo-Dioulasso
                    </p>
                    <p style="margin-top:6px;">Tous les documents listés ici sont consultables sur place, aux heures d'ouverture de la bibliothèque.</p>
                </div>
            </aside>

            <!-- Colonne résultats -->
            <div class="biblio-results">
                <div class="results-head">
                    <span>{{ $documents->total() }} document(s) trouvé(s)</span>
                </div>

                <div class="documents-grid">
                    @forelse ($documents as $document)
                        @php
                            $docStyle = $docTypeStyles[$document->type] ?? $docTypeStyles['default'];
                        @endphp
                        <div class="doc-card">
                            <div class="doc-icon" style="--doc-color: {{ $docStyle['color'] }};">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $docStyle['icon'] !!}
                                </svg>
                            </div>

                            <div class="doc-top">
                                <span class="badge prog" style="--badge-color: {{ $docStyle['color'] }};">{{ $typeLabels[$document->type] ?? $document->type }}</span>
                                @if ($document->format_fichier)
                                    <span class="doc-format">{{ strtoupper($document->format_fichier) }}</span>
                                @endif
                            </div>
                            <h4>{{ $document->titre }}</h4>
                            @if ($document->description)
                                <p class="d">{{ \Illuminate\Support\Str::limit($document->description, 120) }}</p>
                            @endif
                            <div class="course-meta">
                                @if ($document->categorie)
                                    <span>{{ $document->categorie->nom }}</span>
                                @endif
                                @if ($document->publie_le)
                                    <span>{{ \Carbon\Carbon::parse($document->publie_le)->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>
                            <div class="doc-footer">
                                <span class="doc-taille">
                                    @if ($document->taille_fichier_ko)
                                        @if ($document->taille_fichier_ko >= 1024)
                                            {{ number_format($document->taille_fichier_ko / 1024, 1) }} Mo
                                        @else
                                            {{ $document->taille_fichier_ko }} Ko
                                        @endif
                                    @endif
                                </span>

                                <span class="doc-restreint"
                                    title="Consultable uniquement à la bibliothèque physique de l'ENEF, Bobo-Dioulasso">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        width="14" height="14">
                                        <rect x="3" y="11" width="18" height="10" rx="1" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    À consulter sur place
                                </span>
                            </div>
                        </div>
                    @empty
                        <p style="color:var(--ink-soft);">Aucun document ne correspond à votre recherche.</p>
                    @endforelse
                </div>

                <div class="pagination-wrap">
                    {{ $documents->links('vendor.pagination.enef') }}
                </div>

                <p class="biblio-note">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4M12 8h.01" />
                    </svg>
                    Les documents ne sont pas téléchargeables en ligne. Rendez-vous à la bibliothèque de l'ENEF
                    (Bobo-Dioulasso) pour consulter leur version physique.
                </p>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .biblio-page {
                display: grid;
                grid-template-columns: 260px 1fr;
                gap: 32px;
                align-items: start;
            }

            .biblio-filters {
                background: var(--white);
                border: 1px solid var(--line);
                padding: 20px;
                position: sticky;
                top: 20px;
            }

            .filter-block {
                margin-bottom: 16px;
            }

            .filter-block label {
                display: block;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--ink-soft);
                margin-bottom: 6px;
            }

            .filter-block input,
            .filter-block select {
                width: 100%;
                padding: 8px 10px;
                border: 1px solid var(--line);
                background: var(--paper-alt);
                font-family: inherit;
                font-size: 14px;
            }

            .biblio-adresse {
                margin-top: 20px;
                padding-top: 16px;
                border-top: 1px solid var(--line);
                font-size: 13px;
                color: var(--ink-soft);
                line-height: 1.5;
            }

            .biblio-adresse p {
                display: flex;
                align-items: flex-start;
                gap: 6px;
            }

            .biblio-adresse svg {
                flex-shrink: 0;
                margin-top: 2px;
                color: var(--forest-deep);
            }

            .results-head {
                font-size: 13px;
                color: var(--ink-soft);
                margin-bottom: 16px;
            }

            .documents-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 20px;
            }

            .doc-card {
                position: relative;
                background: var(--white);
                border: 1px solid var(--line);
                border-top: 3px solid var(--doc-color, var(--line));
                padding: 20px;
                padding-top: 56px;
                display: flex;
                flex-direction: column;
                transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
            }

            .doc-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, .06);
            }

            .doc-icon {
                position: absolute;
                top: 16px;
                left: 20px;
                width: 34px;
                height: 34px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: color-mix(in srgb, var(--doc-color) 12%, white);
                color: var(--doc-color);
            }

            .doc-icon svg {
                width: 18px;
                height: 18px;
            }

            .doc-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
            }

            .doc-top .badge {
                background: color-mix(in srgb, var(--badge-color) 14%, white);
                color: var(--badge-color);
                border: none;
            }

            .doc-format {
                font-size: 11px;
                font-weight: 700;
                color: var(--ink-soft);
            }

            .doc-card h4 {
                margin-bottom: 8px;
            }

            .doc-footer {
                margin-top: auto;
                padding-top: 14px;
                border-top: 1px solid var(--line);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .doc-taille {
                font-size: 12px;
                color: var(--ink-soft);
            }

            .doc-restreint {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 12px;
                font-weight: 600;
                color: var(--ink-soft);
                cursor: help;
            }

            .biblio-note {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                margin-top: 24px;
                padding: 14px 16px;
                background: var(--paper-alt);
                border-left: 3px solid var(--forest-accent);
                font-size: 13px;
                color: var(--ink-soft);
                line-height: 1.5;
            }

            .biblio-note svg {
                flex-shrink: 0;
                margin-top: 2px;
                color: var(--forest-deep);
            }

            .pagination-wrap {
                margin-top: 30px;
            }

            .enef-pagination {
                display: flex;
                justify-content: center;
            }

            .enef-pagination ul {
                display: flex;
                align-items: center;
                gap: 6px;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .enef-pagination .page-link {
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 38px;
                height: 38px;
                padding: 0 8px;
                background: var(--white);
                border: 1px solid var(--line);
                color: var(--ink);
                text-decoration: none;
                font-size: 14px;
                font-weight: 600;
                transition: border-color .2s ease, background .2s ease, color .2s ease;
            }

            .enef-pagination a.page-link:hover {
                border-color: var(--forest-accent);
                color: var(--forest-deep);
            }

            .enef-pagination .page-item.active .page-link {
                background: var(--forest-deep);
                border-color: var(--forest-deep);
                color: #fff;
            }

            .enef-pagination .page-item.disabled .page-link {
                color: var(--ink-soft);
                opacity: .4;
                cursor: default;
            }

            .enef-pagination .page-link.dots {
                border: none;
                background: transparent;
                min-width: auto;
            }

            @media (max-width: 800px) {
                .biblio-page {
                    grid-template-columns: 1fr;
                }

                .biblio-filters {
                    position: static;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (function () {
                var form = document.getElementById('biblio-filter-form');
                var searchInput = document.getElementById('q');
                if (!form || !searchInput) return;

                var timer = null;

                searchInput.addEventListener('input', function () {
                    clearTimeout(timer);
                    // Recherche automatique 500ms après la dernière frappe
                    timer = setTimeout(function () {
                        form.submit();
                    }, 500);
                });

                // Empêche le rechargement immédiat si l'utilisateur presse Entrée
                // pendant que le debounce est encore en attente (évite un double submit)
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        clearTimeout(timer);
                    }
                });
            })();
        </script>
    @endpush

@endsection