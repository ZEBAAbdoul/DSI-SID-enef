<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestion des actualités']); ?>

    <div class="container-fluid py-4">

        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Gestion des actualités</h1>
                <p class="text-muted mb-0">
                    <?php echo e($actualites->total()); ?>

                    <?php echo e(Str::plural('actualité', $actualites->total())); ?>

                    au total.
                </p>
            </div>

            <a href="<?php echo e(route('admin.actualites.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouvelle actualité
            </a>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-triangle-exclamation me-1"></i>
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <form method="GET" action="<?php echo e(route('admin.actualites.index')); ?>">
                    <div class="row g-3 align-items-end">

                        <div class="col-lg-4 col-md-6">
                            <label for="search" class="form-label small text-muted mb-1">
                                Recherche
                            </label>
                            <input type="search"
                                   id="search"
                                   name="search"
                                   class="form-control"
                                   placeholder="Titre, chapô ou contenu..."
                                   value="<?php echo e(request('search')); ?>">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label for="type" class="form-label small text-muted mb-1">
                                Type
                            </label>
                            <select id="type" name="type" class="form-select">
                                <option value="">Tous les types</option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valeur => $libelle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($valeur); ?>"
                                            <?php if(request('type') === $valeur): echo 'selected'; endif; ?>>
                                        <?php echo e($libelle); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label for="statut" class="form-label small text-muted mb-1">
                                Statut
                            </label>
                            <select id="statut" name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="publiee" <?php if(request('statut') === 'publiee'): echo 'selected'; endif; ?>>
                                    Publiées
                                </option>
                                <option value="brouillon" <?php if(request('statut') === 'brouillon'): echo 'selected'; endif; ?>>
                                    Brouillons
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            <?php if(request()->hasAny(['search', 'type', 'statut'])): ?>
                                <a href="<?php echo e(route('admin.actualites.index')); ?>"
                                   class="btn btn-outline-secondary"
                                   title="Réinitialiser les filtres">
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
                                <th style="width:90px;">Image</th>
                                <th>Titre</th>
                                <th style="width:150px;">Type</th>
                                <th style="width:80px;" class="text-center">Ordre</th>
                                <th style="width:120px;">Statut</th>
                                <th style="width:120px;">Date</th>
                                <th style="width:180px;" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $actualites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actualite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e($actualite->is_publiee ? '' : 'table-warning-subtle'); ?>">

                                <td>
                                    <img src="<?php echo e($actualite->image); ?>"
                                         width="70"
                                         height="50"
                                         class="rounded"
                                         style="object-fit:cover;"
                                         loading="lazy"
                                         alt="Visuel de « <?php echo e($actualite->titre); ?> »">
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        <?php echo e(Str::limit($actualite->titre, 60)); ?>

                                    </div>
                                    <small class="text-muted font-monospace">
                                        /<?php echo e($actualite->slug); ?>

                                    </small>
                                </td>

                                <td>
                                    <span class="badge <?php echo e($actualite->type_badge); ?>">
                                        <?php echo e($actualite->type_libelle); ?>

                                    </span>
                                </td>

                                <td class="text-center text-muted">
                                    <?php echo e($actualite->ordre_menu); ?>

                                </td>

                                <td>
                                    <span class="badge <?php echo e($actualite->statut_badge); ?>">
                                        <?php echo e($actualite->statut_libelle); ?>

                                    </span>
                                </td>

                                <td>
                                    <span title="<?php echo e($actualite->created_at->format('d/m/Y H:i')); ?>">
                                        <?php echo e($actualite->created_at->format('d/m/Y')); ?>

                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        
                                        <?php if($actualite->is_publiee): ?>
                                            <a href="<?php echo e(route('actualites.show', $actualite->slug)); ?>"
                                               target="_blank"
                                               rel="noopener"
                                               class="btn btn-sm btn-outline-secondary"
                                               aria-label="Voir en ligne"
                                               title="Voir en ligne">
                                                <i class="fas fa-up-right-from-square"></i>
                                            </a>
                                        <?php endif; ?>

                                        
                                        <a href="<?php echo e(route('admin.actualites.edit', $actualite)); ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           aria-label="Modifier"
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        
                                        <form method="POST"
                                              action="<?php echo e($actualite->is_publiee
                                                    ? route('admin.actualites.depublier', $actualite)
                                                    : route('admin.actualites.publier', $actualite)); ?>"
                                              class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <button type="submit"
                                                    class="btn btn-sm <?php echo e($actualite->is_publiee
                                                        ? 'btn-outline-warning'
                                                        : 'btn-outline-success'); ?>"
                                                    aria-label="<?php echo e($actualite->is_publiee ? 'Dépublier' : 'Publier'); ?>"
                                                    title="<?php echo e($actualite->is_publiee ? 'Dépublier' : 'Publier'); ?>">
                                                <i class="fas <?php echo e($actualite->is_publiee
                                                    ? 'fa-eye-slash'
                                                    : 'fa-eye'); ?>"></i>
                                            </button>
                                        </form>

                                        
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression<?php echo e($actualite->id); ?>"
                                                aria-label="Supprimer"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-newspaper fa-2x text-muted mb-3 d-block"></i>

                                    <?php if(request()->hasAny(['search', 'type', 'statut'])): ?>
                                        <p class="text-muted mb-3">
                                            Aucune actualité ne correspond à ces critères.
                                        </p>
                                        <a href="<?php echo e(route('admin.actualites.index')); ?>"
                                           class="btn btn-sm btn-outline-secondary">
                                            Réinitialiser les filtres
                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted mb-3">
                                            Aucune actualité enregistrée pour le moment.
                                        </p>
                                        <a href="<?php echo e(route('admin.actualites.create')); ?>"
                                           class="btn btn-sm btn-success">
                                            Créer la première actualité
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>

                </div>
            </div>

            <?php if($actualites->hasPages()): ?>
                <div class="card-footer bg-white">
                    <?php echo e($actualites->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>

    
    <?php $__currentLoopData = $actualites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actualite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modalSuppression<?php echo e($actualite->id); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 mb-0">
                            <i class="fas fa-triangle-exclamation text-danger me-2"></i>
                            Confirmer la suppression
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-0">
                            Voulez-vous vraiment supprimer l'actualité
                            « <strong><?php echo e($actualite->titre); ?></strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="<?php echo e(route('admin.actualites.destroy', $actualite)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>
                                Supprimer définitivement
                            </button>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\actualites\index.blade.php ENDPATH**/ ?>