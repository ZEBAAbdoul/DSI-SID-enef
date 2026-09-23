<?php $__env->startSection('title', 'Mot du Directeur Général — ENEF'); ?>

<?php $__env->startSection('content'); ?>

    <section style="padding:60px 0;">
        <div class="container dg-section">
            <div class="dg-portrait">
                <?php if($param_site && $param_site->mot_dg_photo_url): ?>
                    <img src="<?php echo e(asset($param_site->mot_dg_photo_url)); ?>"
                        alt="Photo du <?php echo e($param_site->mot_dg_nom ?? 'Directeur Général'); ?>" class="dg-photo">
                <?php else: ?>
                    <img src="<?php echo e(asset('images/DG.jpg')); ?>" alt="Photo du Directeur Général" class="dg-photo">
                <?php endif; ?>

                <span class="cap">
                    <b><?php echo e($param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO'); ?></b>
                    <?php echo e($param_site->mot_dg_titre ?? "Directeur Général de l'ENEF"); ?>

                </span>
            </div>
            <div>
                <span class="section-head kicker" style="display:block;">Mot du Directeur Général</span>
                <div class="dg-message">
                    <?php echo nl2br(e($param_site->mot_dg_contenu ?? '')); ?>

                </div>
                <div class="dg-signoff">
                    <b><?php echo e($param_site->mot_dg_nom ?? 'Cdt R. SAWADOGO'); ?></b>
                    Directeur Général de l'École Nationale des Eaux et Forêts
                </div>
                <div style="margin-top:24px;">
                    <a href="<?php echo e(url('/')); ?>#dg" class="back-link">&larr; Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <style>
            .dg-message {
                font-family: "Fraunces", serif;
                font-size: 18px;
                line-height: 1.7;
                color: var(--ink);
                margin: 18px 0 24px;
            }

            .back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: var(--water);
    text-decoration: none;
    transition: color .2s ease, gap .2s ease;
}

.back-link:hover {
    color: var(--forest-deep);
    gap: 9px;
}
        </style>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\mot_directeur\index.blade.php ENDPATH**/ ?>