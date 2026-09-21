@extends('layouts.site')

@section('title', 'Galerie photo')

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold">Galerie photo</h1>
        <p class="text-muted">Quelques images de la vie de l'établissement.</p>
    </div>

    @if($photos->isEmpty())
        <p class="text-center text-muted">Aucune photo disponible pour le moment.</p>
    @else
        <div class="row g-4">
            @foreach($photos as $photo)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ $photo->image_url }}"
                       data-bs-toggle="modal"
                       data-bs-target="#modalPhoto{{ $photo->id }}"
                       class="d-block text-decoration-none">
                        <div class="ratio ratio-4x3 rounded overflow-hidden shadow-sm">
                            <img src="{{ $photo->image_url }}"
                                 alt="{{ $photo->titre }}"
                                 class="w-100 h-100"
                                 style="object-fit: cover;"
                                 loading="lazy">
                        </div>
                        <p class="mt-2 mb-0 small fw-semibold text-dark text-truncate">
                            {{ $photo->titre }}
                        </p>
                    </a>
                </div>

                {{-- Modal d'agrandissement --}}
                <div class="modal fade" id="modalPhoto{{ $photo->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h2 class="modal-title h6 mb-0">{{ $photo->titre }}</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <img src="{{ $photo->image_url }}" alt="{{ $photo->titre }}" class="w-100">
                            @if($photo->description)
                                <div class="modal-body">
                                    <p class="mb-0 text-muted">{{ $photo->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection