<x-admin :title="'Détail — ' . $unite->titre">

    <div class="container-fluid py-4">

        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.unites-pedagogiques.index') }}">Unités pédagogiques</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $unite->titre }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h4 mb-1">
                    {{ $unite->titre }}
                    @if ($unite->note)
                        <span class="badge bg-warning text-dark align-middle">{{ $unite->note }}</span>
                    @endif
                </h1>
                <div class="text-muted small">
                    N°{{ $unite->numero }} &middot; Ordre {{ $unite->ordre }}
                    &middot;
                    <span class="badge {{ $unite->est_publie ? 'bg-success' : 'bg-secondary' }}">
                        {{ $unite->est_publie ? 'Publiée' : 'Masquée' }}
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                {{-- @if ($unite->est_publie)
                    <a href="{{ route('admin.unites-pedagogiques.index') }}#unite-{{ $unite->slug }}"
                        target="_blank" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-up-right-from-square me-1"></i> Voir côté public
                    </a>
                @endif --}}
                <a href="{{ route('admin.unites-pedagogiques.edit', $unite) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i> Modifier
                </a>
                <a href="{{ route('admin.unites-pedagogiques.index') }}" class="btn btn-outline-secondary btn-sm">
                    &larr; Retour à la liste
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    @if ($unite->photo_url)
                        <a href="{{ $unite->photo_url }}" target="_blank">
                            <img src="{{ $unite->photo_url }}" alt="{{ $unite->titre }}" class="card-img-top"
                                style="height:240px;object-fit:cover;">
                        </a>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted"
                            style="height:240px;">
                            <div class="text-center">
                                <i class="fas fa-image fa-2x mb-2 d-block"></i>
                                Aucune photo
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted small mb-2">Résumé</h6>
                        <p class="mb-0">{{ $unite->concept }}</p>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted small mb-3">Informations</h6>
                        <dl class="row mb-0 small">
                            <dt class="col-5 text-muted fw-normal">Numéro</dt>
                            <dd class="col-7 mb-2">{{ $unite->numero }}</dd>

                            <dt class="col-5 text-muted fw-normal">Ordre d'affichage</dt>
                            <dd class="col-7 mb-2">{{ $unite->ordre }}</dd>

                            <dt class="col-5 text-muted fw-normal">Slug</dt>
                            <dd class="col-7 mb-2"><code>{{ $unite->slug }}</code></dd>

                            <dt class="col-5 text-muted fw-normal">Sous-unités</dt>
                            <dd class="col-7 mb-2">{{ count($unite->sous_unites ?? []) }}</dd>

                            @if ($unite->updated_at)
                                <dt class="col-5 text-muted fw-normal">Mise à jour</dt>
                                <dd class="col-7 mb-0">{{ $unite->updated_at->format('d/m/Y à H:i') }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted small mb-2">Objectif général</h6>
                        <p class="mb-0">{{ $unite->objectif_general }}</p>
                    </div>
                </div>

                @if (!empty($unite->objectifs_specifiques))
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted small mb-2">
                                Objectifs spécifiques
                                <span class="badge bg-light text-dark border ms-1">{{ count($unite->objectifs_specifiques) }}</span>
                            </h6>
                            <ul class="mb-0">
                                @foreach ($unite->objectifs_specifiques as $obj)
                                    <li>{{ $obj }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (!empty($unite->sous_unites))
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <h6 class="text-uppercase text-muted small p-3 pb-0 mb-0">
                                Sous-unités
                                <span class="badge bg-light text-dark border ms-1">{{ count($unite->sous_unites) }}</span>
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 mt-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sous-unité</th>
                                            <th>État</th>
                                            <th>Applications / thématiques</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unite->sous_unites as $su)
                                            <tr>
                                                <td>{{ $su['nom'] }}</td>
                                                <td>{{ $su['etat'] ?? '—' }}</td>
                                                <td>{{ $su['apps'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-muted small fst-italic">Aucune sous-unité renseignée.</div>
                @endif

            </div>
        </div>

    </div>

</x-admin>