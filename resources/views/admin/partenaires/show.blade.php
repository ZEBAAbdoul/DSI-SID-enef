{{-- resources/views/admin/partenaires/show.blade.php --}}
<x-admin>
    @section('title', 'Détails du partenaire')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $partenaire->nom }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.partenaires.edit', $partenaire) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.partenaires.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($partenaire->logo_url)
                        <img src="{{ asset($partenaire->logo_url) }}" alt="{{ $partenaire->nom }}"
                            class="img-fluid border rounded p-2" style="max-height:140px; background:#fff;">
                    @else
                        <div class="text-muted"><i class="fas fa-image fa-3x"></i><p>Aucun logo</p></div>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width:200px;">Nom</th>
                                <td>{{ $partenaire->nom }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ ucfirst($partenaire->type) }}</td>
                            </tr>
                            <tr>
                                <th>Site web</th>
                                <td>
                                    @if ($partenaire->site_web)
                                        <a href="{{ $partenaire->site_web }}" target="_blank" rel="noopener">
                                            {{ $partenaire->site_web }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ordre d'affichage</th>
                                <td>{{ $partenaire->ordre_affichage }}</td>
                            </tr>
                            <tr>
                                <th>Statut</th>
                                <td>
                                    <span class="badge {{ $partenaire->actif ? 'badge-primary' : 'badge-danger' }}">
                                        {{ $partenaire->actif ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>
                                    @if ($partenaire->description)
                                        {{ $partenaire->description }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin>