<x-admin title="Enseignants">

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Enseignants</h1>
                <p class="text-muted mb-0">
                    {{ $enseignants->total() }}
                    enseignant{{ $enseignants->total() > 1 ? 's' : '' }} au total.
                </p>
            </div>

            <a href="{{ route('admin.enseignants.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouvel enseignant
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.enseignants.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Recherche</label>
                            <input type="search" name="search" class="form-control"
                                   placeholder="Nom, prénom, matricule, spécialité..."
                                   value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="actif" @selected(request('statut') === 'actif')>Actif</option>
                                <option value="inactif" @selected(request('statut') === 'inactif')>Inactif</option>
                                <option value="suspendu" @selected(request('statut') === 'suspendu')>Suspendu</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            @if(request()->hasAny(['search', 'statut']))
                                <a href="{{ route('admin.enseignants.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom complet</th>
                                <th>Spécialité</th>
                                <th>Téléphone</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($enseignants as $enseignant)
                            <tr>
                                <td class="font-monospace small">{{ $enseignant->matricule }}</td>
                                <td class="fw-semibold">{{ $enseignant->nom_complet }}</td>
                                <td>{{ $enseignant->specialite ?? '—' }}</td>
                                <td>{{ $enseignant->telephone ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $enseignant->statut_badge }}">
                                        {{ $enseignant->statut_libelle }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('admin.enseignants.edit', $enseignant) }}"
                                           class="btn btn-sm btn-outline-primary" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression{{ $enseignant->id }}"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Aucun enseignant trouvé.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($enseignants->hasPages())
                <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="text-muted small">
                        Affichage de <strong>{{ $enseignants->firstItem() }}</strong>
                        à <strong>{{ $enseignants->lastItem() }}</strong>
                        sur <strong>{{ $enseignants->total() }}</strong> résultats
                    </div>
                    <div>{{ $enseignants->onEachSide(1)->links() }}</div>
                </div>
            @endif
        </div>

    </div>

    @foreach($enseignants as $enseignant)
        <div class="modal fade" id="modalSuppression{{ $enseignant->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title h5 mb-0">
                            <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                            Confirmer la suppression
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Supprimer l'enseignant « <strong>{{ $enseignant->nom_complet }}</strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            Son compte utilisateur et ses informations personnelles seront également supprimés.
                            Cette action est irréversible.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form method="POST" action="{{ route('admin.enseignants.destroy', $enseignant) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</x-admin>