

<x-admin>

    @section('title', 'Détail de la vidéo')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-video mr-2"></i>

                Détail de la vidéo

            </h3>


            <div class="card-tools">

                <a
                    href="{{ route('admin.videos.edit', $video) }}"
                    class="btn btn-warning btn-sm"
                >

                    <i class="fas fa-edit mr-1"></i>

                    Modifier

                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="row">

                <div class="col-md-8">

                    <div class="embed-responsive embed-responsive-16by9 bg-dark">

                        <iframe
                            class="embed-responsive-item"
                            src="{{ $video->url }}"
                            allowfullscreen
                        ></iframe>

                    </div>

                    <div class="mt-3">

                        <a
                            href="{{ $video->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-external-link-alt mr-1"></i>

                            Ouvrir la vidéo

                        </a>

                    </div>

                </div>


                <div class="col-md-4">

                    <h4>
                        {{ $video->titre }}
                    </h4>


                    <hr>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-align-left mr-1"></i>
                            Description
                        </strong>

                        <div class="text-muted mt-1">

                            @if ($video->description)

                                {!! nl2br(e($video->description)) !!}

                            @else

                                <em>
                                    Aucune description.
                                </em>

                            @endif

                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-link mr-1"></i>
                            Lien
                        </strong>

                        <div class="mt-1">

                            <a
                                href="{{ $video->url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                {{ $video->url }}
                            </a>

                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-sort-numeric-down mr-1"></i>
                            Ordre
                        </strong>

                        <span class="ml-2">
                            {{ $video->ordre }}
                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-eye mr-1"></i>
                            Visibilité
                        </strong>

                        <span class="ml-2">

                            @if ($video->est_visible)

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

                            {{ $video->created_at?->format('d/m/Y H:i') }}

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-edit mr-1"></i>
                            Modifiée le
                        </strong>

                        <span class="ml-2">

                            {{ $video->updated_at?->format('d/m/Y H:i') }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="card-footer">

            <a
                href="{{ route('admin.videos.index') }}"
                class="btn btn-secondary"
            >

                <i class="fas fa-arrow-left mr-1"></i>

                Retour à la liste

            </a>

        </div>

    </div>

</x-admin>

