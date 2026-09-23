

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

    <?php $__env->startSection('title', 'Catégories de documents'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-info">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


    <div class="card">

        
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-folder-open mr-2"></i>
                Catégories de documents
            </h3>

            <div class="card-tools">

                
                <form
                    action="<?php echo e(route('admin.categories-documents.index')); ?>"
                    method="GET"
                    class="form-inline"
                    style="display:inline-block;margin-right:10px;"
                >
                    <div class="input-group input-group-sm" style="width:240px;">

                        <input
                            type="text"
                            name="recherche"
                            value="<?php echo e(request('recherche')); ?>"
                            class="form-control"
                            placeholder="Rechercher une catégorie…"
                        >

                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>

                    </div>
                </form>


                
                <a
                    href="<?php echo e(route('admin.categories-documents.create')); ?>"
                    class="btn btn-primary btn-sm"
                >
                    <i class="fas fa-plus"></i>
                    Nouvelle catégorie
                </a>

            </div>
        </div>


        
        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover mb-0"
                    width="100%"
                    cellspacing="0"
                >

                    <thead>
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>NOM</th>

                            <th style="width:140px;">ACTIONS</th>
                        </tr>
                    </thead>


                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                
                                <td class="text-center">
                                    <?php echo e($loop->iteration); ?>

                                </td>


                                
                                <td>
                                    <strong>
                                        <i class="fas fa-folder text-warning mr-1"></i>
                                        <?php echo e($categorie->nom); ?>

                                    </strong>
                                </td>


                                
                                <td>
                                    
                                    <a
                                        href="<?php echo e(route('admin.categories-documents.edit', $categorie)); ?>"
                                        class="btn btn-sm btn-warning"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    
                                    <form
                                        action="<?php echo e(route('admin.categories-documents.destroy', $categorie)); ?>"
                                        method="POST"
                                        style="display:inline-block;"
                                        class="delete-categorie-form"
                                        data-categorie-nom="<?php echo e($categorie->nom); ?>"
                                    >

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Supprimer"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >
                                    <i class="fas fa-folder-open fa-2x mb-2"></i>
                                    <br>
                                    Aucune catégorie de document trouvée.
                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        
        <?php if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>

            <div class="card-footer">
                <?php echo e($categories->withQueryString()->links()); ?>

            </div>

        <?php endif; ?>

    </div>


    
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form.delete-categorie-form')
                .forEach(function (form) {

                    form.addEventListener('submit', function (event) {

                        event.preventDefault();

                        const categorie = form.getAttribute(
                            'data-categorie-nom'
                        );

                        Swal.fire({

                            title: 'Supprimer cette catégorie ?',

                            html:
                                'La catégorie <strong>« ' +
                                categorie +
                                ' »</strong> sera définitivement supprimée.',

                            icon: 'warning',

                            showCancelButton: true,

                            confirmButtonColor: '#d33',

                            cancelButtonColor: '#6c757d',

                            confirmButtonText:
                                '<i class="fas fa-trash"></i> Oui, supprimer',

                            cancelButtonText:
                                'Annuler',

                        }).then(function (result) {

                            if (result.isConfirmed) {
                                form.submit();
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
<?php endif; ?>

<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\categories-documents\index.blade.php ENDPATH**/ ?>