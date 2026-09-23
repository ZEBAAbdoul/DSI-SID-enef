<?php
    $compact = $compact ?? false;
    $reverse = $reverse ?? false;

    // Assez de cartes pour une boucle continue, même avec peu de témoignages
    $count = $temoignages->count();
    $cards = $count < 5
        ? collect(range(1, (int) ceil(5 / $count)))->flatMap(fn () => $temoignages)->values()
        : $temoignages;
?>

<div class="testi-track <?php echo e($reverse ? 'testi-track--reverse' : ''); ?>"
    style="animation-duration: <?php echo e(max(35, $cards->count() * ($compact ? 6 : 8))); ?>s;">
    <?php for($g = 0; $g < 2; $g++): ?>
        <div class="testi-group" <?php if($g === 1): ?> aria-hidden="true" <?php endif; ?>>
            <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temoignage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $note = max(0, min(5, (int) $temoignage->note));
                    $initiales = \Illuminate\Support\Str::of($temoignage->auteur)
                        ->explode(' ')
                        ->filter()
                        ->map(fn ($mot) => mb_substr($mot, 0, 1))
                        ->take(2)
                        ->implode('');
                ?>
                <article class="testi-card">
                    <span class="testi-quote" aria-hidden="true">“</span>

                    <div class="testi-stars" aria-label="Note : <?php echo e($note); ?> sur 5">
                        <?php echo str_repeat('★', $note); ?><?php echo str_repeat('☆', 5 - $note); ?>

                    </div>

                    <div class="testi-body">
                        <p class="testi-text"><?php echo e($temoignage->contenu); ?></p>
                        <button type="button" class="testi-more" hidden
                            <?php if($g === 1): ?> tabindex="-1" <?php endif; ?>>Lire la suite</button>
                    </div>

                    <?php if($temoignage->formation_concernee): ?>
                        <span class="testi-formation"><?php echo e($temoignage->formation_concernee); ?></span>
                    <?php endif; ?>

                    <div class="testi-who">
                        <?php if($temoignage->image_url): ?>
                            <img src="<?php echo e(asset($temoignage->image_url)); ?>" alt="<?php echo e($temoignage->auteur); ?>"
                                class="testi-avatar" loading="lazy">
                        <?php else: ?>
                            <span class="testi-avatar testi-avatar-initials"><?php echo e(\Illuminate\Support\Str::upper($initiales)); ?></span>
                        <?php endif; ?>
                        <div>
                            <span class="testi-name"><?php echo e($temoignage->auteur); ?></span>
                            <?php if($temoignage->fonction): ?>
                                <span class="testi-role"><?php echo e($temoignage->fonction); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endfor; ?>
</div><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/partials/testimonials-track.blade.php ENDPATH**/ ?>