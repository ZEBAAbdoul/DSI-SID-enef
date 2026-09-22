@extends('layouts.site')

@section('title', 'ENEF — Documents en consultation sur place')

@section('content')

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Ressources documentaires</div>
            <h1>Documents en consultation sur place</h1>
            <p class="hero-lede">Ces documents ne sont pas téléchargeables en ligne. Munissez-vous du code de
                consultation indiqué et présentez-vous à l'ENEF pour les consulter. Pour les documents
                téléchargeables, rendez-vous sur la
                <a href="{{ route('bibliotheque.index') }}">page des documents téléchargeables</a>.</p>
        </div>
    </section>

    <!-- ===================== FILTRES ===================== -->
    <section id="bibliotheque-filtres" style="padding:0 0 24px;">
        <div class="container">
            <form method="GET" action="{{ route('bibliotheque.consultation') }}" class="biblio-filters">
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
                        <a href="{{ route('bibliotheque.consultation') }}" class="btn btn-outline btn-sm">Réinitialiser</a>
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
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 8v4l3 2" />
                    </svg>
                    <p>Aucun document en consultation sur place ne correspond à votre recherche.</p>
                </div>
            @else
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
                                @if ($document->publie_le)
                                    <span><span class="lbl">Publié le</span>
                                        {{ $document->publie_le->format('d/m/Y') }}</span>
                                @endif
                            </div>

                            <div class="biblio-card-footer">
                                <div class="biblio-consultation">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         width="15" height="15">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 8v4l3 2" />
                                    </svg>
                                    <div>
                                        <span class="biblio-consultation-label">Consultation sur place</span>
                                        @if ($document->code_consultation)
                                            <span class="biblio-code">Code : {{ $document->code_consultation }}</span>
                                        @endif
                                    </div>
                                </div>
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