<x-admin title="Documents">

    <div class="container-fluid py-4">

        {{-- ============================================================
             EN-TÊTE
        ============================================================ --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Documents</h1>
                <p class="text-muted mb-0">
                    {{ $documents->total() }}
                    {{ Str::plural('document', $documents->total()) }}
                    au total.
                </p>
            </div>

            <a href="{{ route('admin.documents.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouveau document
            </a>
        </div>

        {{-- ============================================================
             MESSAGES
        ============================================================ --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-triangle-exclamation me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ============================================================
             FILTRES
        ============================================================ --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('admin.documents.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-lg-4 col-md-6">
                            <label for="categorie_id" class="form-label small text-muted mb-1">
                                Catégorie
                            </label>
                            <select id="categorie_id" name="categorie_id" class="form-select">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}"
                                            @selected(request('categorie_id') == $categorie->id)>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label for="type" class="form-label small text-muted mb-1">
                                Type
                            </label>
                            <select id="type" name="type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="rapport" @selected(request('type') === 'rapport')>Rapport</option>
                                <option value="brochure" @selected(request('type') === 'brochure')>Brochure</option>
                                <option value="texte_reglementaire" @selected(request('type') === 'texte_reglementaire')>Texte réglementaire</option>
                                <option value="support_pedagogique" @selected(request('type') === 'support_pedagogique')>Support pédagogique</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label for="acces" class="form-label small text-muted mb-1">
                                Accès
                            </label>
                            <select id="acces" name="acces" class="form-select">
                                <option value="">Tous les accès</option>
                                <option value="public" @selected(request('acces') === 'public')>Public</option>
                                <option value="restreint" @selected(request('acces') === 'restreint')>Restreint</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            @if(request()->hasAny(['categorie_id', 'type', 'acces']))
                                <a href="{{ route('admin.documents.index') }}"
                                   class="btn btn-outline-secondary"
                                   title="Réinitialiser les filtres">
                                    <i class="fas fa-rotate-left"></i>
                                </a>
                            @endif
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- ============================================================
             TABLEAU
        ============================================================ --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th style="width:150px;">Catégorie</th>
                                <th style="width:150px;">Type</th>
                                <th style="width:110px;">Accès</th>
                                <th style="width:90px;">Version</th>
                                <th style="width:100px;">Taille</th>
                                <th style="width:80px;" class="text-center">Téléch.</th>
                                <th style="width:120px;">Publié le</th>
                                <th style="width:160px;">Publié par</th>
                                <th style="width:180px;" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($documents as $document)
                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        {{ Str::limit($document->titre, 60) }}
                                    </div>
                                    @if($document->description)
                                        <small class="text-muted">
                                            {{ Str::limit($document->description, 70) }}
                                        </small>
                                    @endif
                                </td>

                                <td>{{ $document->categorie?->nom ?? '—' }}</td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ str_replace('_', ' ', $document->type) }}
                                    </span>
                                </td>

                                <td>
                                    @if($document->acces === 'public')
                                        <span class="badge bg-success">Public</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Restreint</span>
                                    @endif
                                </td>

                                <td class="text-muted">{{ $document->version ?? '—' }}</td>

                                <td class="text-muted">
                                    @if($document->taille_fichier_ko)
                                        {{ number_format($document->taille_fichier_ko / 1024, 2) }} Mo
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="text-center text-muted">
                                    {{ $document->nombre_telechargements }}
                                </td>

                                <td>
                                    <span title="{{ $document->publie_le?->format('d/m/Y H:i') }}">
                                        {{ $document->publie_le?->format('d/m/Y') ?? '—' }}
                                    </span>
                                </td>

                                <td>{{ $document->publiePar?->name ?? '—' }}</td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        {{-- Voir --}}
                                        <a href="{{ route('admin.documents.show', $document) }}"
                                           class="btn btn-sm btn-outline-secondary"
                                           aria-label="Voir"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Modifier --}}
                                        <a href="{{ route('admin.documents.edit', $document) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           aria-label="Modifier"
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        {{-- Supprimer --}}
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression{{ $document->id }}"
                                                aria-label="Supprimer"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-file-lines fa-2x text-muted mb-3 d-block"></i>

                                    @if(request()->hasAny(['categorie_id', 'type', 'acces']))
                                        <p class="text-muted mb-3">
                                            Aucun document ne correspond à ces critères.
                                        </p>
                                        <a href="{{ route('admin.documents.index') }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            Réinitialiser les filtres
                                        </a>
                                    @else
                                        <p class="text-muted mb-3">
                                            Aucun document enregistré pour le moment.
                                        </p>
                                        <a href="{{ route('admin.documents.create') }}"
                                           class="btn btn-sm btn-success">
                                            Créer le premier document
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

            @if($documents->hasPages())
                <div class="card-footer bg-white">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ============================================================
         MODALS DE CONFIRMATION — SUPPRESSION
         (une par document, générées côté serveur)
    ============================================================ --}}
    @foreach($documents as $document)
        <div class="modal fade" id="modalSuppression{{ $document->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 mb-0">
                            <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                            Confirmer la suppression
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-0">
                            Voulez-vous vraiment supprimer le document
                            « <strong>{{ $document->titre }}</strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="{{ route('admin.documents.destroy', $document) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>
                                Supprimer définitivement
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

</x-admin>