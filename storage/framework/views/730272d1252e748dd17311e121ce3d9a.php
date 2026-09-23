<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', 'Gestion des Utilisateurs'); ?>

    
    <div class="row mb-3 align-items-end">

        <div class="col-md-3">
            <label class="fw-bold">Rôle</label>
            <select id="filterRole" class="form-select">
                <option value="">Tous</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->name); ?>"><?php echo e($role->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-2 text-end">
            <button class="btn btn-primary btn-sm fw-bold shadow" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-plus-circle"></i> Ajouter
            </button>
        </div>
    </div>

    
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

            
            <div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
        </div>
    </div>

    
    <?php echo $__env->make('admin.user.partials.add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.user.partials.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.user.partials.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php $__env->startSection('css'); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <?php $__env->stopSection(); ?>

    
    <?php $__env->startSection('js'); ?>
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
                        url: "<?php echo e(route('admin.user.index')); ?>",
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
                    $.post("<?php echo e(route('admin.user.store')); ?>", $(this).serialize(), function() {
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
                        url: "<?php echo e(url('/admin/users')); ?>/" + id,
                        type: "DELETE",
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>"
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
    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\user\index.blade.php ENDPATH**/ ?>