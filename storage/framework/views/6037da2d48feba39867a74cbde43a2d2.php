<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Témoignages']); ?>
    <div class="container-fluid py-3">
        <div class="mb-3">
            <h1 class="h3 mb-0">Modération des témoignages</h1>
            <small class="text-muted">Les témoignages sont rédigés par les élèves. Vous pouvez les publier sur la page
                d'accueil, les retirer ou les supprimer.</small>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <form method="GET" class="card card-body mb-3">
            <div class="form-row align-items-end">
                <div class="form-group col-md-6 mb-md-0">
                    <label for="q" class="mb-1">Recherche</label>
                    <input type="text" id="q" name="q" value="<?php echo e(request('q')); ?>" class="form-control"
                        placeholder="Auteur, contenu, formation…">
                </div>
                <div class="form-group col-md-3 mb-md-0">
                    <label for="statut" class="mb-1">Statut</label>
                    <select id="statut" name="statut" class="form-control">
                        <option value="">Tous</option>
                        <option value="en_attente" <?php if(request('statut') === 'en_attente'): echo 'selected'; endif; ?>>En attente</option>
                        <option value="publie" <?php if(request('statut') === 'publie'): echo 'selected'; endif; ?>>Publiés</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success">Filtrer</button>
                    <a href="<?php echo e(route('admin.temoignages.index')); ?>" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:220px;">Auteur</th>
                            <th>Témoignage</th>
                            <th style="width:90px;">Note</th>
                            <th style="width:120px;">Statut</th>
                            <th style="width:120px;">Reçu le</th>
                            <th style="width:210px;" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $temoignages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temoignage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center" style="gap:10px;">
                                        <?php if($temoignage->image_url): ?>
                                            <img src="<?php echo e(asset($temoignage->image_url)); ?>"
                                                alt="<?php echo e($temoignage->auteur); ?>" class="rounded-circle"
                                                style="width:40px;height:40px;object-fit:cover;">
                                        <?php else: ?>
                                            <span
                                                class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center"
                                                style="width:40px;height:40px;font-weight:700;">
                                                <?php echo e(\Illuminate\Support\Str::upper(mb_substr($temoignage->auteur, 0, 1))); ?>

                                            </span>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight:600;"><?php echo e($temoignage->auteur); ?></div>
                                            <small class="text-muted"><?php echo e($temoignage->fonction); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><?php echo e($temoignage->contenu); ?></div>
                                    <?php if($temoignage->formation_concernee): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-graduation-cap"></i> <?php echo e($temoignage->formation_concernee); ?>

                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-warning" style="white-space:nowrap;">
                                    <?php echo e(str_repeat('★', $temoignage->note)); ?><?php echo e(str_repeat('☆', 5 - $temoignage->note)); ?>

                                </td>
                                <td>
                                    <?php if($temoignage->est_publie): ?>
                                        <span class="badge badge-success">Publié</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">En attente</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo e($temoignage->created_at?->format('d/m/Y')); ?></small></td>
                                <td class="text-right" style="white-space:nowrap;">
                                    <form action="<?php echo e(route('admin.temoignages.toggle', $temoignage)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <?php if($temoignage->est_publie): ?>
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-eye-slash"></i> Dépublier
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Publier
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <form action="<?php echo e(route('admin.temoignages.destroy', $temoignage)); ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer définitivement ce témoignage ?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Aucun témoignage trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($temoignages->hasPages()): ?>
                <div class="card-footer"><?php echo e($temoignages->links('pagination::bootstrap-4')); ?></div>
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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\temoignages\index.blade.php ENDPATH**/ ?>