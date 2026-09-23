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
    <?php $__env->startSection('title', 'Choisir une session de formation'); ?>

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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sessions de formation disponibles</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>FORMATION</th>
                            <th>CATÉGORIE</th>
                            <th>LIEU</th>
                            <th>DATE DÉBUT</th>
                            <th>DATE FIN</th>
                            <th>PLACES DISPONIBLES</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $formation = $session->formation;
                                $complet = $session->places_disponibles <= 0;
                            ?>
                            <tr>
                                <td><?php echo e($formation->titre ?? 'Formation supprimée'); ?></td>
                                <td><?php echo e($formation->categorie->nom ?? '—'); ?></td>
                                <td><?php echo e($session->lieu ?? '—'); ?></td>
                                <td><?php echo e(optional($session->date_debut)->format('d/m/Y') ?? '—'); ?></td>
                                <td><?php echo e(optional($session->date_fin)->format('d/m/Y') ?? '—'); ?></td>
                                <td>
                                    <span class="badge <?php echo e($complet ? 'badge-secondary' : 'badge-success'); ?>">
                                        <?php echo e($session->places_disponibles); ?> / <?php echo e($session->places_totales); ?>

                                    </span>
                                </td>
                                <td>
    <?php if($inscriptions->has($session->id)): ?>

        
        <a href="<?php echo e(route('admin.inscription.show', $inscriptions[$session->id]->id)); ?>"
            class="btn btn-sm btn-info">
            <i class="fas fa-eye mr-1"></i>
            Voir ma candidature
        </a>

    <?php elseif($complet): ?>

        
        <button type="button" class="btn btn-sm btn-secondary" disabled>
            <i class="fas fa-ban mr-1"></i>
            Session complète
        </button>

    <?php else: ?>

        
        <a href="<?php echo e(route('admin.inscription.inscriptionforme', $session->id)); ?>"
            class="btn btn-sm btn-primary">
            <i class="fas fa-user-plus mr-1"></i>
            S'inscrire
        </a>

    <?php endif; ?>
</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Aucune session ouverte pour le moment.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalInscription" tabindex="-1" role="dialog" aria-labelledby="modalInscriptionLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="<?php echo e(route('admin.inscription.store')); ?>" method="POST" id="formInscription"
                    enctype="multipart/form-data" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalInscriptionLabel">
                            <span id="modal-step-indicator">Étape 1/2 — Votre candidature</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="session_formation_id" id="input-session-id" value="">

                        
                        <div id="step-1">

                            
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 id="info-formation" class="mb-2"></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Type :</strong> <span id="info-type"></span></p>
                                            <p class="mb-1"><strong>Catégorie :</strong> <span
                                                    id="info-categorie"></span></p>
                                            <p class="mb-1"><strong>Durée :</strong> <span id="info-duree"></span></p>
                                            <p class="mb-1"><strong>Coût indicatif :</strong> <span
                                                    id="info-cout"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Public cible :</strong> <span
                                                    id="info-public-cible"></span></p>
                                            <p class="mb-1"><strong>Lieu :</strong> <span id="info-lieu"></span></p>
                                            <p class="mb-1"><strong>Dates :</strong> <span id="info-dates"></span></p>
                                            <p class="mb-1"><strong>Places disponibles :</strong> <span
                                                    id="info-places"></span></p>
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted" id="info-resume"></p>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label for="input-commentaire">Remarque (facultatif)</label>
                                <textarea class="form-control" id="input-commentaire" name="commentaire" rows="2"
                                    placeholder="Une précision à ajouter à votre candidature ?"></textarea>
                            </div>

                            
                            <?php if($typesPieces->isNotEmpty()): ?>
                                <div class="form-group">
                                    <label>Pièces justificatives</label>
                                    <?php $__currentLoopData = $typesPieces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group mb-2 piece-upload"
                                            data-obligatoire="<?php echo e($type->obligatoire ? '1' : '0'); ?>"
                                            data-libelle="<?php echo e($type->libelle); ?>">
                                            <label for="piece-<?php echo e($type->code); ?>"
                                                class="d-flex justify-content-between">
                                                <span><?php echo e($type->libelle); ?></span>
                                                <?php if($type->obligatoire): ?>
                                                    <span class="badge badge-danger">Obligatoire</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Facultatif</span>
                                                <?php endif; ?>
                                            </label>
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="custom-file-input piece-input <?php echo e($errors->has("pieces.{$type->code}") ? 'is-invalid' : ''); ?>"
                                                    id="piece-<?php echo e($type->code); ?>" name="pieces[<?php echo e($type->code); ?>]"
                                                    accept=".pdf,.jpg,.jpeg,.png" data-libelle="<?php echo e($type->libelle); ?>"
                                                    <?php echo e($type->obligatoire ? 'required' : ''); ?>>
                                                <label class="custom-file-label" for="piece-<?php echo e($type->code); ?>">
                                                    Choisir un fichier…
                                                </label>
                                            </div>
                                            <small class="form-text text-danger d-none piece-error">
                                                Ce document est obligatoire.
                                            </small>
                                            <?php $__errorArgs = ["pieces.{$type->code}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <small class="text-danger d-block"><?php echo e($message); ?></small>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <small class="form-text text-muted">
                                        Formats acceptés : PDF, JPG, PNG — 5 Mo max par fichier.
                                    </small>
                                </div>
                            <?php endif; ?>

                            <div class="alert alert-danger d-none" id="step1-alert"></div>
                        </div>

                        
                        <div id="step-2" class="d-none">
                            <p class="text-muted">
                                Merci de vérifier les informations ci-dessous avant de confirmer votre candidature.
                            </p>

                            <table class="table table-sm table-borderless mb-3">
                                <tr>
                                    <th style="width:35%">Formation</th>
                                    <td id="recap-formation"></td>
                                </tr>
                                <tr>
                                    <th>Type / Catégorie</th>
                                    <td id="recap-type-categorie"></td>
                                </tr>
                                <tr>
                                    <th>Durée / Coût</th>
                                    <td id="recap-duree-cout"></td>
                                </tr>
                                <tr>
                                    <th>Lieu</th>
                                    <td id="recap-lieu"></td>
                                </tr>
                                <tr>
                                    <th>Dates</th>
                                    <td id="recap-dates"></td>
                                </tr>
                                <tr>
                                    <th>Remarque</th>
                                    <td id="recap-commentaire">—</td>
                                </tr>
                                <tr>
                                    <th>Pièces jointes</th>
                                    <td>
                                        <ul class="pl-3 mb-0" id="recap-pieces"></ul>
                                    </td>
                                </tr>
                            </table>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="modal-confirm"
                                    name="confirmation" required>
                                <label class="custom-control-label" for="modal-confirm">
                                    Je confirme vouloir candidater à cette session de formation.
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>

                        <div>
                            <button type="button" class="btn btn-outline-secondary d-none" id="btn-precedent">
                                <i class="fas fa-arrow-left"></i> Précédent
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-suivant">
                                Suivant <i class="fas fa-arrow-right"></i>
                            </button>
                            <button type="submit" class="btn btn-primary d-none" id="btn-confirmer">
                                <i class="fas fa-check"></i> Confirmer mon inscription
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
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
<?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/candidat/choisir-session.blade.php ENDPATH**/ ?>