@extends('layouts.site')

@section('title', 'Choisir une session de formation')

@section('content')

    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Espace candidat</div>
            <h1>Choisissez votre session de formation</h1>
            <p class="hero-lede">Sélectionnez la session à laquelle vous souhaitez candidater.</p>
        </div>
    </section>

    <section class="alt">
        <div class="container">
            @error('session_formation_id')
                <p class="form-error" style="margin-bottom:20px;">{{ $message }}</p>
            @enderror

            <div class="sessions-choix-grid">
                @forelse ($sessions as $session)
                    <form action="{{ route('inscription.store') }}" method="POST" class="session-choix-card">
                        @csrf
                        <input type="hidden" name="session_formation_id" value="{{ $session->id }}">

                        <h4>{{ $session->formation->titre ?? 'Formation' }}</h4>
                        <p class="session-choix-meta">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $session->lieu ?? 'Lieu à préciser' }}
                        </p>
                        <p class="session-choix-meta">
                            Du {{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y') }}
                            @if ($session->date_fin)
                                au {{ \Carbon\Carbon::parse($session->date_fin)->translatedFormat('d M Y') }}
                            @endif
                        </p>
                        <span class="places-badge">{{ $session->places_disponibles }} / {{ $session->places_totales }} places</span>

                        <button type="submit" class="btn btn-primary btn-sm">Candidater à cette session</button>
                    </form>
                @empty
                    <p style="color:var(--ink-soft);">Aucune session ouverte pour le moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .sessions-choix-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }

            .session-choix-card {
                display: flex;
                flex-direction: column;
                gap: 8px;
                background: var(--white);
                border: 1px solid var(--line);
                padding: 20px;
            }

            .session-choix-meta {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 13px;
                color: var(--ink-soft);
            }

            .session-choix-card .places-badge {
                align-self: flex-start;
                font-size: 11.5px;
                font-weight: 700;
                color: var(--water);
                background: var(--water-soft);
                padding: 4px 9px;
                margin: 4px 0 8px;
            }

            .form-error {
                color: #A32020;
                font-size: 13px;
            }
        </style>
    @endpush

@endsection