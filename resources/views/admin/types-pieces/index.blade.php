{{-- resources/views/admin/types-pieces/index.blade.php --}}
<x-admin>
    @section('title', 'Types de pièces')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Types de pièces</h3>
            <div class="card-tools">
                <form action="{{ route('admin.types-pieces.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="{{ request('recherche') }}" class="form-control"
                            placeholder="Rechercher un type de pièce…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="{{ route('admin.types-pieces.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouveau type de pièce
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ORDRE</th>
                            <th>CODE</th>
                            <th>LIBELLÉ</th>
                            <th>OBLIGATOIRE</th>
                            <th>ACTIF</th>
                            
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($typesPieces as $typePiece)
                            <tr>
                                <td>{{ $typePiece->ordre }}</td>
                                <td><code>{{ $typePiece->code }}</code></td>
                                <td>{{ $typePiece->libelle }}</td>
                                <td>
                                    <span class="badge {{ $typePiece->obligatoire ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $typePiece->obligatoire ? 'Oui' : 'Non' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $typePiece->actif ? 'badge-primary' : 'badge-danger' }}">
                                        {{ $typePiece->actif ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('admin.types-pieces.edit', $typePiece) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.types-pieces.destroy', $typePiece) }}" method="POST" style="display:inline-block;"
                                        class="delete-type-piece-form"
                                        data-type-piece-code="{{ $typePiece->code }}"
                                        data-type-piece-libelle="{{ $typePiece->libelle }}">
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
                                <td colspan="7" class="text-center text-muted">Aucun type de pièce trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $typesPieces->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status_type_piece'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('status_type_piece') }}',
                    timer: 2500,
                    showConfirmButton: false,
                });
            @endif

            @if (session('erreur_type_piece'))
                Swal.fire({
                    icon: 'error',
                    title: 'Suppression impossible',
                    text: '{{ session('erreur_type_piece') }}',
                });
            @endif

            document.querySelectorAll('form.delete-type-piece-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const code = form.getAttribute('data-type-piece-code');
                    const libelle = form.getAttribute('data-type-piece-libelle');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer ce type de pièce ?',
                        html: 'Le type <strong>« ' + libelle + ' »</strong> (<code>' + code + '</code>) sera définitivement supprimé.',
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
