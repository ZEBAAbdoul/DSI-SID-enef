

<x-admin>

    @section('title', 'Vidéos')

    @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card">

        {{-- HEADER --}}
        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-video mr-2"></i>

                Vidéos

            </h3>


            <div class="card-tools">

                {{-- Recherche --}}
                <form
                    action="{{ route('admin.videos.index') }}"
                    method="GET"
                    class="form-inline"
                    style="display:inline-block;margin-right:10px;"
                >

                    <div
                        class="input-group input-group-sm"
                        style="width:240px;"
                    >

                        <input
                            type="text"
                            name="recherche"
                            value="{{ request('recherche') }}"
                            class="form-control"
                            placeholder="Rechercher une vidéo…"
                        >

                        <span class="input-group-append">

                            <button
                                type="submit"
                                class="btn btn-default"
                            >
                                <i class="fas fa-search"></i>
                            </button>

                        </span>

                    </div>

                </form>


                {{-- Nouvelle vidéo --}}
                <a
                    href="{{ route('admin.videos.create') }}"
                    class="btn btn-primary btn-sm"
                >

                    <i class="fas fa-plus"></i>

                    Nouvelle vidéo

                </a>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover mb-0"
                    width="100%"
                    cellspacing="0"
                >

                    <thead>

                        <tr>

                            <th style="width:60px;">
                                #
                            </th>

                            <th>
                                TITRE
                            </th>

                            <th>
                                LIEN VIDÉO
                            </th>

                            <th style="width:90px;">
                                ORDRE
                            </th>

                            <th style="width:120px;">
                                VISIBILITÉ
                            </th>

                            <th style="width:150px;">
                                ACTIONS
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($videos as $video)

                            <tr>

                                {{-- Numéro --}}
                                <td class="text-center">
                                    {{ $videos->firstItem() + $loop->index }}
                                </td>


                                {{-- Titre --}}
                                <td>

                                    <strong>

                                        <i class="fas fa-video text-danger mr-1"></i>

                                        {{ $video->titre }}

                                    </strong>

                                    @if ($video->description)

                                        <div class="text-muted small mt-1">

                                            {{ \Illuminate\Support\Str::limit($video->description, 100) }}

                                        </div>

                                    @endif

                                </td>


                                {{-- URL --}}
                                <td>

                                    <a
                                        href="{{ $video->url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        title="Ouvrir la vidéo"
                                    >

                                        <i class="fas fa-external-link-alt mr-1"></i>

                                        {{ \Illuminate\Support\Str::limit($video->url, 60) }}

                                    </a>

                                </td>


                                {{-- Ordre --}}
                                <td class="text-center">

                                    {{ $video->ordre }}

                                </td>


                                {{-- Visibilité --}}
                                <td class="text-center">

                                    @if ($video->est_visible)

                                        <span class="badge badge-success">

                                            <i class="fas fa-eye mr-1"></i>

                                            Visible

                                        </span>

                                    @else

                                        <span class="badge badge-secondary">

                                            <i class="fas fa-eye-slash mr-1"></i>

                                            Masquée

                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    {{-- Voir --}}
                                    <a
                                        href="{{ route('admin.videos.show', $video) }}"
                                        class="btn btn-sm btn-info"
                                        title="Voir"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    {{-- Modifier --}}
                                    <a
                                        href="{{ route('admin.videos.edit', $video) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    {{-- Supprimer --}}
                                    <form
                                        action="{{ route('admin.videos.destroy', $video) }}"
                                        method="POST"
                                        style="display:inline-block;"
                                        class="delete-video-form"
                                        data-video-titre="{{ $video->titre }}"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Supprimer"
                                        >

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >

                                    <i class="fas fa-video fa-2x mb-2"></i>

                                    <br>

                                    Aucune vidéo trouvée.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        @if ($videos instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="card-footer">

                {{ $videos->withQueryString()->links() }}

            </div>

        @endif

    </div>


    {{-- SWEETALERT --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form.delete-video-form')
                .forEach(function (form) {

                    form.addEventListener('submit', function (event) {

                        event.preventDefault();

                        const titre = form.getAttribute(
                            'data-video-titre'
                        );

                        Swal.fire({

                            title: 'Supprimer cette vidéo ?',

                            html:
                                'La vidéo <strong>« ' +
                                titre +
                                ' »</strong> sera définitivement supprimée.',

                            icon: 'warning',

                            showCancelButton: true,

                            confirmButtonColor: '#d33',

                            cancelButtonColor: '#6c757d',

                            confirmButtonText:
                                '<i class="fas fa-trash"></i> Oui, supprimer',

                            cancelButtonText:
                                'Annuler',

                        }).then(function (result) {

                            if (result.isConfirmed) {

                                form.submit();

                            }

                        });

                    });

                });

        });

    </script>

</x-admin>

