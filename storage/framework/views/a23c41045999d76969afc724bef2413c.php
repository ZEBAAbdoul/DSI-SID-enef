

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

    <?php $__env->startSection('title', 'Détail de la photo'); ?>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-image mr-2"></i>
                Détail de la photo
            </h3>

            <div class="card-tools">

                <a
                    href="<?php echo e(route('admin.photos.edit', $photo)); ?>"
                    class="btn btn-warning btn-sm"
                >
                    <i class="fas fa-edit mr-1"></i>
                    Modifier
                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="row">

                
                <div class="col-md-7 text-center">

                    <?php if($photo->image_url): ?>

                        <img
                            src="<?php echo e(asset($photo->image_url)); ?>"
                            alt="<?php echo e($photo->titre); ?>"
                            class="img-fluid img-thumbnail"
                            style="max-height:500px; cursor: pointer;"
                            onclick="openLightbox()"
                        >

                    <?php else: ?>

                        <div class="text-muted py-5">

                            <i class="fas fa-image fa-4x"></i>

                            <p class="mt-2">
                                Aucune image disponible.
                            </p>

                        </div>

                    <?php endif; ?>

                </div>


                
                <div class="col-md-5">

                    <h4 class="mb-3">
                        <?php echo e($photo->titre); ?>

                    </h4>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-align-left mr-1"></i>
                            Description
                        </strong>

                        <div class="text-muted mt-1">

                            <?php if($photo->description): ?>

                                <?php echo nl2br(e($photo->description)); ?>


                            <?php else: ?>

                                <em>
                                    Aucune description.
                                </em>

                            <?php endif; ?>

                        </div>

                    </div>


                    <hr>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-sort-numeric-down mr-1"></i>
                            Ordre
                        </strong>

                        <span class="ml-2">
                            <?php echo e($photo->ordre); ?>

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-eye mr-1"></i>
                            Visibilité
                        </strong>

                        <span class="ml-2">

                            <?php if($photo->est_visible): ?>

                                <span class="badge badge-success">
                                    <i class="fas fa-check mr-1"></i>
                                    Visible
                                </span>

                            <?php else: ?>

                                <span class="badge badge-secondary">
                                    <i class="fas fa-times mr-1"></i>
                                    Masquée
                                </span>

                            <?php endif; ?>

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-plus mr-1"></i>
                            Créée le
                        </strong>

                        <span class="ml-2">
                            <?php echo e($photo->created_at?->format('d/m/Y H:i')); ?>

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-edit mr-1"></i>
                            Modifiée le
                        </strong>

                        <span class="ml-2">
                            <?php echo e($photo->updated_at?->format('d/m/Y H:i')); ?>

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="card-footer">

            <a
                href="<?php echo e(route('admin.photos.index')); ?>"
                class="btn btn-secondary"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Retour à la liste
            </a>

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
<?php endif; ?>

<!-- Lightbox personnalisée -->
<div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.95); z-index: 9999; justify-content: center; align-items: center;">
    <button onclick="closeLightbox()" style="position: absolute; top: 20px; right: 20px; background: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 24px; cursor: pointer; z-index: 10000;">&times;</button>
    
    <div style="text-align: center; max-width: 90%; max-height: 90%;">
        <h3 id="lightboxTitle" style="color: white; margin-bottom: 10px;"></h3>
        <img id="lightboxImage" src="" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
    </div>
</div>

<script>
function openLightbox() {
    const photoUrl = '<?php echo e(asset($photo->image_url)); ?>';
    const photoTitle = '<?php echo e($photo->titre); ?>';
    
    document.getElementById('lightboxTitle').textContent = photoTitle;
    document.getElementById('lightboxImage').src = photoUrl;
    
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Fermer avec Escape
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').style.display === 'flex') {
        if (e.key === 'Escape') {
            closeLightbox();
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

<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\photos\show.blade.php ENDPATH**/ ?>