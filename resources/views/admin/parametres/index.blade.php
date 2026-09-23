<x-admin>
    @section('title', 'Paramètres du Site')

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Erreurs :</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ===================== EN-TÊTE ===================== --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="fas fa-cogs text-primary"></i> Paramètres du Site
                    </h2>
                    <p class="text-muted">Gérez les informations générales de votre site web</p>
                </div>
                @if($parametres)
                    <div>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteParametresModal">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ===================== ALERTE SI AUCUN PARAMÈTRE ===================== --}}
    @if(!$parametres)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Aucun paramètre trouvé !</strong> Veuillez créer les paramètres du site.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ===================== FORMULAIRE ===================== --}}
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-edit"></i>
                {{ $parametres ? 'Modifier les paramètres' : 'Ajouter les paramètres' }}
            </h3>
        </div>

        <div class="card-body">
            <form id="parametresForm" method="POST" action="{{ $parametres ? route('admin.parametres.update', $parametres->id) : route('admin.parametres.store') }}" enctype="multipart/form-data">
                @csrf
                @if($parametres)
                    @method('PUT')
                @endif

                <div class="row">
                    {{-- ==================== SECTION IDENTITÉ ==================== --}}
                    <div class="col-md-12">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-info-circle"></i> Informations Générales
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nom_site" class="form-label fw-bold">
                            Nom du site <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('nom_site') is-invalid @enderror"
                               id="nom_site" name="nom_site"
                               value="{{ old('nom_site', $parametres->nom_site ?? '') }}"
                               placeholder="Ex: ENEF - École Nationale des Eaux et Forêts" required>
                        @error('nom_site')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slogan" class="form-label fw-bold">Slogan</label>
                        <input type="text" class="form-control @error('slogan') is-invalid @enderror"
                               id="slogan" name="slogan"
                               value="{{ old('slogan', $parametres->slogan ?? '') }}"
                               placeholder="Ex: Former les gestionnaires des ressources naturelles">
                        @error('slogan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="logo_url" class="form-label fw-bold">Logo du site</label>
                        <input type="file" class="form-control @error('logo_url') is-invalid @enderror"
                               id="logo_url" name="logo_url" accept="image/*">
                        @error('logo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($parametres && $parametres->logo_url)
                            <div class="mt-2">
                                <img src="{{ asset($parametres->logo_url) }}" alt="Logo" style="max-height: 80px;" class="border rounded p-1">
                                <small class="text-muted d-block">Logo actuel</small>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="favicon_url" class="form-label fw-bold">Favicon</label>
                        <input type="file" class="form-control @error('favicon_url') is-invalid @enderror"
                               id="favicon_url" name="favicon_url" accept="image/*">
                        @error('favicon_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($parametres && $parametres->favicon_url)
                            <div class="mt-2">
                                <img src="{{ asset($parametres->favicon_url) }}" alt="Favicon" style="max-height: 40px;" class="border rounded p-1">
                                <small class="text-muted d-block">Favicon actuel</small>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="meta_description" class="form-label fw-bold">Meta Description (SEO)</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="2"
                                  placeholder="Description pour le référencement (max 255 caractères)">{{ old('meta_description', $parametres->meta_description ?? '') }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Maximum 255 caractères</small>
                    </div>

                    {{-- ==================== SECTION MOT DU DG ==================== --}}
                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-user-tie"></i> Message du Directeur Général
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mot_dg_titre" class="form-label fw-bold">Titre du message</label>
                        <input type="text" class="form-control @error('mot_dg_titre') is-invalid @enderror"
                               id="mot_dg_titre" name="mot_dg_titre"
                               value="{{ old('mot_dg_titre', $parametres->mot_dg_titre ?? '') }}"
                               placeholder="Ex: Message du Directeur Général">
                        @error('mot_dg_titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mot_dg_nom" class="form-label fw-bold">Nom du Directeur Général</label>
                        <input type="text" class="form-control @error('mot_dg_nom') is-invalid @enderror"
                               id="mot_dg_nom" name="mot_dg_nom"
                               value="{{ old('mot_dg_nom', $parametres->mot_dg_nom ?? '') }}"
                               placeholder="Ex: Dr. Oumar Diallo">
                        @error('mot_dg_nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="mot_dg_contenu" class="form-label fw-bold">Contenu du message</label>
                        <textarea class="form-control @error('mot_dg_contenu') is-invalid @enderror"
                                  id="mot_dg_contenu" name="mot_dg_contenu" rows="5"
                                  placeholder="Écrivez le message du Directeur Général ici...">{{ old('mot_dg_contenu', $parametres->mot_dg_contenu ?? '') }}</textarea>
                        @error('mot_dg_contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="mot_dg_photo_url" class="form-label fw-bold">Photo du Directeur Général</label>
                        <input type="file" class="form-control @error('mot_dg_photo_url') is-invalid @enderror"
                               id="mot_dg_photo_url" name="mot_dg_photo_url" accept="image/*">
                        @error('mot_dg_photo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($parametres && $parametres->mot_dg_photo_url)
                            <div class="mt-2">
                                <img src="{{ asset($parametres->mot_dg_photo_url) }}" alt="Photo DG" style="max-height: 100px;" class="border rounded p-1">
                                <small class="text-muted d-block">Photo actuelle</small>
                            </div>
                        @endif
                    </div>

                    {{-- ==================== SECTION CONTACT ==================== --}}
                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-address-card"></i> Coordonnées
                        </h5>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="adresse" class="form-label fw-bold">Adresse</label>
                        <input type="text" class="form-control @error('adresse') is-invalid @enderror"
                               id="adresse" name="adresse"
                               value="{{ old('adresse', $parametres->adresse ?? '') }}"
                               placeholder="Ex: Route de Rufisque, Dakar, Sénégal">
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label fw-bold">Téléphone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                               id="telephone" name="telephone"
                               value="{{ old('telephone', $parametres->telephone ?? '') }}"
                               placeholder="Ex: +221 33 859 12 34">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email_contact" class="form-label fw-bold">Email de contact</label>
                        <input type="email" class="form-control @error('email_contact') is-invalid @enderror"
                               id="email_contact" name="email_contact"
                               value="{{ old('email_contact', $parametres->email_contact ?? '') }}"
                               placeholder="Ex: contact@enef.sn">
                        @error('email_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="contact_rh" class="form-label fw-bold">Contact ressources humaines</label>
                        <input type="text" class="form-control @error('contact_rh') is-invalid @enderror"
                               id="contact_rh" name="contact_rh"
                               value="{{ old('contact_rh', $parametres->contact_rh ?? '') }}"
                               placeholder="Ex: (00226) 20 98 06 89">
                        @error('contact_rh')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ==================== SECTION STATISTIQUES ==================== --}}
                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-chart-bar"></i> Statistiques
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="annee_creation" class="form-label fw-bold">Année de création</label>
                        <input type="number" class="form-control @error('annee_creation') is-invalid @enderror"
                               id="annee_creation" name="annee_creation"
                               value="{{ old('annee_creation', $parametres->annee_creation ?? '') }}"
                               placeholder="Ex: 1985" min="1900" max="{{ date('Y') }}">
                        @error('annee_creation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="personne_forme" class="form-label fw-bold">Nombre de personnes formées</label>
                        <input type="number" class="form-control @error('personne_forme') is-invalid @enderror"
                               id="personne_forme" name="personne_forme"
                               value="{{ old('personne_forme', $parametres->personne_forme ?? '') }}"
                               placeholder="Ex: 2500" min="0">
                        @error('personne_forme')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ==================== SECTION RÉSEAUX SOCIAUX ==================== --}}
                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-share-alt"></i> Réseaux Sociaux
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="facebook_url" class="form-label fw-bold">
                            <i class="fab fa-facebook text-primary"></i> Facebook
                        </label>
                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                               id="facebook_url" name="facebook_url"
                               value="{{ old('facebook_url', $parametres->facebook_url ?? '') }}"
                               placeholder="https://facebook.com/enef.sn">
                        @error('facebook_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="linkedin_url" class="form-label fw-bold">
                            <i class="fab fa-linkedin text-primary"></i> LinkedIn
                        </label>
                        <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                               id="linkedin_url" name="linkedin_url"
                               value="{{ old('linkedin_url', $parametres->linkedin_url ?? '') }}"
                               placeholder="https://linkedin.com/company/enef-sn">
                        @error('linkedin_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ==================== SECTION LIENS UTILES ==================== --}}
                    <div class="col-md-12 mt-4">
                        <h5 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-link"></i> Liens utiles
                        </h5>
                        <p class="text-muted mb-3">
                            Liens affichés dans le pied de page du site (ministères, institutions, plateformes…).
                            Laissez une ligne vide pour la supprimer.
                        </p>
                    </div>

                    <div class="col-12 mb-3">
                        @php
                            $liensActuels = [];
                            if (old('liens_utiles.titre') !== null) {
                                $oldTitres = (array) old('liens_utiles.titre');
                                $oldUrls = (array) (request()->old('liens_utiles.url') ?? []);
                                foreach ($oldTitres as $i => $t) {
                                    $liensActuels[] = ['titre' => $t, 'url' => $oldUrls[$i] ?? ''];
                                }
                            } else {
                                $liensActuels = $parametres->liens_utiles ?? [];
                            }
                        @endphp

                        <div id="liensUtilesList">
                            @forelse($liensActuels as $lien)
                                <div class="row g-2 lien-utile-row mb-2">
                                    <div class="col-md-5">
                                        <input type="text" name="liens_utiles[titre][]" class="form-control"
                                               placeholder="Titre du lien (ex: Gouvernement du Faso)"
                                               value="{{ $lien['titre'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="liens_utiles[url][]" class="form-control"
                                               placeholder="https://www.exemple.bf"
                                               value="{{ $lien['url'] ?? '' }}">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-remove-lien"
                                                title="Supprimer ce lien">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted small" id="aucunLienUtile">
                                    Aucun lien configuré pour le moment.
                                </div>
                            @endforelse
                        </div>

                        <button type="button" id="btnAjouterLien" class="btn btn-outline-primary btn-sm mt-1">
                            <i class="fas fa-plus"></i> Ajouter un lien
                        </button>
                        @error('liens_utiles.url.*')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ==================== DERNIÈRE MODIFICATION ==================== --}}
                    @if($parametres && $parametres->updatedBy)
                        <div class="col-12 mt-3">
                            <hr>
                            <p class="text-muted mb-0">
                                <i class="fas fa-user-edit"></i>
                                Dernière modification par : <strong>{{ $parametres->updatedBy->name ?? 'Inconnu' }}</strong>
                                <span class="mx-2">|</span>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $parametres->updated_at ? $parametres->updated_at->format('d/m/Y à H:i') : 'Non défini' }}
                            </p>
                        </div>
                    @endif

                    {{-- ==================== BOUTONS ==================== --}}
                    <div class="col-12 mt-4">
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary fw-bold">
                                <i class="fas fa-save"></i>
                                {{ $parametres ? 'Mettre à jour' : 'Enregistrer' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ==================== MODAL DE SUPPRESSION ==================== --}}
    @if($parametres)
        <div class="modal fade" id="deleteParametresModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle"></i> Confirmation de suppression
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold">Êtes-vous sûr de vouloir supprimer tous les paramètres du site ?</p>
                        <p class="text-muted">Cette action est irréversible et supprimera également les fichiers associés (logo, favicon, photo).</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form id="deleteParametresForm" method="POST" action="{{ route('admin.parametres.destroy', $parametres->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer définitivement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ==================== CONTENEUR TOAST ==================== --}}
    <div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

    {{-- ==================== CSS ==================== --}}
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <style>
            .form-label {
                font-weight: 600;
            }
            .card {
                border-radius: 10px;
                overflow: hidden;
            }
            .card-header {
                border-bottom: 3px solid rgba(255,255,255,0.2);
            }
            .border-bottom {
                border-bottom: 2px solid #dee2e6 !important;
            }
            .text-primary {
                color: #0d6efd !important;
            }
            .btn-primary {
                background: linear-gradient(135deg, #0d6efd, #0a58ca);
                border: none;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #0a58ca, #084298);
            }
            .alert {
                border-radius: 10px;
            }
        </style>
    @endsection

    {{-- ==================== JS ==================== --}}
    @section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Définir le token CSRF globalement
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {

            /* ===================== SOUMISSION FORMULAIRE ===================== */
            $('#parametresForm').on('submit', function(e) {
                e.preventDefault();

                // Récupérer le token CSRF du formulaire ou du meta tag
                let csrfToken = $('input[name="_token"]').val() || $('meta[name="csrf-token"]').attr('content');

                let formData = new FormData(this);
                // Ajouter explicitement le token CSRF
                formData.append('_token', csrfToken);

                let url = $(this).attr('action');
                // Toujours en POST : la vraie méthode (PUT pour la modification) est transmise
                // via le champ caché `_method` du formulaire. Un PUT ajax + FormData multiplart
                // n'est pas parsé par PHP ($_POST vide) → ni CSRF ni validation ne passent.
                let method = 'POST';

                let submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> En cours...');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        showToast(response.message || 'Paramètres enregistrés avec succès !', 'success');

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        // Gérer spécifiquement l'erreur CSRF
                        if (xhr.status === 419) {
                            showToast('La session a expiré. Veuillez rafraîchir la page et réessayer.', 'error');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                            return;
                        }

                        let errors = xhr.responseJSON?.errors || xhr.responseJSON?.message || 'Erreur lors de l\'enregistrement !';

                        if (typeof errors === 'object') {
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += '• ' + value[0] + '\n';
                            });
                            showToast(errorMessages, 'error');
                        } else {
                            showToast(errors, 'error');
                        }

                        console.log('Erreur AJAX:', xhr.responseJSON);

                        submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> {{ $parametres ? "Mettre à jour" : "Enregistrer" }}');
                    }
                });
            });

            /* ===================== TOAST ===================== */
            function showToast(message, type = 'success') {
                let colors = {
                    success: 'bg-success text-white',
                    error: 'bg-danger text-white',
                    info: 'bg-info text-white',
                    warning: 'bg-warning text-dark'
                };

                let icon = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    info: 'fa-info-circle',
                    warning: 'fa-exclamation-triangle'
                };

                let formattedMessage = message.replace(/\n/g, '<br>');

                let toast = $(`
                    <div class="toast ${colors[type]} p-3 mb-2 rounded shadow-lg" role="alert" style="display:none; min-width: 300px; border-radius: 8px;">
                        <div class="d-flex align-items-start">
                            <div class="me-2 fs-5">
                                <i class="fas ${icon[type]}"></i>
                            </div>
                            <div class="flex-grow-1">
                                ${formattedMessage}
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `);

                $('#toastContainer').append(toast);
                toast.fadeIn(300);

                setTimeout(() => {
                    toast.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            /* ===================== LIENS UTILES : AJOUT / RETRAIT ===================== */
            function nouvelleLigneLien(titre = '', url = '') {
                return $(`
                    <div class="row g-2 lien-utile-row mb-2">
                        <div class="col-md-5">
                            <input type="text" name="liens_utiles[titre][]" class="form-control"
                                   placeholder="Titre du lien (ex: Gouvernement du Faso)" value="${titre}">
                        </div>
                        <div class="col-md-6">
                            <input type="url" name="liens_utiles[url][]" class="form-control"
                                   placeholder="https://www.exemple.bf" value="${url}">
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-lien"
                                    title="Supprimer ce lien">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `);
            }

            $('#btnAjouterLien').on('click', function() {
                $('#aucunLienUtile').remove();
                $('#liensUtilesList').append(nouvelleLigneLien());
            });

            $('#liensUtilesList').on('click', '.btn-remove-lien', function() {
                $(this).closest('.lien-utile-row').remove();
                if ($('.lien-utile-row').length === 0) {
                    $('#liensUtilesList').append('<div class="text-muted small" id="aucunLienUtile">Aucun lien configuré pour le moment.</div>');
                }
            });

        });
    </script>
@endsection
</x-admin>
