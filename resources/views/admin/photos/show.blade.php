

<x-admin>

    @section('title', 'Détail de la photo')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-image mr-2"></i>
                Détail de la photo
            </h3>

            <div class="card-tools">

                <a
                    href="{{ route('admin.photos.edit', $photo) }}"
                    class="btn btn-warning btn-sm"
                >
                    <i class="fas fa-edit mr-1"></i>
                    Modifier
                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="row">

                {{-- IMAGE --}}
                <div class="col-md-7 text-center">

                    @if ($photo->image_url)

                        <img
                            src="{{ asset('storage/' . $photo->image_url) }}"
                            alt="{{ $photo->titre }}"
                            class="img-fluid img-thumbnail"
                            style="max-height:500px;"
                        >

                    @else

                        <div class="text-muted py-5">

                            <i class="fas fa-image fa-4x"></i>

                            <p class="mt-2">
                                Aucune image disponible.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- INFORMATIONS --}}
                <div class="col-md-5">

                    <h4 class="mb-3">
                        {{ $photo->titre }}
                    </h4>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-align-left mr-1"></i>
                            Description
                        </strong>

                        <div class="text-muted mt-1">

                            @if ($photo->description)

                                {!! nl2br(e($photo->description)) !!}

                            @else

                                <em>
                                    Aucune description.
                                </em>

                            @endif

                        </div>

                    </div>


                    <hr>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-sort-numeric-down mr-1"></i>
                            Ordre
                        </strong>

                        <span class="ml-2">
                            {{ $photo->ordre }}
                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-eye mr-1"></i>
                            Visibilité
                        </strong>

                        <span class="ml-2">

                            @if ($photo->est_visible)

                                <span class="badge badge-success">
                                    <i class="fas fa-check mr-1"></i>
                                    Visible
                                </span>

                            @else

                                <span class="badge badge-secondary">
                                    <i class="fas fa-times mr-1"></i>
                                    Masquée
                                </span>

                            @endif

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-plus mr-1"></i>
                            Créée le
                        </strong>

                        <span class="ml-2">
                            {{ $photo->created_at?->format('d/m/Y H:i') }}
                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-edit mr-1"></i>
                            Modifiée le
                        </strong>

                        <span class="ml-2">
                            {{ $photo->updated_at?->format('d/m/Y H:i') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="card-footer">

            <a
                href="{{ route('admin.photos.index') }}"
                class="btn btn-secondary"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Retour à la liste
            </a>

        </div>

    </div>

</x-admin>

