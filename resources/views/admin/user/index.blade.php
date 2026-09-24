<x-admin>
    @section('title', 'Gestion des Utilisateurs')

    {{-- Messages flash (retour des pages create / edit) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- ===================== FILTRES ===================== --}}
    <div class="row mb-3 align-items-end">

        <div class="col-md-3">
            <label class="fw-bold">Rôle</label>
            <select id="filterRole" class="form-select">
                <option value="">Tous</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="fw-bold">Statut</label>
            <select id="filterStatut" class="form-select">
                <option value="">Tous</option>
                <option value="actif">Actifs</option>
                <option value="inactif">Désactivés</option>
            </select>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-2 text-end">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm fw-bold shadow">
                <i class="fas fa-plus-circle"></i> Ajouter
            </a>
        </div>
    </div>

    {{-- ===================== TABLE ===================== --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-list"></i> Liste des utilisateurs
            </h3>
        </div>

        <div class="card-body">
            <table id="usersTable" class="table table-bordered table-striped table-hover nowrap w-100">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle(s)</th>
                        <th>Statut</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            {{-- Conteneur pour les toasts --}}
            <div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
        </div>
    </div>

    {{-- ===================== MODALS ===================== --}}
    @include('admin.user.partials.delete')

    {{-- Modal : réinitialiser le mot de passe (2 étapes : confirmation, puis affichage du mot de passe) --}}
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordTitle"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-warning" id="resetPasswordHeader">
                    <h5 class="modal-title" id="resetPasswordTitle">
                        <i class="fas fa-key me-2 mr-2"></i>
                        <span id="resetPasswordTitleText">Réinitialiser le mot de passe ?</span>
                    </h5>
                    <button type="button" class="btn-close" id="resetCloseX" data-bs-dismiss="modal"
                        aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <div id="resetError" class="alert alert-danger d-none" role="alert"></div>

                    {{-- Étape 1 : confirmation --}}
                    <div id="resetStepConfirm">
                        <p class="mb-2">Vous êtes sur le point de réinitialiser le mot de passe du compte suivant :
                        </p>

                        <div class="border rounded p-2 bg-light">
                            <div class="fw-bold" id="resetName"></div>
                            <div class="text-muted small" id="resetEmail"></div>
                        </div>

                        <p class="small text-muted mt-3 mb-0">
                            Le mot de passe actuel sera remplacé par le mot de passe par défaut de l'ENEF.
                            Les connexions « Se souvenir de moi » de cet utilisateur seront invalidées.
                        </p>
                    </div>

                    {{-- Étape 2 : résultat (le mot de passe n'est jamais présent dans le HTML de la page) --}}
                    <div id="resetStepDone" class="d-none">
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-1"></i> Le mot de passe a été réinitialisé.
                        </div>

                        <label class="form-label fw-bold">Nouveau mot de passe temporaire</label>
                        <div class="d-flex align-items-center gap-2">
                            <code id="resetPwdValue"
                                class="fs-5 px-3 py-2 bg-light border rounded flex-grow-1 user-select-all"></code>
                            <button type="button" class="btn btn-outline-secondary" id="resetCopyBtn">
                                <i class="fas fa-copy me-1"></i> Copier
                            </button>
                        </div>

                        <p class="small text-muted mt-3 mb-0">
                            Communiquez-le à l'utilisateur de façon sécurisée et invitez-le à le modifier
                            depuis son profil dès sa prochaine connexion.
                        </p>
                    </div>
                </div>

                <div class="modal-footer" id="resetFooterConfirm">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        id="resetCancelBtn">Annuler</button>
                    <button type="button" class="btn btn-warning" id="resetConfirmBtn">
                        <span class="spinner-border spinner-border-sm me-1 mr-1 d-none" id="resetSpinner"
                            role="status" aria-hidden="true"></span>
                        <span id="resetConfirmLabel">Réinitialiser</span>
                    </button>
                </div>

                <div class="modal-footer d-none" id="resetFooterDone">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal de confirmation : activer / désactiver un compte (contenu rempli en JS) --}}
    <div class="modal fade" id="toggleActifModal" tabindex="-1" aria-labelledby="toggleActifTitle"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header text-white" id="toggleActifHeader">
                    <h5 class="modal-title" id="toggleActifTitle">
                        <i id="toggleActifIcon" class="fas me-2 mr-2"></i>
                        <span id="toggleActifTitleText"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    {{-- Erreur renvoyée par le serveur (le modal reste ouvert) --}}
                    <div id="toggleActifError" class="alert alert-danger d-none" role="alert"></div>

                    <p class="mb-2" id="toggleActifText"></p>

                    <div class="border rounded p-2 bg-light">
                        <div class="fw-bold" id="toggleActifName"></div>
                        <div class="text-muted small" id="toggleActifEmail"></div>
                    </div>

                    <p class="small text-muted mt-3 mb-0" id="toggleActifNote"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        id="toggleActifCancel">Annuler</button>
                    <button type="button" class="btn" id="toggleActifConfirm">
                        <span class="spinner-border spinner-border-sm me-1 mr-1 d-none" id="toggleActifSpinner"
                            role="status" aria-hidden="true"></span>
                        <span id="toggleActifConfirmLabel"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ===================== CSS ===================== --}}
    @section('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    @endsection

    {{-- ===================== JS ===================== --}}
    @section('js')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

        <script>
            // Identifiant de l'utilisateur connecté : il ne peut pas désactiver son propre compte
            const currentUserId = @json((string) auth()->id());

            $(function() {

                /* ===================== DATATABLE ===================== */
                let table = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.user.index') }}",
                        data: function(d) {
                            d.role = $('#filterRole').val();
                            d.statut = $('#filterStatut').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'roles',
                            orderable: false,
                            searchable: false
                        },
                        {
                            // Statut : interrupteur + badge (nécessite `est_actif` dans le JSON du contrôleur)
                            data: 'est_actif',
                            name: 'est_actif',
                            searchable: false,
                            render: function(data, type, row) {
                                if (type !== 'display') return data;

                                const actif = (data === true || data === 1 || data === '1');
                                const estMoi = String(row.id) === String(currentUserId);

                                return `
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch mb-0 me-2 mr-2">
                                            <input class="form-check-input toggleActifBtn" type="checkbox"
                                                role="switch" data-id="${row.id}"
                                                ${actif ? 'checked' : ''}
                                                ${estMoi ? 'disabled title="Vous ne pouvez pas désactiver votre propre compte"' : ''}>
                                        </div>
                                        <span class="badge ${actif ? 'bg-success badge-success' : 'bg-danger badge-danger'}">
                                            ${actif ? 'Actif' : 'Désactivé'}
                                        </span>
                                    </div>`;
                            }
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    dom: 'Blfrtip',
                    buttons: ['colvis', 'csv', 'excel', 'pdf', 'print'],
                    responsive: true
                });

                /* ===================== FILTRES ===================== */
                $('#filterRole, #filterStatut').on('change', function() {
                    table.ajax.reload();
                });

                /* ===================== ACTIVER / DÉSACTIVER (avec modal de confirmation) ===================== */
                const toggleModalEl = document.getElementById('toggleActifModal');
                const $toggleModal = $(toggleModalEl);
                let pendingToggle = null; // { id, activer }

                function setToggleLoading(loading) {
                    $('#toggleActifConfirm, #toggleActifCancel').prop('disabled', loading);
                    $('#toggleActifSpinner').toggleClass('d-none', !loading);
                    if (loading) {
                        $('#toggleActifConfirmLabel').text('Traitement…');
                    } else if (pendingToggle) {
                        $('#toggleActifConfirmLabel').text(pendingToggle.activer ? 'Activer le compte' :
                            'Désactiver le compte');
                    }
                }

                // Message clair selon le code HTTP (aide au diagnostic)
                function describeToggleError(xhr, route) {
                    route = route || "toggle-actif";
                    const serveur = xhr.responseJSON && xhr.responseJSON.message;
                    switch (xhr.status) {
                        case 0:
                            return "Impossible de joindre le serveur. Vérifiez votre connexion.";
                        case 403:
                            return serveur || "Action non autorisée (403) : votre rôle ne permet pas cette opération.";
                        case 404:
                            return "Route ou utilisateur introuvable (404) : vérifiez que la route « " + route +
                                " » est bien déclarée.";
                        case 405:
                            return "Méthode non autorisée (405) : la route " + route + " doit accepter PATCH.";
                        case 419:
                            return "Session expirée (419) : rechargez la page puis réessayez.";
                        case 422:
                            return serveur || "Opération refusée (422).";
                        case 500:
                            return serveur ?
                                "Erreur serveur (500) : " + serveur :
                                "Erreur serveur (500) : consultez storage/logs/laravel.log.";
                        default:
                            return serveur || ("Erreur inattendue (" + xhr.status + ").");
                    }
                }

                // 1) Clic sur l'interrupteur : on annule le changement visuel et on ouvre le modal.
                //    L'état ne change réellement qu'après confirmation (rechargement du tableau).
                $(document).on('change', '.toggleActifBtn', function() {
                    const activer = this.checked;
                    this.checked = !activer;

                    const row = table.row($(this).closest('tr')).data() || {};
                    pendingToggle = {
                        id: $(this).data('id'),
                        activer: activer
                    };

                    // Contenu du modal (.text() : pas d'injection HTML)
                    $('#toggleActifName').text(row.name || '—');
                    $('#toggleActifEmail').text(row.email || '');
                    $('#toggleActifError').addClass('d-none').text('');

                    $('#toggleActifHeader')
                        .removeClass('bg-danger bg-success')
                        .addClass(activer ? 'bg-success' : 'bg-danger');
                    $('#toggleActifIcon')
                        .removeClass('fa-user-slash fa-user-check')
                        .addClass(activer ? 'fa-user-check' : 'fa-user-slash');
                    $('#toggleActifConfirm')
                        .removeClass('btn-danger btn-success')
                        .addClass(activer ? 'btn-success' : 'btn-danger');

                    $('#toggleActifTitleText').text(activer ? 'Activer ce compte ?' : 'Désactiver ce compte ?');
                    $('#toggleActifText').text(activer ?
                        'Vous êtes sur le point de réactiver le compte suivant :' :
                        'Vous êtes sur le point de désactiver le compte suivant :');
                    $('#toggleActifNote').text(activer ?
                        "L'utilisateur pourra de nouveau se connecter." :
                        "L'utilisateur ne pourra plus se connecter et sera déconnecté dès sa prochaine action. Vous pourrez le réactiver à tout moment."
                        );

                    setToggleLoading(false);
                    $toggleModal.modal('show');
                });

                // 2) Confirmation : appel AJAX
                $('#toggleActifConfirm').on('click', function() {
                    if (!pendingToggle) return;

                    setToggleLoading(true);
                    $('#toggleActifError').addClass('d-none').text('');

                    $.ajax({
                        url: "{{ url('/admin/users') }}/" + pendingToggle.id + "/toggle-actif",
                        type: "PATCH",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $toggleModal.modal('hide');
                            showToast(res.message || "Statut mis à jour !", "success");
                            table.ajax.reload(null, false); // garde la page courante
                        },
                        error: function(xhr) {
                            // Le modal reste ouvert et affiche la cause de l'échec
                            $('#toggleActifError').text(describeToggleError(xhr)).removeClass(
                                'd-none');
                            console.log(xhr);
                        },
                        complete: function() {
                            setToggleLoading(false);
                        }
                    });
                });

                // 3) Fermeture du modal : on oublie l'action en attente
                toggleModalEl.addEventListener('hidden.bs.modal', function() {
                    pendingToggle = null;
                });

                /* ===================== RÉINITIALISER LE MOT DE PASSE ===================== */
                const resetModalEl = document.getElementById('resetPasswordModal');
                const $resetModal = $(resetModalEl);
                let pendingReset = null; // { id }

                function showResetStep(step) {
                    const fait = (step === 'done');
                    $('#resetStepConfirm').toggleClass('d-none', fait);
                    $('#resetStepDone').toggleClass('d-none', !fait);
                    $('#resetFooterConfirm').toggleClass('d-none', fait);
                    $('#resetFooterDone').toggleClass('d-none', !fait);

                    $('#resetPasswordHeader')
                        .toggleClass('bg-warning', !fait)
                        .toggleClass('bg-success text-white', fait);
                    $('#resetCloseX').toggleClass('btn-close-white', fait);
                    $('#resetPasswordTitleText').text(fait ? 'Mot de passe réinitialisé' :
                        'Réinitialiser le mot de passe ?');
                }

                function setResetLoading(loading) {
                    $('#resetConfirmBtn, #resetCancelBtn').prop('disabled', loading);
                    $('#resetSpinner').toggleClass('d-none', !loading);
                    $('#resetConfirmLabel').text(loading ? 'Traitement…' : 'Réinitialiser');
                }

                // 1) Clic sur le bouton "clé" de la ligne : ouverture du modal de confirmation
                $(document).on('click', '.resetPasswordBtn', function() {
                    const row = table.row($(this).closest('tr')).data() || {};
                    pendingReset = {
                        id: $(this).data('id')
                    };

                    $('#resetName').text(row.name || '—'); // .text() : pas d'injection HTML
                    $('#resetEmail').text(row.email || '');
                    $('#resetError').addClass('d-none').text('');

                    setResetLoading(false);
                    showResetStep('confirm');
                    $resetModal.modal('show');
                });

                // 2) Confirmation : appel AJAX
                $('#resetConfirmBtn').on('click', function() {
                    if (!pendingReset) return;

                    setResetLoading(true);
                    $('#resetError').addClass('d-none').text('');

                    $.ajax({
                        url: "{{ url('/admin/users') }}/" + pendingReset.id + "/reset-password",
                        type: "PATCH",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $('#resetPwdValue').text(res.password || '');
                            showResetStep('done');
                        },
                        error: function(xhr) {
                            $('#resetError').text(describeToggleError(xhr, 'reset-password'))
                                .removeClass('d-none');
                            console.log(xhr);
                        },
                        complete: function() {
                            setResetLoading(false);
                        }
                    });
                });

                // 3) Copier le mot de passe
                $('#resetCopyBtn').on('click', function() {
                    const texte = $('#resetPwdValue').text();
                    const $btn = $(this);
                    const ok = function() {
                        $btn.html('<i class="fas fa-check me-1"></i> Copié');
                        setTimeout(function() {
                            $btn.html('<i class="fas fa-copy me-1"></i> Copier');
                        }, 2000);
                    };

                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(texte).then(ok);
                    } else {
                        // Repli (page en http)
                        const ta = document.createElement('textarea');
                        ta.value = texte;
                        document.body.appendChild(ta);
                        ta.select();
                        try {
                            document.execCommand('copy');
                            ok();
                        } catch (e) {}
                        document.body.removeChild(ta);
                    }
                });

                // 4) Fermeture : on ne garde ni l'action en attente ni le mot de passe affiché
                resetModalEl.addEventListener('hidden.bs.modal', function() {
                    pendingReset = null;
                    $('#resetPwdValue').text('');
                });

                /* ===================== DELETE USER ===================== */
                $(document).on('click', '.deleteUserBtn', function() {
                    $('#deleteUserId').val($(this).data('id'));
                    $('#deleteUserModal').modal('show');
                });

                $('#deleteUserForm').submit(function(e) {
                    e.preventDefault();
                    let id = $('#deleteUserId').val();

                    $.ajax({
                        url: "{{ url('/admin/users') }}/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            $('#deleteUserModal').modal('hide');
                            table.ajax.reload();
                            showToast("Utilisateur supprimé avec succès !", "success");
                        },
                        error: function(err) {
                            showToast(
                                (err.responseJSON && err.responseJSON.message) ||
                                "Erreur lors de la suppression !",
                                "error"
                            );
                            console.log(err);
                        }
                    });
                });

            });

            /* ===================== FUNCTION TOAST ===================== */
            function showToast(message, type = 'success') {
                let colors = {
                    success: 'bg-success text-white',
                    error: 'bg-danger text-white',
                    info: 'bg-info text-white'
                };

                let toast = $(`
                    <div class="toast ${colors[type]} p-3 mb-2 rounded" role="alert" style="display:none;">
                        ${message}
                    </div>
                `);

                $('#toastContainer').append(toast);
                toast.fadeIn();

                setTimeout(() => {
                    toast.fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000); // Durée 3 secondes
            }
        </script>
    @endsection
</x-admin>
