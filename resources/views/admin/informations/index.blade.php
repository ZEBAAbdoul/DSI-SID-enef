<x-admin>
    @section('title', 'Informations')

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informations</h3>
            <div class="card-tools">
                <a href="{{ route('admin.informations.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle information
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>TITRE</th>
                            <th>DESTINATAIRES</th>
                            <th>FICHIER</th>
                            <th>STATUT</th>
                            <th>PUBLIÉE LE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($informations as $information)
                            <tr>
                                <td>{{ $information->titre }}</td>
                                <td>{{ \App\Models\Information::CIBLES[$information->cible] ?? $information->cible }}</td>
                                <td>
                                    @if ($information->fichier_path)
                                        <a href="{{ route('admin.informations.fichier', $information) }}">
                                            <i class="fas fa-file-pdf text-danger"></i> {{ $information->fichier_nom }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $information->est_publie ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $information->est_publie ? 'Publiée' : 'Brouillon' }}
                                    </span>
                                </td>
                                <td>{{ $information->publie_le?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.informations.edit', $information) }}"
                                        class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.informations.destroy', $information) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('Supprimer cette information ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucune information.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $informations->links() }}</div>
    </div>
</x-admin>