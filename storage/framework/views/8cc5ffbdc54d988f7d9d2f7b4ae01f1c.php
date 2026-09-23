<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Formations']); ?>

    <div class="container-fluid">

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-2"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">

                    <h3 class="card-title mb-0">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Liste des formations
                    </h3>

                    <?php if (! (auth()->user()->hasRole('user'))): ?>
                        <a href="<?php echo e(route('admin.formations.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i>
                            Nouvelle formation
                        </a>
                    <?php endif; ?>

                </div>
            </div>

            <div class="card-body">

                
                <form method="GET" action="<?php echo e(route('admin.formations.index')); ?>" class="mb-4">

                    <div class="row">

                        
                        <div class="col-md-4">
                            <label>Recherche</label>

                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Titre, résumé, mots-clés..." value="<?php echo e(request('search')); ?>">

                                <div class="input-group-append">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-2">
                            <label>Type</label>

                            <select name="type" class="form-control">
                                <option value="">Tous</option>

                                <option value="academique" <?php echo e(request('type') == 'academique' ? 'selected' : ''); ?>>
                                    Académique
                                </option>

                                <option value="continue_programmee"
                                    <?php echo e(request('type') == 'continue_programmee' ? 'selected' : ''); ?>>
                                    Continue Programmée
                                </option>

                                <option value="continue_a_la_carte"
                                    <?php echo e(request('type') == 'continue_a_la_carte' ? 'selected' : ''); ?>>
                                    Continue à la Carte
                                </option>
                            </select>
                        </div>

                        
                        <div class="col-md-2">
                            <label>Filière</label>

                            <select name="filiere_id" class="form-control">
                                <option value="">Toutes</option>

                                <?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($filiere->id); ?>"
                                        <?php echo e(request('filiere_id') == $filiere->id ? 'selected' : ''); ?>>
                                        <?php echo e($filiere->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-md-2">
                            <label>Catégorie</label>

                            <select name="categorie_id" class="form-control">
                                <option value="">Toutes</option>

                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($categorie->id); ?>"
                                        <?php echo e(request('categorie_id') == $categorie->id ? 'selected' : ''); ?>>
                                        <?php echo e($categorie->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="col-md-2">
                            <label>Statut</label>

                            <select name="statut" class="form-control">
                                <option value="">Tous</option>

                                <option value="ouverte" <?php echo e(request('statut') == 'ouverte' ? 'selected' : ''); ?>>
                                    Ouverte
                                </option>

                                <option value="cloturee" <?php echo e(request('statut') == 'cloturee' ? 'selected' : ''); ?>>
                                    Clôturée
                                </option>

                                <option value="brouillon" <?php echo e(request('statut') == 'brouillon' ? 'selected' : ''); ?>>
                                    Brouillon
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-filter mr-1"></i>
                            Filtrer
                        </button>

                        <a href="<?php echo e(route('admin.formations.index')); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-redo mr-1"></i>
                            Réinitialiser
                        </a>
                    </div>

                </form>

                
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="thead-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Formation</th>
                                <th>Type</th>
                                <th>Filière</th>
                                <th>Catégorie</th>
                                <th>Durée</th>
                                <th>Coût</th>
                                <th>Statut</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $__empty_1 = true; $__currentLoopData = $formations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>

                                    <td>
                                        <?php echo e($formations->firstItem() + $loop->index); ?>

                                    </td>

                                    <td>
                                        <strong>
                                            <?php echo e($formation->titre); ?>

                                        </strong>

                                        <?php if($formation->resume): ?>
                                            <div class="small text-muted mt-1">
                                                <?php echo e(Str::limit($formation->resume, 80)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="badge badge-info">
                                            <?php echo e($formation->type_libelle); ?>

                                        </span>
                                    </td>

                                    <td>
                                        <?php echo e($formation->filiere->nom ?? '—'); ?>

                                    </td>

                                    <td>
                                        <?php echo e($formation->categorie->nom ?? '—'); ?>

                                    </td>

                                    <td>
                                        <?php echo e($formation->duree); ?>

                                    </td>

                                    <td>
                                        <?php echo e($formation->cout_formate); ?>

                                    </td>

                                    <td>
                                        <span class="badge <?php echo e($formation->statut_badge); ?>">
                                            <?php echo e($formation->statut_libelle); ?>

                                        </span>
                                    </td>

                                    <td>

                                        <div class="btn-group">

                                            
                                            <a href="<?php echo e(route('admin.formations.show', $formation)); ?>"
                                                class="btn btn-info btn-sm" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <?php if (! (auth()->user()->hasRole('user'))): ?>
                                                
                                                <a href="<?php echo e(route('admin.formations.edit', $formation)); ?>"
                                                    class="btn btn-warning btn-sm" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#modalSuppression<?php echo e($formation->id); ?>" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php endif; ?>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>
                                    <td colspan="9" class="text-center py-5">

                                        <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>

                                        <h5>Aucune formation trouvée</h5>

                                        <p class="text-muted">
                                            Aucune formation ne correspond aux critères sélectionnés.
                                        </p>

                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                
                <?php if($formations->hasPages()): ?>
                    <div class="mt-3">
                        <?php echo e($formations->links()); ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>

    
    <?php if (! (auth()->user()->hasRole('user'))): ?>
        <?php $__currentLoopData = $formations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="modal fade" id="modalSuppression<?php echo e($formation->id); ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
                                Confirmer la suppression
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <p class="mb-0">
                                Voulez-vous vraiment supprimer la formation
                                « <strong><?php echo e($formation->titre); ?></strong> » ?
                            </p>

                            <?php if($formation->sessions()->exists()): ?>
                                <div class="alert alert-warning mt-3 mb-0">
                                    <i class="fas fa-triangle-exclamation mr-1"></i>
                                    Cette formation possède des sessions actives.
                                    La suppression sera refusée tant qu'elles n'auront pas été retirées.
                                </div>
                            <?php else: ?>
                                <p class="text-muted small mb-0 mt-2">
                                    Cette action est irréversible.
                                </p>
                            <?php endif; ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Annuler
                            </button>

                            <form action="<?php echo e(route('admin.formations.destroy', $formation)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash mr-1"></i>
                                    Supprimer définitivement
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/admin/formations/index.blade.php ENDPATH**/ ?>