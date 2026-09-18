{{-- resources/views/admin/categories-documents/index.blade.php --}}

<x-admin>

    @section('title', 'Catégories de documents')

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
                <i class="fas fa-folder-open mr-2"></i>
                Catégories de documents
            </h3>

            <div class="card-tools">

                {{-- Recherche --}}
                <form
                    action="{{ route('admin.categories-documents.index') }}"
                    method="GET"
                    class="form-inline"
                    style="display:inline-block;margin-right:10px;"
                >
                    <div class="input-group input-group-sm" style="width:240px;">

                        <input
                            type="text"
                            name="recherche"
                            value="{{ request('recherche') }}"
                            class="form-control"
                            placeholder="Rechercher une catégorie…"
                        >

                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>

                    </div>
                </form>


                {{-- Nouvelle catégorie --}}
                <a
                    href="{{ route('admin.categories-documents.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    <i class="fas fa-plus"></i>
                    Nouvelle catégorie
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
                            <th style="width:60px;">#</th>
                            <th>NOM</th>
                            <th>CATÉGORIE PARENTE</th>
                            <th>SOUS-CATÉGORIES</th>
                            <th>DOCUMENTS</th>
                            <th style="width:140px;">ACTIONS</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse ($categories as $categorie)

                            <tr>

                                {{-- Numéro --}}
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- Nom --}}
                                <td>
                                    <strong>
                                        <i class="fas fa-folder text-warning mr-1"></i>
                                        {{ $categorie->nom }}
                                    </strong>
                                </td>


                                {{-- Parent --}}
                                <td>
                                    @if ($categorie->parent)
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-folder mr-1"></i>
                                            {{ $categorie->parent->nom }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            Catégorie principale
                                        </span>
                                    @endif
                                </td>


                                {{-- Enfants --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $categorie->enfants->count() }}
                                    </span>
                                </td>


                                {{-- Documents --}}
                                <td>
                                    @if ($categorie->documents_count ?? false)
                                        <span class="badge badge-success">
                                            {{ $categorie->documents_count }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            0
                                        </span>
                                    @endif
                                </td>


                                {{-- Actions --}}
                                <td>

                                    {{-- Voir --}}
                                    <a
                                        href="{{ route('admin.categories-documents.show', $categorie) }}"
                                        class="btn btn-sm btn-info"
                                        title="Voir"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    {{-- Modifier --}}
                                    <a
                                        href="{{ route('admin.categories-documents.edit', $categorie) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    {{-- Supprimer --}}
                                    <form
                                        action="{{ route('admin.categories-documents.destroy', $categorie) }}"
                                        method="POST"
                                        style="display:inline-block;"
                                        class="delete-categorie-form"
                                        data-categorie-nom="{{ $categorie->nom }}"
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
                                    <i class="fas fa-folder-open fa-2x mb-2"></i>
                                    <br>
                                    Aucune catégorie de document trouvée.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        @if ($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="card-footer">
                {{ $categories->withQueryString()->links() }}
            </div>

        @endif

    </div>


    {{-- SWEETALERT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form.delete-categorie-form')
                .forEach(function (form) {

                    form.addEventListener('submit', function (event) {

                        event.preventDefault();

                        const categorie = form.getAttribute(
                            'data-categorie-nom'
                        );

                        Swal.fire({

                            title: 'Supprimer cette catégorie ?',

                            html:
                                'La catégorie <strong>« ' +
                                categorie +
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

