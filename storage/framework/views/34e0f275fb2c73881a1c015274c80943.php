
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
    <?php $__env->startSection('title', 'Types de pièces'); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Types de pièces</h3>
            <div class="card-tools">
                <form action="<?php echo e(route('admin.types-pieces.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="<?php echo e(request('recherche')); ?>" class="form-control"
                            placeholder="Rechercher un type de pièce…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="<?php echo e(route('admin.types-pieces.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouveau type de pièce
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ORDRE</th>
                            <th>CODE</th>
                            <th>LIBELLÉ</th>
                            <th>OBLIGATOIRE</th>
                            <th>ACTIF</th>
                            
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $typesPieces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typePiece): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($typePiece->ordre); ?></td>
                                <td><code><?php echo e($typePiece->code); ?></code></td>
                                <td><?php echo e($typePiece->libelle); ?></td>
                                <td>
                                    <span class="badge <?php echo e($typePiece->obligatoire ? 'badge-success' : 'badge-secondary'); ?>">
                                        <?php echo e($typePiece->obligatoire ? 'Oui' : 'Non'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($typePiece->actif ? 'badge-primary' : 'badge-danger'); ?>">
                                        <?php echo e($typePiece->actif ? 'Actif' : 'Inactif'); ?>

                                    </span>
                                </td>

                                <td>
                                    <a href="<?php echo e(route('admin.types-pieces.edit', $typePiece)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.types-pieces.destroy', $typePiece)); ?>" method="POST" style="display:inline-block;"
                                        class="delete-type-piece-form"
                                        data-type-piece-code="<?php echo e($typePiece->code); ?>"
                                        data-type-piece-libelle="<?php echo e($typePiece->libelle); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucun type de pièce trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($typesPieces->links()); ?>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if(session('status_type_piece')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '<?php echo e(session('status_type_piece')); ?>',
                    timer: 2500,
                    showConfirmButton: false,
                });
            <?php endif; ?>

            <?php if(session('erreur_type_piece')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Suppression impossible',
                    text: '<?php echo e(session('erreur_type_piece')); ?>',
                });
            <?php endif; ?>

            document.querySelectorAll('form.delete-type-piece-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const code = form.getAttribute('data-type-piece-code');
                    const libelle = form.getAttribute('data-type-piece-libelle');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer ce type de pièce ?',
                        html: 'Le type <strong>« ' + libelle + ' »</strong> (<code>' + code + '</code>) sera définitivement supprimé.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formToSubmit.submit();
                        }
                    });
                });
            });
        });
    </script>
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
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\types-pieces\index.blade.php ENDPATH**/ ?>