@extends('layouts.site')

@section('title', $formation->titre . ' — ENEF')

@section('content')

    <section style="padding-top:40px;">
        <div class="container">

            <div class="section-head">
                <div>
                    <span class="kicker">{{ $formation->categorie->nom ?? 'Formation' }}</span>
                    <h2>{{ $formation->titre }}</h2>
                    <p class="desc">{{ $formation->resume }}</p>
                </div>
                @if ($formation->type === 'continue_a_la_carte')
                    <span class="badge carte">À la carte</span>
                @else
                    <span class="badge prog">{{ $formation->type_libelle }}</span>
                @endif
            </div>

            <div class="course-meta" style="margin-bottom:32px;">
                @if ($formation->duree)
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 3" />
                        </svg>
                        {{ $formation->duree }}
                    </span>
                @endif
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    {{ $formation->public_cible ?? 'Tous publics' }}
                </span>
                @if ($formation->cout_indicatif)
                    <span>{{ $formation->cout_formate ?? number_format($formation->cout_indicatif, 0, ',', ' ') . ' F CFA / participant' }}</span>
                @endif
                @if ($formation->filiere)
                    <span>Filière : {{ $formation->filiere->nom }}</span>
                @endif
            </div>

            @if ($formation->image_url)
                <div style="margin-bottom:32px;">
                    <img src="{{ asset($formation->image_url) }}" alt="{{ $formation->titre }}"
                        style="width:100%; max-height:420px; object-fit:cover; border:1px solid var(--line);">
                </div>
            @endif

            @if ($formation->objectifs)
                <h3>Objectifs</h3>
                <p style="white-space:pre-line;">{{ $formation->objectifs }}</p>
            @endif

            @if ($formation->contenu_programme)
                <h3>Programme</h3>
                <p style="white-space:pre-line;">{{ $formation->contenu_programme }}</p>
            @endif

            @if ($formation->techniques || $formation->places_min || $formation->places_max || $formation->periode_indicative)
                <h3>Infos pratiques</h3>
                <div class="module-infos">
                    @if ($formation->techniques)
                        <div><span class="lbl">Techniques pédagogiques</span><span>{{ $formation->techniques }}</span></div>
                    @endif
                    @if ($formation->places_min || $formation->places_max)
                        <div><span class="lbl">Places par session</span><span>{{ $formation->places_min }} à {{ $formation->places_max }} personnes</span></div>
                    @endif
                    @if ($formation->periode_indicative)
                        <div><span class="lbl">Période indicative</span><span>{{ $formation->periode_indicative }}</span></div>
                    @endif
                </div>
            @endif

            @if ($formation->sessions && $formation->sessions->isNotEmpty())
                <h3>Prochaines sessions</h3>
                <ul class="sessions-list" style="margin-bottom:24px;">
                    @foreach ($formation->sessions as $session)
                        <li class="session-item">
                            <span class="session-date">
                                {{ \Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y') }}
                                @if ($session->date_fin)
                                    → {{ \Carbon\Carbon::parse($session->date_fin)->translatedFormat('d M Y') }}
                                @endif
                            </span>
                            <span class="session-lieu">{{ $session->lieu }}</span>
                            <span class="session-places">{{ $session->places_disponibles }} place(s) disponible(s)</span>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if ($formation->mots_cles)
                <div style="margin-top:24px;display:flex;gap:9px;flex-wrap:wrap;">
                    @foreach ($formation->mots_cles_array as $motCle)
                        <span class="chip">{{ $motCle }}</span>
                    @endforeach
                </div>
            @endif

            <div style="margin-top:36px;display:flex;gap:14px;flex-wrap:wrap;">
                @if ($formation->type === 'continue_a_la_carte')
                    <a href="{{ url('/') }}#admissions" class="btn btn-primary">Demander ce module</a>
                @else
                    <a href="{{ url('/') }}#admissions" class="btn btn-primary">Candidater à cette formation</a>
                @endif
                <a href="{{ route('catalogue.formations') }}" class="btn btn-outline">Retour au catalogue</a>
            </div>

        </div>
    </section>

    @push('styles')
        <style>
            .module-infos {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 12px;
                margin: 18px 0 28px;
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

            .module-infos > div span:last-child { font-size: 13.5px; }
        </style>
    @endpush

@endsection