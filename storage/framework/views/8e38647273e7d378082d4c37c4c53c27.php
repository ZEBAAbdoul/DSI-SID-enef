<?php $hidden = $hidden ?? false; ?>
<article class="news-card" <?php if($hidden): ?> aria-hidden="true" <?php endif; ?>>
    <div class="news-thumb">
        <img src="<?php echo e($actualite->image); ?>" alt="<?php echo e($hidden ? '' : $actualite->titre); ?>">
        <span class="date"><?php echo e($actualite->created_at->translatedFormat('d M Y')); ?></span>
    </div>
    <div class="news-body">
        <span class="news-cat"><?php echo e($actualite->type_libelle); ?></span>
        <h3><?php echo e($actualite->titre); ?></h3>
        <p><?php echo e($actualite->chapo ?? $actualite->resume); ?></p>
        <a class="news-link" href="<?php echo e(route('actualites.show', $actualite->slug)); ?>">Lire la suite
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M13 6l6 6-6 6" />
            </svg></a>
    </div>
</article><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/partials/news-card.blade.php ENDPATH**/ ?>