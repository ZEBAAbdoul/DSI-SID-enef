<x-admin>
    @section('title', 'Gestion des Utilisateurs')

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
            <button class="btn btn-primary btn-sm fw-bold shadow" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus-circle"></i> Ajouter
            </button>
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
    @include('admin.user.partials.add')
    @include('admin.user.partials.edit')
    @include('admin.user.partials.delete')

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

                /* ===================== ACTIVER / DÉSACTIVER ===================== */
                $(document).on('change', '.toggleActifBtn', function() {
                    const checkbox = this;
                    const $cb = $(this);
                    const id = $cb.data('id');
                    const activer = checkbox.checked;

                    const message = activer ?
                        'Activer ce compte ?' :
                        'Désactiver ce compte ? L\'utilisateur ne pourra plus se connecter.';

                    if (!confirm(message)) {
                        checkbox.checked = !activer; // annulation : on remet l'interrupteur
                        return;
                    }

                    $cb.prop('disabled', true);

                    $.ajax({
                        url: "{{ url('/admin/users') }}/" + id + "/toggle-actif",
                        type: "PATCH",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            showToast(res.message || "Statut mis à jour !", "success");
                            table.ajax.reload(null, false); // garde la page courante
                        },
                        error: function(xhr) {
                            checkbox.checked = !activer;
                            $cb.prop('disabled', false);
                            showToast(
                                (xhr.responseJSON && xhr.responseJSON.message) ||
                                "Erreur lors de la mise à jour du statut !",
                                "error"
                            );
                        }
                    });
                });

                /* ===================== ADD USER ===================== */
                $('#addUserForm').submit(function(e) {
                    e.preventDefault();
                    $.post("{{ route('admin.user.store') }}", $(this).serialize(), function() {
                        $('#addUserModal').modal('hide');
                        $('#usersTable').DataTable().ajax.reload();
                        showToast("Utilisateur ajouté avec succès !", "success");
                    }).fail(function(err) {
                        showToast("Erreur lors de l'ajout !", "error");
                        console.log(err);
                    });
                });



                /* ===================== EDIT USER ===================== */
                $(document).on('click', '.editUserBtn', function() {
                    let id = $(this).data('id');

                    // Remplir le formulaire avec les données du tableau
                    let row = $(this).closest('tr');
                    let name = row.find('td:eq(1)').text().trim();
                    let email = row.find('td:eq(2)').text().trim();
                    let role = row.find('td:eq(3) .badge').first().text().trim();

                    $('#editUserForm').attr('action', '/admin/users/' + id);
                    $('#editUserId').val(id);
                    $('#editName').val(name);
                    $('#editEmail').val(email);
                    $('#editRole').val(role);
                    $('#editUserModal').modal('show');
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
                            showToast("Erreur lors de la suppression !", "error");
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