<?php $__env->startSection('title', $actualite->titre . ' - ENEF'); ?>

<?php $__env->startSection('content'); ?>

<div class="container py-5">

    <div class="row g-5">

        
        <div class="col-lg-8">

            
            <div class="mb-3">

                <span class="badge <?php echo e($actualite->type_badge); ?>">
                    <?php echo e($actualite->type_libelle); ?>

                </span>

            </div>


            
            <h1 class="fw-bold mb-3">
                <?php echo e($actualite->titre); ?>

            </h1>


            
            <div class="text-muted mb-4">

                <i class="far fa-calendar-alt me-2"></i>

                Publié le
                <?php echo e($actualite->created_at->format('d/m/Y à H:i')); ?>


            </div>


            
            <div class="mb-4">

                <img
                    src="<?php echo e($actualite->image); ?>"
                    alt="<?php echo e($actualite->titre); ?>"
                    class="img-fluid rounded shadow-sm w-100"
                    style="max-height:500px; object-fit:cover;"
                >

            </div>


            
            <?php if($actualite->chapo): ?>

                <div class="lead fw-semibold mb-4">

                    <?php echo e($actualite->chapo); ?>


                </div>

            <?php endif; ?>


            
            <div
                class="actualite-contenu"
                style="line-height:1.9;"
            >

                <?php echo nl2br(e($actualite->contenu)); ?>


            </div>


            
            <div class="mt-5">

                <a
                    href="<?php echo e(route('actualites.index')); ?>"
                    class="btn btn-outline-success"
                >

                    <i class="fas fa-arrow-left me-1"></i>

                    Retour aux actualités

                </a>

            </div>

        </div>


        
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-success text-white">

                    <strong>
                        Actualités récentes
                    </strong>

                </div>


                <div class="list-group list-group-flush">

                    <?php $__empty_1 = true; $__currentLoopData = $recentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <a
                            href="<?php echo e(route('actualites.show', $recente->slug)); ?>"
                            class="list-group-item list-group-item-action"
                        >

                            <div class="fw-bold">

                                <?php echo e(Str::limit($recente->titre, 70)); ?>


                            </div>

                            <small class="text-muted">

                                <?php echo e($recente->created_at->format('d/m/Y')); ?>


                            </small>

                        </a>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <div class="p-3 text-muted">
                            Aucune autre actualité.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\actualites\show.blade.php ENDPATH**/ ?>