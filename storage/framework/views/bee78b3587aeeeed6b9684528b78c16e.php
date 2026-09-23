<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Documents']); ?>

    <div class="container-fluid py-4">

        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Documents</h1>
                <p class="text-muted mb-0">
                    <?php echo e($documents->total()); ?>

                    <?php echo e(Str::plural('document', $documents->total())); ?>

                    au total.
                </p>
            </div>

            <a href="<?php echo e(route('admin.documents.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Nouveau document
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

                <form method="GET" action="<?php echo e(route('admin.documents.index')); ?>">
                    <div class="row g-3 align-items-end">

                        <div class="col-lg-3 col-md-6">
                            <label for="categorie_id" class="form-label small text-muted mb-1">
                                Catégorie
                            </label>
                            <select id="categorie_id" name="categorie_id" class="form-select">
                                <option value="">Toutes les catégories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($categorie->id); ?>"
                                            <?php if(request('categorie_id') == $categorie->id): echo 'selected'; endif; ?>>
                                        <?php echo e($categorie->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label for="type" class="form-label small text-muted mb-1">
                                Type
                            </label>
                            <select id="type" name="type" class="form-select">
                                <option value="">Tous les types</option>
                                <option value="rapport" <?php if(request('type') === 'rapport'): echo 'selected'; endif; ?>>Rapport</option>
                                <option value="brochure" <?php if(request('type') === 'brochure'): echo 'selected'; endif; ?>>Brochure</option>
                                <option value="texte_reglementaire" <?php if(request('type') === 'texte_reglementaire'): echo 'selected'; endif; ?>>Texte réglementaire</option>
                                <option value="support_pedagogique" <?php if(request('type') === 'support_pedagogique'): echo 'selected'; endif; ?>>Support pédagogique</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label for="acces" class="form-label small text-muted mb-1">
                                Accès
                            </label>
                            <select id="acces" name="acces" class="form-select">
                                <option value="">Tous les accès</option>
                                <option value="public" <?php if(request('acces') === 'public'): echo 'selected'; endif; ?>>Public</option>
                                <option value="restreint" <?php if(request('acces') === 'restreint'): echo 'selected'; endif; ?>>Restreint</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6">
                            <label for="telechargeable" class="form-label small text-muted mb-1">
                                Téléchargeable
                            </label>
                            <select id="telechargeable" name="telechargeable" class="form-select">
                                <option value="">Indifférent</option>
                                <option value="1" <?php if(request('telechargeable') === '1'): echo 'selected'; endif; ?>>Oui</option>
                                <option value="0" <?php if(request('telechargeable') === '0'): echo 'selected'; endif; ?>>Non</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-success flex-grow-1">
                                <i class="fas fa-filter me-1"></i>
                                Filtrer
                            </button>

                            <?php if(request()->hasAny(['categorie_id', 'type', 'acces', 'telechargeable'])): ?>
                                <a href="<?php echo e(route('admin.documents.index')); ?>"
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
                                <th>Titre</th>
                                <th style="width:150px;">Catégorie</th>
                                <th style="width:150px;">Type</th>
                                <th style="width:110px;">Accès</th>
                                <th style="width:130px;">Téléchargement</th>
                                <th style="width:90px;">Version</th>
                                <th style="width:100px;">Taille</th>
                                <th style="width:80px;" class="text-center">Téléch.</th>
                                <th style="width:120px;">Publié le</th>
                                <th style="width:160px;">Publié par</th>
                                <th style="width:180px;" class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        <?php echo e(Str::limit($document->titre, 60)); ?>

                                    </div>
                                    
                                </td>

                                <td><?php echo e($document->categorie?->nom ?? '—'); ?></td>

                                <td>
                                    <span class="badge bg-secondary">
                                        <?php echo e(str_replace('_', ' ', $document->type)); ?>

                                    </span>
                                </td>

                                <td>
                                    <?php if($document->acces === 'public'): ?>
                                        <span class="badge bg-success">Public</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Restreint</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($document->telechargeable): ?>
                                        <span class="badge bg-info text-dark">
                                            <i class="fas fa-download me-1"></i> Oui
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-eye me-1"></i> Sur place
                                        </span>
                                        <?php if($document->code_consultation): ?>
                                            <div class="small text-muted mt-1"><?php echo e($document->code_consultation); ?></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>

                                <td class="text-muted"><?php echo e($document->version ?? '—'); ?></td>

                                <td class="text-muted">
                                    <?php if($document->taille_fichier_ko): ?>
                                        <?php echo e(number_format($document->taille_fichier_ko / 1024, 2)); ?> Mo
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>

                                <td class="text-center text-muted">
                                    <?php echo e($document->nombre_telechargements); ?>

                                </td>

                                <td>
                                    <span title="<?php echo e($document->publie_le?->format('d/m/Y H:i')); ?>">
                                        <?php echo e($document->publie_le?->format('d/m/Y') ?? '—'); ?>

                                    </span>
                                </td>

                                <td><?php echo e($document->publiePar?->name ?? '—'); ?></td>

                                <td>
                                    <div class="d-flex justify-content-end gap-1">

                                        
                                        <a href="<?php echo e(route('admin.documents.show', $document)); ?>"
                                           class="btn btn-sm btn-outline-secondary"
                                           aria-label="Voir"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        
                                        <a href="<?php echo e(route('admin.documents.edit', $document)); ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           aria-label="Modifier"
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression<?php echo e($document->id); ?>"
                                                aria-label="Supprimer"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="fas fa-file-lines fa-2x text-muted mb-3 d-block"></i>

                                    <?php if(request()->hasAny(['categorie_id', 'type', 'acces', 'telechargeable'])): ?>
                                        <p class="text-muted mb-3">
                                            Aucun document ne correspond à ces critères.
                                        </p>
                                        <a href="<?php echo e(route('admin.documents.index')); ?>"
                                           class="btn btn-sm btn-outline-secondary">
                                            Réinitialiser les filtres
                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted mb-3">
                                            Aucun document enregistré pour le moment.
                                        </p>
                                        <a href="<?php echo e(route('admin.documents.create')); ?>"
                                           class="btn btn-sm btn-success">
                                            Créer le premier document
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>

                </div>
            </div>

            <?php if($documents->hasPages()): ?>
                <div class="card-footer bg-white">
                    <?php echo e($documents->links()); ?>

                </div>
            <?php endif; ?>
        </div>

    </div>

    
    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modalSuppression<?php echo e($document->id); ?>" tabindex="-1" aria-hidden="true">
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
                            Voulez-vous vraiment supprimer le document
                            « <strong><?php echo e($document->titre); ?></strong> » ?
                        </p>
                        <p class="text-muted small mb-0 mt-2">
                            Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="<?php echo e(route('admin.documents.destroy', $document)); ?>">
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\documents\index.blade.php ENDPATH**/ ?>