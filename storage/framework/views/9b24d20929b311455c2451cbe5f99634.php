
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
    <?php $__env->startSection('title', 'Matières'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-success"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if(session('erreur_matiere')): ?>
        <div class="alert alert-danger"><?php echo e(session('erreur_matiere')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Matières</h3>
            <div class="card-tools">
                <form action="<?php echo e(route('admin.matieres.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:5px;">
                    <div class="input-group input-group-sm" style="width:200px;">
                        <select name="filiere_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Toutes les filières</option>
                            <?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($fl->id); ?>" <?php echo e(request('filiere_id') == $fl->id ? 'selected' : ''); ?>><?php echo e($fl->nom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </form>
                <form action="<?php echo e(route('admin.matieres.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:260px;">
                        <input type="text" name="recherche" value="<?php echo e(request('recherche')); ?>" class="form-control"
                            placeholder="Rechercher une matière…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default" title="Rechercher">
                                <i class="fas fa-search"></i>
                            </button>
                            <?php if(request('recherche')): ?>
                                <a href="<?php echo e(route('admin.matieres.index')); ?>" class="btn btn-default" title="Réinitialiser la recherche">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?>
                        </span>
                    </div>
                </form>
                <a href="<?php echo e(route('admin.matieres.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle matière
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NOM</th>
                            <th>CODE</th>
                            <th>FILIÈRE</th>
                            <th>COEFFICIENT</th>
                            <th>VOLUME HORAIRE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($matiere->nom); ?></td>
                                <td><code><?php echo e($matiere->code ?? '—'); ?></code></td>
                                <td><?php echo e($matiere->filiere->nom ?? '—'); ?></td>
                                <td><?php echo e($matiere->coefficient); ?></td>
                                <td><?php echo e($matiere->volume_horaire ?? '—'); ?> h</td>
                                <td>
                                    <a href="<?php echo e(route('admin.matieres.edit', $matiere)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.matieres.destroy', $matiere)); ?>" method="POST" style="display:inline-block;"
                                        class="delete-matiere-form"
                                        data-matiere-nom="<?php echo e($matiere->nom); ?>">
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
                                <td colspan="6" class="text-center text-muted">Aucune matière trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($matieres->links()); ?>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.delete-matiere-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const nom = form.getAttribute('data-matiere-nom');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer cette matière ?',
                        text: 'La matière « ' + nom + ' » sera définitivement supprimée.',
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
<?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/admin/matieres/index.blade.php ENDPATH**/ ?>