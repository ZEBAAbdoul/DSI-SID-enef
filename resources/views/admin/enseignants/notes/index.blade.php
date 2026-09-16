<x-admin title="Mes notes déposées">

    <div class="container-fluid py-4">

        {{-- En-tête --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h4 mb-1">Les notes déposées</h1>
                <p class="text-muted mb-0">
                    Liste des fichiers de notes que vous avez déposés.
                </p>
            </div>

            <a href="{{ route('admin.enseignant.notes.create') }}" class="btn btn-success">
                <i class="fas fa-upload me-1"></i>
                Déposer des notes
            </a>
        </div>

        {{-- Message de succès --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Erreurs --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Barre de filtres --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.enseignant.notes.index') }}" class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Matière</label>
                        <select name="matiere_id" class="form-select form-select-sm">
                            <option value="">Toutes</option>
                            @foreach($matieres ?? [] as $matiere)
                                <option value="{{ $matiere->id }}" @selected(request('matiere_id') == $matiere->id)>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Type d'évaluation</label>
                        <select name="type_evaluation" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            @foreach(['controle' => 'Contrôle', 'examen' => 'Examen', 'tp' => 'TP', 'oral' => 'Oral', 'projet' => 'Projet'] as $value => $label)
                                <option value="{{ $value }}" @selected(request('type_evaluation') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Date d'évaluation</label>
                        <input type="date" name="date_evaluation" value="{{ request('date_evaluation') }}" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-filter me-1"></i>Filtrer
                        </button>
                        @if(request()->hasAny(['matiere_id', 'type_evaluation', 'date_evaluation']))
                            <a href="{{ route('admin.enseignant.notes.index') }}" class="btn btn-sm btn-outline-secondary">
                                Réinitialiser
                            </a>
                        @endif
                    </div>

                </form>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt text-success me-2"></i>
                    <strong>Mes notes</strong>

                    @if($notes instanceof \Illuminate\Contracts\Pagination\Paginator ||
                        $notes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <span class="badge bg-secondary ms-2">{{ $notes->total() }}</span>
                    @endif
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Formation</th>
                                <th>Session</th>
                                <th>Matière</th>
                                <th>Type</th>
                                <th>Date évaluation</th>
                                <th>Fichier</th>
                                <th>Déposé le</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($notes as $note)

                            @php
                                $extension = strtolower(pathinfo($note->nom_original, PATHINFO_EXTENSION));

                                $fileIcon = match(true) {
                                    $extension === 'pdf' => 'fa-file-pdf text-danger',
                                    in_array($extension, ['xlsx', 'xls']) => 'fa-file-excel text-success',
                                    $extension === 'csv' => 'fa-file-csv text-success',
                                    default => 'fa-file text-secondary',
                                };

                                $typeBadge = match($note->type_evaluation) {
                                    'controle' => 'bg-primary',
                                    'examen'   => 'bg-danger',
                                    'tp'       => 'bg-info',
                                    'oral'     => 'bg-warning text-dark',
                                    'projet'   => 'bg-success',
                                    default    => 'bg-secondary',
                                };

                                $tailleKo = $note->taille ? round($note->taille / 1024, 1) : null;
                            @endphp

                            <tr>

                                <td>
                                    {{ $note->formation->nom
                                        ?? $note->formation->titre
                                        ?? '—' }}
                                </td>

<td>
    @if($note->session)
        <div class="small">
            <div>
                <i class="fas fa-calendar-alt text-primary me-1"></i>
                <strong>
                    {{ $note->session->date_debut?->format('d/m/Y') ?? '—' }}
                </strong>
            </div>

            <div class="text-muted">
                <i class="fas fa-arrow-down me-1"></i>
                {{ $note->session->date_fin?->format('d/m/Y') ?? '—' }}
            </div>
        </div>
    @else
        <span class="text-muted">—</span>
    @endif
</td>
                                <td>{{ $note->matiere->nom ?? '—' }}</td>

                                <td>
                                    <span class="badge {{ $typeBadge }} text-capitalize">
                                        {{ $note->type_evaluation ?? '—' }}
                                    </span>
                                </td>

                                <td>{{ $note->date_evaluation?->format('d/m/Y') ?? '—' }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas {{ $fileIcon }} me-2"></i>
                                        <div>
                                            <span class="text-truncate d-block"
                                                  style="max-width: 220px;"
                                                  title="{{ $note->nom_original }}">
                                                {{ $note->nom_original }}
                                            </span>
                                            @if($tailleKo)
                                                <small class="text-muted">{{ $tailleKo }} Ko</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <small class="text-muted">
                                        {{ $note->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('admin.enseignant.notes.telecharger', $note) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Télécharger">
                                        <i class="fas fa-download"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalSuppression{{ $note->id }}"
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                        <h5>Aucun fichier déposé</h5>
                                        <p class="mb-3">Vous n'avez encore déposé aucune note.</p>
                                        <a href="{{ route('admin.enseignant.notes.create') }}" class="btn btn-success">
                                            <i class="fas fa-upload me-1"></i>
                                            Déposer une note
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                        </tbody>

                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if($notes instanceof \Illuminate\Contracts\Pagination\Paginator ||
                $notes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)

                @if($notes->hasPages())
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted">
                                Affichage de <strong>{{ $notes->firstItem() }}</strong>
                                à <strong>{{ $notes->lastItem() }}</strong>
                                sur <strong>{{ $notes->total() }}</strong> résultats
                            </small>
                            <div>
                                {{ $notes->onEachSide(1)->links() }}
                            </div>
                        </div>
                    </div>
                @endif

            @endif

        </div>

    </div>


    {{-- MODALES DE SUPPRESSION --}}
    @foreach($notes as $note)

        <div class="modal fade"
             id="modalSuppression{{ $note->id }}"
             tabindex="-1"
             aria-labelledby="modalSuppressionLabel{{ $note->id }}"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 mb-0" id="modalSuppressionLabel{{ $note->id }}">
                            <i class="fas fa-trash text-danger me-2"></i>
                            Supprimer ce fichier ?
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>

                    <div class="modal-body">
                        <p>Vous êtes sur le point de supprimer le fichier :</p>

                        <div class="alert alert-light border">
                            <strong>{{ $note->nom_original }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ $note->matiere->nom ?? 'Matière inconnue' }}
                                @if($note->type_evaluation)
                                    — {{ $note->type_evaluation }}
                                @endif
                            </small>
                        </div>

                        <p class="text-danger mb-0">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="{{ route('admin.enseignant.notes.destroy', $note) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>
                                Supprimer
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    @endforeach

</x-admin>