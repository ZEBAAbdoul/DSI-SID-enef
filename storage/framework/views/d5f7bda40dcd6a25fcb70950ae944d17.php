<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Déposer des notes']); ?>

    <div class="container-fluid py-4">

        <h1 class="h4 mb-4">Déposer un fichier de notes</h1>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form method="POST"
                      action="<?php echo e(route('admin.enseignant.notes.store')); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $erreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($erreur); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Formation <span class="text-danger">*</span></label>
                            <select name="formation_id" class="form-select" required>
                                <option value="">— Sélectionner —</option>
                                <?php $__currentLoopData = $formations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($formation->id); ?>"
                                            <?php if(old('formation_id') == $formation->id): echo 'selected'; endif; ?>>
                                        <?php echo e($formation->titre); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Session (optionnel)</label>
                            <select name="session_formation_id" class="form-select">
                                <option value="">Aucune session spécifique</option>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($session->id); ?>"
                                            <?php if(old('session_formation_id') == $session->id): echo 'selected'; endif; ?>>
                                        <?php echo e($session->formation->titre ?? '—'); ?>

                                        — <?php echo e(\Carbon\Carbon::parse($session->date_debut)->format('d/m/Y')); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Matière <span class="text-danger">*</span></label>
                            <select name="matiere_id" class="form-select" required>
                                <option value="">— Sélectionner —</option>
                                <?php $__currentLoopData = $matieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $matiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($matiere->id); ?>"
                                            <?php if(old('matiere_id') == $matiere->id): echo 'selected'; endif; ?>>
                                        <?php echo e($matiere->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Type d'évaluation <span class="text-danger">*</span></label>
                            <select name="type_evaluation" class="form-select" required>
                                <option value="controle" <?php if(old('type_evaluation') === 'controle'): echo 'selected'; endif; ?>>Contrôle</option>
                                <option value="examen" <?php if(old('type_evaluation') === 'examen'): echo 'selected'; endif; ?>>Examen</option>
                                <option value="tp" <?php if(old('type_evaluation') === 'tp'): echo 'selected'; endif; ?>>TP</option>
                                <option value="oral" <?php if(old('type_evaluation') === 'oral'): echo 'selected'; endif; ?>>Oral</option>
                                <option value="projet" <?php if(old('type_evaluation') === 'projet'): echo 'selected'; endif; ?>>Projet</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Date de l'évaluation</label>
                            <input type="date" name="date_evaluation" class="form-control"
                                   value="<?php echo e(old('date_evaluation')); ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Commentaire (optionnel)</label>
                            <textarea name="commentaire" rows="2" class="form-control"><?php echo e(old('commentaire')); ?></textarea>
                        </div>

                        <div class="col-12">
                            <hr>
                            <label class="form-label">Fichier <span class="text-danger">*</span></label>
                            <input type="file" name="fichier" accept=".xlsx,.xls,.csv,.pdf"
                                   class="form-control" required>
                            <div class="form-text">
                                Formats acceptés : Excel (.xlsx, .xls), CSV ou PDF — 10 Mo maximum.
                            </div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-1"></i>
                            Déposer le fichier
                        </button>
                        <a href="<?php echo e(route('admin.enseignant.notes.index')); ?>" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>

                </form>

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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\enseignants\notes\create.blade.php ENDPATH**/ ?>