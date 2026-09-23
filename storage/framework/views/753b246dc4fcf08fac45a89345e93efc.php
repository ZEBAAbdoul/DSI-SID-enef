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

    <?php $__env->startSection('title', 'Dossier ' . $inscription->numero_dossier); ?>

    
    
    
    <div class="mb-3">
        <a href="<?php echo e(route('admin.inscriptions.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>
            Retour à la liste des dossiers
        </a>
    </div>

    
    <?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-info-circle mr-2"></i>
            <?php echo e(session('status')); ?>


            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <h6>
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Une erreur est survenue
            </h6>

            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <div class="row">

        
        
        

        <div class="col-md-4">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-folder-open mr-2"></i>
                        Dossier <?php echo e($inscription->numero_dossier); ?>

                    </h3>
                </div>

                <div class="card-body">

                    
                    <p>
                        <strong>
                            <i class="fas fa-user mr-1"></i>
                            Candidat :
                        </strong>

                        <?php echo e($inscription->candidat->name ?? ($inscription->candidat->email ?? '—')); ?>

                    </p>

                    
                    <p>
                        <strong>
                            <i class="fas fa-envelope mr-1"></i>
                            Email :
                        </strong>

                        <?php echo e($inscription->candidat->email ?? '—'); ?>

                    </p>

                    
                    <p>
                        <strong>
                            <i class="fas fa-graduation-cap mr-1"></i>
                            Formation :
                        </strong>

                        <?php echo e($inscription->formation->titre ?? '—'); ?>

                    </p>

                    
                    <p>
                        <strong>
                            <i class="fas fa-layer-group mr-1"></i>
                            Catégorie :
                        </strong>

                        <?php echo e($inscription->formation->categorie->nom ?? '—'); ?>

                    </p>

                    
                    <p>
                        <strong>
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Session :
                        </strong>

                        <?php if($inscription->session): ?>

                            <?php echo e(\Carbon\Carbon::parse($inscription->session->date_debut)->translatedFormat('d M Y')); ?>


                            <?php if($inscription->session->date_fin): ?>
                                —
                                <?php echo e(\Carbon\Carbon::parse($inscription->session->date_fin)->translatedFormat('d M Y')); ?>

                            <?php endif; ?>

                            <br>

                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <?php echo e($inscription->session->lieu ?? 'Lieu non précisé'); ?>

                            </small>
                        <?php else: ?>
                            —

                        <?php endif; ?>
                    </p>

                    
                    <p>
                        <strong>
                            <i class="fas fa-clock mr-1"></i>
                            Déposé le :
                        </strong>

                        <?php echo e($inscription->date_soumission?->format('d/m/Y H:i') ?? '—'); ?>

                    </p>

                    
                    <p>
                        <strong>
                            <i class="fas fa-info-circle mr-1"></i>
                            Statut :
                        </strong>

                        <span class="badge statut-badge-<?php echo e($inscription->statut); ?>">
                            <?php echo e($inscription->statut); ?>

                        </span>
                    </p>

                    
                    <?php if($inscription->motif_rejet): ?>
                        <div class="alert alert-danger mt-3 mb-0">

                            <strong>
                                <i class="fas fa-times-circle mr-1"></i>
                                Motif du rejet :
                            </strong>

                            <div class="mt-1">
                                <?php echo e($inscription->motif_rejet); ?>

                            </div>

                        </div>
                    <?php endif; ?>

                </div>


                
                <?php if($inscription->statut !== 'valide'): ?>
                    <div class="card-footer">

                        
                        <?php
                            $toutesPiecesConformes =
                                $inscription->pieces->isNotEmpty() &&
                                $inscription->pieces->every(fn($piece) => $piece->statut_verification === 'conforme');
                        ?>

                        <?php if($toutesPiecesConformes): ?>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#modalValider">

                                <i class="fas fa-check mr-1"></i>
                                Valider

                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-success btn-sm" disabled
                                title="Toutes les pièces doivent être conformes avant de pouvoir valider le dossier">

                                <i class="fas fa-check mr-1"></i>
                                Valider

                            </button>
                        <?php endif; ?>


                        
                        


                        
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#modalRejeter">

                            <i class="fas fa-times mr-1"></i>
                            Rejeter

                        </button>

                    </div>
                <?php endif; ?>

            </div>

        </div>


        
        
        

        <div class="col-md-8">

            <div class="card card-primary">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-paperclip mr-2"></i>
                        Pièces jointes
                        (<?php echo e($inscription->pieces->count()); ?>)

                        <?php $nbResoumises = $inscription->pieces->where('resoumis', true)->count(); ?>
                        <?php if($nbResoumises > 0): ?>
                            <span class="badge badge-info ml-2">
                                <i class="fas fa-sync-alt mr-1"></i>
                                <?php echo e($nbResoumises); ?> <?php echo e(Str::plural('fichier', $nbResoumises)); ?> resoumis
                            </span>
                        <?php endif; ?>
                    </h3>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead>

                                <tr>

                                    <th>TYPE</th>
                                    <th>FICHIER</th>
                                    <th>DÉPOSÉ LE</th>
                                    <th>VÉRIFICATION</th>
                                    <th class="text-center">ACTIONS</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php $__empty_1 = true; $__currentLoopData = $inscription->pieces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $piece): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                    <tr>

                                        
                                        <td>
                                            <strong>
                                                <?php echo e($piece->type_piece_libelle); ?>

                                            </strong>
                                        </td>


                                        
                                        <td>

                                            <span class="badge badge-secondary">
                                                <?php echo e(strtoupper($piece->format_fichier)); ?>

                                            </span>

                                            <?php if($piece->taille_fichier_ko): ?>
                                                <small class="text-muted d-block">
                                                    <?php echo e($piece->taille_fichier_ko); ?> Ko
                                                </small>
                                            <?php endif; ?>

                                        </td>


                                        
                                        <td>

                                            <?php echo e(optional($piece->created_at)->format('d/m/Y H:i')); ?>


                                        </td>


                                        
                                        
                                        <td>

                                            <span class="badge verif-badge-<?php echo e($piece->statut_verification); ?>">
                                                <?php switch($piece->statut_verification):
                                                    case ('conforme'): ?>
                                                        <i class="fas fa-check mr-1"></i>
                                                        Conforme
                                                    <?php break; ?>

                                                    <?php case ('non_conforme'): ?>
                                                        <i class="fas fa-times mr-1"></i>
                                                        Non conforme
                                                    <?php break; ?>

                                                    <?php default: ?>
                                                        <i class="fas fa-clock mr-1"></i>
                                                        En attente
                                                <?php endswitch; ?>
                                            </span>

                                            <?php if($piece->resoumis): ?>
                                                <span class="badge badge-info mt-1 d-block" style="width:fit-content;">
                                                    <i class="fas fa-sync-alt mr-1"></i>
                                                    Nouveau fichier déposé
                                                </span>
                                            <?php endif; ?>

                                            <?php if($piece->commentaire): ?>
                                                <small class="text-muted d-block mt-1">
                                                    <?php echo e($piece->commentaire); ?>

                                                </small>
                                            <?php endif; ?>

                                        </td>


                                        
                                        
                                        <td class="text-center">

                                            
                                            <a href="<?php echo e(route('admin.inscription.piece.telecharger', $piece)); ?>"
                                                class="btn btn-sm btn-info" target="_blank" title="Voir le fichier">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <?php if($inscription->statut !== 'valide'): ?>
                                                
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-toggle="modal" data-target="#modalVerifier<?php echo e($piece->id); ?>"
                                                    title="Vérifier la pièce">
                                                    <i class="fas fa-check-double"></i>
                                                </button>

                                                
                                                <?php if($piece->statut_verification !== 'non_conforme'): ?>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-toggle="modal"
                                                        data-target="#modalNonConforme<?php echo e($piece->id); ?>"
                                                        title="Marquer non conforme">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </td>

                                    </tr>


                                    
                                    
                                    

                                    <div class="modal fade" id="modalVerifier<?php echo e($piece->id); ?>" tabindex="-1"
                                        role="dialog" aria-hidden="true">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <form
                                                    action="<?php echo e(route('admin.inscriptions.pieces.verifier', $piece)); ?>"
                                                    method="POST">

                                                    <?php echo csrf_field(); ?>

                                                    <div class="modal-header">

                                                        <h5 class="modal-title">

                                                            <i class="fas fa-check-double mr-2"></i>

                                                            Vérifier :
                                                            <?php echo e($piece->type_piece_libelle); ?>


                                                        </h5>

                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Fermer">

                                                            <span aria-hidden="true">
                                                                &times;
                                                            </span>

                                                        </button>

                                                    </div>


                                                    <div class="modal-body">

                                                        <div class="form-group">

                                                            <label for="statut_<?php echo e($piece->id); ?>">
                                                                Statut
                                                            </label>

                                                            <select name="statut_verification"
                                                                id="statut_<?php echo e($piece->id); ?>" class="form-control"
                                                                required>

                                                                <option value="conforme">
                                                                    Conforme
                                                                </option>

                                                                <option value="non_conforme">
                                                                    Non conforme
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <div class="form-group">

                                                            <label for="commentaire_<?php echo e($piece->id); ?>">
                                                                Commentaire
                                                            </label>

                                                            <textarea name="commentaire" id="commentaire_<?php echo e($piece->id); ?>" class="form-control" rows="3"
                                                                placeholder="Commentaire optionnel..."></textarea>

                                                        </div>

                                                    </div>


                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">

                                                            Annuler

                                                        </button>


                                                        <button type="submit" class="btn btn-primary">

                                                            <i class="fas fa-save mr-1"></i>
                                                            Enregistrer

                                                        </button>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                    
                                    
                                    
                                    <div class="modal fade" id="modalNonConforme<?php echo e($piece->id); ?>" tabindex="-1"
                                        role="dialog" aria-hidden="true">

                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <form
                                                    action="<?php echo e(route('admin.inscriptions.pieces.verifier', $piece)); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>

                                                    
                                                    <input type="hidden" name="statut_verification"
                                                        value="non_conforme">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-times-circle mr-2 text-danger"></i>
                                                            Marquer non conforme : <?php echo e($piece->type_piece_libelle); ?>

                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Fermer">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Le candidat sera informé et pourra déposer un nouveau
                                                            fichier.
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="commentaire_nc_<?php echo e($piece->id); ?>">
                                                                Motif (obligatoire)
                                                            </label>
                                                            <textarea name="commentaire" id="commentaire_nc_<?php echo e($piece->id); ?>" class="form-control" rows="3" required
                                                                placeholder="Exemple : document illisible, mauvais format, date expirée..."></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                            Annuler
                                                        </button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times mr-1"></i>
                                                            Confirmer non conforme
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <tr>

                                            <td colspan="5" class="text-center text-muted py-4">

                                                <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>

                                                Aucune pièce déposée.

                                            </td>

                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        
        
        

        <div class="modal fade" id="modalRejeter" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <form action="<?php echo e(route('admin.inscriptions.rejeter', $inscription)); ?>" method="POST">

                        <?php echo csrf_field(); ?>

                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-times-circle mr-2"></i>
                                Rejeter le dossier

                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        <div class="modal-body">

                            <div class="form-group">

                                <label for="motif_rejet">
                                    Motif du rejet
                                </label>

                                <textarea name="motif_rejet" id="motif_rejet" class="form-control" rows="4" required
                                    placeholder="Indiquez le motif du rejet..."></textarea>

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Annuler

                            </button>

                            <button type="submit" class="btn btn-danger">

                                <i class="fas fa-times mr-1"></i>
                                Rejeter

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        
        
        

        <div class="modal fade" id="modalValider" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <form action="<?php echo e(route('admin.inscriptions.valider', $inscription)); ?>" method="POST">

                        <?php echo csrf_field(); ?>

                        <div class="modal-header">

                            <h5 class="modal-title">
                                <i class="fas fa-check-circle mr-2 text-success"></i>
                                Valider le dossier
                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="alert alert-success">
                                <i class="fas fa-info-circle mr-1"></i>
                                Toutes les pièces justificatives ont été vérifiées et sont conformes.
                            </div>

                            <p class="mb-1">
                                <strong>Candidat :</strong>
                                <?php echo e($inscription->candidat->name ?? ($inscription->candidat->email ?? '—')); ?>

                            </p>

                            <p class="mb-1">
                                <strong>Formation :</strong>
                                <?php echo e($inscription->formation->titre ?? '—'); ?>

                            </p>

                            <p class="mb-0">
                                <strong>Dossier :</strong>
                                <?php echo e($inscription->numero_dossier); ?>

                            </p>

                            <p class="mt-3 mb-0 text-muted">
                                Confirmez-vous la validation définitive de ce dossier ?
                                Cette action informera le candidat qu'il peut procéder au paiement.
                            </p>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Annuler
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-1"></i>
                                Confirmer la validation
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        
        
        

        <div class="modal fade" id="modalIncomplet" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog" role="document">

                <div class="modal-content">

                    <form action="<?php echo e(route('admin.inscriptions.incomplet', $inscription)); ?>" method="POST">

                        <?php echo csrf_field(); ?>

                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Dossier incomplet

                            </h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        <div class="modal-body">

                            <div class="alert alert-warning">

                                <i class="fas fa-info-circle mr-1"></i>

                                Indiquez au candidat les pièces ou informations
                                qui doivent être complétées.

                            </div>


                            <div class="form-group">

                                <label for="commentaire_incomplet">
                                    Commentaire
                                </label>

                                <textarea name="commentaire" id="commentaire_incomplet" class="form-control" rows="4" required
                                    placeholder="Exemple : Veuillez fournir une copie lisible de votre diplôme..."></textarea>

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Annuler

                            </button>


                            <button type="submit" class="btn btn-warning">

                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Marquer comme incomplet

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        
        
        

        <style>
            .statut-badge-depose {
                background-color: #17a2b8;
                color: #fff;
            }

            .statut-badge-en_cours {
                background-color: #007bff;
                color: #fff;
            }

            .statut-badge-incomplet {
                background-color: #ffc107;
                color: #212529;
            }

            .statut-badge-valide {
                background-color: #28a745;
                color: #fff;
            }

            .statut-badge-rejete {
                background-color: #dc3545;
                color: #fff;
            }

            .verif-badge-conforme {
                background-color: #28a745;
                color: #fff;
            }

            .verif-badge-non_conforme {
                background-color: #dc3545;
                color: #fff;
            }

            .verif-badge-en_attente {
                background-color: #ffc107;
                color: #212529;
            }

            .card-title {
                font-weight: 600;
            }

            .table td,
            .table th {
                vertical-align: middle;
            }
        </style>

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
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/admin/inscriptions/show.blade.php ENDPATH**/ ?>