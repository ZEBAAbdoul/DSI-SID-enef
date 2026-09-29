<x-admin>

    @section('title', 'Dossier ' . $inscription->numero_dossier)

    @php
        $candidat = $inscription->candidat;
        $personne = $candidat?->personne;

        $statuts = [
            'depose'    => ['Déposé', 'info', 'fa-inbox'],
            'en_cours'  => ['En cours', 'primary', 'fa-spinner'],
            'incomplet' => ['Incomplet', 'warning', 'fa-exclamation-triangle'],
            'valide'    => ['Validé', 'success', 'fa-check-circle'],
            'rejete'    => ['Rejeté', 'danger', 'fa-times-circle'],
        ];
        [$statutLabel, $statutColor, $statutIcon] = $statuts[$inscription->statut] ?? [
            ucfirst(str_replace('_', ' ', $inscription->statut)),
            'secondary',
            'fa-info-circle',
        ];

        $pieces = $inscription->pieces;
        $nbPieces = $pieces->count();
        $nbConformes = $pieces->where('statut_verification', 'conforme')->count();
        $nbNonConformes = $pieces->where('statut_verification', 'non_conforme')->count();
        $nbAttente = $nbPieces - $nbConformes - $nbNonConformes;
        $nbResoumises = $pieces->where('resoumis', true)->count();
        $pourcentage = $nbPieces > 0 ? round(($nbConformes / $nbPieces) * 100) : 0;
        $toutesPiecesConformes = $nbPieces > 0 && $nbConformes === $nbPieces;
        $piecesManquantes = $inscription->typesPiecesManquants();
        $peutTraiter = $inscription->statut !== 'valide';

        $nomCandidat = $personne?->nom_complet ?: ($candidat->email ?? '—');

        $sexeLabel = match (strtoupper((string) $personne?->sexe)) {
            'M' => 'Masculin',
            'F' => 'Féminin',
            default => $personne?->sexe ?: null,
        };

        $dateNaissance = $personne?->date_naissance
            ? \Carbon\Carbon::parse($personne->date_naissance)->translatedFormat('d F Y')
            : null;

        $adresseComplete = collect([$personne?->adresse, $personne?->ville, $personne?->pays_residence])
            ->filter()
            ->implode(', ');
    @endphp

    {{-- ===================== BARRE DU HAUT ===================== --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
        <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i> Retour à la liste
        </a>

        {{-- @if ($peutTraiter)
            <div>
                @if ($toutesPiecesConformes)
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#modalValider">
                        <i class="fas fa-check mr-1"></i> Valider
                    </button>
                @else
                    <button type="button" class="btn btn-success btn-sm" disabled
                        title="Toutes les pièces doivent être conformes avant de valider le dossier">
                        <i class="fas fa-check mr-1"></i> Valider
                    </button>
                @endif

                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalRejeter">
                    <i class="fas fa-times mr-1"></i> Rejeter
                </button>
            </div>
        @endif --}}
    </div>

    {{-- Messages --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show py-2 mb-2">
            <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
            <button type="button" class="close py-2" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2 mb-2">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close py-2" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- ===================== EN-TÊTE DU DOSSIER ===================== --}}
    <div class="card dossier-header border-0 shadow-sm mb-2">
        <div class="card-body py-2">
            <div class="row align-items-center">

                <div class="col-lg-8">
                    <div class="d-flex align-items-center flex-wrap">
                        <h5 class="mb-0 font-weight-bold mr-3">{{ $inscription->numero_dossier }}</h5>
                        <span class="badge badge-{{ $statutColor }} statut-pill">
                            <i class="fas {{ $statutIcon }} mr-1"></i>{{ $statutLabel }}
                        </span>
                    </div>

                    <div class="text-muted small mt-1">
                        <i class="fas fa-graduation-cap mr-1"></i>
                        <strong>{{ $inscription->formation->titre ?? '—' }}</strong>
                        @if ($inscription->formation?->categorie?->nom)
                            ({{ $inscription->formation->categorie->nom }})
                        @endif

                        @if ($inscription->session)
                            <span class="mx-1">•</span>
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ \Carbon\Carbon::parse($inscription->session->date_debut)->translatedFormat('d M Y') }}
                            @if ($inscription->session->date_fin)
                                → {{ \Carbon\Carbon::parse($inscription->session->date_fin)->translatedFormat('d M Y') }}
                            @endif
                            <span class="mx-1">•</span>
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $inscription->session->lieu ?? 'Lieu non précisé' }}
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 text-lg-right small mt-2 mt-lg-0">
                    <div>
                        <span class="text-muted">Déposé le</span>
                        <strong>{{ $inscription->date_soumission?->format('d/m/Y H:i') ?? '—' }}</strong>
                    </div>
                    @if ($inscription->date_traitement || $inscription->traite_par)
                        <div>
                            <span class="text-muted">Traité le</span>
                            <strong>{{ $inscription->date_traitement?->format('d/m/Y H:i') ?? '—' }}</strong>
                            @if ($inscription->traitePar)
                                <span class="text-muted">par</span> <strong>{{ $inscription->traitePar->name }}</strong>
                            @endif
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Motif du rejet --}}
    @if ($inscription->motif_rejet)
        <div class="callout callout-danger py-2 my-2">
            <strong><i class="fas fa-times-circle mr-1"></i>Motif du rejet :</strong>
            {{ $inscription->motif_rejet }}
        </div>
    @endif

    <div class="row">

        {{-- ===================== CANDIDAT ===================== --}}
        <div class="col-lg-4">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header py-2">
                    <h3 class="card-title"><i class="fas fa-user mr-2"></i>Candidat</h3>
                </div>
                <div class="card-body py-2">
                    <dl class="row info-list mb-0">
                        <dt class="col-4">Nom</dt>
                        <dd class="col-8">{{ $nomCandidat }}</dd>

                        <dt class="col-4">Sexe</dt>
                        <dd class="col-8">{{ $sexeLabel ?? '—' }}</dd>

                        <dt class="col-4">Naissance</dt>
                        <dd class="col-8">
                            {{ $dateNaissance ?? '—' }}
                            @if ($personne?->lieu_naissance)
                                <span class="text-muted font-weight-normal">à {{ $personne->lieu_naissance }}</span>
                            @endif
                        </dd>

                        <dt class="col-4">Nationalité</dt>
                        <dd class="col-8">
                            {{ $personne?->pays_nationalite ?? '—' }}
                            @if ($personne?->nationalite_type)
                                <span class="text-muted font-weight-normal">({{ $personne->nationalite_type }})</span>
                            @endif
                        </dd>

                        <dt class="col-4">Pièce ID</dt>
                        <dd class="col-8">
                            @if ($personne?->piece_type || $personne?->piece_numero)
                                {{ $personne->piece_type }}
                                @if ($personne->piece_numero)
                                    <span class="text-muted font-weight-normal">N° {{ $personne->piece_numero }}</span>
                                @endif
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-4">Téléphone</dt>
                        <dd class="col-8">{{ $personne?->telephone ? $personne->telephone_complet : '—' }}</dd>

                        <dt class="col-4">Email</dt>
                        <dd class="col-8">{{ $candidat->email ?? '—' }}</dd>

                        <dt class="col-4">Adresse</dt>
                        <dd class="col-8 mb-0">{{ $adresseComplete ?: '—' }}</dd>
                    </dl>
                </div>
            </div>
            @if ($peutTraiter)
            <div>
                @if ($toutesPiecesConformes)
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#modalValider">
                        <i class="fas fa-check mr-1"></i> Valider
                    </button>
                @else
                    <button type="button" class="btn btn-success btn-sm" disabled
                        title="Toutes les pièces doivent être conformes avant de valider le dossier">
                        <i class="fas fa-check mr-1"></i> Valider
                    </button>
                @endif

                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalRejeter">
                    <i class="fas fa-times mr-1"></i> Rejeter
                </button>
            </div>
        @endif
        </div>

        {{-- ===================== PIÈCES ===================== --}}
        <div class="col-lg-8">
            <div class="card card-outline card-primary shadow-sm">

                <div class="card-header py-2">
                    <h3 class="card-title">
                        <i class="fas fa-paperclip mr-2"></i>Pièces jointes ({{ $nbPieces }})
                    </h3>
                    <div class="card-tools mr-0">
                        <span class="badge badge-success">{{ $nbConformes }} conforme(s)</span>
                        <span class="badge badge-warning">{{ $nbAttente }} en attente</span>
                        <span class="badge badge-danger">{{ $nbNonConformes }} non conforme(s)</span>
                        @if ($nbResoumises > 0)
                            <span class="badge badge-info">
                                <i class="fas fa-sync-alt mr-1"></i>{{ $nbResoumises }} resoumis
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Barre de progression fine --}}
                <div class="progress progress-thin rounded-0">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $pourcentage }}%"
                        aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                @if ($piecesManquantes->isNotEmpty())
                    <div class="alert alert-warning py-1 px-3 mb-0 rounded-0 small">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <strong>Pièces obligatoires manquantes :</strong>
                        {{ $piecesManquantes->implode(', ') }}
                    </div>
                @endif

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Pièce</th>
                                    <th>Déposé le</th>
                                    <th>Vérification</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pieces as $piece)
                                    @php $verif = $piece->statut_verification ?: 'en_attente'; @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $piece->type_piece_libelle }}</strong>
                                            <small class="text-muted d-block">
                                                {{ strtoupper($piece->format_fichier) }}
                                                @if ($piece->taille_fichier_ko)
                                                    · {{ $piece->taille_fichier_ko }} Ko
                                                @endif
                                            </small>
                                        </td>

                                        <td class="text-nowrap small">
                                            {{ optional($piece->created_at)->format('d/m/Y H:i') }}
                                        </td>

                                        <td>
                                            <span class="badge verif-badge-{{ $verif }}">
                                                @switch($verif)
                                                    @case('conforme')
                                                        <i class="fas fa-check mr-1"></i>Conforme
                                                    @break

                                                    @case('non_conforme')
                                                        <i class="fas fa-times mr-1"></i>Non conforme
                                                    @break

                                                    @default
                                                        <i class="fas fa-clock mr-1"></i>En attente
                                                @endswitch
                                            </span>

                                            @if ($piece->resoumis)
                                                <span class="badge badge-info" title="Nouveau fichier déposé">
                                                    <i class="fas fa-sync-alt"></i>
                                                </span>
                                            @endif

                                            @if ($piece->commentaire)
                                                <small class="text-muted d-block">{{ $piece->commentaire }}</small>
                                            @endif
                                        </td>

                                        <td class="text-center text-nowrap">
                                            <a href="{{ route('admin.inscription.piece.telecharger', $piece) }}"
                                                class="btn btn-sm btn-info" target="_blank" title="Voir le fichier">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($peutTraiter)
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-toggle="modal" data-target="#modalVerifier"
                                                    data-action="{{ route('admin.inscriptions.pieces.verifier', $piece) }}"
                                                    data-titre="{{ $piece->type_piece_libelle }}"
                                                    data-statut="{{ $verif }}"
                                                    data-commentaire="{{ $piece->commentaire }}"
                                                    title="Vérifier la pièce">
                                                    <i class="fas fa-check-double"></i>
                                                </button>

                                                @if ($verif !== 'non_conforme')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-toggle="modal" data-target="#modalVerifier"
                                                        data-action="{{ route('admin.inscriptions.pieces.verifier', $piece) }}"
                                                        data-titre="{{ $piece->type_piece_libelle }}"
                                                        data-statut="non_conforme" data-commentaire=""
                                                        title="Marquer non conforme">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                            Aucune pièce déposée.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===================== MODAL UNIQUE : VÉRIFIER UNE PIÈCE ===================== --}}
    @if ($peutTraiter)
        <div class="modal fade" id="modalVerifier" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="formVerifier" action="#" method="POST">
                        @csrf

                        <div class="modal-header py-2">
                            <h5 class="modal-title">
                                <i class="fas fa-check-double mr-2"></i>
                                Vérifier : <span id="verifTitre"></span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="verifStatut">Statut</label>
                                <select name="statut_verification" id="verifStatut" class="form-control" required>
                                    <option value="conforme">Conforme</option>
                                    <option value="non_conforme">Non conforme</option>
                                </select>
                            </div>

                            <div id="verifAlerte" class="alert alert-warning py-2 d-none">
                                <i class="fas fa-info-circle mr-1"></i>
                                Le candidat sera informé et pourra déposer un nouveau fichier.
                            </div>

                            <div class="form-group mb-0">
                                <label for="verifCommentaire" id="verifLabel">Commentaire</label>
                                <textarea name="commentaire" id="verifCommentaire" class="form-control" rows="3"
                                    placeholder="Exemple : document illisible, mauvais format, date expirée..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer py-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ===================== MODAL REJETER ===================== --}}
    <div class="modal fade" id="modalRejeter" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.inscriptions.rejeter', $inscription) }}" method="POST">
                    @csrf

                    <div class="modal-header py-2">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle mr-2 text-danger"></i> Rejeter le dossier
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label for="motif_rejet">Motif du rejet</label>
                            <textarea name="motif_rejet" id="motif_rejet" class="form-control" rows="4" required
                                placeholder="Indiquez le motif du rejet..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times mr-1"></i> Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL VALIDER ===================== --}}
    <div class="modal fade" id="modalValider" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.inscriptions.valider', $inscription) }}" method="POST">
                    @csrf

                    <div class="modal-header py-2">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle mr-2 text-success"></i> Valider le dossier
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-success py-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Toutes les pièces justificatives sont conformes.
                        </div>

                        <p class="mb-1"><strong>Candidat :</strong> {{ $nomCandidat }}</p>
                        <p class="mb-1"><strong>Formation :</strong> {{ $inscription->formation->titre ?? '—' }}</p>
                        <p class="mb-3"><strong>Dossier :</strong> {{ $inscription->numero_dossier }}</p>

                        <p class="text-muted mb-0">
                            Confirmez-vous la validation définitive de ce dossier ?
                            Cette action informera le candidat qu'il peut procéder au paiement.
                        </p>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check mr-1"></i> Confirmer la validation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== SCRIPT : MODAL DE VÉRIFICATION PARTAGÉ ===================== --}}
    <script>
        window.addEventListener('load', function() {
            var $modal = $('#modalVerifier');
            if (!$modal.length) return;

            var $form = $('#formVerifier');
            var $statut = $('#verifStatut');
            var $com = $('#verifCommentaire');
            var $alerte = $('#verifAlerte');
            var $label = $('#verifLabel');

            function maj() {
                var nc = $statut.val() === 'non_conforme';
                $alerte.toggleClass('d-none', !nc);
                $com.prop('required', nc);
                $label.text(nc ? 'Motif (obligatoire)' : 'Commentaire');
            }

            $modal.on('show.bs.modal', function(e) {
                var $btn = $(e.relatedTarget);
                $form.attr('action', $btn.attr('data-action'));
                $('#verifTitre').text($btn.attr('data-titre'));
                $statut.val($btn.attr('data-statut') === 'non_conforme' ? 'non_conforme' : 'conforme');
                $com.val($btn.attr('data-commentaire') || '');
                maj();
            });

            $statut.on('change', maj);
        });
    </script>

    {{-- ===================== STYLES ===================== --}}
    <style>
        .dossier-header {
            border-left: 5px solid #007bff;
        }

        .statut-pill {
            font-size: .8rem;
            padding: .35rem .7rem;
            border-radius: 50rem;
            font-weight: 600;
        }

        .info-list dt {
            font-weight: 500;
            color: #6c757d;
            font-size: .8rem;
            margin-bottom: .35rem;
        }

        .info-list dd {
            font-weight: 600;
            font-size: .875rem;
            margin-bottom: .35rem;
            word-break: break-word;
        }

        .progress-thin {
            height: 4px;
        }

        .verif-badge-conforme {
            background-color: #28a745;
            color: #fff;
        }

        .verif-badge-non_conforme {
            background-color: #dc3545;
            color: #fff;
        }

        .verif-badge-en_attente {
            background-color: #ffc107;
            color: #212529;
        }

        .card-title {
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>

</x-admin>