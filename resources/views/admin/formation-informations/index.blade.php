<x-admin>
    <x-slot name="title">Informations complémentaires</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Informations complémentaires</h1>
        <a href="{{ route('admin.formation-informations.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Ajouter une information
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse ($categories as $key => $label)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $label }}</strong>
            </div>
            <div class="card-body p-0">
                @if (($informations[$key] ?? collect())->isEmpty())
                    <p class="text-muted p-3 mb-0">Aucune information dans cette catégorie.</p>
                @else
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Ordre</th>
                                <th>Libellé</th>
                                <th>Valeur</th>
                                <th style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($informations[$key] as $information)
                                <tr>
                                    <td>{{ $information->ordre }}</td>
                                    <td>{{ $information->libelle }}</td>
                                    <td>{{ $information->valeur ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('admin.formation-informations.edit', $information) }}"
                                           class="btn btn-sm btn-outline-secondary">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.formation-informations.destroy', $information) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Supprimer cette information ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Aucune catégorie configurée.</p>
    @endforelse
</x-admin>