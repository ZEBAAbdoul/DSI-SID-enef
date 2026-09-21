<x-admin title="Témoignages">
    <div class="container-fluid py-3">
        <div class="mb-3">
            <h1 class="h3 mb-0">Modération des témoignages</h1>
            <small class="text-muted">Les témoignages sont rédigés par les élèves. Vous pouvez les publier sur la page
                d'accueil, les retirer ou les supprimer.</small>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="card card-body mb-3">
            <div class="form-row align-items-end">
                <div class="form-group col-md-6 mb-md-0">
                    <label for="q" class="mb-1">Recherche</label>
                    <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Auteur, contenu, formation…">
                </div>
                <div class="form-group col-md-3 mb-md-0">
                    <label for="statut" class="mb-1">Statut</label>
                    <select id="statut" name="statut" class="form-control">
                        <option value="">Tous</option>
                        <option value="en_attente" @selected(request('statut') === 'en_attente')>En attente</option>
                        <option value="publie" @selected(request('statut') === 'publie')>Publiés</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Filtrer</button>
                    <a href="{{ route('admin.temoignages.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:220px;">Auteur</th>
                            <th>Témoignage</th>
                            <th style="width:90px;">Note</th>
                            <th style="width:120px;">Statut</th>
                            <th style="width:120px;">Reçu le</th>
                            <th style="width:210px;" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($temoignages as $temoignage)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center" style="gap:10px;">
                                        @if ($temoignage->image_url)
                                            <img src="{{ asset($temoignage->image_url) }}"
                                                alt="{{ $temoignage->auteur }}" class="rounded-circle"
                                                style="width:40px;height:40px;object-fit:cover;">
                                        @else
                                            <span
                                                class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center"
                                                style="width:40px;height:40px;font-weight:700;">
                                                {{ \Illuminate\Support\Str::upper(mb_substr($temoignage->auteur, 0, 1)) }}
                                            </span>
                                        @endif
                                        <div>
                                            <div style="font-weight:600;">{{ $temoignage->auteur }}</div>
                                            <small class="text-muted">{{ $temoignage->fonction }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $temoignage->contenu }}</div>
                                    @if ($temoignage->formation_concernee)
                                        <small class="text-muted">
                                            <i class="fas fa-graduation-cap"></i> {{ $temoignage->formation_concernee }}
                                        </small>
                                    @endif
                                </td>
                                <td class="text-warning" style="white-space:nowrap;">
                                    {{ str_repeat('★', $temoignage->note) }}{{ str_repeat('☆', 5 - $temoignage->note) }}
                                </td>
                                <td>
                                    @if ($temoignage->est_publie)
                                        <span class="badge badge-success">Publié</span>
                                    @else
                                        <span class="badge badge-warning">En attente</span>
                                    @endif
                                </td>
                                <td><small>{{ $temoignage->created_at?->format('d/m/Y') }}</small></td>
                                <td class="text-right" style="white-space:nowrap;">
                                    <form action="{{ route('admin.temoignages.toggle', $temoignage) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if ($temoignage->est_publie)
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-eye-slash"></i> Dépublier
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Publier
                                            </button>
                                        @endif
                                    </form>
                                    <form action="{{ route('admin.temoignages.destroy', $temoignage) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer définitivement ce témoignage ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Aucun témoignage trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($temoignages->hasPages())
                <div class="card-footer">{{ $temoignages->links('pagination::bootstrap-4') }}</div>
            @endif
        </div>
    </div>
</x-admin>