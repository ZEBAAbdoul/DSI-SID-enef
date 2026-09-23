<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($document->titre).'']); ?>

    <div class="container-fluid py-4">

        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1"><?php echo e($document->titre); ?></h1>
                <span class="badge bg-secondary"><?php echo e($typeOptions[$document->type] ?? $document->type); ?></span>
                <?php if($document->acces === 'public'): ?>
                    <span class="badge bg-success">Public</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">Restreint</span>
                <?php endif; ?>
                <?php if($document->telechargeable): ?>
                    <span class="badge bg-info text-dark"><i class="fas fa-download me-1"></i> Téléchargeable</span>
                <?php else: ?>
                    <span class="badge bg-light text-dark border"><i class="fas fa-eye me-1"></i> Consultation sur place</span>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.documents.edit', $document)); ?>" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-pen me-1"></i> Modifier
                </a>
                <button type="button"
                        class="btn btn-sm btn-outline-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modalSuppression<?php echo e($document->id); ?>">
                    <i class="fas fa-trash me-1"></i> Supprimer
                </button>
                <a href="<?php echo e(route('admin.documents.index')); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Catégorie</dt>
                            <dd class="col-sm-9"><?php echo e($document->categorie?->nom ?? '—'); ?></dd>

                            <dt class="col-sm-3">Description</dt>
                            <dd class="col-sm-9"><?php echo e($document->description ?: '—'); ?></dd>

                            <dt class="col-sm-3">Version</dt>
                            <dd class="col-sm-9"><?php echo e($document->version ?: '—'); ?></dd>

                            <dt class="col-sm-3">Téléchargeable</dt>
                            <dd class="col-sm-9">
                                <?php if($document->telechargeable): ?>
                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i> Oui</span>
                                <?php else: ?>
                                    <span class="text-muted"><i class="fas fa-times-circle me-1"></i> Non — consultation sur place uniquement</span>
                                <?php endif; ?>
                            </dd>

                            <dt class="col-sm-3">Code de consultation</dt>
                            <dd class="col-sm-9"><?php echo e($document->code_consultation ?: '—'); ?></dd>

                            <dt class="col-sm-3">Fichier</dt>
                            <dd class="col-sm-9">
                                <?php if($document->fichier_url): ?>
                                    <a href="<?php echo e(route('admin.documents.telecharger', $document)); ?>"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-download me-1"></i>
                                        <?php echo e(basename($document->fichier_url)); ?>

                                    </a>
                                    <span class="text-muted small ms-2">
                                        <?php echo e($document->format_fichier ? strtoupper($document->format_fichier) : ''); ?>

                                        <?php if($document->taille_fichier_ko): ?>
                                            , <?php echo e(number_format($document->taille_fichier_ko / 1024, 2)); ?> Mo
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </dd>

                            <dt class="col-sm-3">Publié le</dt>
                            <dd class="col-sm-9"><?php echo e($document->publie_le?->format('d/m/Y') ?? '—'); ?></dd>

                            <dt class="col-sm-3">Publié par</dt>
                            <dd class="col-sm-9"><?php echo e($document->publiePar?->name ?? '—'); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

            
        </div>

    </div>

    
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\documents\show.blade.php ENDPATH**/ ?>