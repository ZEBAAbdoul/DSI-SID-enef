<x-admin>

    @section('title', 'Dossier ' . $inscription->numero_dossier)

    {{-- ========================================================= --}}
    {{-- RETOUR                                                    --}}
    {{-- ========================================================= --}}
    <div class="mb-3">
        <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>
            Retour à la liste des dossiers
        </a>
    </div>

    {{-- Message de succès --}}
    @if (session('status'))
        <div class="alert alert-info alert-dismissible fade show">
            <i class="fas fa-info-circle mr-2"></i>
            {{ session('status') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h6>
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Une erreur est survenue
            </h6>

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="row">

        {{-- ========================================================= --}}
        {{-- INFORMATIONS SUR LA CANDIDATURE                           --}}
        {{-- ========================================================= --}}

        <div class="col-md-4">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-folder-open mr-2"></i>
                        Dossier {{ $inscription->numero_dossier }}
                    </h3>
                </div>

                <div class="card-body">

                    {{-- Candidat --}}
                    <p>
                        <strong>
                            <i class="fas fa-user mr-1"></i>
                            Candidat :
                        </strong>

                        {{ $inscription->candidat->name ?? ($inscription->candidat->email ?? '—') }}
                    </p>

                    {{-- Email --}}
                    <p>
                        <strong>
                            <i class="fas fa-envelope mr-1"></i>
                            Email :
                        </strong>

                        {{ $inscription->candidat->email ?? '—' }}
                    </p>

                    {{-- Formation --}}
                    <p>
                        <strong>
                            <i class="fas fa-graduation-cap mr-1"></i>
                            Formation :
                        </strong>

                        {{ $inscription->formation->titre ?? '—' }}
                    </p>

                    {{-- Catégorie --}}
                    <p>
                        <strong>
                            <i class="fas fa-layer-group mr-1"></i>
                            Catégorie :
                        </strong>

                        {{ $inscription->formation->categorie->nom ?? '—' }}
                    </p>

                    {{-- Session --}}
                    <p>
                        <strong>
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Session :
                        </strong>

                        @if ($inscription->session)

                            {{ \Carbon\Carbon::parse($inscription->session->date_debut)->translatedFormat('d M Y') }}

                            @if ($inscription->session->date_fin)
                                —
                                {{ \Carbon\Carbon::parse($inscription->session->date_fin)->translatedFormat('d M Y') }}
                            @endif

                            <br>

                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $inscription->session->lieu ?? 'Lieu non précisé' }}
                            </small>
                        @else
                            —

                        @endif
                    </p>

                    {{-- Date de soumission --}}
                    <p>
                        <strong>
                            <i class="fas fa-clock mr-1"></i>
                            Déposé le :
                        </strong>

                        {{ $inscription->date_soumission?->format('d/m/Y H:i') ?? '—' }}
                    </p>

                    {{-- Statut --}}
                    <p>
                        <strong>
                            <i class="fas fa-info-circle mr-1"></i>
                            Statut :
                        </strong>

                        <span class="badge statut-badge-{{ $inscription->statut }}">
                            {{ $inscription->statut }}
                        </span>
                    </p>

                    {{-- Motif rejet --}}
                    @if ($inscription->motif_rejet)
                        <div class="alert alert-danger mt-3 mb-0">

                            <strong>
                                <i class="fas fa-times-circle mr-1"></i>
                                Motif du rejet :
                            </strong>

                            <div class="mt-1">
                                {{ $inscription->motif_rejet }}
                            </div>

                        </div>
                    @endif

                </div>


                {{-- Actions administrateur --}}
                @if ($inscription->statut !== 'valide')
                    <div class="card-footer">

                        {{-- Valider --}}
                        @php
                            $toutesPiecesConformes =
                                $inscription->pieces->isNotEmpty() &&
                                $inscription->pieces->every(fn($piece) => $piece->statut_verification === 'conforme');
                        @endphp

                        @if ($toutesPiecesConformes)
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#modalValider">

                                <i class="fas fa-check mr-1"></i>
                                Valider

                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-sm" disabled
                                title="Toutes les pièces doivent être conformes avant de pouvoir valider le dossier">

                                <i class="fas fa-check mr-1"></i>
                                Valider

                            </button>
                        @endif


                        {{-- Incomplet --}}
                        {{-- <button type="button"
                                class="btn btn-warning btn-sm"
                                data-toggle="modal"
                                data-target="#modalIncomplet">

                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Incomplet

                        </button> --}}


                        {{-- Rejeter --}}
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#modalRejeter">

                            <i class="fas fa-times mr-1"></i>
                            Rejeter

                        </button>

                    </div>
                @endif

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PIÈCES JOINTES                                           --}}
        {{-- ========================================================= --}}

        <div class="col-md-8">

            <div class="card card-primary">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-paperclip mr-2"></i>
                        Pièces jointes
                        ({{ $inscription->pieces->count() }})
                    </h3>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead>

                                <tr>

                                    <th>TYPE</th>
                                    <th>FICHIER</th>
                                    <th>DÉPOSÉ LE</th>
                                    <th>VÉRIFICATION</th>
                                    <th class="text-center">ACTIONS</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($inscription->pieces as $piece)

                                    <tr>

                                        {{-- Type --}}
                                        <td>
                                            <strong>
                                                {{ $piece->type_piece_libelle }}
                                            </strong>
                                        </td>


                                        {{-- Format --}}
                                        <td>

                                            <span class="badge badge-secondary">
                                                {{ strtoupper($piece->format_fichier) }}
                                            </span>

                                            @if ($piece->taille_fichier_ko)
                                                <small class="text-muted d-block">
                                                    {{ $piece->taille_fichier_ko }} Ko
                                                </small>
                                            @endif

                                        </td>


                                        {{-- Date --}}
                                        <td>

                                            {{ optional($piece->created_at)->format('d/m/Y H:i') }}

                                        </td>


                                        {{-- Vérification --}}
                                        <td>

                                            <span class="badge verif-badge-{{ $piece->statut_verification }}">

                                                @switch($piece->statut_verification)
                                                    @case('conforme')
                                                        <i class="fas fa-check mr-1"></i>
                                                        Conforme
                                                    @break

                                                    @case('non_conforme')
                                                        <i class="fas fa-times mr-1"></i>
                                                        Non conforme
                                                    @break

                                                    @default
                                                        <i class="fas fa-clock mr-1"></i>
                                                        En attente
                                                @endswitch

                                            </span>


                                            @if ($piece->commentaire)
                                                <small class="text-muted d-block mt-1">
                                                    {{ $piece->commentaire }}
                                                </small>
                                            @endif

                                        </td>


                                        {{-- Actions --}}
                                        {{-- Actions --}}
                                        <td class="text-center">

                                            {{-- Voir / télécharger --}}
                                            <a href="{{ route('admin.inscription.piece.telecharger', $piece) }}"
                                                class="btn btn-sm btn-info" target="_blank" title="Voir le fichier">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($inscription->statut !== 'valide')
                                                {{-- Vérifier (conforme / non conforme via select) --}}
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-toggle="modal" data-target="#modalVerifier{{ $piece->id }}"
                                                    title="Vérifier la pièce">
                                                    <i class="fas fa-check-double"></i>
                                                </button>

                                                {{-- Non conforme rapide --}}
                                                @if ($piece->statut_verification !== 'non_conforme')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-toggle="modal"
                                                        data-target="#modalNonConforme{{ $piece->id }}"
                                                        title="Marquer non conforme">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @endif

                                        </td>

                                    </tr>


                                    {{-- ================================================= --}}
                                    {{-- MODAL VÉRIFICATION DE LA PIÈCE                  --}}
                                    {{-- ================================================= --}}

                                    <div class="modal fade" id="modalVerifier{{ $piece->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <form
                                                    action="{{ route('admin.inscriptions.pieces.verifier', $piece) }}"
                                                    method="POST">

                                                    @csrf

                                                    <div class="modal-header">

                                                        <h5 class="modal-title">

                                                            <i class="fas fa-check-double mr-2"></i>

                                                            Vérifier :
                                                            {{ $piece->type_piece_libelle }}

                                                        </h5>

                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Fermer">

                                                            <span aria-hidden="true">
                                                                &times;
                                                            </span>

                                                        </button>

                                                    </div>


                                                    <div class="modal-body">

                                                        <div class="form-group">

                                                            <label for="statut_{{ $piece->id }}">
                                                                Statut
                                                            </label>

                                                            <select name="statut_verification"
                                                                id="statut_{{ $piece->id }}" class="form-control"
                                                                required>

                                                                <option value="conforme">
                                                                    Conforme
                                                                </option>

                                                                <option value="non_conforme">
                                                                    Non conforme
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <div class="form-group">

                                                            <label for="commentaire_{{ $piece->id }}">
                                                                Commentaire
                                                            </label>

                                                            <textarea name="commentaire" id="commentaire_{{ $piece->id }}" class="form-control" rows="3"
                                                                placeholder="Commentaire optionnel..."></textarea>

                                                        </div>

                                                    </div>


                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">

                                                            Annuler

                                                        </button>


                                                        <button type="submit" class="btn btn-primary">

                                                            <i class="fas fa-save mr-1"></i>
                                                            Enregistrer

                                                        </button>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ================================================= --}}
                                    {{-- MODAL NON CONFORME (rapide)                        --}}
                                    {{-- ================================================= --}}
                                    <div class="modal fade" id="modalNonConforme{{ $piece->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">

                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <form
                                                    action="{{ route('admin.inscriptions.pieces.verifier', $piece) }}"
                                                    method="POST">
                                                    @csrf

                                                    {{-- On force le statut, pas besoin de select --}}
                                                    <input type="hidden" name="statut_verification"
                                                        value="non_conforme">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-times-circle mr-2 text-danger"></i>
                                                            Marquer non conforme : {{ $piece->type_piece_libelle }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Fermer">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Le candidat sera informé et pourra déposer un nouveau
                                                            fichier.
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="commentaire_nc_{{ $piece->id }}">
                                                                Motif (obligatoire)
                                                            </label>
                                                            <textarea name="commentaire" id="commentaire_nc_{{ $piece->id }}" class="form-control" rows="3" required
                                                                placeholder="Exemple : document illisible, mauvais format, date expirée..."></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Annuler
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times mr-1"></i>
                                                            Confirmer non conforme
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    @empty

                                        <tr>

                                            <td colspan="5" class="text-center text-muted py-4">

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


        {{-- ============================================================= --}}
        {{-- MODAL REJETER                                                --}}
        {{-- ============================================================= --}}

        <div class="modal fade" id="modalRejeter" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <form action="{{ route('admin.inscriptions.rejeter', $inscription) }}" method="POST">

                        @csrf

                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-times-circle mr-2"></i>
                                Rejeter le dossier

                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        <div class="modal-body">

                            <div class="form-group">

                                <label for="motif_rejet">
                                    Motif du rejet
                                </label>

                                <textarea name="motif_rejet" id="motif_rejet" class="form-control" rows="4" required
                                    placeholder="Indiquez le motif du rejet..."></textarea>

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Annuler

                            </button>

                            <button type="submit" class="btn btn-danger">

                                <i class="fas fa-times mr-1"></i>
                                Rejeter

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        {{-- ============================================================= --}}
        {{-- MODAL VALIDER                                                --}}
        {{-- ============================================================= --}}

        <div class="modal fade" id="modalValider" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <form action="{{ route('admin.inscriptions.valider', $inscription) }}" method="POST">

                        @csrf

                        <div class="modal-header">

                            <h5 class="modal-title">
                                <i class="fas fa-check-circle mr-2 text-success"></i>
                                Valider le dossier
                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="alert alert-success">
                                <i class="fas fa-info-circle mr-1"></i>
                                Toutes les pièces justificatives ont été vérifiées et sont conformes.
                            </div>

                            <p class="mb-1">
                                <strong>Candidat :</strong>
                                {{ $inscription->candidat->name ?? ($inscription->candidat->email ?? '—') }}
                            </p>

                            <p class="mb-1">
                                <strong>Formation :</strong>
                                {{ $inscription->formation->titre ?? '—' }}
                            </p>

                            <p class="mb-0">
                                <strong>Dossier :</strong>
                                {{ $inscription->numero_dossier }}
                            </p>

                            <p class="mt-3 mb-0 text-muted">
                                Confirmez-vous la validation définitive de ce dossier ?
                                Cette action informera le candidat qu'il peut procéder au paiement.
                            </p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Annuler
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-1"></i>
                                Confirmer la validation
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- MODAL DOSSIER INCOMPLET                                      --}}
        {{-- ============================================================= --}}

        <div class="modal fade" id="modalIncomplet" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <form action="{{ route('admin.inscriptions.incomplet', $inscription) }}" method="POST">

                        @csrf

                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Dossier incomplet

                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        <div class="modal-body">

                            <div class="alert alert-warning">

                                <i class="fas fa-info-circle mr-1"></i>

                                Indiquez au candidat les pièces ou informations
                                qui doivent être complétées.

                            </div>


                            <div class="form-group">

                                <label for="commentaire_incomplet">
                                    Commentaire
                                </label>

                                <textarea name="commentaire" id="commentaire_incomplet" class="form-control" rows="4" required
                                    placeholder="Exemple : Veuillez fournir une copie lisible de votre diplôme..."></textarea>

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Annuler

                            </button>


                            <button type="submit" class="btn btn-warning">

                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Marquer comme incomplet

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- STYLES                                                        --}}
        {{-- ============================================================= --}}

        <style>
            .statut-badge-depose {
                background-color: #17a2b8;
                color: #fff;
            }

            .statut-badge-en_cours {
                background-color: #007bff;
                color: #fff;
            }

            .statut-badge-incomplet {
                background-color: #ffc107;
                color: #212529;
            }

            .statut-badge-valide {
                background-color: #28a745;
                color: #fff;
            }

            .statut-badge-rejete {
                background-color: #dc3545;
                color: #fff;
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
