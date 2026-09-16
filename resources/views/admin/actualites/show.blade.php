@extends('layouts.app')

@section('title', $actualite->titre . ' - ENEF')

@section('content')

<div class="container py-5">

    <div class="row g-5">

        {{-- Contenu principal --}}
        <div class="col-lg-8">

            {{-- Type --}}
            <div class="mb-3">

                <span class="badge {{ $actualite->type_badge }}">
                    {{ $actualite->type_libelle }}
                </span>

            </div>


            {{-- Titre --}}
            <h1 class="fw-bold mb-3">
                {{ $actualite->titre }}
            </h1>


            {{-- Date --}}
            <div class="text-muted mb-4">

                <i class="far fa-calendar-alt me-2"></i>

                Publié le
                {{ $actualite->created_at->format('d/m/Y à H:i') }}

            </div>


            {{-- Image --}}
            <div class="mb-4">

                <img
                    src="{{ $actualite->image }}"
                    alt="{{ $actualite->titre }}"
                    class="img-fluid rounded shadow-sm w-100"
                    style="max-height:500px; object-fit:cover;"
                >

            </div>


            {{-- Chapo --}}
            @if($actualite->chapo)

                <div class="lead fw-semibold mb-4">

                    {{ $actualite->chapo }}

                </div>

            @endif


            {{-- Contenu --}}
            <div
                class="actualite-contenu"
                style="line-height:1.9;"
            >

                {!! nl2br(e($actualite->contenu)) !!}

            </div>


            {{-- Retour --}}
            <div class="mt-5">

                <a
                    href="{{ route('actualites.index') }}"
                    class="btn btn-outline-success"
                >

                    <i class="fas fa-arrow-left me-1"></i>

                    Retour aux actualités

                </a>

            </div>

        </div>


        {{-- Sidebar --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-success text-white">

                    <strong>
                        Actualités récentes
                    </strong>

                </div>


                <div class="list-group list-group-flush">

                    @forelse($recentes as $recente)

                        <a
                            href="{{ route('actualites.show', $recente->slug) }}"
                            class="list-group-item list-group-item-action"
                        >

                            <div class="fw-bold">

                                {{ Str::limit($recente->titre, 70) }}

                            </div>

                            <small class="text-muted">

                                {{ $recente->created_at->format('d/m/Y') }}

                            </small>

                        </a>

                    @empty

                        <div class="p-3 text-muted">
                            Aucune autre actualité.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection