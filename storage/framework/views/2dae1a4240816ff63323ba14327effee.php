<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Détail de l\'idée']); ?>
    <div class="container-fluid py-3">
        <a href="<?php echo e(route('admin.idees-direction.index')); ?>" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-2"><?php echo e($idee->titre); ?></h4>
                        <div class="mb-3">
                            <span class="badge badge-<?php echo e($idee->statut_badge); ?>"><?php echo e($idee->statut_libelle); ?></span>
                            <?php if($idee->categorie_libelle): ?>
                                <span class="badge badge-light border ml-1"><?php echo e($idee->categorie_libelle); ?></span>
                            <?php endif; ?>
                        </div>
                        <p style="white-space:pre-line;"><?php echo e($idee->description); ?></p>
                        <hr>
                        <small class="text-muted">
                            Proposée par <strong><?php echo e($idee->auteur_nom); ?></strong>
                            le <?php echo e($idee->created_at?->format('d/m/Y à H:i')); ?>

                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><strong>Traitement</strong></div>
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.idees-direction.update', $idee)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="form-group">
                                <label for="statut">Statut</label>
                                <select id="statut" name="statut" class="form-control">
                                    <?php $__currentLoopData = \App\Models\Idee::STATUTS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cle => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cle); ?>" <?php if(old('statut', $idee->statut) === $cle): echo 'selected'; endif; ?>><?php echo e($s['label']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="reponse">Réponse à l'auteur</label>
                                <textarea id="reponse" name="reponse" rows="5" maxlength="1000" class="form-control"
                                    placeholder="Facultatif : explication, remerciement, prochaines étapes…"><?php echo e(old('reponse', $idee->reponse)); ?></textarea>
                                <small class="form-text text-muted">Visible par l'auteur de l'idée.</small>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">Enregistrer</button>
                        </form>

                        <?php if($idee->traitee_le): ?>
                            <small class="text-muted d-block mt-3">
                                Dernier traitement le <?php echo e($idee->traitee_le->format('d/m/Y')); ?>

                                <?php if($idee->traiteePar): ?> par <?php echo e($idee->traiteePar->personne?->prenom ?? $idee->traiteePar->email); ?> <?php endif; ?>
                            </small>
                        <?php endif; ?>
                    </div>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\idees-direction\show.blade.php ENDPATH**/ ?>