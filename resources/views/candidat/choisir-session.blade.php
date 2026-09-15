<x-admin>
    @section('title', 'Choisir une session de formation')

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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sessions de formation disponibles</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>FORMATION</th>
                            <th>CATÉGORIE</th>
                            <th>LIEU</th>
                            <th>DATE DÉBUT</th>
                            <th>DATE FIN</th>
                            <th>PLACES DISPONIBLES</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $session)
                            @php
                                $formation = $session->formation;
                                $complet = $session->places_disponibles <= 0;
                            @endphp
                            <tr>
                                <td>{{ $formation->titre ?? 'Formation supprimée' }}</td>
                                <td>{{ $formation->categorie->nom ?? '—' }}</td>
                                <td>{{ $session->lieu ?? '—' }}</td>
                                <td>{{ optional($session->date_debut)->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ optional($session->date_fin)->format('d/m/Y') ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $complet ? 'badge-secondary' : 'badge-success' }}">
                                        {{ $session->places_disponibles }} / {{ $session->places_totales }}
                                    </span>
                                </td>
                                <td>
    @if ($inscriptions->has($session->id))

        {{-- Le candidat est déjà inscrit --}}
        <a href="{{ route('admin.inscription.show', $inscriptions[$session->id]->id) }}"
            class="btn btn-sm btn-info">
            <i class="fas fa-eye mr-1"></i>
            Voir ma candidature
        </a>

    @elseif ($complet)

        {{-- Session complète --}}
        <button type="button" class="btn btn-sm btn-secondary" disabled>
            <i class="fas fa-ban mr-1"></i>
            Session complète
        </button>

    @else

        {{-- Pas encore inscrit --}}
        <a href="{{ route('admin.inscription.inscriptionforme', $session->id) }}"
            class="btn btn-sm btn-primary">
            <i class="fas fa-user-plus mr-1"></i>
            S'inscrire
        </a>

    @endif
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Aucune session ouverte pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal de confirmation d'inscription --}}
    <div class="modal fade" id="modalInscription" tabindex="-1" role="dialog" aria-labelledby="modalInscriptionLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.inscription.store') }}" method="POST" id="formInscription"
                    enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInscriptionLabel">
                            <span id="modal-step-indicator">Étape 1/2 — Votre candidature</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="session_formation_id" id="input-session-id" value="">

                        {{-- ===================== ÉTAPE 1 : SAISIE ===================== --}}
                        <div id="step-1">

                            {{-- Bloc infos formation --}}
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 id="info-formation" class="mb-2"></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Type :</strong> <span id="info-type"></span></p>
                                            <p class="mb-1"><strong>Catégorie :</strong> <span
                                                    id="info-categorie"></span></p>
                                            <p class="mb-1"><strong>Durée :</strong> <span id="info-duree"></span></p>
                                            <p class="mb-1"><strong>Coût indicatif :</strong> <span
                                                    id="info-cout"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Public cible :</strong> <span
                                                    id="info-public-cible"></span></p>
                                            <p class="mb-1"><strong>Lieu :</strong> <span id="info-lieu"></span></p>
                                            <p class="mb-1"><strong>Dates :</strong> <span id="info-dates"></span></p>
                                            <p class="mb-1"><strong>Places disponibles :</strong> <span
                                                    id="info-places"></span></p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted" id="info-resume"></p>
                                </div>
                            </div>

                            {{-- Remarque facultative --}}
                            <div class="form-group">
                                <label for="input-commentaire">Remarque (facultatif)</label>
                                <textarea class="form-control" id="input-commentaire" name="commentaire" rows="2"
                                    placeholder="Une précision à ajouter à votre candidature ?"></textarea>
                            </div>

                            {{-- Dépôt des pièces justificatives --}}
                            @if ($typesPieces->isNotEmpty())
                                <div class="form-group">
                                    <label>Pièces justificatives</label>
                                    @foreach ($typesPieces as $type)
                                        <div class="form-group mb-2 piece-upload"
                                            data-obligatoire="{{ $type->obligatoire ? '1' : '0' }}"
                                            data-libelle="{{ $type->libelle }}">
                                            <label for="piece-{{ $type->code }}"
                                                class="d-flex justify-content-between">
                                                <span>{{ $type->libelle }}</span>
                                                @if ($type->obligatoire)
                                                    <span class="badge badge-danger">Obligatoire</span>
                                                @else
                                                    <span class="badge badge-secondary">Facultatif</span>
                                                @endif
                                            </label>
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="custom-file-input piece-input {{ $errors->has("pieces.{$type->code}") ? 'is-invalid' : '' }}"
                                                    id="piece-{{ $type->code }}" name="pieces[{{ $type->code }}]"
                                                    accept=".pdf,.jpg,.jpeg,.png" data-libelle="{{ $type->libelle }}"
                                                    {{ $type->obligatoire ? 'required' : '' }}>
                                                <label class="custom-file-label" for="piece-{{ $type->code }}">
                                                    Choisir un fichier…
                                                </label>
                                            </div>
                                            <small class="form-text text-danger d-none piece-error">
                                                Ce document est obligatoire.
                                            </small>
                                            @error("pieces.{$type->code}")
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    @endforeach
                                    <small class="form-text text-muted">
                                        Formats acceptés : PDF, JPG, PNG — 5 Mo max par fichier.
                                    </small>
                                </div>
                            @endif

                            <div class="alert alert-danger d-none" id="step1-alert"></div>
                        </div>

                        {{-- ===================== ÉTAPE 2 : RÉCAPITULATIF ===================== --}}
                        <div id="step-2" class="d-none">
                            <p class="text-muted">
                                Merci de vérifier les informations ci-dessous avant de confirmer votre candidature.
                            </p>

                            <table class="table table-sm table-borderless mb-3">
                                <tr>
                                    <th style="width:35%">Formation</th>
                                    <td id="recap-formation"></td>
                                </tr>
                                <tr>
                                    <th>Type / Catégorie</th>
                                    <td id="recap-type-categorie"></td>
                                </tr>
                                <tr>
                                    <th>Durée / Coût</th>
                                    <td id="recap-duree-cout"></td>
                                </tr>
                                <tr>
                                    <th>Lieu</th>
                                    <td id="recap-lieu"></td>
                                </tr>
                                <tr>
                                    <th>Dates</th>
                                    <td id="recap-dates"></td>
                                </tr>
                                <tr>
                                    <th>Remarque</th>
                                    <td id="recap-commentaire">—</td>
                                </tr>
                                <tr>
                                    <th>Pièces jointes</th>
                                    <td>
                                        <ul class="pl-3 mb-0" id="recap-pieces"></ul>
                                    </td>
                                </tr>
                            </table>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="modal-confirm"
                                    name="confirmation" required>
                                <label class="custom-control-label" for="modal-confirm">
                                    Je confirme vouloir candidater à cette session de formation.
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>

                        <div>
                            <button type="button" class="btn btn-outline-secondary d-none" id="btn-precedent">
                                <i class="fas fa-arrow-left"></i> Précédent
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-suivant">
                                Suivant <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn btn-primary d-none" id="btn-confirmer">
                                <i class="fas fa-check"></i> Confirmer mon inscription
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-admin>
