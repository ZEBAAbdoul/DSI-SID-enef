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
     <?php $__env->slot('title', null, []); ?> Informations complémentaires <?php $__env->endSlot(); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Informations complémentaires</h1>
        <a href="<?php echo e(route('admin.formation-informations.create')); ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> Ajouter une information
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card mb-4">
            <div class="card-header">
                <strong><?php echo e($label); ?></strong>
            </div>
            <div class="card-body p-0">
                <?php if(($informations[$key] ?? collect())->isEmpty()): ?>
                    <p class="text-muted p-3 mb-0">Aucune information dans cette catégorie.</p>
                <?php else: ?>
                    <table class="table table-hover mb-0">
    <thead>
        <tr>
            <th style="width: 60px;">Ordre</th>
            <th>Libellé</th>
            <th>Valeur</th>
            <th style="width: 140px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $informations[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $information): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($information->ordre); ?></td>
                <td><?php echo e($information->libelle); ?></td>
                <td><?php echo e($information->valeur ?? '—'); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.formation-informations.edit', $information)); ?>"
                       class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-pen"></i>
                    </a>
                    <button type="button"
                            class="btn btn-sm btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal-<?php echo e($information->id); ?>">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

                    
                    <?php $__currentLoopData = $informations[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $information): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="modal fade" id="deleteModal-<?php echo e($information->id); ?>" tabindex="-1"
                             aria-labelledby="deleteModalLabel-<?php echo e($information->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel-<?php echo e($information->id); ?>">
                                            Confirmer la suppression
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer
                                        <strong>« <?php echo e($information->libelle); ?> »</strong> ?
                                        <br>
                                        <span class="text-muted small">Cette action est irréversible.</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                            Annuler
                                        </button>
                                        <form action="<?php echo e(route('admin.formation-informations.destroy', $information)); ?>"
                                              method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-muted">Aucune catégorie configurée.</p>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\formation-informations\index.blade.php ENDPATH**/ ?>