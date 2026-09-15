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
            $(function() {

                /* ===================== DATATABLE ===================== */
                let table = $('#usersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.user.index') }}",
                        data: function(d) {
                            d.role = $('#filterRole').val();
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
