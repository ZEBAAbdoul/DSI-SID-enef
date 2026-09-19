<x-admin>

    @section('title', 'Catégories de photos')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-folder mr-2"></i>
                Catégories de photos
            </h3>

            <div class="card-tools">

                <a href="{{ route('admin.categories-photos.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle catégorie
                </a>

            </div>

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Photos</th>
                        <th>Ordre</th>
                        <th>Visible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->titre }}</td>
                            <td>{{ Str::limit($categorie->description, 50) ?? '-' }}</td>
                            <td>{{ $categorie->photos_count }}</td>
                            <td>{{ $categorie->ordre }}</td>
                            <td>
                                @if($categorie->est_visible)
                                    <span class="badge badge-success">Oui</span>
                                @else
                                    <span class="badge badge-danger">Non</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.categories-photos.show', $categorie) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.categories-photos.edit', $categorie) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories-photos.destroy', $categorie) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Les photos seront conservées mais sans catégorie.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune catégorie trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

</x-admin>