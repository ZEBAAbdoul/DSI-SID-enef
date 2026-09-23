<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Mes notes déposées']); ?>

    <div class="container-fluid py-4">

        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h1 class="h4 mb-1">Les notes déposées</h1>
                <p class="text-muted mb-0">
                    Liste des fichiers de notes que vous avez déposés.
                </p>
            </div>

            <?php if(auth()->user()->hasRole('enseignant')): ?>
                <a href="<?php echo e(route('admin.enseignant.notes.create')); ?>" class="btn btn-success">
                    <i class="fas fa-upload me-1"></i>
                    Déposer des notes
                </a>
            <?php endif; ?>
        </div>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
        <?php endif; ?>

        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i>
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        <?php endif; ?>

        
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body py-3">
                <form method="GET" action="<?php echo e(route('admin.enseignant.notes.index')); ?>"
                    class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Matière</label>
                        <select name="matiere_id" class="form-select form-select-sm">
                            <option value="">Toutes</option>
                            <?php $__currentLoopData = $matieres ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($matiere->id); ?>" <?php if(request('matiere_id') == $matiere->id): echo 'selected'; endif; ?>>
                                    <?php echo e($matiere->nom); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Type d'évaluation</label>
                        <select name="type_evaluation" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <?php $__currentLoopData = ['controle' => 'Contrôle', 'examen' => 'Examen', 'tp' => 'TP', 'oral' => 'Oral', 'projet' => 'Projet']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(request('type_evaluation') === $value): echo 'selected'; endif; ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted mb-1">Date d'évaluation</label>
                        <input type="date" name="date_evaluation" value="<?php echo e(request('date_evaluation')); ?>"
                            class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-filter me-1"></i>Filtrer
                        </button>
                        <?php if(request()->hasAny(['matiere_id', 'type_evaluation', 'date_evaluation'])): ?>
                            <a href="<?php echo e(route('admin.enseignant.notes.index')); ?>"
                                class="btn btn-sm btn-outline-secondary">
                                Réinitialiser
                            </a>
                        <?php endif; ?>
                    </div>

                </form>
            </div>
        </div>

        
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-alt text-success me-2"></i>
                    <strong>Mes notes</strong>

                    <?php if(
                        $notes instanceof \Illuminate\Contracts\Pagination\Paginator ||
                            $notes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator): ?>
                        <span class="badge bg-secondary ms-2"><?php echo e($notes->total()); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Formation</th>
                                <th>Enseignant</th>
                                <th>Session</th>
                                <th>Matière</th>
                                <th>Type</th>
                                <th>Date évaluation</th>
                                <th>Fichier</th>
                                <th>Déposé le</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $extension = strtolower(pathinfo($note->nom_original, PATHINFO_EXTENSION));

                                    $fileIcon = match (true) {
                                        $extension === 'pdf' => 'fa-file-pdf text-danger',
                                        in_array($extension, ['xlsx', 'xls']) => 'fa-file-excel text-success',
                                        $extension === 'csv' => 'fa-file-csv text-success',
                                        default => 'fa-file text-secondary',
                                    };

                                    $typeBadge = match ($note->type_evaluation) {
                                        'controle' => 'bg-primary',
                                        'examen' => 'bg-danger',
                                        'tp' => 'bg-info',
                                        'oral' => 'bg-warning text-dark',
                                        'projet' => 'bg-success',
                                        default => 'bg-secondary',
                                    };

                                    $tailleKo = $note->taille ? round($note->taille / 1024, 1) : null;
                                ?>

                                <tr>

                                    <td>
                                        <?php echo e($note->formation->nom ?? ($note->formation->titre ?? '—')); ?>

                                    </td>

                                    <td>
                                        <?php echo e($note->enseignant->user->personne->nom_complet ?? '—'); ?>

                                    </td>

                                    <td>
                                        <?php if($note->session): ?>
                                            <div class="small">
                                                <div>
                                                    <i class="fas fa-calendar-alt text-primary me-1"></i>
                                                    <strong>
                                                        <?php echo e($note->session->date_debut?->format('d/m/Y') ?? '—'); ?>

                                                    </strong>
                                                </div>

                                                <div class="text-muted">
                                                    <i class="fas fa-arrow-down me-1"></i>
                                                    <?php echo e($note->session->date_fin?->format('d/m/Y') ?? '—'); ?>

                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($note->matiere->nom ?? '—'); ?></td>

                                    <td>
                                        <span class="badge <?php echo e($typeBadge); ?> text-capitalize">
                                            <?php echo e($note->type_evaluation ?? '—'); ?>

                                        </span>
                                    </td>

                                    <td><?php echo e($note->date_evaluation?->format('d/m/Y') ?? '—'); ?></td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas <?php echo e($fileIcon); ?> me-2"></i>
                                            <div>
                                                <span class="text-truncate d-block" style="max-width: 220px;"
                                                    title="<?php echo e($note->nom_original); ?>">
                                                    <?php echo e($note->nom_original); ?>

                                                </span>
                                                <?php if($tailleKo): ?>
                                                    <small class="text-muted"><?php echo e($tailleKo); ?> Ko</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($note->created_at->format('d/m/Y H:i')); ?>

                                        </small>
                                    </td>

                                    <td class="text-end">
                                        <a href="<?php echo e(route('admin.enseignant.notes.telecharger', $note)); ?>"
                                            class="btn btn-sm btn-outline-primary" title="Télécharger">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalSuppression<?php echo e($note->id); ?>" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>

                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                            <h5>Aucun fichier déposé</h5>
                                            <p class="mb-3">Vous n'avez encore déposé aucune note.</p>
                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>

                    </table>
                </div>
            </div>

            
            <?php if(
                $notes instanceof \Illuminate\Contracts\Pagination\Paginator ||
                    $notes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator): ?>

                <?php if($notes->hasPages()): ?>
                    <div class="card-footer bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <small class="text-muted">
                                Affichage de <strong><?php echo e($notes->firstItem()); ?></strong>
                                à <strong><?php echo e($notes->lastItem()); ?></strong>
                                sur <strong><?php echo e($notes->total()); ?></strong> résultats
                            </small>
                            <div>
                                <?php echo e($notes->onEachSide(1)->links()); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>


    
    <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="modalSuppression<?php echo e($note->id); ?>" tabindex="-1"
            aria-labelledby="modalSuppressionLabel<?php echo e($note->id); ?>" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="modal-title h5 mb-0" id="modalSuppressionLabel<?php echo e($note->id); ?>">
                            <i class="fas fa-trash text-danger me-2"></i>
                            Supprimer ce fichier ?
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>

                    <div class="modal-body">
                        <p>Vous êtes sur le point de supprimer le fichier :</p>

                        <div class="alert alert-light border">
                            <strong><?php echo e($note->nom_original); ?></strong>
                            <br>
                            <small class="text-muted">
                                <?php echo e($note->matiere->nom ?? 'Matière inconnue'); ?>

                                <?php if($note->type_evaluation): ?>
                                    — <?php echo e($note->type_evaluation); ?>

                                <?php endif; ?>
                            </small>
                        </div>

                        <p class="text-danger mb-0">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Cette action est irréversible.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Annuler
                        </button>

                        <form method="POST" action="<?php echo e(route('admin.enseignant.notes.destroy', $note)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>
                                Supprimer
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
<?php endif; ?>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\enseignants\notes\index.blade.php ENDPATH**/ ?>