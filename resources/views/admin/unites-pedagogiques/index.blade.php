<x-admin title="Unités pédagogiques et de production">

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0">Unités pédagogiques et de production</h1>
            <a href="{{ route('admin.unites-pedagogiques.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Ajouter une unité
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:64px;">Photo</th>
                            <th style="width:60px;">N°</th>
                            <th style="width:70px;">Ordre</th>
                            <th>Titre</th>
                            <th style="width:130px;">Statut</th>
                            <th style="width:190px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($unites as $unite)
                            <tr>
                                <td>
                                    @if ($unite->photo_url)
                                        <img src="{{ $unite->photo_url }}" alt="{{ $unite->titre }}"
                                            style="width:44px;height:44px;object-fit:cover;border-radius:4px;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light text-muted"
                                            style="width:44px;height:44px;border-radius:4px;font-size:11px;">
                                            —
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $unite->numero }}</td>
                                <td>{{ $unite->ordre }}</td>
                                <td>
                                    {{ $unite->titre }}
                                    @if ($unite->note)
                                        <span class="badge bg-warning text-dark ms-1">{{ $unite->note }}</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST"
                                        action="{{ route('admin.unites-pedagogiques.toggle-publication', $unite) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm {{ $unite->est_publie ? 'btn-success' : 'btn-outline-secondary' }}">
                                            {{ $unite->est_publie ? 'Publiée' : 'Masquée' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.unites-pedagogiques.show', $unite) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Voir le détail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.unites-pedagogiques.edit', $unite) }}"
                                        class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST"
                                        action="{{ route('admin.unites-pedagogiques.destroy', $unite) }}"
                                        class="d-inline" onsubmit="return confirm('Supprimer cette unité ?');">
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
                                <td colspan="6" class="text-center text-muted py-4">
                                    Aucune unité pédagogique enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-admin>