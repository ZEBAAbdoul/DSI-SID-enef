
<x-admin>

    @section('title', 'Photos')

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
                <i class="fas fa-images mr-2"></i>
                Photos
            </h3>

            <div class="card-tools">

                <a
                    href="{{ route('admin.photos.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    <i class="fas fa-plus"></i>
                    Nouvelle photo
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

                            <th style="width:130px;">
                                IMAGE
                            </th>

                            <th>
                                TITRE
                            </th>

                            <th style="width:100px;">
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

                        @forelse ($photos as $photo)

                            <tr>

                                {{-- Numéro --}}
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Image --}}
                                <td class="text-center">

                                    @if ($photo->image_url)

                                        <img
                                            src="{{ asset('storage/' . $photo->image_url) }}"
                                            alt="{{ $photo->titre }}"
                                            class="img-thumbnail"
                                            style="
                                                width:100px;
                                                height:70px;
                                                object-fit:cover;
                                            "
                                        >

                                    @else

                                        <i class="fas fa-image fa-2x text-muted"></i>

                                    @endif

                                </td>


                                {{-- Titre --}}
                                <td>

                                    <strong>
                                        <i class="fas fa-image text-primary mr-1"></i>
                                        {{ $photo->titre }}
                                    </strong>

                                    @if ($photo->description)

                                        <div class="text-muted small mt-1">
                                            {{ \Illuminate\Support\Str::limit($photo->description, 100) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Ordre --}}
                                <td class="text-center">
                                    {{ $photo->ordre }}
                                </td>


                                {{-- Visibilité --}}
                                <td class="text-center">

                                    @if ($photo->est_visible)

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
                                        href="{{ route('admin.photos.show', $photo) }}"
                                        class="btn btn-sm btn-info"
                                        title="Voir"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    {{-- Modifier --}}
                                    <a
                                        href="{{ route('admin.photos.edit', $photo) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    {{-- Supprimer --}}
                                    <form
                                        action="{{ route('admin.photos.destroy', $photo) }}"
                                        method="POST"
                                        style="display:inline-block;"
                                        class="delete-photo-form"
                                        data-photo-titre="{{ $photo->titre }}"
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

                                    <i class="fas fa-images fa-2x mb-2"></i>

                                    <br>

                                    Aucune photo trouvée.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        @if ($photos instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="card-footer">
                {{ $photos->withQueryString()->links() }}
            </div>

        @endif

    </div>


    {{-- SWEETALERT --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form.delete-photo-form')
                .forEach(function (form) {

                    form.addEventListener('submit', function (event) {

                        event.preventDefault();

                        const titre = form.getAttribute(
                            'data-photo-titre'
                        );

                        Swal.fire({

                            title: 'Supprimer cette photo ?',

                            html:
                                'La photo <strong>« ' +
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

