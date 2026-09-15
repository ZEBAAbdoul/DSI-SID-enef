{{-- resources/views/admin/inscriptions/index.blade.php --}}
<x-admin>
    @section('title', 'Candidatures')

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des candidatures</h3>
            <div class="card-tools">
                <form action="{{ route('admin.inscriptions.index') }}" method="GET" class="form-inline">
                    <select name="statut" class="form-control form-control-sm" onchange="this.form.submit()" style="width:auto;">
                        <option value="">Tous les statuts</option>
                        <option value="depose" @selected(request('statut') === 'depose')>Déposé</option>
                        <option value="en_cours" @selected(request('statut') === 'en_cours')>En cours</option>
                        <option value="incomplet" @selected(request('statut') === 'incomplet')>Incomplet</option>
                        <option value="valide" @selected(request('statut') === 'valide')>Validé</option>
                        <option value="rejete" @selected(request('statut') === 'rejete')>Rejeté</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>N° DOSSIER</th>
                            <th>CANDIDAT</th>
                            <th>FORMATION</th>
                            <th>SESSION</th>
                            <th>DÉPOSÉ LE</th>
                            <th>STATUT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inscriptions as $inscription)
                            <tr>
                                <td>{{ $inscription->numero_dossier }}</td>
                                <td>{{ $inscription->candidat->name ?? $inscription->candidat->email ?? 'Candidat inconnu' }}</td>
                                <td>{{ $inscription->formation->titre ?? '—' }}</td>
                                <td>
                                    @if ($inscription->session)
                                        {{ \Carbon\Carbon::parse($inscription->session->date_debut)->format('d/m/Y') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $inscription->date_soumission?->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    <span class="badge statut-badge-{{ $inscription->statut }}">
                                        {{ $inscription->statut_libelle }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.inscriptions.show', $inscription) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucune candidature trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $inscriptions->links() }}
        </div>
    </div>

    @push('styles')
    <style>
        .statut-badge-depose { background: #d1ecf1; color: #0c5460; }
        .statut-badge-en_cours { background: #fff3cd; color: #856404; }
        .statut-badge-incomplet { background: #f8d7da; color: #721c24; }
        .statut-badge-valide { background: #d4edda; color: #155724; }
        .statut-badge-rejete { background: #f8d7da; color: #721c24; }
    </style>
    @endpush
</x-admin>