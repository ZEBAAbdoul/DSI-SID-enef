<x-admin title="{{ $document->titre }}">

    <div class="container-fluid py-4">

        {{-- ============================================================
             EN-TÊTE
        ============================================================ --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">{{ $document->titre }}</h1>
                <span class="badge bg-secondary">{{ $typeOptions[$document->type] ?? $document->type }}</span>
                @if ($document->acces === 'public')
                    <span class="badge bg-success">Public</span>
                @else
                    <span class="badge bg-warning text-dark">Restreint</span>
                @endif
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.documents.edit', $document) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-pen me-1"></i> Modifier
                </a>
                <button type="button"
                        class="btn btn-sm btn-outline-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modalSuppression{{ $document->id }}">
                    <i class="fas fa-trash me-1"></i> Supprimer
                </button>
                <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
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

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Catégorie</dt>
                            <dd class="col-sm-9">{{ $document->categorie?->nom ?? '—' }}</dd>

                            <dt class="col-sm-3">Description</dt>
                            <dd class="col-sm-9">{{ $document->description ?: '—' }}</dd>

                            <dt class="col-sm-3">Version</dt>
                            <dd class="col-sm-9">{{ $document->version ?: '—' }}</dd>

                            <dt class="col-sm-3">Fichier</dt>
                            <dd class="col-sm-9">
                                @if ($document->fichier_url)
                                    <a href="{{ route('admin.documents.telecharger', $document) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-download me-1"></i>
                                        {{ basename($document->fichier_url) }}
                                    </a>
                                    <span class="text-muted small ms-2">
                                        {{ $document->format_fichier ? strtoupper($document->format_fichier) : '' }}
                                        @if($document->taille_fichier_ko)
                                            , {{ number_format($document->taille_fichier_ko / 1024, 2) }} Mo
                                        @endif
                                    </span>
                                @else
                                    —
                                @endif
                            </dd>

                            <dt class="col-sm-3">Publié le</dt>
                            <dd class="col-sm-9">{{ $document->publie_le?->format('d/m/Y') ?? '—' }}</dd>

                            <dt class="col-sm-3">Publié par</dt>
                            <dd class="col-sm-9">{{ $document->publiePar?->name ?? '—' }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-download fa-lg text-muted mb-2 d-block"></i>
                        <div class="display-6 fw-bold">{{ $document->nombre_telechargements }}</div>
                        <div class="text-muted">téléchargement(s)</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
         MODAL DE CONFIRMATION — SUPPRESSION
    ============================================================ --}}
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

</x-admin>