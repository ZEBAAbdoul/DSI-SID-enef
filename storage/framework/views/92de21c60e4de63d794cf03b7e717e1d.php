<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Mes idées']); ?>
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">Mes idées</h1>
                <small class="text-muted">Vous ne voyez ici que vos propres idées. La direction les examine et vous répond.</small>
            </div>
            <a href="<?php echo e(route('admin.idees.create')); ?>" class="btn btn-success">
                <i class="fas fa-lightbulb"></i> Proposer une idée
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php $__empty_1 = true; $__currentLoopData = $idees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap" style="gap:10px;">
                        <div>
                            <h5 class="mb-1"><?php echo e($idee->titre); ?></h5>
                            <span class="badge badge-<?php echo e($idee->statut_badge); ?>"><?php echo e($idee->statut_libelle); ?></span>
                            <?php if($idee->categorie_libelle): ?>
                                <span class="badge badge-light border ml-1"><?php echo e($idee->categorie_libelle); ?></span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted"><?php echo e($idee->created_at?->format('d/m/Y')); ?></small>
                    </div>

                    <p class="mt-3 mb-3" style="white-space:pre-line;"><?php echo e($idee->description); ?></p>

                    <?php if($idee->reponse): ?>
                        <div class="border-left pl-3 mb-3" style="border-width:3px !important;">
                            <small class="text-muted d-block">
                                <i class="fas fa-reply"></i> Réponse de la direction
                                <?php if($idee->traitee_le): ?> · <?php echo e($idee->traitee_le->format('d/m/Y')); ?> <?php endif; ?>
                            </small>
                            <div style="white-space:pre-line;"><?php echo e($idee->reponse); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $idee)): ?>
                        <a href="<?php echo e(route('admin.idees.edit', $idee)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pen"></i> Modifier
                        </a>
                        <form action="<?php echo e(route('admin.idees.destroy', $idee)); ?>" method="POST" class="d-inline"
                            onsubmit="return confirm('Supprimer cette idée ?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    <?php else: ?>
                        <small class="text-muted"><i class="fas fa-lock"></i> Cette idée a été examinée, elle n'est plus modifiable.</small>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    Vous n'avez pas encore proposé d'idée.
                </div>
            </div>
        <?php endif; ?>

        <?php if($idees->hasPages()): ?>
            <?php echo e($idees->links('pagination::bootstrap-4')); ?>

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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\idees\index.blade.php ENDPATH**/ ?>