
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
    <?php $__env->startSection('title', 'Détails du partenaire'); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?php echo e($partenaire->nom); ?></h3>
            <div class="card-tools">
                <a href="<?php echo e(route('admin.partenaires.edit', $partenaire)); ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="<?php echo e(route('admin.partenaires.index')); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <?php if($partenaire->logo_url): ?>
                        <img src="<?php echo e(asset($partenaire->logo_url)); ?>" alt="<?php echo e($partenaire->nom); ?>"
                            class="img-fluid border rounded p-2" style="max-height:140px; background:#fff;">
                    <?php else: ?>
                        <div class="text-muted"><i class="fas fa-image fa-3x"></i><p>Aucun logo</p></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width:200px;">Nom</th>
                                <td><?php echo e($partenaire->nom); ?></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td><?php echo e(ucfirst($partenaire->type)); ?></td>
                            </tr>
                            <tr>
                                <th>Site web</th>
                                <td>
                                    <?php if($partenaire->site_web): ?>
                                        <a href="<?php echo e($partenaire->site_web); ?>" target="_blank" rel="noopener">
                                            <?php echo e($partenaire->site_web); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Ordre d'affichage</th>
                                <td><?php echo e($partenaire->ordre_affichage); ?></td>
                            </tr>
                            <tr>
                                <th>Statut</th>
                                <td>
                                    <span class="badge <?php echo e($partenaire->actif ? 'badge-primary' : 'badge-danger'); ?>">
                                        <?php echo e($partenaire->actif ? 'Actif' : 'Inactif'); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>
                                    <?php if($partenaire->description): ?>
                                        <?php echo e($partenaire->description); ?>

                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\partenaires\show.blade.php ENDPATH**/ ?>