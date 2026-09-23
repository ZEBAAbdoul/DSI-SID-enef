
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
    <?php $__env->startSection('title', 'Mon dossier de candidature'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-info"><?php echo e(session('status')); ?></div>
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

    <?php if(!$inscription): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <p class="mb-3">Vous n'avez pas encore de dossier de candidature.</p>
                <a href="<?php echo e(route('admin.inscription.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Choisir une session
                </a>
            </div>
        </div>
    <?php else: ?>
        <?php
            $badgesStatut = [
                'depose' => 'badge-secondary',
                'en_cours' => 'badge-info',
                'incomplet' => 'badge-warning',
                'valide' => 'badge-success',
                'rejete' => 'badge-danger',
            ];
            $labelsStatut = [
                'depose' => 'Déposé',
                'en_cours' => 'En cours',
                'incomplet' => 'Incomplet',
                'valide' => 'Validé',
                'rejete' => 'Rejeté',
            ];
            $piecesParType = $inscription->pieces->groupBy('type_piece');
        ?>

        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    Dossier <?php echo e($inscription->numero_dossier ?? '—'); ?>

                </h3>

                <span class="badge <?php echo e($badgesStatut[$inscription->statut] ?? 'badge-secondary'); ?>">
                    <?php echo e($labelsStatut[$inscription->statut] ?? $inscription->statut); ?>

                </span>
            </div>

            <div class="card-body">

                
                <?php if($inscription->statut === 'valide'): ?>
                    <div class="alert alert-success shadow-sm mb-4">
                        <div class="d-flex align-items-start">
                            <div class="mr-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>

                            <div>
                                <h5 class="mb-2">
                                    <strong>Félicitations ! Votre inscription a été validée.</strong>
                                </h5>

                                <p class="mb-2">
                                    Votre candidature a été retenue pour cette formation.
                                </p>

                                <p class="mb-0">
                                    Pour procéder au <strong>paiement des frais de scolarité</strong>,
                                    veuillez contacter le
                                    <strong>Service des Ressources Humaines</strong> au numéro :
                                </p>

                                <div class="mt-3">
                                    <a href="tel:+22670000000" class="btn btn-success btn-sm">
                                        <i class="fas fa-phone-alt"></i>
                                        +226 70 00 00 00
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Formation :</strong>
                            <?php echo e($inscription->formation->titre ?? 'Formation supprimée'); ?>

                        </p>

                        <p class="mb-1">
                            <strong>Lieu :</strong>
                            <?php echo e($inscription->session->lieu ?? '—'); ?>

                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>Session :</strong>

                            <?php if($inscription->session): ?>
                                <?php echo e(\Carbon\Carbon::parse($inscription->session->date_debut)->format('d/m/Y')); ?>

                                →
                                <?php echo e($inscription->session->date_fin
                                    ? \Carbon\Carbon::parse($inscription->session->date_fin)->format('d/m/Y')
                                    : '—'); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </p>

                        <p class="mb-1">
                            <strong>Soumis le :</strong>
                            <?php echo e($inscription->date_soumission
                                ? \Carbon\Carbon::parse($inscription->date_soumission)->format('d/m/Y à H:i')
                                : '—'); ?>

                        </p>
                    </div>
                </div>

                <?php if($inscription->statut === 'rejete' && $inscription->motif_rejet): ?>
                    <div class="alert alert-danger mt-3 mb-0">
                        <strong>Motif du rejet :</strong>
                        <?php echo e($inscription->motif_rejet); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>


        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pièces justificatives</h3>
            </div>
            <div class="card-body">
                <?php if($typesPieces->isEmpty()): ?>
                    <p class="text-muted mb-0">Aucun type de pièce configuré.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>PIÈCE</th>
                                    <th>STATUT</th>
                                    <th>FICHIER(S)</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $typesPieces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $piecesDuType = $piecesParType->get($type->code, collect());
                                        $derniere = $piecesDuType->last();
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo e($type->libelle); ?>

                                            <?php if($type->obligatoire): ?>
                                                <span class="badge badge-danger ml-1">Obligatoire</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary ml-1">Facultatif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($piecesDuType->isEmpty()): ?>
                                                <span class="badge badge-light border">Non déposée</span>
                                            <?php elseif($derniere->estConforme()): ?>
                                                <span class="badge badge-success">Conforme</span>
                                            <?php elseif($derniere->estNonConforme()): ?>
                                                <span class="badge badge-danger">Non conforme</span>
                                            <?php else: ?>
                                                <span class="badge badge-warning">En attente de vérification</span>
                                            <?php endif; ?>
                                            <?php if($derniere && $derniere->estNonConforme() && $derniere->commentaire): ?>
                                                <div class="small text-danger mt-1"><?php echo e($derniere->commentaire); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php $__empty_1 = true; $__currentLoopData = $piecesDuType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $piece): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="d-flex align-items-center mb-1">
                                                    <a href="<?php echo e(route('admin.inscription.piece.telecharger', $piece)); ?>"
                                                        class="mr-2">
                                                        <i class="fas fa-file"></i>
                                                        <?php echo e(strtoupper($piece->format_fichier)); ?> ·
                                                        <?php echo e($piece->taille_fichier_ko); ?> Ko
                                                    </a>

                                                    <?php if($inscription->statut !== 'valide'): ?>
                                                        
                                                        <?php if(!$piece->estConforme()): ?>
                                                            <button type="button" class="btn btn-sm btn-link p-0 mr-2"
                                                                data-toggle="collapse"
                                                                data-target="#modifier-<?php echo e($piece->id); ?>">
                                                                <i class="fas fa-pen"></i> Modifier
                                                            </button>
                                                        <?php endif; ?>

                                                        
                                                    <?php endif; ?>
                                                </div>

                                                
                                                <?php if($inscription->statut !== 'valide' && !$piece->estConforme()): ?>
                                                    <div id="modifier-<?php echo e($piece->id); ?>" class="collapse mt-1 mb-2">
                                                        <form
                                                            action="<?php echo e(route('admin.inscription.piece.update', $piece)); ?>"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="form-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <input type="file" name="fichier"
                                                                class="form-control-file mr-2"
                                                                accept=".pdf,.jpg,.jpeg,.png" required>
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-upload"></i> Remplacer
                                                            </button>
                                                        </form>
                                                        <?php $__errorArgs = ['fichier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <small
                                                                class="text-danger d-block mt-1"><?php echo e($message); ?></small>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <small class="form-text text-muted">
                        Formats acceptés : PDF, JPG, PNG — 5 Mo max par fichier.
                    </small>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
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
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/candidat/inscription.blade.php ENDPATH**/ ?>