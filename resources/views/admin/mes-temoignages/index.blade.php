<x-admin title="Mes témoignages">
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">Mes témoignages</h1>
                <small class="text-muted">Partagez votre expérience à l'ENEF. Après validation par l'administration, votre témoignage apparaît sur la page d'accueil.</small>
            </div>
            <a href="{{ route('admin.mes-temoignages.create') }}" class="btn btn-success">
                <i class="fas fa-pen"></i> Écrire un témoignage
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($temoignages as $temoignage)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:10px;">
                        <div>
                            <span class="text-warning">
                                {{ str_repeat('★', $temoignage->note) }}{{ str_repeat('☆', 5 - $temoignage->note) }}
                            </span>
                            @if ($temoignage->est_publie)
                                <span class="badge badge-success ml-2">Publié sur le site</span>
                            @else
                                <span class="badge badge-warning ml-2">En attente de validation</span>
                            @endif
                        </div>
                        <small class="text-muted">{{ $temoignage->created_at?->format('d/m/Y') }}</small>
                    </div>

                    <p class="mt-2 mb-2">« {{ $temoignage->contenu }} »</p>

                    <small class="text-muted d-block mb-3">
                        {{ $temoignage->auteur }}
                        @if ($temoignage->fonction) — {{ $temoignage->fonction }} @endif
                        @if ($temoignage->formation_concernee) · {{ $temoignage->formation_concernee }} @endif
                    </small>

                    <a href="{{ route('admin.mes-temoignages.edit', $temoignage) }}"
                        class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-pen"></i> Modifier
                    </a>
                    <form action="{{ route('admin.mes-temoignages.destroy', $temoignage) }}" method="POST"
                        class="d-inline" onsubmit="return confirm('Supprimer ce témoignage ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    Vous n'avez pas encore écrit de témoignage.
                </div>
            </div>
        @endforelse

        @if ($temoignages->hasPages())
            {{ $temoignages->links('pagination::bootstrap-4') }}
        @endif
    </div>
</x-admin>