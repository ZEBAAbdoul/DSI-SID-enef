<x-admin title="Gestion des recherches &amp; innovations">

    <div class="container-fluid py-4">

        {{-- ============================================================
             EN-TÊTE
        ============================================================ --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Gestion des recherches &amp; innovations</h1>
                <p class="text-muted mb-0">
                    {{ $recherchesInnovations->total() }}
                    {{ Str::plural('élément', $recherchesInnovations->total()) }}
                    au total.
                </p>
            </div>

            <a href="{{ route('admin.recherches-innovations.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouvelle recherche / innovation
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

                <form method="GET" action="{{ route('admin.recherches-innovations.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-lg-4 col-md-6">
                            <label for="search" class="form-label small text-muted mb-1">
                                Recherche
                            </label>
                            <input type="search"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="Titre, chapô ou contenu..."
                                   value="{{ request('search') }}">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label for="type" class="form-label small text-muted mb-1">
                                Type
                            </label>
                            <select id="type" name="type" class="form-select">
                                <option value="">Tous les types</option>
                                @foreach($types as $valeur => $libelle)
                                    <option value="{{ $valeur }}"
                                            @selected(request('type') === $valeur)>
                                        {{ $libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label for="statut" class="form-label small text-muted mb-1">
                                Statut
                            </label>
                            <select id="statut" name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="publiee" @selected(request('statut') === 'publiee')>
                                    Publiées
                                </option>
                                <option value="brouillon" @selected(request('statut') === 'brouillon')>
                                    Brouillons
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            @if(request()->hasAny(['search', 'type', 'statut']))
                                <a href="{{ route('admin.recherches-innovations.index') }}"
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
                                <th style="width:90px;">Photo</th>
                                <th>Titre</th>
                                <th style="width:110px;">Type</th>
                                <th style="width:110px;" class="text-center">Médias</th>
                                <th style="width:110px;">Statut</th>
                                <th style="width:120px;">Créé le</th>
                                <th style="width:160px;" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($recherchesInnovations as $rechercheInnovation)
                            <tr class="{{ $rechercheInnovation->is_publiee ? '' : 'table-warning-subtle' }}">

                                <td>
                                    @if ($rechercheInnovation->photos)
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $rechercheInnovation->image }}"
                                                 width="70"
                                                 height="50"
                                                 class="rounded"
                                                 style="object-fit:cover;"
                                                 loading="lazy"
                                                 alt="Visuel de « {{ $rechercheInnovation->titre }} »">
                                            @if (count($rechercheInnovation->photos) > 1)
                                                <span class="badge bg-dark position-absolute"
                                                      style="top:-6px; right:-6px;"
                                                      title="{{ count($rechercheInnovation->photos) }} photos">
                                                    ×{{ count($rechercheInnovation->photos) }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded bg-light text-muted"
                                             style="width:70px; height:50px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ Str::limit($rechercheInnovation->titre, 55) }}
                                    </div>
                                    <small class="text-muted font-monospace">
                                        /{{ $rechercheInnovation->slug }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge {{ $rechercheInnovation->type_badge }}">
                                        {{ $rechercheInnovation->type_libelle }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="text-success" title="Vidéo">
                                        @if ($rechercheInnovation->url_video)
                                            <i class="fas fa-video me-1"></i>
                                        @else
                                            <i class="fas fa-video text-muted opacity-25"></i>
                                        @endif
                                    </span>
                                    <span title="Document joint">
                                        @if ($rechercheInnovation->document)
                                            <i class="fas fa-file-pdf text-danger ms-1"></i>
                                        @else
                                            <i class="fas fa-file-pdf text-muted opacity-25 ms-1"></i>
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    <span class="badge {{ $rechercheInnovation->statut_badge }}">
                                        {{ $rechercheInnovation->statut_libelle }}
                                    </span>
                                </td>

                                <td>
                                    <span title="{{ $rechercheInnovation->created_at?->format('d/m/Y H:i') }}">
                                        {{ $rechercheInnovation->created_at?->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        {{-- Voir sur le site --}}
                                        @if($rechercheInnovation->is_publiee)
                                            <a href="{{ route('recherches-innovations.show', $rechercheInnovation->slug) }}"
                                               target="_blank"
                                               rel="noopener"
                                               class="btn btn-sm btn-outline-secondary"
                                               aria-label="Voir en ligne"
                                               title="Voir en ligne">
                                                <i class="fas fa-up-right-from-square"></i>
                                            </a>
                                        @endif

                                        {{-- Publier / Dépublier --}}
                                        <form method="POST"
                                              action="{{ $rechercheInnovation->is_publiee
                                                    ? route('admin.recherches-innovations.depublier', $rechercheInnovation)
                                                    : route('admin.recherches-innovations.publier', $rechercheInnovation) }}"
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="btn btn-sm {{ $rechercheInnovation->is_publiee
                                                        ? 'btn-outline-warning'
                                                        : 'btn-outline-success' }}"
                                                    aria-label="{{ $rechercheInnovation->is_publiee ? 'Dépublier' : 'Publier' }}"
                                                    title="{{ $rechercheInnovation->is_publiee ? 'Dépublier' : 'Publier' }}">
                                                <i class="fas {{ $rechercheInnovation->is_publiee
                                                    ? 'fa-eye-slash'
                                                    : 'fa-eye' }}"></i>
                                            </button>
                                        </form>

                                        {{-- Modifier --}}
                                        <a href="{{ route('admin.recherches-innovations.edit', $rechercheInnovation) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           aria-label="Modifier"
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        {{-- Supprimer --}}
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression{{ $rechercheInnovation->id }}"
                                                aria-label="Supprimer"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-flask fa-2x text-muted mb-3 d-block"></i>

                                    @if(request()->hasAny(['search', 'type', 'statut']))
                                        <p class="text-muted mb-3">
                                            Aucune recherche ou innovation ne correspond à ces critères.
                                        </p>
                                        <a href="{{ route('admin.recherches-innovations.index') }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            Réinitialiser les filtres
                                        </a>
                                    @else
                                        <p class="text-muted mb-3">
                                            Aucune recherche ou innovation enregistrée pour le moment.
                                        </p>
                                        <a href="{{ route('admin.recherches-innovations.create') }}"
                                           class="btn btn-sm btn-success">
                                            Créer la première entrée
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

            @if($recherchesInnovations->hasPages())
                <div class="card-footer bg-white">
                    {{ $recherchesInnovations->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ============================================================
         MODALS DE CONFIRMATION — SUPPRESSION
    ============================================================ --}}
    @foreach($recherchesInnovations as $rechercheInnovation)
        <div class="modal fade" id="modalSuppression{{ $rechercheInnovation->id }}" tabindex="-1" aria-hidden="true">
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
                            Voulez-vous vraiment supprimer
                            « <strong>{{ $rechercheInnovation->titre }}</strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            La photo et le document joint seront également supprimés. Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="{{ route('admin.recherches-innovations.destroy', $rechercheInnovation) }}">
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