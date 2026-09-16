<x-admin title="Gestion des actualités">

    <div class="container-fluid py-4">

        {{-- ============================================================
             EN-TÊTE
        ============================================================ --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Gestion des actualités</h1>
                <p class="text-muted mb-0">
                    {{ $actualites->total() }}
                    {{ Str::plural('actualité', $actualites->total()) }}
                    au total.
                </p>
            </div>

            <a href="{{ route('admin.actualites.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouvelle actualité
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

                <form method="GET" action="{{ route('admin.actualites.index') }}">
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

                        <div class="col-lg-3 col-md-6">
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

                        <div class="col-lg-2 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            @if(request()->hasAny(['search', 'type', 'statut']))
                                <a href="{{ route('admin.actualites.index') }}"
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
                                <th style="width:90px;">Image</th>
                                <th>Titre</th>
                                <th style="width:150px;">Type</th>
                                <th style="width:80px;" class="text-center">Ordre</th>
                                <th style="width:120px;">Statut</th>
                                <th style="width:120px;">Date</th>
                                <th style="width:180px;" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($actualites as $actualite)
                            <tr class="{{ $actualite->is_publiee ? '' : 'table-warning-subtle' }}">

                                <td>
                                    <img src="{{ $actualite->image }}"
                                         width="70"
                                         height="50"
                                         class="rounded"
                                         style="object-fit:cover;"
                                         loading="lazy"
                                         alt="Visuel de « {{ $actualite->titre }} »">
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ Str::limit($actualite->titre, 60) }}
                                    </div>
                                    <small class="text-muted font-monospace">
                                        /{{ $actualite->slug }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge {{ $actualite->type_badge }}">
                                        {{ $actualite->type_libelle }}
                                    </span>
                                </td>

                                <td class="text-center text-muted">
                                    {{ $actualite->ordre_menu }}
                                </td>

                                <td>
                                    <span class="badge {{ $actualite->statut_badge }}">
                                        {{ $actualite->statut_libelle }}
                                    </span>
                                </td>

                                <td>
                                    <span title="{{ $actualite->created_at->format('d/m/Y H:i') }}">
                                        {{ $actualite->created_at->format('d/m/Y') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        {{-- Voir en ligne --}}
                                        @if($actualite->is_publiee)
                                            <a href="{{ route('actualites.show', $actualite->slug) }}"
                                               target="_blank"
                                               rel="noopener"
                                               class="btn btn-sm btn-outline-secondary"
                                               aria-label="Voir en ligne"
                                               title="Voir en ligne">
                                                <i class="fas fa-up-right-from-square"></i>
                                            </a>
                                        @endif

                                        {{-- Modifier --}}
                                        <a href="{{ route('admin.actualites.edit', $actualite) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           aria-label="Modifier"
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        {{-- Publier / Dépublier --}}
                                        <form method="POST"
                                              action="{{ $actualite->is_publiee
                                                    ? route('admin.actualites.depublier', $actualite)
                                                    : route('admin.actualites.publier', $actualite) }}"
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="btn btn-sm {{ $actualite->is_publiee
                                                        ? 'btn-outline-warning'
                                                        : 'btn-outline-success' }}"
                                                    aria-label="{{ $actualite->is_publiee ? 'Dépublier' : 'Publier' }}"
                                                    title="{{ $actualite->is_publiee ? 'Dépublier' : 'Publier' }}">
                                                <i class="fas {{ $actualite->is_publiee
                                                    ? 'fa-eye-slash'
                                                    : 'fa-eye' }}"></i>
                                            </button>
                                        </form>

                                        {{-- Supprimer --}}
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression{{ $actualite->id }}"
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
                                    <i class="fas fa-newspaper fa-2x text-muted mb-3 d-block"></i>

                                    @if(request()->hasAny(['search', 'type', 'statut']))
                                        <p class="text-muted mb-3">
                                            Aucune actualité ne correspond à ces critères.
                                        </p>
                                        <a href="{{ route('admin.actualites.index') }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            Réinitialiser les filtres
                                        </a>
                                    @else
                                        <p class="text-muted mb-3">
                                            Aucune actualité enregistrée pour le moment.
                                        </p>
                                        <a href="{{ route('admin.actualites.create') }}"
                                           class="btn btn-sm btn-success">
                                            Créer la première actualité
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

            @if($actualites->hasPages())
                <div class="card-footer bg-white">
                    {{ $actualites->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ============================================================
         MODALS DE CONFIRMATION — SUPPRESSION
         (une par actualité, générées côté serveur)
    ============================================================ --}}
    @foreach($actualites as $actualite)
        <div class="modal fade" id="modalSuppression{{ $actualite->id }}" tabindex="-1" aria-hidden="true">
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
                            Voulez-vous vraiment supprimer l'actualité
                            « <strong>{{ $actualite->titre }}</strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="{{ route('admin.actualites.destroy', $actualite) }}">
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