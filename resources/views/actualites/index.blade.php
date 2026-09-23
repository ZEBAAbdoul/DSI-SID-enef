@extends('layouts.site')

@section('title', 'ENEF — Actualités')

@section('content')

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:24px 0 4px;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Actualités</div>
            <h1 style="margin:0 0 6px; font-size:1.55rem;">Les actualités de l'ENEF</h1>
            <p class="hero-lede" style="margin:0 auto 14px; max-width:680px; font-size:0.95rem;">Suivez la vie de
                l'école : événements, formations, partenariats et communiqués au service des eaux, des forêts et de
                l'environnement.</p>
            <div style="margin-bottom:10px;">
                <a href="{{ url('/') }}#actualites" class="btn btn-outline btn-sm">&larr; Retour à l'accueil</a>
            </div>
        </div>
    </section>

    <!-- ===================== LISTE ===================== -->
    <section id="actualites" class="alt">
        <div class="container">

            <div class="ri-filter">
                <span class="ri-filter-count">
                    {{ $actualites->total() }} actualité(s)
                </span>
            </div>

            <div class="ri-grid">

                @forelse ($actualites as $actualite)
                    <article class="ri-card">
                        <a href="{{ route('actualites.show', $actualite->slug) }}"
                           class="ri-thumb"
                           aria-label="Lire « {{ $actualite->titre }} »">
                            <img src="{{ $actualite->image }}"
                                 alt="{{ $actualite->titre }}"
                                 loading="lazy">
                        </a>

                        <div class="ri-body">
                            <div class="ri-top">
                                <span class="ri-type">{{ $actualite->type_libelle }}</span>
                                <span class="ri-date">
                                    {{ $actualite->created_at->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <h3>
                                <a href="{{ route('actualites.show', $actualite->slug) }}">
                                    {{ $actualite->titre }}
                                </a>
                            </h3>

                            <p>{{ $actualite->chapo ?? $actualite->resume }}</p>

                            <a class="ri-link"
                               href="{{ route('actualites.show', $actualite->slug) }}">Lire la
                                suite
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M13 6l6 6-6 6" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <p style="color:var(--ink-soft);">Aucune actualité publiée pour le moment.</p>
                @endforelse

            </div>

            <div style="margin-top:32px;">
                {{ $actualites->links('vendor.pagination.enef') }}
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
            background: var(--water);
            border-radius: 999px;
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