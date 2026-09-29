@extends('layouts.site')

@section('title', $actualite->titre . ' — ENEF')

@section('content')

    <section style="padding-top:40px;">
        <div class="container" style="max-width:780px;">

            <span class="kicker">{{ $actualite->type_libelle }}</span>
            <h1 style="font-size:clamp(26px,3.5vw,38px);">{{ $actualite->titre }}</h1>
            <p style="color:var(--ink-soft);font-size:14px;margin-bottom:24px;">
                Publié le {{ $actualite->created_at->translatedFormat('d F Y') }}
            </p>

            @if ($actualite->image_couverture_url)
                <img src="{{ $actualite->image }}" alt="{{ $actualite->titre }}"
                    style="width:100%; max-height:420px; object-fit:cover; border:1px solid var(--line); margin-bottom:28px;">
            @endif

            @if ($actualite->chapo)
                <p style="font-size:18px; font-weight:600; color:var(--forest-deep);">{{ $actualite->chapo }}</p>
            @endif

            <div style="white-space:pre-line; font-size:15.5px; line-height:1.7;">
                {{ $actualite->contenu }}
            </div>

            @if ($actualite->lien_facebook)
                <div style="margin-top:24px;">
                    <a href="{{ $actualite->lien_facebook }}" target="_blank" rel="noopener noreferrer"
                        class="btn btn-outline">
                        <i class="fab fa-facebook-f me-1"></i>
                        Voir sur Facebook
                    </a>
                </div>
            @endif

            <div style="margin-top:36px; display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
                <button type="button" class="btn btn-outline" data-partage
                        data-titre="{{ $actualite->titre }}"
                        data-url="{{ route('actualites.show', $actualite->slug) }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;" aria-hidden="true">
                        <line x1="12" y1="2" x2="12" y2="15" />
                        <polyline points="16 6 12 2 8 6" />
                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                    </svg>
                    Partager cette actualité
                </button>
                <a href="{{ route('actualites.index') }}" class="btn btn-outline">Retour aux actualités</a>
            </div>

        </div>
    </section>

    @push('scripts')
        <script>
            (function() {
                var btn = document.getElementById('btn-retour');
                if (!btn) return;

                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.history.length > 1) {
                        window.history.back();
                    } else {
                        window.location.assign('{{ url('/') }}#actualites');
                    }
                });
            })();
        </script>

        @include('partials.share-action')
    @endpush

@endsection
