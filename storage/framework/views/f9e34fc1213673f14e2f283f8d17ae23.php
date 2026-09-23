<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gestion des recherches &amp; innovations']); ?>

    <div class="container-fluid py-4">

        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Gestion des recherches &amp; innovations</h1>
                <p class="text-muted mb-0">
                    <?php echo e($recherchesInnovations->total()); ?>

                    <?php echo e(Str::plural('élément', $recherchesInnovations->total())); ?>

                    au total.
                </p>
            </div>

            <a href="<?php echo e(route('admin.recherches-innovations.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouvelle recherche / innovation
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

                <form method="GET" action="<?php echo e(route('admin.recherches-innovations.index')); ?>">
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

                        <div class="col-lg-2 col-md-6">
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

                        <div class="col-lg-3 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            <?php if(request()->hasAny(['search', 'type', 'statut'])): ?>
                                <a href="<?php echo e(route('admin.recherches-innovations.index')); ?>"
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
                                <th style="width:90px;">Photo</th>
                                <th>Titre</th>
                                <th style="width:110px;">Type</th>
                                <th style="width:110px;" class="text-center">Médias</th>
                                <th style="width:110px;">Statut</th>
                                <th style="width:120px;">Créé le</th>
                                <th style="width:160px;" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recherchesInnovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rechercheInnovation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e($rechercheInnovation->is_publiee ? '' : 'table-warning-subtle'); ?>">

                                <td>
                                    <?php if($rechercheInnovation->photos): ?>
                                        <div class="position-relative d-inline-block">
                                            <img src="<?php echo e($rechercheInnovation->image); ?>"
                                                 width="70"
                                                 height="50"
                                                 class="rounded"
                                                 style="object-fit:cover;"
                                                 loading="lazy"
                                                 alt="Visuel de « <?php echo e($rechercheInnovation->titre); ?> »">
                                            <?php if(count($rechercheInnovation->photos) > 1): ?>
                                                <span class="badge bg-dark position-absolute"
                                                      style="top:-6px; right:-6px;"
                                                      title="<?php echo e(count($rechercheInnovation->photos)); ?> photos">
                                                    ×<?php echo e(count($rechercheInnovation->photos)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center rounded bg-light text-muted"
                                             style="width:70px; height:50px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        <?php echo e(Str::limit($rechercheInnovation->titre, 55)); ?>

                                    </div>
                                    <small class="text-muted font-monospace">
                                        /<?php echo e($rechercheInnovation->slug); ?>

                                    </small>
                                </td>

                                <td>
                                    <span class="badge <?php echo e($rechercheInnovation->type_badge); ?>">
                                        <?php echo e($rechercheInnovation->type_libelle); ?>

                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="text-success" title="Vidéo">
                                        <?php if($rechercheInnovation->url_video): ?>
                                            <i class="fas fa-video me-1"></i>
                                        <?php else: ?>
                                            <i class="fas fa-video text-muted opacity-25"></i>
                                        <?php endif; ?>
                                    </span>
                                    <span title="Document joint">
                                        <?php if($rechercheInnovation->document): ?>
                                            <i class="fas fa-file-pdf text-danger ms-1"></i>
                                        <?php else: ?>
                                            <i class="fas fa-file-pdf text-muted opacity-25 ms-1"></i>
                                        <?php endif; ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="badge <?php echo e($rechercheInnovation->statut_badge); ?>">
                                        <?php echo e($rechercheInnovation->statut_libelle); ?>

                                    </span>
                                </td>

                                <td>
                                    <span title="<?php echo e($rechercheInnovation->created_at?->format('d/m/Y H:i')); ?>">
                                        <?php echo e($rechercheInnovation->created_at?->format('d/m/Y')); ?>

                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        
                                        <?php if($rechercheInnovation->is_publiee): ?>
                                            <a href="<?php echo e(route('recherches-innovations.show', $rechercheInnovation->slug)); ?>"
                                               target="_blank"
                                               rel="noopener"
                                               class="btn btn-sm btn-outline-secondary"
                                               aria-label="Voir en ligne"
                                               title="Voir en ligne">
                                                <i class="fas fa-up-right-from-square"></i>
                                            </a>
                                        <?php endif; ?>

                                        
                                        <form method="POST"
                                              action="<?php echo e($rechercheInnovation->is_publiee
                                                    ? route('admin.recherches-innovations.depublier', $rechercheInnovation)
                                                    : route('admin.recherches-innovations.publier', $rechercheInnovation)); ?>"
                                              class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <button type="submit"
                                                    class="btn btn-sm <?php echo e($rechercheInnovation->is_publiee
                                                        ? 'btn-outline-warning'
                                                        : 'btn-outline-success'); ?>"
                                                    aria-label="<?php echo e($rechercheInnovation->is_publiee ? 'Dépublier' : 'Publier'); ?>"
                                                    title="<?php echo e($rechercheInnovation->is_publiee ? 'Dépublier' : 'Publier'); ?>">
                                                <i class="fas <?php echo e($rechercheInnovation->is_publiee
                                                    ? 'fa-eye-slash'
                                                    : 'fa-eye'); ?>"></i>
                                            </button>
                                        </form>

                                        
                                        <a href="<?php echo e(route('admin.recherches-innovations.edit', $rechercheInnovation)); ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           aria-label="Modifier"
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression<?php echo e($rechercheInnovation->id); ?>"
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
                                    <i class="fas fa-flask fa-2x text-muted mb-3 d-block"></i>

                                    <?php if(request()->hasAny(['search', 'type', 'statut'])): ?>
                                        <p class="text-muted mb-3">
                                            Aucune recherche ou innovation ne correspond à ces critères.
                                        </p>
                                        <a href="<?php echo e(route('admin.recherches-innovations.index')); ?>"
                                           class="btn btn-sm btn-outline-secondary">
                                            Réinitialiser les filtres
                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted mb-3">
                                            Aucune recherche ou innovation enregistrée pour le moment.
                                        </p>
                                        <a href="<?php echo e(route('admin.recherches-innovations.create')); ?>"
                                           class="btn btn-sm btn-success">
                                            Créer la première entrée
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>

                </div>
            </div>

            <?php if($recherchesInnovations->hasPages()): ?>
                <div class="card-footer bg-white">
                    <?php echo e($recherchesInnovations->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>

    
    <?php $__currentLoopData = $recherchesInnovations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rechercheInnovation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modalSuppression<?php echo e($rechercheInnovation->id); ?>" tabindex="-1" aria-hidden="true">
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
                            Voulez-vous vraiment supprimer
                            « <strong><?php echo e($rechercheInnovation->titre); ?></strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            La photo et le document joint seront également supprimés. Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="<?php echo e(route('admin.recherches-innovations.destroy', $rechercheInnovation)); ?>">
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
<?php endif; ?><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/admin/recherches_innovations/index.blade.php ENDPATH**/ ?>