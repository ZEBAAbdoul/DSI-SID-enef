{{-- resources/views/admin/inscriptions/show.blade.php --}}
<x-admin>
    @section('title', 'Dossier ' . $inscription->numero_dossier)

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    <div class="row">
        <!-- Infos candidature -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dossier {{ $inscription->numero_dossier }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Candidat :</strong> {{ $inscription->candidat->name ?? $inscription->candidat->email ?? '—' }}</p>
                    <p><strong>Email :</strong> {{ $inscription->candidat->email ?? '—' }}</p>
                    <p><strong>Formation :</strong> {{ $inscription->formation->titre ?? '—' }}</p>
                    <p><strong>Session :</strong>
                        @if ($inscription->session)
                            {{ \Carbon\Carbon::parse($inscription->session->date_debut)->translatedFormat('d M Y') }}
                            — {{ $inscription->session->lieu }}
                        @else
                            —
                        @endif
                    </p>
                    <p><strong>Déposé le :</strong> {{ $inscription->date_soumission?->format('d/m/Y H:i') ?? '—' }}</p>
                    <p><strong>Statut :</strong> <span class="badge statut-badge-{{ $inscription->statut }}">{{ $inscription->statut_libelle }}</span></p>

                    @if ($inscription->motif_rejet)
                        <p><strong>Motif :</strong> {{ $inscription->motif_rejet }}</p>
                    @endif
                </div>

                @if (!in_array($inscription->statut, ['valide']))
                <div class="card-footer">
                    <form action="{{ route('admin.inscriptions.valider', $inscription) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Valider ce dossier ?')">
                            <i class="fas fa-check"></i> Valider
                        </button>
                    </form>

                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalIncomplet">
                        <i class="fas fa-exclamation-triangle"></i> Incomplet
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalRejeter">
                        <i class="fas fa-times"></i> Rejeter
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Pièces jointes -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pièces jointes ({{ $inscription->pieces->count() }})</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TYPE</th>
                                <th>FICHIER</th>
                                <th>DÉPOSÉ LE</th>
                                <th>VÉRIFICATION</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inscription->pieces as $piece)
                                <tr>
                                    <td>{{ $piece->type_piece_libelle }}</td>
                                    <td>{{ strtoupper($piece->format_fichier) }}</td>
                                    <td>{{ $piece->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge verif-badge-{{ $piece->statut_verification }}">
                                            @switch($piece->statut_verification)
                                                @case('conforme') Conforme @break
                                                @case('non_conforme') Non conforme @break
                                                @default En attente
                                            @endswitch
                                        </span>
                                        @if ($piece->commentaire)
                                            <br><small class="text-muted">{{ $piece->commentaire }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('inscription.pieces.telecharger', $piece) }}" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-toggle="modal" data-target="#modalVerifier{{ $piece->id }}">
                                            <i class="fas fa-check-double"></i> Vérifier
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal vérification pièce -->
                                <div class="modal fade" id="modalVerifier{{ $piece->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.inscriptions.pieces.verifier', $piece) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Vérifier : {{ $piece->type_piece_libelle }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Statut</label>
                                                        <select name="statut_verification" class="form-control" required>
                                                            <option value="conforme">Conforme</option>
                                                            <option value="non_conforme">Non conforme</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Commentaire (optionnel)</label>
                                                        <textarea name="commentaire" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Aucune pièce déposée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal rejeter -->
    <div class="modal fade" id="modalRejeter" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.inscriptions.rejeter', $inscription) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Rejeter le dossier</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>Motif du rejet</label>
                        <textarea name="motif_rejet" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Rejeter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal incomplet -->
    <div class="modal fade" id="modalIncomplet" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.inscriptions.incomplet', $inscription) }}" method="POST">