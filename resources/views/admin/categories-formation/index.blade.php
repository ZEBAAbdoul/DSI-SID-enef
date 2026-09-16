{{-- resources/views/admin/categories-formation/index.blade.php --}}
<x-admin>
    @section('title', 'Catégories de formation')

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Catégories de formation</h3>
            <div class="card-tools">
                <form action="{{ route('admin.categories-formation.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="{{ request('recherche') }}" class="form-control"
                            placeholder="Rechercher une catégorie…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="{{ route('admin.categories-formation.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle catégorie
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NOM</th>
                            <th>SLUG</th>
                            {{-- <th>FORMATIONS</th>
                            <th>CRÉÉE LE</th> --}}
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $categorie)
                            <tr>
                                <td>{{ $categorie->nom_formate }}</td>
                                <td><code>{{ $categorie->slug }}</code></td>
                                {{-- <td>
                                    <span class="badge badge-info">{{ $categorie->formations_count }}</span>
                                </td>
                                <td>{{ $categorie->created_at?->format('d/m/Y') }}</td> --}}
                                <td>
                                    <a href="{{ route('admin.categories-formation.edit', $categorie) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories-formation.destroy', $categorie) }}" method="POST" style="display:inline-block;"
                                        class="delete-categorie-form"
                                        data-categorie-nom="{{ $categorie->nom }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucune catégorie trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $categories->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.delete-categorie-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const categorie = form.getAttribute('data-categorie-nom');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer cette catégorie ?',
                        text: 'La catégorie « ' + categorie + ' » sera définitivement supprimée.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formToSubmit.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-admin>
