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
    <?php $__env->startSection('title', 'Sessions de formation'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-info"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sessions de formation</h3>
            <div class="card-tools">
                <form action="<?php echo e(route('admin.sessions-formation.index')); ?>" method="GET" class="form-inline"
                    style="display:inline-block;margin-right:10px;">
                    <select name="statut" class="form-control form-control-sm" onchange="this.form.submit()"
                        style="width:auto;">
                        <option value="">Tous les statuts</option>
                        <option value="ouverte" <?php if(request('statut') === 'ouverte'): echo 'selected'; endif; ?>>Ouverte</option>
                        <option value="complete" <?php if(request('statut') === 'complete'): echo 'selected'; endif; ?>>Complète</option>
                        <option value="cloturee" <?php if(request('statut') === 'cloturee'): echo 'selected'; endif; ?>>Clôturée</option>
                    </select>
                </form>
                <?php if (! (auth()->user()->hasRole('user'))): ?>
                    <a href="<?php echo e(route('admin.sessions-formation.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nouvelle session
                    </a>
                <?php endif; ?>

            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>FORMATION</th>
                            <th>LIEU</th>
                            <th>DATE DÉBUT</th>
                            <th>DATE FIN</th>
                            <th>PLACES</th>
                            <th>STATUT</th>
                            <?php if (! (auth()->user()->hasRole('user'))): ?>
                                <th>ACTIONS</th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($session->formation->titre ?? 'Formation supprimée'); ?></td>
                                <td><?php echo e($session->lieu ?? '—'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($session->date_debut)->format('d/m/Y')); ?></td>
                                <td><?php echo e($session->date_fin ? \Carbon\Carbon::parse($session->date_fin)->format('d/m/Y') : '—'); ?>

                                </td>
                                <td><?php echo e($session->places_disponibles); ?> / <?php echo e($session->places_totales); ?></td>
                                <td>
                                    <span class="badge statut-badge-<?php echo e($session->statut); ?>">
                                        <?php echo e(ucfirst($session->statut)); ?>

                                    </span>
                                </td>
                                <?php if (! (auth()->user()->hasRole('user'))): ?>
                                    <td>
                                        <a href="<?php echo e(route('admin.sessions-formation.edit', $session)); ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.sessions-formation.destroy', $session)); ?>"
                                            method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Supprimer cette session ?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucune session trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($sessions->links()); ?>

        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
        <style>
            .statut-badge-ouverte {
                background: #d4edda;
                color: #155724;
            }

            .statut-badge-complete {
                background: #fff3cd;
                color: #856404;
            }

            .statut-badge-cloturee {
                background: #f8d7da;
                color: #721c24;
            }
        </style>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/admin/sessions-formation/index.blade.php ENDPATH**/ ?>