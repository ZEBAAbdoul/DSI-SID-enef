{{-- resources/views/admin/filieres/index.blade.php --}}
<x-admin>
    @section('title', 'Filières')

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session('erreur_filiere'))
        <div class="alert alert-danger">{{ session('erreur_filiere') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des filières</h3>
            <div class="card-tools">
                <form action="{{ route('admin.filieres.index') }}" method="GET" class="form-inline"
                    style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:260px;">
                        <input type="text" name="recherche" value="{{ request('recherche') }}" class="form-control"
                            placeholder="Rechercher une filière…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="{{ route('admin.filieres.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle filière
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
                            <th>RESPONSABLE</th>
                            <th>OPTIONS</th>
                            <th>ÉTAT</th>
                            <th>FORMATIONS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filieres as $filiere)
                            <tr>
                                <td>{{ $filiere->nom_formate }}</td>
                                <td><code>{{ $filiere->code ?? '—' }}</code></td>
                                <td>{{ $filiere->responsable ?? '—' }}</td>
                                <td>
                                    @if ($filiere->description)
                                        <ul class="list-unstyled mb-0 small">
                                            @foreach (explode("\n", $filiere->description) as $ligne)
                                                @php($ligne = trim($ligne, "• \t"))
                                                @if ($ligne !== '')
                                                    <li>• {{ $ligne }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if ($filiere->est_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $filiere->formations_count }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.filieres.edit', $filiere) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.filieres.destroy', $filiere) }}" method="POST"
                                        style="display:inline-block;" class="delete-filiere-form"
                                        data-filiere-nom="{{ $filiere->nom }}">
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
                                <td colspan="6" class="text-center text-muted">Aucune filière trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $filieres->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form.delete-filiere-form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const filiere = form.getAttribute('data-filiere-nom');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer cette filière ?',
                        text: 'La filière « ' + filiere +
                            ' » sera définitivement supprimée.',
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
