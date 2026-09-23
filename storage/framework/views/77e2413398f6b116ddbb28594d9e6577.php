<?php $__env->startSection('title', $actualite->titre . ' — ENEF'); ?>

<?php $__env->startSection('content'); ?>

    <section style="padding-top:40px;">
        <div class="container" style="max-width:780px;">

            <span class="kicker"><?php echo e($actualite->type_libelle); ?></span>
            <h1 style="font-size:clamp(26px,3.5vw,38px);"><?php echo e($actualite->titre); ?></h1>
            <p style="color:var(--ink-soft);font-size:14px;margin-bottom:24px;">
                Publié le <?php echo e($actualite->created_at->translatedFormat('d F Y')); ?>

            </p>

            <?php if($actualite->image_couverture_url): ?>
                <img src="<?php echo e($actualite->image); ?>" alt="<?php echo e($actualite->titre); ?>"
                    style="width:100%; max-height:420px; object-fit:cover; border:1px solid var(--line); margin-bottom:28px;">
            <?php endif; ?>

            <?php if($actualite->chapo): ?>
                <p style="font-size:18px; font-weight:600; color:var(--forest-deep);"><?php echo e($actualite->chapo); ?></p>
            <?php endif; ?>

            <div style="white-space:pre-line; font-size:15.5px; line-height:1.7;">
                <?php echo e($actualite->contenu); ?>

            </div>

            <div style="margin-top:36px;">
                <a href="<?php echo e(route('actualites.index')); ?>" class="btn btn-outline">Retour aux actualités</a>
            </div>

        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/actualites/show.blade.php ENDPATH**/ ?>