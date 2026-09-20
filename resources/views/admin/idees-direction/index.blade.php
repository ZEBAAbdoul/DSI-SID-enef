<x-admin title="Toutes les idées">
    <div class="container-fluid py-3">
        <div class="mb-3">
            <h1 class="h3 mb-0">Boîte à idées</h1>
            <small class="text-muted">Toutes les idées du personnel. Ouvrez une idée pour la traiter et répondre à son auteur.</small>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Pastilles de statut --}}
        <div class="mb-3">
            <a href="{{ route('admin.idees-direction.index') }}"
                class="btn btn-sm {{ request('statut') ? 'btn-outline-secondary' : 'btn-secondary' }}">
                Toutes ({{ $compteurs->sum() }})
            </a>
            @foreach (\App\Models\Idee::STATUTS as $cle => $s)
                <a href="{{ route('admin.idees-direction.index', ['statut' => $cle]) }}"
                    class="btn btn-sm {{ request('statut') === $cle ? 'btn-' . $s['badge'] : 'btn-outline-' . $s['badge'] }}">
                    {{ $s['label'] }} ({{ $compteurs[$cle] ?? 0 }})
                </a>
            @endforeach
        </div>

        <form method="GET" class="card card-body mb-3">
            <input type="hidden" name="statut" value="{{ request('statut') }}">
            <div class="form-row align-items-end">
                <div class="form-group col-md-6 mb-md-0">
                    <label for="q" class="mb-1">Recherche</label>
                    <input type="text" id="q" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Titre ou contenu…">
                </div>
                <div class="form-group col-md-3 mb-md-0">
                    <label for="categorie" class="mb-1">Domaine</label>
                    <select id="categorie" name="categorie" class="form-control">
                        <option value="">Tous</option>
                        @foreach (\App\Models\Idee::CATEGORIES as $cle => $libelle)
                            <option value="{{ $cle }}" @selected(request('categorie') === $cle)>{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Filtrer</button>
                    <a href="{{ route('admin.idees-direction.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Idée</th>
                            <th style="width:200px;">Auteur</th>
                            <th style="width:170px;">Domaine</th>
                            <th style="width:120px;">Statut</th>
                            <th style="width:110px;">Reçue le</th>
                            <th style="width:100px;" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($idees as $idee)
                            <tr>
                                <td>
                                    <div style="font-weight:600;">{{ $idee->titre }}</div>
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($idee->description, 90) }}</small>
                                </td>
                                <td>{{ $idee->auteur_nom }}</td>
                                <td><small>{{ $idee->categorie_libelle ?? '—' }}</small></td>
                                <td><span class="badge badge-{{ $idee->statut_badge }}">{{ $idee->statut_libelle }}</span></td>
                                <td><small>{{ $idee->created_at?->format('d/m/Y') }}</small></td>
                                <td class="text-right">
                                    <a href="{{ route('admin.idees-direction.show', $idee) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Ouvrir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Aucune idée trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($idees->hasPages())
                <div class="card-footer">{{ $idees->links('pagination::bootstrap-4') }}</div>
            @endif
        </div>
    </div>
</x-admin>