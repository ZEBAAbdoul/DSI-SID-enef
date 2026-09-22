@extends('layouts.site')

@section('title', 'ENEF — Recherches et innovations')

@section('content')

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Recherche &amp; innovation</div>
            <h1>Les recherches et innovations de l'ENEF</h1>
            <p class="hero-lede">L'école développe et valorise des travaux de recherche appliquée et des innovations
                au service des eaux, des forêts et de l'environnement : projets, expérimentations, prototypes et
                réalisations menés par les enseignants et les apprenants de l'ENEF.</p>
            <div style="margin-top:20px;">
                <a href="{{ url('/') }}" class="btn btn-outline btn-sm">&larr; Retour à l'accueil</a>
            </div>
        </div>
    </section>

    <!-- ===================== LISTE ===================== -->
    <section id="recherches-innovations" class="alt">
        <div class="container">

            <div class="ri-filter">
                <form action="{{ route('recherches-innovations.index') }}" method="GET">
                    <label class="ri-filter-label" for="ri-type">Filtrer par type</label>
                    <select id="ri-type" name="type" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        @foreach ($types as $valeur => $libelle)
                            <option value="{{ $valeur }}" @selected(request('type') === $valeur)>
                                {{ $libelle }}
                            </option>
                        @endforeach
                    </select>
                    <noscript>
                        <button type="submit" class="btn btn-outline btn-sm">Filtrer</button>
                    </noscript>
                </form>

                @if (request('type'))
                    <a class="ri-filter-reset" href="{{ route('recherches-innovations.index') }}">
                        &times; Tout afficher
                    </a>
                @endif

                <span class="ri-filter-count">
                    {{ $recherchesInnovations->total() }} résultat(s)
                </span>
            </div>

            <div class="ri-grid">

                @forelse ($recherchesInnovations as $rechercheInnovation)
                    <article class="ri-card">
                    <a href="{{ route('recherches-innovations.show', $rechercheInnovation->slug) }}"
                       class="ri-thumb"
                       aria-label="Lire « {{ $rechercheInnovation->titre }} »">
                        @if ($rechercheInnovation->image)
                            <img src="{{ $rechercheInnovation->image }}"
                                 alt="{{ $rechercheInnovation->titre }}"
                                 loading="lazy">
                        @else
                            <span class="ri-ph">
                                <svg viewBox="0 0 24 24" width="34" height="34" fill="none"
                                     stroke="currentColor" stroke-width="1.6">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 8v8M8 12h8" />
                                </svg>
                            </span>
                        @endif
                    </a>

                    <div class="ri-body">
                        <div class="ri-top">
                            <span class="ri-type {{ $rechercheInnovation->type }}">
                                {{ $rechercheInnovation->type_libelle }}
                            </span>
                            <span class="ri-date">
                                {{ $rechercheInnovation->created_at->translatedFormat('d M Y') }}
                            </span>
                        </div>

                        <h3>
                            <a href="{{ route('recherches-innovations.show', $rechercheInnovation->slug) }}">
                                {{ $rechercheInnovation->titre }}
                            </a>
                        </h3>

                        <p>{{ $rechercheInnovation->chapo ?? \Illuminate\Support\Str::limit(strip_tags((string) $rechercheInnovation->contenu), 140) }}</p>

                        <a class="ri-link"
                           href="{{ route('recherches-innovations.show', $rechercheInnovation->slug) }}">Lire la
                            suite
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M13 6l6 6-6 6" />
                            </svg>
                        </a>
                    </div>
                </article>
                @empty
                    <p style="color:var(--ink-soft);">Aucune recherche ou innovation publiée pour le moment.</p>
                @endforelse

            </div>

            <div style="margin-top:32px;">
                {{ $recherchesInnovations->links('vendor.pagination.enef') }}
            </div>

        </div>
    </section>

    <style>
        .ri-filter {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 26px;
            padding: 14px 16px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 4px;
        }

        .ri-filter form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .ri-filter-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-soft);
        }

        .ri-filter select {
            font: inherit;
            font-size: 14px;
            color: var(--ink);
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 3px;
            padding: 8px 12px;
            min-width: 200px;
            cursor: pointer;
        }

        .ri-filter select:focus-visible {
            outline: 3px solid var(--water);
            outline-offset: 2px;
        }

        .ri-filter-reset {
            font-size: 13px;
            font-weight: 600;
            color: var(--clay);
            text-decoration: none;
        }

        .ri-filter-reset:hover {
            text-decoration: underline;
        }

        .ri-filter-count {
            font-size: 13px;
            color: var(--ink-soft);
        }

        .ri-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .ri-card {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: box-shadow .18s ease, transform .18s ease;
        }

        .ri-card:hover {
            box-shadow: 0 10px 24px rgba(23, 50, 38, .12);
            transform: translateY(-3px);
        }

        .ri-thumb {
            aspect-ratio: 16/10;
            background: linear-gradient(135deg, var(--water), #173226);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .ri-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .ri-thumb .ri-ph {
            color: #fff;
            opacity: .75;
        }

        .ri-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .ri-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .ri-type {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 5px 10px;
            color: #fff;
            border-radius: 999px;
        }

        .ri-type.recherche {
            background: var(--water);
        }

        .ri-type.innovation {
            background: #173226;
        }

        .ri-date {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .ri-body h3 {
            margin: 0 0 8px;
            font-size: 17px;
            line-height: 1.35;
        }

        .ri-body h3 a {
            color: inherit;
            text-decoration: none;
        }

        .ri-body h3 a:hover {
            color: var(--clay);
        }

        .ri-body p {
            margin: 0 0 14px;
            color: var(--ink-soft);
            font-size: 14px;
            flex: 1;
        }

        .ri-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            color: var(--water);
            text-decoration: none;
        }

        .ri-link svg {
            width: 16px;
            height: 16px;
        }

        .ri-link:hover {
            color: var(--clay);
        }
    </style>

@endsection