<x-admin>
    @section('title', 'Formations')

    <div class="container-fluid">

        {{-- Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- En-tête --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">

                    <h3 class="card-title mb-0">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Liste des formations
                    </h3>

                    @unless(auth()->user()->hasRole('user'))
                        <a href="{{ route('admin.formations.create') }}"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>
                            Nouvelle formation
                        </a>
                    @endunless

                </div>
            </div>

            <div class="card-body">

                {{-- Filtres --}}
                <form method="GET"
                      action="{{ route('admin.formations.index') }}"
                      class="mb-4">

                    <div class="row">

                        {{-- Recherche --}}
                        <div class="col-md-4">
                            <label>Recherche</label>

                            <div class="input-group">
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Titre, résumé, mots-clés..."
                                       value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Type --}}
                        <div class="col-md-2">
                            <label>Type</label>

                            <select name="type" class="form-control">
                                <option value="">Tous</option>

                                <option value="academique"
                                    {{ request('type') == 'academique' ? 'selected' : '' }}>
                                    Académique
                                </option>

                                <option value="continue_programmee"
                                    {{ request('type') == 'continue_programmee' ? 'selected' : '' }}>
                                    Continue Programmée
                                </option>

                                <option value="continue_a_la_carte"
                                    {{ request('type') == 'continue_a_la_carte' ? 'selected' : '' }}>
                                    Continue à la Carte
                                </option>
                            </select>
                        </div>

                        {{-- Filière --}}
                        <div class="col-md-2">
                            <label>Filière</label>

                            <select name="filiere_id" class="form-control">
                                <option value="">Toutes</option>

                                @foreach ($filieres as $filiere)
                                    <option value="{{ $filiere->id }}"
                                        {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                        {{ $filiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Catégorie --}}
                        <div class="col-md-2">
                            <label>Catégorie</label>

                            <select name="categorie_id" class="form-control">
                                <option value="">Toutes</option>

                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}"
                                        {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Statut --}}
                        <div class="col-md-2">
                            <label>Statut</label>

                            <select name="statut" class="form-control">
                                <option value="">Tous</option>

                                <option value="ouverte"
                                    {{ request('statut') == 'ouverte' ? 'selected' : '' }}>
                                    Ouverte
                                </option>

                                <option value="cloturee"
                                    {{ request('statut') == 'cloturee' ? 'selected' : '' }}>
                                    Clôturée
                                </option>

                                <option value="brouillon"
                                    {{ request('statut') == 'brouillon' ? 'selected' : '' }}>
                                    Brouillon
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-filter mr-1"></i>
                            Filtrer
                        </button>

                        <a href="{{ route('admin.formations.index') }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-redo mr-1"></i>
                            Réinitialiser
                        </a>
                    </div>

                </form>

                {{-- Tableau --}}
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="thead-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Formation</th>
                                <th>Type</th>
                                <th>Filière</th>
                                <th>Catégorie</th>
                                <th>Durée</th>
                                <th>Coût</th>
                                <th>Statut</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($formations as $formation)

                                <tr>

                                    <td>
                                        {{ $formations->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $formation->titre }}
                                        </strong>

                                        @if ($formation->resume)
                                            <div class="small text-muted mt-1">
                                                {{ Str::limit($formation->resume, 80) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge badge-info">
                                            {{ $formation->type_libelle }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $formation->filiere->nom ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $formation->categorie->nom ?? '—' }}
                                    </td>

                                    <td>
                                        {{ $formation->duree }}
                                    </td>

                                    <td>
                                        {{ $formation->cout_formate }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $formation->statut_badge }}">
                                            {{ $formation->statut_libelle }}
                                        </span>
                                    </td>

                                    <td>

                                        <div class="btn-group">

                                            {{-- Voir --}}
                                            <a href="{{ route('admin.formations.show', $formation) }}"
                                               class="btn btn-info btn-sm"
                                               title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @unless(auth()->user()->hasRole('user'))

                                                {{-- Modifier --}}
                                                <a href="{{ route('admin.formations.edit', $formation) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                {{-- Supprimer --}}
                                                <form action="{{ route('admin.formations.destroy', $formation) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette formation ?');">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                </form>

                                            @endunless

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="9" class="text-center py-5">

                                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>

                                        <h5>Aucune formation trouvée</h5>

                                        <p class="text-muted">
                                            Aucune formation ne correspond aux critères sélectionnés.
                                        </p>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if ($formations->hasPages())
                    <div class="mt-3">
                        {{ $formations->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>
</x-admin>