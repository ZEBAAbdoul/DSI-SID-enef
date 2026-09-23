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
    <?php $__env->startSection('title', $formation->titre); ?>

    <div class="container-fluid">

        
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title mb-0">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    <?php echo e($formation->titre); ?>

                </h3>

                <span class="badge <?php echo e($formation->statut_badge); ?>">
                    <?php echo e($formation->statut_libelle); ?>

                </span>

            </div>

            <div class="card-body">

                <div class="row">

                    
                    <div class="col-md-4">

                        <?php if($formation->image_url): ?>

                            <img src="<?php echo e(asset($formation->image_url)); ?>"
                                 alt="<?php echo e($formation->titre); ?>"
                                 class="img-fluid rounded shadow-sm"
                                 style="width:100%; max-height:300px; object-fit:cover;">

                        <?php else: ?>

                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                 style="height:250px;">

                                <div class="text-center text-muted">
                                    <i class="fas fa-graduation-cap fa-4x mb-3"></i>
                                    <p>Aucune image</p>
                                </div>

                            </div>

                        <?php endif; ?>

                    </div>

                    
                    <div class="col-md-8">

                        <h2 class="mb-3">
                            <?php echo e($formation->titre); ?>

                        </h2>

                        <?php if($formation->resume): ?>
                            <p class="text-muted">
                                <?php echo e($formation->resume); ?>

                            </p>
                        <?php endif; ?>

                        <hr>

                        <div class="row">

                            <div class="col-md-6">
                                <p>
                                    <strong>
                                        <i class="fas fa-layer-group mr-1"></i>
                                        Type :
                                    </strong>

                                    <?php echo e($formation->type_libelle); ?>

                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-sitemap mr-1"></i>
                                        Catégorie :
                                    </strong>

                                    <?php echo e($formation->categorie->nom ?? '—'); ?>

                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-project-diagram mr-1"></i>
                                        Filière :
                                    </strong>

                                    <?php echo e($formation->filiere->nom ?? '—'); ?>

                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>
                                    <strong>
                                        <i class="fas fa-clock mr-1"></i>
                                        Durée :
                                    </strong>

                                    <?php echo e($formation->duree_formatee); ?>

                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Coût :
                                    </strong>

                                    <?php echo e($formation->cout_formate); ?>

                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-user mr-1"></i>
                                        Créée par :
                                    </strong>

                                    <?php echo e($formation->createur->name ?? '—'); ?>

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <hr>

                
                <?php if($formation->objectifs): ?>

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-bullseye mr-2 text-primary"></i>
                            Objectifs de la formation
                        </h4>

                        <div class="p-3 bg-light rounded">
                            <?php echo nl2br(e($formation->objectifs)); ?>

                        </div>

                    </div>

                <?php endif; ?>

                
                <?php if($formation->contenu_programme): ?>

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-book-open mr-2 text-primary"></i>
                            Contenu du programme
                        </h4>

                        <div class="p-3 bg-light rounded">
                            <?php echo nl2br(e($formation->contenu_programme)); ?>

                        </div>

                    </div>

                <?php endif; ?>

                
                <?php if($formation->public_cible): ?>

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-users mr-2 text-primary"></i>
                            Public cible
                        </h4>

                        <div class="p-3 bg-light rounded">
                            <?php echo nl2br(e($formation->public_cible)); ?>

                        </div>

                    </div>

                <?php endif; ?>

                
                <?php if($formation->mots_cles_array): ?>

                    <div class="mb-4">

                        <h4>
                            <i class="fas fa-tags mr-2 text-primary"></i>
                            Mots-clés
                        </h4>

                        <?php $__currentLoopData = $formation->mots_cles_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge badge-secondary mr-1 mb-1">
                                <?php echo e($mot); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Sessions de cette formation
                </h3>

                <?php if (! (auth()->user()->hasRole('user'))): ?>
                    <a href="<?php echo e(route('admin.sessions-formation.create', ['formation_id' => $formation->id])); ?>"
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>
                        Nouvelle session
                    </a>
                <?php endif; ?>

            </div>

            <div class="card-body">

                <?php if($formation->sessions->count()): ?>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="thead-light">

                                <tr>
                                    <th>Dates</th>
                                    <th>Lieu</th>
                                    <th>Places</th>
                                    <th>Statut</th>
                                    <th width="100">Actions</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php $__currentLoopData = $formation->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>

                                        <td>

                                            <?php echo e(\Carbon\Carbon::parse($session->date_debut)->format('d/m/Y')); ?>


                                            <?php if($session->date_fin): ?>
                                                →
                                                <?php echo e(\Carbon\Carbon::parse($session->date_fin)->format('d/m/Y')); ?>

                                            <?php endif; ?>

                                        </td>

                                        <td>
                                            <?php echo e($session->lieu ?? '—'); ?>

                                        </td>

                                        <td>
                                            <?php echo e($session->places_disponibles ?? '—'); ?>

                                        </td>

                                        <td>

                                            <?php
                                                $badge = match ($session->statut) {
                                                    'ouverte' => 'badge-success',
                                                    'cloturee' => 'badge-danger',
                                                    'brouillon' => 'badge-warning',
                                                    default => 'badge-secondary',
                                                };
                                            ?>

                                            <span class="badge <?php echo e($badge); ?>">
                                                <?php echo e(ucfirst($session->statut)); ?>

                                            </span>

                                        </td>

                                        <td>

                                            <a href="<?php echo e(route('admin.sessions-formation.edit', $session)); ?>"
                                               class="btn btn-warning btn-sm"
                                               title="Modifier">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <div class="text-center py-4 text-muted">

                        <i class="fas fa-calendar-times fa-3x mb-3"></i>

                        <p class="mb-0">
                            Aucune session n'est encore associée à cette formation.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </div>


        
        <div class="mt-3 mb-4">

            <a href="<?php echo e(route('admin.formations.index')); ?>"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>
                Retour aux formations

            </a>

            <?php if (! (auth()->user()->hasRole('user'))): ?>

                <a href="<?php echo e(route('admin.formations.edit', $formation)); ?>"
                   class="btn btn-warning">

                    <i class="fas fa-edit mr-1"></i>
                    Modifier

                </a>

            <?php endif; ?>

        </div>
        <br>

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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\formations\show.blade.php ENDPATH**/ ?>