<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Enseignants']); ?>

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Enseignants</h1>
                <p class="text-muted mb-0">
                    <?php echo e($enseignants->total()); ?>

                    enseignant<?php echo e($enseignants->total() > 1 ? 's' : ''); ?> au total.
                </p>
            </div>

            <?php if(!auth()->user()->hasRole('enseignant')): ?>
    <a href="<?php echo e(route('admin.enseignants.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus me-1"></i>
        Nouvel enseignant
    </a>
<?php endif; ?>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.enseignants.index')); ?>">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-1">Recherche</label>
                            <input type="search" name="search" class="form-control"
                                   placeholder="Nom, prénom, matricule, spécialité..."
                                   value="<?php echo e(request('search')); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted mb-1">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="actif" <?php if(request('statut') === 'actif'): echo 'selected'; endif; ?>>Actif</option>
                                <option value="inactif" <?php if(request('statut') === 'inactif'): echo 'selected'; endif; ?>>Inactif</option>
                                <option value="suspendu" <?php if(request('statut') === 'suspendu'): echo 'selected'; endif; ?>>Suspendu</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            <?php if(request()->hasAny(['search', 'statut'])): ?>
                                <a href="<?php echo e(route('admin.enseignants.index')); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-rotate-left"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Spécialité</th>
                                <th>Téléphone</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $enseignants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enseignant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="font-monospace small"><?php echo e($enseignant->matricule); ?></td>
                                <td class="fw-semibold"><?php echo e($enseignant->nom_complet); ?></td>
                                <td class="fw-semibold"><?php echo e($enseignant->user->email); ?></td>
                                <td><?php echo e($enseignant->specialite ?? '—'); ?></td>
                                <td><?php echo e($enseignant->telephone ?? '—'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($enseignant->statut_badge); ?>">
                                        <?php echo e($enseignant->statut_libelle); ?>

                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="<?php echo e(route('admin.enseignants.edit', $enseignant)); ?>"
                                           class="btn btn-sm btn-outline-primary" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression<?php echo e($enseignant->id); ?>"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Aucun enseignant trouvé.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if($enseignants->hasPages()): ?>
                <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="text-muted small">
                        Affichage de <strong><?php echo e($enseignants->firstItem()); ?></strong>
                        à <strong><?php echo e($enseignants->lastItem()); ?></strong>
                        sur <strong><?php echo e($enseignants->total()); ?></strong> résultats
                    </div>
                    <div><?php echo e($enseignants->onEachSide(1)->links()); ?></div>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?php $__currentLoopData = $enseignants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enseignant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modalSuppression<?php echo e($enseignant->id); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title h5 mb-0">
                            <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                            Confirmer la suppression
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            Supprimer l'enseignant « <strong><?php echo e($enseignant->nom_complet); ?></strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            Son compte utilisateur et ses informations personnelles seront également supprimés.
                            Cette action est irréversible.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                        <form method="POST" action="<?php echo e(route('admin.enseignants.destroy', $enseignant)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/admin/enseignants/index.blade.php ENDPATH**/ ?>