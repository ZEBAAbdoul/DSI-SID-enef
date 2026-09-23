<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Mes témoignages']); ?>
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">Mes témoignages</h1>
                <small class="text-muted">Partagez votre expérience à l'ENEF. Après validation par l'administration, votre témoignage apparaît sur la page d'accueil.</small>
            </div>
            <a href="<?php echo e(route('admin.mes-temoignages.create')); ?>" class="btn btn-success">
                <i class="fas fa-pen"></i> Écrire un témoignage
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php $__empty_1 = true; $__currentLoopData = $temoignages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temoignage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:10px;">
                        <div>
                            <span class="text-warning">
                                <?php echo e(str_repeat('★', $temoignage->note)); ?><?php echo e(str_repeat('☆', 5 - $temoignage->note)); ?>

                            </span>
                            <?php if($temoignage->est_publie): ?>
                                <span class="badge badge-success ml-2">Publié sur le site</span>
                            <?php else: ?>
                                <span class="badge badge-warning ml-2">En attente de validation</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted"><?php echo e($temoignage->created_at?->format('d/m/Y')); ?></small>
                    </div>

                    <p class="mt-2 mb-2">« <?php echo e($temoignage->contenu); ?> »</p>

                    <small class="text-muted d-block mb-3">
                        <?php echo e($temoignage->auteur); ?>

                        <?php if($temoignage->fonction): ?> — <?php echo e($temoignage->fonction); ?> <?php endif; ?>
                        <?php if($temoignage->formation_concernee): ?> · <?php echo e($temoignage->formation_concernee); ?> <?php endif; ?>
                    </small>

                    <a href="<?php echo e(route('admin.mes-temoignages.edit', $temoignage)); ?>"
                        class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-pen"></i> Modifier
                    </a>
                    <form action="<?php echo e(route('admin.mes-temoignages.destroy', $temoignage)); ?>" method="POST"
                        class="d-inline" onsubmit="return confirm('Supprimer ce témoignage ?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    Vous n'avez pas encore écrit de témoignage.
                </div>
            </div>
        <?php endif; ?>

        <?php if($temoignages->hasPages()): ?>
            <?php echo e($temoignages->links('pagination::bootstrap-4')); ?>

        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/admin/mes-temoignages/index.blade.php ENDPATH**/ ?>