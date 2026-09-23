<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Toutes les idées']); ?>
    <div class="container-fluid py-3">
        <div class="mb-3">
            <h1 class="h3 mb-0">Boîte à idées</h1>
            <small class="text-muted">Toutes les idées du personnel. Ouvrez une idée pour la traiter et répondre à son auteur.</small>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <div class="mb-3">
            <a href="<?php echo e(route('admin.idees-direction.index')); ?>"
                class="btn btn-sm <?php echo e(request('statut') ? 'btn-outline-secondary' : 'btn-secondary'); ?>">
                Toutes (<?php echo e($compteurs->sum()); ?>)
            </a>
            <?php $__currentLoopData = \App\Models\Idee::STATUTS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cle => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.idees-direction.index', ['statut' => $cle])); ?>"
                    class="btn btn-sm <?php echo e(request('statut') === $cle ? 'btn-' . $s['badge'] : 'btn-outline-' . $s['badge']); ?>">
                    <?php echo e($s['label']); ?> (<?php echo e($compteurs[$cle] ?? 0); ?>)
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <form method="GET" class="card card-body mb-3">
            <input type="hidden" name="statut" value="<?php echo e(request('statut')); ?>">
            <div class="form-row align-items-end">
                <div class="form-group col-md-6 mb-md-0">
                    <label for="q" class="mb-1">Recherche</label>
                    <input type="text" id="q" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                        placeholder="Titre ou contenu…">
                </div>
                <div class="form-group col-md-3 mb-md-0">
                    <label for="categorie" class="mb-1">Domaine</label>
                    <select id="categorie" name="categorie" class="form-control">
                        <option value="">Tous</option>
                        <?php $__currentLoopData = \App\Models\Idee::CATEGORIES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cle => $libelle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cle); ?>" <?php if(request('categorie') === $cle): echo 'selected'; endif; ?>><?php echo e($libelle); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Filtrer</button>
                    <a href="<?php echo e(route('admin.idees-direction.index')); ?>" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Idée</th>
                            <th style="width:200px;">Auteur</th>
                            <th style="width:170px;">Domaine</th>
                            <th style="width:120px;">Statut</th>
                            <th style="width:110px;">Reçue le</th>
                            <th style="width:100px;" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $idees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div style="font-weight:600;"><?php echo e($idee->titre); ?></div>
                                    <small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($idee->description, 90)); ?></small>
                                </td>
                                <td><?php echo e($idee->auteur_nom); ?></td>
                                <td><small><?php echo e($idee->categorie_libelle ?? '—'); ?></small></td>
                                <td><span class="badge badge-<?php echo e($idee->statut_badge); ?>"><?php echo e($idee->statut_libelle); ?></span></td>
                                <td><small><?php echo e($idee->created_at?->format('d/m/Y')); ?></small></td>
                                <td class="text-right">
                                    <a href="<?php echo e(route('admin.idees-direction.show', $idee)); ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Ouvrir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Aucune idée trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($idees->hasPages()): ?>
                <div class="card-footer"><?php echo e($idees->links('pagination::bootstrap-4')); ?></div>
            <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\idees-direction\index.blade.php ENDPATH**/ ?>