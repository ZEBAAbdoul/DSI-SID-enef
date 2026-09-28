<x-admin>
    @section('title', 'Mon espace')

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mes candidatures</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.inscription.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nouvelle candidature
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>FORMATION</th>
                                    <th>SESSION</th>
                                    <th>STATUT</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inscriptions as $inscription)
                                    @php $session = $sessionsCandidat->get($inscription->session_formation_id); @endphp
                                    <tr>
                                        <td>{{ $session?->formation?->titre ?? 'Formation' }}</td>
                                        <td>{{ $session?->date_debut?->format('d/m/Y') ?? '—' }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ ucfirst($inscription->statut ?? 'déposée') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.inscription.show', $inscription->id) }}"
                                               class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Vous n'avez pas encore déposé de candidature.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sessions ouvertes aux candidatures</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.inscription.create') }}" class="btn btn-primary btn-sm">Tout voir</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>FORMATION</th>
                                    <th>PERIODE</th>
                                    <th>DÉPÔT JUSQU'AU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sessionsOuvertes as $s)
                                    <tr>
                                        <td>{{ $s->formation->titre ?? 'Formation' }}</td>
                                        <td> {{ $s->date_debut->format('d/m/Y') }} au {{ $s->date_fin->format('d/m/Y') }}</td>
                                        <td>{{ $s->date_limite_depot?->format('d/m/Y') ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            Aucune session ouverte pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @include('dashboard.partials.informations')
        </div>
    </div>
</x-admin>