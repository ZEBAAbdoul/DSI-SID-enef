
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

    <?php $__env->startSection('title', 'Photos'); ?>

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
                <i class="fas fa-images mr-2"></i>
                Photos
            </h3>

            <div class="card-tools">

                <a
                    href="<?php echo e(route('admin.photos.create')); ?>"
                    class="btn btn-primary btn-sm"
                >
                    <i class="fas fa-plus"></i>
                    Nouvelle photo
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

                            <th style="width:60px;">
                                #
                            </th>

                            <th style="width:130px;">
                                IMAGE
                            </th>

                            <th>
                                TITRE
                            </th>

                            <th style="width:100px;">
                                ORDRE
                            </th>

                            <th style="width:120px;">
                                VISIBILITÉ
                            </th>

                            <th style="width:150px;">
                                ACTIONS
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr>

                                
                                <td class="text-center">
                                    <?php echo e($loop->iteration); ?>

                                </td>


                                
                                <td class="text-center">

                                    <?php if($photo->image_url): ?>

                                        <img
                                            src="<?php echo e(asset($photo->image_url)); ?>"
                                            alt="<?php echo e($photo->titre); ?>"
                                            class="img-thumbnail"
                                            style="
                                                width:100px;
                                                height:70px;
                                                object-fit:cover;
                                                cursor: pointer;
                                            "
                                            onclick="openLightbox(<?php echo e($loop->index); ?>)"
                                        >

                                    <?php else: ?>

                                        <i class="fas fa-image fa-2x text-muted"></i>

                                    <?php endif; ?>

                                </td>


                                
                                <td>

                                    <strong>
                                        <i class="fas fa-image text-primary mr-1"></i>
                                        <?php echo e($photo->titre); ?>

                                    </strong>

                                    <?php if($photo->description): ?>

                                        <div class="text-muted small mt-1">
                                            <?php echo e(\Illuminate\Support\Str::limit($photo->description, 100)); ?>

                                        </div>

                                    <?php endif; ?>

                                </td>


                                
                                <td class="text-center">
                                    <?php echo e($photo->ordre); ?>

                                </td>


                                
                                <td class="text-center">

                                    <?php if($photo->est_visible): ?>

                                        <span class="badge badge-success">
                                            <i class="fas fa-eye mr-1"></i>
                                            Visible
                                        </span>

                                    <?php else: ?>

                                        <span class="badge badge-secondary">
                                            <i class="fas fa-eye-slash mr-1"></i>
                                            Masquée
                                        </span>

                                    <?php endif; ?>

                                </td>


                                
                                <td>

                                    
                                    <a
                                        href="<?php echo e(route('admin.photos.show', $photo)); ?>"
                                        class="btn btn-sm btn-info"
                                        title="Voir"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    
                                    <a
                                        href="<?php echo e(route('admin.photos.edit', $photo)); ?>"
                                        class="btn btn-sm btn-warning"
                                        title="Modifier"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    
                                    <form
                                        action="<?php echo e(route('admin.photos.destroy', $photo)); ?>"
                                        method="POST"
                                        style="display:inline-block;"
                                        class="delete-photo-form"
                                        data-photo-titre="<?php echo e($photo->titre); ?>"
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

                                    <i class="fas fa-images fa-2x mb-2"></i>

                                    <br>

                                    Aucune photo trouvée.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        
        <?php if($photos instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>

            <div class="card-footer">
                <?php echo e($photos->withQueryString()->links()); ?>

            </div>

        <?php endif; ?>

    </div>


    
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            document
                .querySelectorAll('form.delete-photo-form')
                .forEach(function (form) {

                    form.addEventListener('submit', function (event) {

                        event.preventDefault();

                        const titre = form.getAttribute(
                            'data-photo-titre'
                        );

                        Swal.fire({

                            title: 'Supprimer cette photo ?',

                            html:
                                'La photo <strong>« ' +
                                titre +
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

<!-- Lightbox personnalisée avec navigation -->
<div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); z-index: 9999; justify-content: center; align-items: center;">
    <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 20px; background: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 24px; cursor: pointer; z-index: 10000;">&times;</button>
    
    <button onclick="navigateLightbox(-1)" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; color: white; cursor: pointer;">&#10094;</button>
    
    <div style="text-align: center; max-width: 90%; max-height: 90%;">
        <h3 id="lightboxTitle" style="color: white; margin-bottom: 10px;"></h3>
        <img id="lightboxImage" src="" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
        <p id="lightboxCounter" style="color: white; margin-top: 10px;"></p>
    </div>
    
    <button onclick="navigateLightbox(1)" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.2); border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; color: white; cursor: pointer;">&#10095;</button>
</div>

<script>
window.currentPagePhotos = <?php echo json_encode($photos->items(), 15, 512) ?>;
window.currentPhotoIndex = 0;

function openLightbox(index) {
    window.currentPhotoIndex = index;
    const photo = window.currentPagePhotos[index];
    
    document.getElementById('lightboxTitle').textContent = photo.titre;
    document.getElementById('lightboxImage').src = '/storage/' + photo.image_url;
    document.getElementById('lightboxCounter').textContent = (index + 1) + ' / ' + window.currentPagePhotos.length;
    
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function navigateLightbox(direction) {
    const newIndex = (window.currentPhotoIndex + direction + window.currentPagePhotos.length) % window.currentPagePhotos.length;
    openLightbox(newIndex);
}

// Fermer avec Escape
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').style.display === 'flex') {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            navigateLightbox(1);
        } else if (e.key === 'ArrowLeft') {
            navigateLightbox(-1);
        }
    }
});

// Fermer en cliquant sur le fond
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>

<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\photos\index.blade.php ENDPATH**/ ?>