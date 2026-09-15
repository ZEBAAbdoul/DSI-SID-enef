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
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 3" />
                    </svg>
                    {{ $formation->duree_formate }}
                </span>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    {{ $formation->public_cible ?? 'Tous publics' }}
                </span>
                <span>{{ $formation->cout_formate }}</span>
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

            @if ($formation->mots_cles)
                <div style="margin-top:24px;display:flex;gap:9px;flex-wrap:wrap;">
                    @foreach ($formation->mots_cles_array as $motCle)
                        <span class="chip">{{ $motCle }}</span>
                    @endforeach
                </div>
            @endif

            <div style="margin-top:36px;display:flex;gap:14px;flex-wrap:wrap;">
                <a href="{{ url('/') }}#admissions" class="btn btn-primary">Candidater à cette formation</a>
                <a href="{{ url('/') }}#catalogue" class="btn btn-outline">Retour au catalogue</a>
            </div>

        </div>
    </section>

@endsection