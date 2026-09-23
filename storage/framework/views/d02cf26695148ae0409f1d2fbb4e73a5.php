

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
    <?php $__env->startSection('title', 'Candidatures'); ?>

    
    <?php if(session('status')): ?>
        <div class="alert alert-info">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle mr-1"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>


    <div class="card">

        
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-file-alt mr-2"></i>
                Liste des candidatures
            </h3>

            <div class="card-tools">

                <form action="<?php echo e(route('admin.inscriptions.index')); ?>"
                      method="GET"
                      class="form-inline">

                    <select name="statut"
                            class="form-control form-control-sm"
                            onchange="this.form.submit()"
                            style="width:auto;">

                        <option value="">
                            Tous les statuts
                        </option>

                        <option value="depose"
                            <?php if(request('statut') === 'depose'): echo 'selected'; endif; ?>>
                            Déposé
                        </option>

                        <option value="en_cours"
                            <?php if(request('statut') === 'en_cours'): echo 'selected'; endif; ?>>
                            En cours
                        </option>

                        <option value="incomplet"
                            <?php if(request('statut') === 'incomplet'): echo 'selected'; endif; ?>>
                            Incomplet
                        </option>

                        <option value="valide"
                            <?php if(request('statut') === 'valide'): echo 'selected'; endif; ?>>
                            Validé
                        </option>

                        <option value="rejete"
                            <?php if(request('statut') === 'rejete'): echo 'selected'; endif; ?>>
                            Rejeté
                        </option>

                    </select>

                </form>

            </div>
        </div>


        
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0"
                       width="100%"
                       cellspacing="0">

                    <thead>
                        <tr>
                            <th>N° DOSSIER</th>
                            <th>CANDIDAT</th>
                            <th>FORMATION</th>
                            <th>SESSION</th>
                            <th>DÉPOSÉ LE</th>
                            <th>STATUT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>


                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $inscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                
                                <td>
                                    <strong>
                                        <?php echo e($inscription->numero_dossier); ?>

                                    </strong>
                                </td>


                                
                                <td>
                                    <div class="candidate-name">
                                        <i class="fas fa-user mr-1 text-muted"></i>

                                        <?php echo e($inscription->candidat->name
                                            ?? $inscription->candidat->email
                                            ?? 'Candidat inconnu'); ?>

                                    </div>
                                </td>


                                
                                <td>
                                    <?php echo e($inscription->formation->titre ?? '—'); ?>

                                </td>


                                
                                <td>

                                    <?php if($inscription->session): ?>

                                        <span class="date-session">
                                            <i class="far fa-calendar-alt mr-1"></i>

                                            <?php echo e(\Carbon\Carbon::parse(
                                                $inscription->session->date_debut
                                            )->format('d/m/Y')); ?> au <?php echo e(\Carbon\Carbon::parse(
                                                $inscription->session->date_fin
                                            )->format('d/m/Y')); ?>

                                        </span>

                                    <?php else: ?>

                                        —

                                    <?php endif; ?>

                                </td>


                                
                                <td>

                                    <?php if($inscription->date_soumission): ?>

                                        <?php echo e($inscription->date_soumission->format('d/m/Y')); ?>


                                    <?php else: ?>

                                        —

                                    <?php endif; ?>

                                </td>


                                
                                <td>

                                    <?php

                                        $statutConfig = [

                                            'depose' => [
                                                'label' => 'Déposé',
                                                'icon' => 'fas fa-file-upload',
                                                'class' => 'statut-depose',
                                            ],

                                            'en_cours' => [
                                                'label' => 'En cours',
                                                'icon' => 'fas fa-hourglass-half',
                                                'class' => 'statut-en-cours',
                                            ],

                                            'incomplet' => [
                                                'label' => 'Incomplète',
                                                'icon' => 'fas fa-exclamation-circle',
                                                'class' => 'statut-incomplet',
                                            ],

                                            'valide' => [
                                                'label' => 'Validée',
                                                'icon' => 'fas fa-check-circle',
                                                'class' => 'statut-valide',
                                            ],

                                            'rejete' => [
                                                'label' => 'Rejetée',
                                                'icon' => 'fas fa-times-circle',
                                                'class' => 'statut-rejete',
                                            ],

                                        ];


                                        $statut = $statutConfig[$inscription->statut]
                                            ?? [
                                                'label' => ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $inscription->statut
                                                    )
                                                ),
                                                'icon' => 'fas fa-info-circle',
                                                'class' => 'statut-default',
                                            ];

                                    ?>


                                    <span class="statut-badge <?php echo e($statut['class']); ?>">

                                        <i class="<?php echo e($statut['icon']); ?>"></i>

                                        <?php echo e($statut['label']); ?>


                                    </span>

                                </td>


                                
                                <td>

                                    <a href="<?php echo e(route(
                                        'admin.inscriptions.show',
                                        $inscription
                                    )); ?>"
                                       class="btn btn-sm btn-info">

                                        <i class="fas fa-eye"></i>

                                        Voir

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td colspan="7"
                                    class="text-center text-muted py-4">

                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>

                                    Aucune candidature trouvée.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        
        <div class="card-footer">

            <?php echo e($inscriptions->links()); ?>


        </div>

    </div>


    
    <?php $__env->startPush('styles'); ?>

        <style>

            /* --------------------------------
               BADGE GÉNÉRAL
            -------------------------------- */

            .statut-badge {

                display: inline-flex;

                align-items: center;

                justify-content: center;

                gap: 7px;

                padding: 6px 12px;

                border-radius: 20px;

                font-size: 12px;

                font-weight: 600;

                white-space: nowrap;

                border: 1px solid transparent;

                transition: all .2s ease;

            }


            .statut-badge i {

                font-size: 12px;

            }


            .statut-badge:hover {

                transform: translateY(-1px);

                box-shadow:
                    0 3px 8px rgba(0, 0, 0, .08);

            }


            /* --------------------------------
               DÉPOSÉ
            -------------------------------- */

            .statut-depose {

                color: #075985;

                background: #e0f2fe;

                border-color: #7dd3fc;

            }

            .statut-depose i {

                color: #0284c7;

            }


            /* --------------------------------
               EN COURS
            -------------------------------- */

            .statut-en-cours {

                color: #92400e;

                background: #fffbeb;

                border-color: #fcd34d;

            }

            .statut-en-cours i {

                color: #f59e0b;

            }


            /* --------------------------------
               INCOMPLÈTE
            -------------------------------- */

            .statut-incomplet {

                color: #1e40af;

                background: #eff6ff;

                border-color: #93c5fd;

            }

            .statut-incomplet i {

                color: #2563eb;

            }


            /* --------------------------------
               VALIDÉE
            -------------------------------- */

            .statut-valide {

                color: #166534;

                background: #ecfdf3;

                border-color: #86efac;

            }

            .statut-valide i {

                color: #16a34a;

            }


            /* --------------------------------
               REJETÉE
            -------------------------------- */

            .statut-rejete {

                color: #991b1b;

                background: #fef2f2;

                border-color: #fecaca;

            }

            .statut-rejete i {

                color: #dc2626;

            }


            /* --------------------------------
               STATUT INCONNU
            -------------------------------- */

            .statut-default {

                color: #374151;

                background: #f3f4f6;

                border-color: #d1d5db;

            }

            .statut-default i {

                color: #6b7280;

            }


            /* --------------------------------
               CANDIDAT
            -------------------------------- */

            .candidate-name {

                font-weight: 500;

            }


            /* --------------------------------
               SESSION
            -------------------------------- */

            .date-session {

                white-space: nowrap;

            }

        </style>

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
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\inscriptions\index.blade.php ENDPATH**/ ?>