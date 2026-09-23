{{-- resources/views/admin/matieres/index.blade.php --}}
<x-admin>
    @section('title', 'Matières')

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session('erreur_matiere'))
        <div class="alert alert-danger">{{ session('erreur_matiere') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Matières</h3>
            <div class="card-tools">
                <form action="{{ route('admin.matieres.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:5px;">
                    <div class="input-group input-group-sm" style="width:200px;">
                        <select name="filiere_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Toutes les filières</option>
                            @foreach ($filieres as $fl)
                                <option value="{{ $fl->id }}" {{ request('filiere_id') == $fl->id ? 'selected' : '' }}>{{ $fl->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <form action="{{ route('admin.matieres.index') }}" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:260px;">
                        <input type="text" name="recherche" value="{{ request('recherche') }}" class="form-control"
                            placeholder="Rechercher une matière…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default" title="Rechercher">
                                <i class="fas fa-search"></i>
                            </button>
                            @if (request('recherche'))
                                <a href="{{ route('admin.matieres.index') }}" class="btn btn-default" title="Réinitialiser la recherche">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </span>
                    </div>
                </form>
                <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle matière
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NOM</th>
                            <th>CODE</th>
                            <th>FILIÈRE</th>
                            <th>COEFFICIENT</th>
                            <th>VOLUME HORAIRE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matieres as $matiere)
                            <tr>
                                <td>{{ $matiere->nom }}</td>
                                <td><code>{{ $matiere->code ?? '—' }}</code></td>
                                <td>{{ $matiere->filiere->nom ?? '—' }}</td>
                                <td>{{ $matiere->coefficient }}</td>
                                <td>{{ $matiere->volume_horaire ?? '—' }} h</td>
                                <td>
                                    <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.matieres.destroy', $matiere) }}" method="POST" style="display:inline-block;"
                                        class="delete-matiere-form"
                                        data-matiere-nom="{{ $matiere->nom }}">
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
                                <td colspan="6" class="text-center text-muted">Aucune matière trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $matieres->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.delete-matiere-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const nom = form.getAttribute('data-matiere-nom');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer cette matière ?',
                        text: 'La matière « ' + nom + ' » sera définitivement supprimée.',
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
