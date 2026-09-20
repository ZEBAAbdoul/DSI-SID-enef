<x-admin title="Mes idées">
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">Mes idées</h1>
                <small class="text-muted">Vous ne voyez ici que vos propres idées. La direction les examine et vous répond.</small>
            </div>
            <a href="{{ route('admin.idees.create') }}" class="btn btn-success">
                <i class="fas fa-lightbulb"></i> Proposer une idée
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($idees as $idee)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:10px;">
                        <div>
                            <h5 class="mb-1">{{ $idee->titre }}</h5>
                            <span class="badge badge-{{ $idee->statut_badge }}">{{ $idee->statut_libelle }}</span>
                            @if ($idee->categorie_libelle)
                                <span class="badge badge-light border ml-1">{{ $idee->categorie_libelle }}</span>
                            @endif
                        </div>
                        <small class="text-muted">{{ $idee->created_at?->format('d/m/Y') }}</small>
                    </div>

                    <p class="mt-3 mb-3" style="white-space:pre-line;">{{ $idee->description }}</p>

                    @if ($idee->reponse)
                        <div class="border-left pl-3 mb-3" style="border-width:3px !important;">
                            <small class="text-muted d-block">
                                <i class="fas fa-reply"></i> Réponse de la direction
                                @if ($idee->traitee_le) · {{ $idee->traitee_le->format('d/m/Y') }} @endif
                            </small>
                            <div style="white-space:pre-line;">{{ $idee->reponse }}</div>
                        </div>
                    @endif

                    @can('update', $idee)
                        <a href="{{ route('admin.idees.edit', $idee) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pen"></i> Modifier
                        </a>
                        <form action="{{ route('admin.idees.destroy', $idee) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Supprimer cette idée ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @else
                        <small class="text-muted"><i class="fas fa-lock"></i> Cette idée a été examinée, elle n'est plus modifiable.</small>
                    @endcan
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    Vous n'avez pas encore proposé d'idée.
                </div>
            </div>
        @endforelse

        @if ($idees->hasPages())
            {{ $idees->links('pagination::bootstrap-4') }}
        @endif
    </div>
</x-admin>