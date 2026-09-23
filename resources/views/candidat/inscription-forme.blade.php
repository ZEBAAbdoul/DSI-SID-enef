@php
    $formation = $session->formation;
    $placesTotales = (int) ($session->places_totales ?? 0);
    $placesDispo = (int) ($session->places_disponibles ?? 0);
    $complet = $placesDispo <= 0;
    $tauxOccupation = $placesTotales > 0 ? round((($placesTotales - $placesDispo) / $placesTotales) * 100) : 0;
    $badgeClass = $complet ? 'badge-danger' : 'badge-success';
@endphp

{{-- NB : @section() ne fonctionne pas dans un composant <x-admin>.
     Adapter selon l'API de ton composant : attribut `title` (ci-dessous)
     ou <x-slot name="title">Inscription à une formation</x-slot> --}}
<x-admin title="Inscription à une formation">

    {{-- ==========================================================
         RETOUR
    =========================================================== --}}
    <div class="mb-3">
        <a href="{{ route('admin.inscription.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>
            Retour aux sessions
        </a>
    </div>

    {{-- ==========================================================
         MESSAGES
    =========================================================== --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>
                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                Veuillez corriger les erreurs suivantes :
            </strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <small class="d-block mt-2">
                Pour des raisons de sécurité, les fichiers doivent être sélectionnés à nouveau.
            </small>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($complet)
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-ban mr-2" aria-hidden="true"></i>
            Cette session est complète : les inscriptions sont closes.
        </div>
    @endif

    <div class="row">

        {{-- ======================================================
             COLONNE PRINCIPALE
        ======================================================= --}}
        <div class="col-lg-8">

            {{-- INFORMATIONS FORMATION --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-graduation-cap mr-2" aria-hidden="true"></i>
                        {{ $formation?->titre ?? 'Formation' }}
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <strong>Type :</strong><br>
                                {{ $formation?->type_libelle ?? '—' }}
                            </p>
                            <p>
                                <strong>Catégorie :</strong><br>
                                {{ $formation?->categorie?->nom ?? '—' }}
                            </p>
                            <p>
                                <strong>Durée :</strong><br>
                                {{ $formation?->duree_formatee ?? '—' }}
                            </p>
                            <p class="mb-0">
                                <strong>Coût indicatif :</strong><br>
                                {{ $formation?->cout_formate ?? '—' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Public cible :</strong><br>
                                {{ $formation?->public_cible ?? '—' }}
                            </p>
                            <p>
                                <strong>Lieu :</strong><br>
                                <i class="fas fa-map-marker-alt text-danger mr-1" aria-hidden="true"></i>
                                {{ $session->lieu ?? '—' }}
                            </p>
                            <p>
                                <strong>Date de début :</strong><br>
                                {{ $session->date_debut?->format('d/m/Y') ?? '—' }}
                            </p>
                            <p class="mb-0">
                                <strong>Date de fin :</strong><br>
                                {{ $session->date_fin?->format('d/m/Y') ?? '—' }}
                            </p>
                        </div>
                    </div>

                    @if ($formation?->resume)
                        <hr>
                        <h5>
                            <i class="fas fa-align-left mr-1" aria-hidden="true"></i>
                            Présentation
                        </h5>
                        <p class="text-muted mb-0">{{ $formation->resume }}</p>
                    @endif
                </div>
            </div>

            {{-- ==================================================
                 FORMULAIRE D'INSCRIPTION
            =================================================== --}}
            <form action="{{ route('admin.inscription.store') }}" method="POST" enctype="multipart/form-data"
                id="form-inscription" novalidate>

                @csrf

                <input type="hidden" name="session_formation_id" value="{{ $session->id }}">

                {{-- COMMENTAIRE --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-edit mr-2" aria-hidden="true"></i>
                            Votre candidature
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="commentaire">
                                Remarque
                                <small class="text-muted">(facultatif)</small>
                            </label>

                            <textarea name="commentaire" id="commentaire" class="form-control @error('commentaire') is-invalid @enderror"
                                rows="4" maxlength="500" placeholder="Une précision à ajouter à votre candidature ?">{{ old('commentaire') }}</textarea>

                            <div class="d-flex justify-content-between">
                                <small class="form-text text-muted">Maximum 500 caractères.</small>
                                <small class="form-text text-muted"><span id="commentaire-count">0</span>/500</small>
                            </div>

                            @error('commentaire')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ==================================================
                     PIECES JUSTIFICATIVES
                =================================================== --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-file-upload mr-2" aria-hidden="true"></i>
                            Pièces justificatives
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2" aria-hidden="true"></i>
                            Veuillez fournir les documents demandés.
                            Les documents marqués <strong>Obligatoire</strong> doivent être fournis.
                        </div>

                        @forelse ($typesPieces as $type)
                            @php
                                $champ = 'pieces.' . $type->code;
                                $idPiece = 'piece-' . $type->code;
                            @endphp

                            <div class="form-group piece-upload mb-4" id="piece-wrapper-{{ $type->code }}">

                                {{-- Un seul <label> par champ : le titre est relié via aria-labelledby --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="font-weight-bold" id="piece-title-{{ $type->code }}">
                                        <i class="fas fa-file-alt mr-1" aria-hidden="true"></i>
                                        {{ $type->libelle }}
                                    </span>

                                    @if ($type->obligatoire)
                                        <span class="badge badge-danger">Obligatoire</span>
                                    @else
                                        <span class="badge badge-secondary">Facultatif</span>
                                    @endif
                                </div>

                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error($champ) is-invalid @enderror"
                                        id="{{ $idPiece }}" name="pieces[{{ $type->code }}]"
                                        accept=".pdf,.jpg,.jpeg,.png" data-max-size="5242880"
                                        aria-labelledby="piece-title-{{ $type->code }}"
                                        aria-describedby="{{ $idPiece }}-help"
                                        @if ($type->obligatoire) required @endif>

                                    <label class="custom-file-label" for="{{ $idPiece }}">
                                        Choisir un fichier…
                                    </label>
                                </div>

                                <small id="{{ $idPiece }}-help" class="form-text text-muted">
                                    PDF, JPG ou PNG — 5 Mo maximum.
                                </small>

                                <div class="piece-selected-info mt-2" id="piece-info-{{ $type->code }}"
                                    style="display:none;">
                                    <i class="fas fa-check-circle text-success mr-1" aria-hidden="true"></i>
                                    <span class="font-weight-bold piece-name"></span>
                                    <span class="text-muted piece-size-info"></span>
                                </div>

                                <small class="text-danger d-block mt-1 piece-error" role="alert"
                                    @unless ($errors->has($champ)) style="display:none;" @endunless>
                                    @error($champ){{ $message }}@enderror
                                </small>
                            </div>
                        @empty
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>
                                Aucune pièce justificative n'est configurée pour cette formation.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ==================================================
                     CONFIRMATION
                =================================================== --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                class="custom-control-input @error('confirmation') is-invalid @enderror"
                                id="confirmation" name="confirmation" value="1"
                                {{ old('confirmation') ? 'checked' : '' }} required>

                            <label class="custom-control-label" for="confirmation">
                                Je confirme vouloir candidater à cette session de formation.
                            </label>
                        </div>

                        @error('confirmation')
                            <small class="text-danger d-block mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- ==================================================
                     BOUTONS
                =================================================== --}}
                <div class="d-flex justify-content-between mb-5">
                    <a href="{{ route('admin.inscription.create') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-success btn-lg" id="btn-submit"
                        data-locked="{{ $complet ? '1' : '0' }}" disabled>
                        <i class="fas fa-check mr-1" aria-hidden="true"></i>
                        <span id="btn-submit-label">Confirmer mon inscription</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ======================================================
             SIDEBAR
        ======================================================= --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2" aria-hidden="true"></i>
                        Résumé de la session
                    </h5>
                </div>

                <div class="card-body">
                    <h5 class="text-primary">{{ $formation?->titre ?? 'Formation' }}</h5>

                    <hr>

                    <div class="mb-3">
                        <i class="fas fa-calendar-alt mr-2 text-primary" aria-hidden="true"></i>
                        <strong>Dates</strong><br>
                        <span class="ml-4">
                            {{ $session->date_debut?->format('d/m/Y') ?? '—' }}
                            →
                            {{ $session->date_fin?->format('d/m/Y') ?? '—' }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt mr-2 text-danger" aria-hidden="true"></i>
                        <strong>Lieu</strong><br>
                        <span class="ml-4">{{ $session->lieu ?? 'Non précisé' }}</span>
                    </div>

                    <div class="mb-3">
                        <i class="fas fa-users mr-2 text-primary" aria-hidden="true"></i>
                        <strong>Places disponibles</strong><br>
                        <span class="ml-4 badge {{ $badgeClass }}">
                            {{ $placesDispo }} / {{ $placesTotales }}
                        </span>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $tauxOccupation }}%" aria-valuenow="{{ $tauxOccupation }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-circle mr-2" aria-hidden="true"></i>
                        Vérifiez vos documents avant de confirmer votre candidature.
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .piece-upload {
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background: #fafafa;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .piece-upload:hover {
            background: #f5f5f5;
        }

        .piece-upload-ok {
            border-color: #28a745;
            background: #f4fbf6;
        }

        .piece-selected-info {
            font-size: 0.875rem;
        }

        .custom-file-label {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .sticky-top {
            z-index: 10;
        }

        #btn-submit:disabled {
            cursor: not-allowed;
            opacity: 0.65;
        }

        @media (max-width: 991px) {
            .sticky-top {
                position: static !important;
                margin-top: 20px;
            }
        }
    </style>

    {{-- Script inline (pas de @push) : il ne dépend ni d'un @stack('scripts') dans le layout,
         ni de l'événement DOMContentLoaded (déjà passé si la page est injectée dynamiquement). --}}
    <script>
        (function() {
            const init = function() {

                // ----------------------------------------------------
                // Compteur de caractères pour le commentaire
                // ----------------------------------------------------
                const commentaire = document.getElementById('commentaire');
                const compteur = document.getElementById('commentaire-count');

                const majCompteur = () => {
                    if (commentaire && compteur) {
                        compteur.textContent = commentaire.value.length;
                    }
                };

                if (commentaire) {
                    majCompteur();
                    commentaire.addEventListener('input', majCompteur);
                }

                // ----------------------------------------------------
                // Taille de fichier lisible
                // ----------------------------------------------------
                const formatTaille = (octets) => {
                    if (octets < 1024) return octets + ' o';
                    if (octets < 1024 * 1024) return (octets / 1024).toFixed(0) + ' Ko';
                    return (octets / (1024 * 1024)).toFixed(1) + ' Mo';
                };

                // ----------------------------------------------------
                // Champs de fichiers : nom affiché + validation taille
                // ----------------------------------------------------
                document.querySelectorAll('.custom-file-input').forEach(function(input) {

                    const wrapper = input.closest('.piece-upload');
                    const label = wrapper ? wrapper.querySelector('.custom-file-label') : null;
                    const infoBox = wrapper ? wrapper.querySelector('.piece-selected-info') : null;
                    const infoName = infoBox ? infoBox.querySelector('.piece-name') : null;
                    const infoSize = infoBox ? infoBox.querySelector('.piece-size-info') : null;
                    const errorBox = wrapper ? wrapper.querySelector('.piece-error') : null;
                    const maxSize = parseInt(input.dataset.maxSize || '5242880', 10);
                    const labelDefault = 'Choisir un fichier…';

                    const afficherErreur = (message) => {
                        if (!errorBox) return;
                        errorBox.textContent = message;
                        errorBox.style.display = message ? 'block' : 'none';
                    };

                    const resetChamp = () => {
                        if (label) label.textContent = labelDefault;
                        if (infoBox) infoBox.style.display = 'none';
                        if (wrapper) wrapper.classList.remove('piece-upload-ok');
                    };

                    input.addEventListener('change', function() {

                        const file = this.files[0];

                        afficherErreur('');
                        this.classList.remove('is-invalid');

                        if (!file) {
                            resetChamp();
                            return;
                        }

                        if (file.size > maxSize) {
                            this.value = '';
                            resetChamp();
                            this.classList.add('is-invalid');
                            afficherErreur('Le fichier « ' + file.name +
                                '» dépasse la taille maximale autorisée (5 Mo).');
                            return;
                        }

                        if (label) label.textContent = file.name;

                        if (infoBox && infoName && infoSize) {
                            infoName.textContent = file.name;
                            infoSize.textContent = ' (' + formatTaille(file.size) + ')';
                            infoBox.style.display = 'block';
                        }

                        if (wrapper) wrapper.classList.add('piece-upload-ok');
                    });
                });

                // ----------------------------------------------------
                // Activer le bouton uniquement si la case est cochée
                // (et si la session n'est pas complète)
                // ----------------------------------------------------
                const confirmation = document.getElementById('confirmation');
                const btnSubmit = document.getElementById('btn-submit');

                const majBoutonSubmit = () => {
                    if (confirmation && btnSubmit) {
                        const verrouille = btnSubmit.dataset.locked === '1';
                        btnSubmit.disabled = verrouille || !confirmation.checked;
                    }
                };

                if (confirmation) {
                    majBoutonSubmit();
                    confirmation.addEventListener('change', majBoutonSubmit);
                }

                // ----------------------------------------------------
                // Validation + anti double envoi
                // ----------------------------------------------------
                const form = document.getElementById('form-inscription');
                const btnLabel = document.getElementById('btn-submit-label');

                if (form && btnSubmit) {
                    form.addEventListener('submit', function(event) {

                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');

                            const premierInvalide = form.querySelector(':invalid');
                            if (premierInvalide) {
                                premierInvalide.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                premierInvalide.focus({ preventScroll: true });
                            }
                            return;
                        }

                        btnSubmit.disabled = true;
                        if (btnLabel) btnLabel.textContent = 'Envoi en cours…';
                        btnSubmit.insertAdjacentHTML(
                            'afterbegin',
                            '<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>'
                        );
                    });
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>

</x-admin>