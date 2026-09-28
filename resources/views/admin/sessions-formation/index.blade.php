<x-admin>
    @section('title', 'Sessions de formation')

    @php
        $peutGerer = ! auth()->user()->hasRole('user');
        $nbColonnes = $peutGerer ? 8 : 7;
    @endphp

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sessions de formation</h3>
            <div class="card-tools">
                <form action="{{ route('admin.sessions-formation.index') }}" method="GET" class="form-inline"
                    style="display:inline-block;margin-right:10px;">
                    <select name="statut" class="form-control form-control-sm" onchange="this.form.submit()"
                        style="width:auto;">
                        <option value="">Tous les statuts</option>
                        <option value="ouverte" @selected(request('statut') === 'ouverte')>Ouverte</option>
                        <option value="complete" @selected(request('statut') === 'complete')>Complète</option>
                        <option value="cloturee" @selected(request('statut') === 'cloturee')>Clôturée</option>
                    </select>
                </form>
                @if ($peutGerer)
                    <a href="{{ route('admin.sessions-formation.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nouvelle session
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>FORMATION</th>
                            <th>LIEU</th>
                            <th>DATE DÉBUT</th>
                            <th>DATE FIN</th>
                            <th>DÉPÔT JUSQU'AU</th>
                            <th>PLACES</th>
                            <th>STATUT</th>
                            @if ($peutGerer)
                                <th>ACTIONS</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $session)
                            @php
                                $limite = $session->date_limite_depot
                                    ? \Carbon\Carbon::parse($session->date_limite_depot)
                                    : null;
                                $depotClos = $limite && $limite->copy()->endOfDay()->isPast();
                            @endphp
                            <tr>
                                <td>{{ $session->formation->titre ?? 'Formation supprimée' }}</td>
                                <td>{{ $session->lieu ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($session->date_debut)->format('d/m/Y') }}</td>
                                <td>{{ $session->date_fin ? \Carbon\Carbon::parse($session->date_fin)->format('d/m/Y') : '—' }}</td>
                                <td>
                                    @if ($limite)
                                        <span class="{{ $depotClos ? 'text-danger' : '' }}">
                                            {{ $limite->format('d/m/Y') }}
                                        </span>
                                        @if ($depotClos)
                                            <small class="d-block text-danger">Dépôt clos</small>
                                        @endif
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $session->places_disponibles }} / {{ $session->places_totales }}</td>
                                <td>
                                    <span class="badge statut-badge-{{ $session->statut }}">
                                        {{ ucfirst($session->statut) }}
                                    </span>
                                </td>
                                @if ($peutGerer)
                                    <td>
                                        <a href="{{ route('admin.sessions-formation.edit', $session) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.sessions-formation.destroy', $session) }}"
                                            method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Supprimer cette session ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $nbColonnes }}" class="text-center text-muted">
                                    Aucune session trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $sessions->links() }}
        </div>
    </div>

    @push('styles')
        <style>
            .statut-badge-ouverte  { background: #d4edda; color: #155724; }
            .statut-badge-complete { background: #fff3cd; color: #856404; }
            .statut-badge-cloturee { background: #f8d7da; color: #721c24; }
        </style>
    @endpush
</x-admin>