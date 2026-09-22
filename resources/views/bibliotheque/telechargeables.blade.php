@extends('layouts.site')

@section('title', 'ENEF — Documents téléchargeables')

@section('content')

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Ressources documentaires</div>
            <h1>Documents téléchargeables</h1>
            <p class="hero-lede">Rapports, brochures, textes réglementaires et supports pédagogiques librement
                téléchargeables. Pour les documents à consultation restreinte, rendez-vous sur la
                <a href="{{ route('bibliotheque.consultation') }}">page de consultation sur place</a>.</p>
        </div>
    </section>

    <!-- ===================== FILTRES ===================== -->
    <section id="bibliotheque-filtres" style="padding:0 0 24px;">
        <div class="container">
            <form method="GET" action="{{ route('bibliotheque.index') }}" class="biblio-filters">
                <div class="filter-field">
                    <label for="categorie_id">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}"
                                @selected(request('categorie_id') == $categorie->id)>
                                {{ $categorie->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-field">
                    <label for="type">Type</label>
                    <select name="type" id="type" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        @foreach ($typeOptions as $key => $label)
                            <option value="{{ $key }}" @selected(request('type') === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-field">
                    <label for="q">Recherche</label>
                    <input type="text" name="q" id="q" value="{{ request('q') }}"
                           placeholder="Titre, mot-clé...">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
                    @if (request()->anyFilled(['categorie_id', 'type', 'q']))
                        <a href="{{ route('bibliotheque.index') }}" class="btn btn-outline btn-sm">Réinitialiser</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <!-- ===================== LISTE ===================== -->
    <section id="bibliotheque-liste">
        <div class="container">

            @if ($documents->isEmpty())
                <div class="biblio-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="42" height="42">
                        <path d="M12 3v12m0 0-4-4m4 4 4-4" />
                        <path d="M4 19.5h16" />
                    </svg>
                    <p>Aucun document téléchargeable ne correspond à votre recherche.</p>
                </div>
            @else
                <p class="biblio-results-count">{{ $documents->total() }} document(s) disponible(s)</p>

                <div class="biblio-grid">
                    @foreach ($documents as $document)
                        <article class="biblio-card">
                            <div class="biblio-card-top">
                                <span class="biblio-format">{{ strtoupper($document->format_fichier ?? '—') }}</span>
                                @if ($document->categorie)
                                    <span class="biblio-categorie">{{ $document->categorie->nom }}</span>
                                @endif
                            </div>

                            <h3 class="biblio-title">{{ $document->titre }}</h3>

                            @if ($document->description)
                                <p class="biblio-desc">{{ Str::limit($document->description, 160) }}</p>
                            @endif

                            <div class="biblio-meta">
                                @if ($document->version)
                                    <span><span class="lbl">Version</span> {{ $document->version }}</span>
                                @endif
                                @if ($document->taille_fichier_ko)
                                    <span><span class="lbl">Taille</span>
                                        {{ $document->taille_fichier_ko >= 1024
                                            ? number_format($document->taille_fichier_ko / 1024, 1) . ' Mo'
                                            : $document->taille_fichier_ko . ' Ko' }}
                                    </span>
                                @endif
                                @if ($document->publie_le)
                                    <span><span class="lbl">Publié le</span>
                                        {{ $document->publie_le->format('d/m/Y') }}</span>
                                @endif
                                @if ($document->code_consultation)
                                    <span><span class="lbl">Code</span> {{ $document->code_consultation }}</span>
                                @endif
                            </div>

                            <div class="biblio-card-footer">
                                <a href="{{ route('documents.telecharger', $document) }}"
                                   class="btn btn-primary btn-sm">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         width="15" height="15">
                                        <path d="M12 3v12m0 0-4-4m4 4 4-4" />
                                        <path d="M4 19.5h16" />
                                    </svg>
                                    Télécharger
                                </a>
                                {{-- <span class="biblio-count">{{ $document->nombre_telechargements }} téléchargement(s)</span> --}}
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="biblio-pagination">
                    {{ $documents->links('vendor.pagination.enef') }}
                </div>
            @endif

        </div>
    </section>

    @push('styles')
        @include('bibliotheque._styles')
    @endpush

@endsection