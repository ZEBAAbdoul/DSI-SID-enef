{{-- resources/views/candidat/inscription.blade.php --}}
<x-admin>
    @section('title', 'Mon dossier de candidature')

    @if (session('status'))
        <div class="alert alert-info">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$inscription)
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="mb-3">Vous n'avez pas encore de dossier de candidature.</p>
                <a href="{{ route('admin.inscription.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Choisir une session
                </a>
            </div>
        </div>
    @else
        @php
            $badgesStatut = [
                'depose' => 'badge-secondary',
                'en_cours' => 'badge-info',
                'incomplet' => 'badge-warning',
                'valide' => 'badge-success',
                'rejete' => 'badge-danger',
            ];
            $labelsStatut = [
                'depose' => 'Déposé',
                'en_cours' => 'En cours',
                'incomplet' => 'Incomplet',
                'valide' => 'Validé',
                'rejete' => 'Rejeté',
            ];
            $piecesParType = $inscription->pieces->groupBy('type_piece');
        @endphp

        {{-- En-tête du dossier --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    Dossier {{ $inscription->numero_dossier ?? '—' }}
                </h3>

                <span class="badge {{ $badgesStatut[$inscription->statut] ?? 'badge-secondary' }}">
                    {{ $labelsStatut[$inscription->statut] ?? $inscription->statut }}
                </span>
            </div>

            <div class="card-body">

                {{-- Message affiché uniquement si la candidature est validée --}}
                @if ($inscription->statut === 'valide')
                    <div class="alert alert-success shadow-sm mb-4">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>

                            <div>
                                <h5 class="mb-2">
                                    <strong>Félicitations ! Votre inscription a été validée.</strong>
                                </h5>

                                <p class="mb-2">
                                    Votre candidature a été retenue pour cette formation.
                                </p>

                                <p class="mb-0">
                                    Pour procéder au <strong>paiement des frais de scolarité</strong>,
                                    veuillez contacter le
                                    <strong>Service des Ressources Humaines</strong> au numéro :
                                </p>

                                <div class="mt-3">
                                    <a href="tel:+22670000000" class="btn btn-success btn-sm">
                                        <i class="fas fa-phone-alt"></i>
                                        +226 70 00 00 00
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Formation :</strong>
                            {{ $inscription->formation->titre ?? 'Formation supprimée' }}
                        </p>

                        <p class="mb-1">
                            <strong>Lieu :</strong>
                            {{ $inscription->session->lieu ?? '—' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Session :</strong>

                            @if ($inscription->session)
                                {{ \Carbon\Carbon::parse($inscription->session->date_debut)->format('d/m/Y') }}
                                →
                                {{ $inscription->session->date_fin
                                    ? \Carbon\Carbon::parse($inscription->session->date_fin)->format('d/m/Y')
                                    : '—' }}
                            @else
                                —
                            @endif
                        </p>

                        <p class="mb-1">
                            <strong>Soumis le :</strong>
                            {{ $inscription->date_soumission
                                ? \Carbon\Carbon::parse($inscription->date_soumission)->format('d/m/Y à H:i')
                                : '—' }}
                        </p>
                    </div>
                </div>

                @if ($inscription->statut === 'rejete' && $inscription->motif_rejet)
                    <div class="alert alert-danger mt-3 mb-0">
                        <strong>Motif du rejet :</strong>
                        {{ $inscription->motif_rejet }}
                    </div>
                @endif
            </div>
        </div>


        {{-- Pièces justificatives --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pièces justificatives</h3>
            </div>
            <div class="card-body">
                @if ($typesPieces->isEmpty())
                    <p class="text-muted mb-0">Aucun type de pièce configuré.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>PIÈCE</th>
                                    <th>STATUT</th>
                                    <th>FICHIER(S)</th>
                                    {{-- <th style="width: 220px;"></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($typesPieces as $type)
                                    @php
                                        $piecesDuType = $piecesParType->get($type->code, collect());
                                        $derniere = $piecesDuType->last();
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $type->libelle }}
                                            @if ($type->obligatoire)
                                                <span class="badge badge-danger ml-1">Obligatoire</span>
                                            @else
                                                <span class="badge badge-secondary ml-1">Facultatif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($piecesDuType->isEmpty())
                                                <span class="badge badge-light border">Non déposée</span>
                                            @elseif ($derniere->estConforme())
                                                <span class="badge badge-success">Conforme</span>
                                            @elseif ($derniere->estNonConforme())
                                                <span class="badge badge-danger">Non conforme</span>
                                            @else
                                                <span class="badge badge-warning">En attente de vérification</span>
                                            @endif
                                            @if ($derniere && $derniere->estNonConforme() && $derniere->commentaire)
                                                <div class="small text-danger mt-1">{{ $derniere->commentaire }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @forelse ($piecesDuType as $piece)
                                                <div class="d-flex align-items-center mb-1">
                                                    <a href="{{ route('admin.inscription.piece.telecharger', $piece) }}"
                                                        class="mr-2">
                                                        <i class="fas fa-file"></i>
                                                        {{ strtoupper($piece->format_fichier) }} ·
                                                        {{ $piece->taille_fichier_ko }} Ko
                                                    </a>

                                                    @if ($inscription->statut !== 'valide')
                                                        {{-- Bouton Modifier : uniquement si la pièce n'est PAS conforme --}}
                                                        @if (!$piece->estConforme())
                                                            <button type="button" class="btn btn-sm btn-link p-0 mr-2"
                                                                data-toggle="collapse"
                                                                data-target="#modifier-{{ $piece->id }}">
                                                                <i class="fas fa-pen"></i> Modifier
                                                            </button>
                                                        @endif

                                                        {{-- <form
                                                            action="{{ route('admin.inscription.piece.destroy', $piece) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Supprimer ce fichier ?');"
                                                            class="mb-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form> --}}
                                                    @endif
                                                </div>

                                                {{-- Formulaire de remplacement (masqué par défaut) --}}
                                                @if ($inscription->statut !== 'valide' && !$piece->estConforme())
                                                    <div id="modifier-{{ $piece->id }}" class="collapse mt-1 mb-2">
                                                        <form
                                                            action="{{ route('admin.inscription.piece.update', $piece) }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="form-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="file" name="fichier"
                                                                class="form-control-file mr-2"
                                                                accept=".pdf,.jpg,.jpeg,.png" required>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-upload"></i> Remplacer
                                                            </button>
                                                        </form>
                                                        @error('fichier')
                                                            <small
                                                                class="text-danger d-block mt-1">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                @endif
                                            @empty
                                                <span class="text-muted">—</span>
                                            @endforelse
                                        </td>
                                        {{-- <td>
                                            @if ($inscription->statut !== 'valide' && (!$derniere || $derniere->estNonConforme()))
                                                <form
                                                    action="{{ route('admin.inscription.piece.store', $inscription) }}"
                                                    method="POST" enctype="multipart/form-data" class="form-inline">
                                                    @csrf
                                                    <input type="hidden" name="type_piece"
                                                        value="{{ $type->code }}">
                                                    <input type="file" name="fichier" class="form-control-file mr-2"
                                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-upload"></i> Déposer
                                                    </button>
                                                </form>
                                                @error('fichier')
                                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                @enderror
                                            @endif
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <small class="form-text text-muted">
                        Formats acceptés : PDF, JPG, PNG — 5 Mo max par fichier.
                    </small>
                @endif
            </div>
        </div>
    @endif
</x-admin>
