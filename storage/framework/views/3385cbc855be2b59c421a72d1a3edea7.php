<?php $__env->startSection('title', $formation->titre . ' — ENEF'); ?>

<?php $__env->startSection('content'); ?>

    <section style="padding-top:40px;">
        <div class="container">

            <div class="section-head">
                <div>
                    <span class="kicker"><?php echo e($formation->categorie->nom ?? 'Formation'); ?></span>
                    <h2><?php echo e($formation->titre); ?></h2>
                    <p class="desc"><?php echo e($formation->resume); ?></p>
                </div>
                <?php if($formation->type === 'continue_a_la_carte'): ?>
                    <span class="badge carte">À la carte</span>
                <?php else: ?>
                    <span class="badge prog"><?php echo e($formation->type_libelle); ?></span>
                <?php endif; ?>
            </div>

            <div class="course-meta" style="margin-bottom:32px;">
                <?php if($formation->duree): ?>
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 3" />
                        </svg>
                        <?php echo e($formation->duree); ?>

                    </span>
                <?php endif; ?>
                <span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    <?php echo e($formation->public_cible ?? 'Tous publics'); ?>

                </span>
                <?php if($formation->cout_indicatif): ?>
                    <span><?php echo e($formation->cout_formate ?? number_format($formation->cout_indicatif, 0, ',', ' ') . ' F CFA / participant'); ?></span>
                <?php endif; ?>
                <?php if($formation->filiere): ?>
                    <span>Filière : <?php echo e($formation->filiere->nom); ?></span>
                <?php endif; ?>
            </div>

            <?php if($formation->image_url): ?>
                <div style="margin-bottom:32px;">
                    <img src="<?php echo e(asset($formation->image_url)); ?>" alt="<?php echo e($formation->titre); ?>"
                        style="width:100%; max-height:420px; object-fit:cover; border:1px solid var(--line);">
                </div>
            <?php endif; ?>

            <?php if($formation->objectifs): ?>
                <h3>Objectifs</h3>
                <p style="white-space:pre-line;"><?php echo e($formation->objectifs); ?></p>
            <?php endif; ?>

            <?php if($formation->contenu_programme): ?>
                <h3>Programme</h3>
                <p style="white-space:pre-line;"><?php echo e($formation->contenu_programme); ?></p>
            <?php endif; ?>

            <?php if($formation->techniques || $formation->places_min || $formation->places_max || $formation->periode_indicative): ?>
                <h3>Infos pratiques</h3>
                <div class="module-infos">
                    <?php if($formation->techniques): ?>
                        <div><span class="lbl">Techniques pédagogiques</span><span><?php echo e($formation->techniques); ?></span></div>
                    <?php endif; ?>
                    <?php if($formation->places_min || $formation->places_max): ?>
                        <div><span class="lbl">Places par session</span><span><?php echo e($formation->places_min); ?> à <?php echo e($formation->places_max); ?> personnes</span></div>
                    <?php endif; ?>
                    <?php if($formation->periode_indicative): ?>
                        <div><span class="lbl">Période indicative</span><span><?php echo e($formation->periode_indicative); ?></span></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($formation->sessions && $formation->sessions->isNotEmpty()): ?>
                <h3>Prochaines sessions</h3>
                <ul class="sessions-list" style="margin-bottom:24px;">
                    <?php $__currentLoopData = $formation->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="session-item">
                            <span class="session-date">
                                <?php echo e(\Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y')); ?>

                                <?php if($session->date_fin): ?>
                                    → <?php echo e(\Carbon\Carbon::parse($session->date_fin)->translatedFormat('d M Y')); ?>

                                <?php endif; ?>
                            </span>
                            <span class="session-lieu"><?php echo e($session->lieu); ?></span>
                            <span class="session-places"><?php echo e($session->places_disponibles); ?> place(s) disponible(s)</span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>

            <?php if($formation->mots_cles): ?>
                <div style="margin-top:24px;display:flex;gap:9px;flex-wrap:wrap;">
                    <?php $__currentLoopData = $formation->mots_cles_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $motCle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="chip"><?php echo e($motCle); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <div style="margin-top:36px;display:flex;gap:14px;flex-wrap:wrap;">
                <?php if($formation->type === 'continue_a_la_carte'): ?>
                    <a href="<?php echo e(url('/')); ?>#admissions" class="btn btn-primary">Demander ce module</a>
                <?php else: ?>
                    <a href="<?php echo e(url('/')); ?>#admissions" class="btn btn-primary">Candidater à cette formation</a>
                <?php endif; ?>
                <a href="<?php echo e(route('catalogue.formations.initiales')); ?>" class="btn btn-outline">Retour au catalogue</a>
            </div>

        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <style>
            .module-infos {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 12px;
                margin: 18px 0 28px;
                background: var(--paper-alt);
                padding: 14px 16px;
            }

            .module-infos .lbl {
                display: block;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--ink-soft);
                margin-bottom: 2px;
            }

            .module-infos > div span:last-child { font-size: 13.5px; }
        </style>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\formations\show.blade.php ENDPATH**/ ?>