
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
    <?php $__env->startSection('title', 'Partenaires'); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Partenaires</h3>
            <div class="card-tools">
                <form action="<?php echo e(route('admin.partenaires.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="<?php echo e(request('recherche')); ?>" class="form-control"
                            placeholder="Rechercher un partenaire…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="<?php echo e(route('admin.partenaires.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouveau partenaire
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ORDRE</th>
                            <th>LOGO</th>
                            <th>NOM</th>
                            <th>TYPE</th>
                            <th>SITE WEB</th>
                            <th>ACTIF</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $partenaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partenaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($partenaire->ordre_affichage); ?></td>
                                <td>
                                    <?php if($partenaire->logo_url): ?>
                                        <img src="<?php echo e(asset($partenaire->logo_url)); ?>" alt="<?php echo e($partenaire->nom); ?>"
                                            style="max-height:35px;" class="border rounded p-1">
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($partenaire->nom); ?></td>
                                <td><?php echo e(ucfirst($partenaire->type)); ?></td>
                                <td>
                                    <?php if($partenaire->site_web): ?>
                                        <a href="<?php echo e($partenaire->site_web); ?>" target="_blank" rel="noopener">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($partenaire->actif ? 'badge-primary' : 'badge-danger'); ?>">
                                        <?php echo e($partenaire->actif ? 'Actif' : 'Inactif'); ?>

                                    </span>
                                </td>
                                <td>
                                <a href="<?php echo e(route('admin.partenaires.show', $partenaire)); ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.partenaires.edit', $partenaire)); ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                    <form action="<?php echo e(route('admin.partenaires.destroy', $partenaire)); ?>" method="POST" style="display:inline-block;"
                                        class="delete-partenaire-form"
                                        data-partenaire-nom="<?php echo e($partenaire->nom); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Aucun partenaire trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($partenaires->links()); ?>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if(session('status_partenaire')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: <?php echo json_encode(session('status_partenaire'), 15, 512) ?>,
                    timer: 2500,
                    showConfirmButton: false,
                });
            <?php endif; ?>

            document.querySelectorAll('form.delete-partenaire-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const nom = form.getAttribute('data-partenaire-nom');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer ce partenaire ?',
                        html: 'Le partenaire <strong>« ' + nom + ' »</strong> sera définitivement supprimé ainsi que son logo.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formToSubmit.submit();
                        }
                    });
                });
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/admin/partenaires/index.blade.php ENDPATH**/ ?>