<?php $__env->startSection('title', 'ENEF — Catalogue de formations'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== EN-TÊTE CATALOGUE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Formation initiale et formation continue</div>
            <h1>Catalogue de formations initiales</h1>
            <p class="hero-lede">Cycles de formation initiale (Eaux et Forêts, Environnement) et formation continue
                2025-2026 — formations programmées à dates fixes et modules à la carte, conçus pour les
                professionnels de l'environnement et des ressources naturelles.</p>
            <div class="hero-ctas">
                <a href="<?php echo e(url('/')); ?>#admissions" class="btn btn-ghost-light">&larr; Retour à l'accueil</a>
            </div>
        </div>
    </section>

    <!-- ===================== CATALOGUE ===================== -->
    <section id="catalogue-complet">
        <div class="container">

            <div class="tabs" role="tablist">
                <button class="tab-btn" role="tab" aria-selected="true" data-filter-group="initiale">
                    Formations initiales <span class="count">(<?php echo e($formationsInitiales->count()); ?>)</span>
                </button>
                
            </div>

            <!-- ---------- Formations initiales ---------- -->
            <div class="catalogue-group" data-group-panel="initiale">
                <div class="catalogue-accordion">
                    <?php $__empty_1 = true; $__currentLoopData = $formationsInitiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            // Diplôme et conditions d'accès sont stockés dans objectifs / public_cible (voir seeder)
                            $diplome = \Illuminate\Support\Str::of($item->objectifs ?? '')
                                ->after('Diplôme délivré :')
                                ->trim()
                                ->rtrim('.');
                            $conditions = trim(\Illuminate\Support\Str::after($item->public_cible ?? '', 'Conditions d’accès :'));
                        ?>
                        <details class="module-card">
                            <summary>
                                <span class="module-code"><?php echo e($item->code_module); ?></span>
                                <span class="module-title"><?php echo e($item->titre); ?></span>
                                <span class="module-meta">
                                    <?php if($item->duree): ?>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 3" /></svg>
                                        <?php echo e($item->duree); ?>

                                    <?php endif; ?>
                                </span>
                                <span class="badge prog">Formation initiale</span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M6 9l6 6 6-6" /></svg>
                            </summary>

                            <div class="module-body">
                                <?php if($item->resume): ?>
                                    <p class="module-resume"><?php echo e($item->resume); ?></p>
                                <?php endif; ?>

                                <?php if($item->contenu_programme): ?>
                                    <h5>Contenu de la formation</h5>
                                    <p class="module-text"><?php echo nl2br(e($item->contenu_programme)); ?></p>
                                <?php endif; ?>

                                <div class="module-infos">
                                    <?php if($diplome->isNotEmpty()): ?>
                                        <div><span class="lbl">Diplôme</span><span><?php echo e($diplome); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->duree): ?>
                                        <div><span class="lbl">Durée de la formation</span><span><?php echo e($item->duree); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($conditions !== ''): ?>
                                        <div><span class="lbl">Conditions d'accès</span><span><?php echo nl2br(e($conditions)); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->cout_indicatif): ?>
                                        <div><span class="lbl">Frais de scolarité</span><span><?php echo e(number_format($item->cout_indicatif, 0, ',', ' ')); ?> F CFA / an</span></div>
                                    <?php endif; ?>
                                </div>

                                <a href="<?php echo e(route('formations.show', $item->slug)); ?>" class="btn btn-outline btn-sm">Voir la fiche du cycle</a>
                                
                            </div>
                        </details>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p style="color:var(--ink-soft);">Aucune formation initiale disponible pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ---------- Formations programmées ---------- -->
            <div class="catalogue-group" data-group-panel="programmee" hidden>
                <div class="catalogue-accordion">
                    <?php $__empty_1 = true; $__currentLoopData = $formationsProgrammees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <details class="module-card">
                            <summary>
                                <span class="module-code"><?php echo e($item->code_module); ?></span>
                                <span class="module-title"><?php echo e($item->titre); ?></span>
                                <span class="module-meta">
                                    <?php if($item->duree): ?>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 3" /></svg>
                                        <?php echo e($item->duree); ?>

                                    <?php endif; ?>
                                </span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M6 9l6 6 6-6" /></svg>
                            </summary>

                            <div class="module-body">
                                <?php if($item->resume): ?>
                                    <p class="module-resume"><?php echo e($item->resume); ?></p>
                                <?php endif; ?>

                                <?php if($item->objectifs): ?>
                                    <h5>Objectifs</h5>
                                    <p class="module-text"><?php echo nl2br(e($item->objectifs)); ?></p>
                                <?php endif; ?>

                                <?php if($item->contenu_programme): ?>
                                    <h5>Contenu de la formation</h5>
                                    <p class="module-text"><?php echo nl2br(e($item->contenu_programme)); ?></p>
                                <?php endif; ?>

                                <div class="module-infos">
                                    <?php if($item->public_cible): ?>
                                        <div><span class="lbl">Public cible</span><span><?php echo e($item->public_cible); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->techniques): ?>
                                        <div><span class="lbl">Techniques</span><span><?php echo e($item->techniques); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->cout_indicatif): ?>
                                        <div><span class="lbl">Coût</span><span><?php echo e(number_format($item->cout_indicatif, 0, ',', ' ')); ?> F CFA / participant</span></div>
                                    <?php endif; ?>
                                    <?php if($item->places_min || $item->places_max): ?>
                                        <div><span class="lbl">Places par session</span><span><?php echo e($item->places_min); ?> à <?php echo e($item->places_max); ?> personnes</span></div>
                                    <?php endif; ?>
                                    <?php if($item->periode_indicative): ?>
                                        <div><span class="lbl">Période indicative</span><span><?php echo e($item->periode_indicative); ?></span></div>
                                    <?php endif; ?>
                                </div>

                                <?php if($item->sessions && $item->sessions->isNotEmpty()): ?>
                                    <div class="sessions-block">
                                        <span class="sessions-title">Prochaines sessions</span>
                                        <ul class="sessions-list">
                                            <?php $__currentLoopData = $item->sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                    </div>
                                <?php endif; ?>

                                
                            </div>
                        </details>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p style="color:var(--ink-soft);">Aucune formation programmée disponible pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ---------- Formations à la carte ---------- -->
            <div class="catalogue-group" data-group-panel="carte" hidden>
                <div class="catalogue-accordion">
                    <?php $__empty_1 = true; $__currentLoopData = $formationsALaCarte; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <details class="module-card">
                            <summary>
                                <span class="module-code"><?php echo e($item->code_module); ?></span>
                                <span class="module-title"><?php echo e($item->titre); ?></span>
                                <span class="badge carte">À la carte</span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M6 9l6 6 6-6" /></svg>
                            </summary>

                            <div class="module-body">
                                <?php if($item->resume): ?>
                                    <p class="module-resume"><?php echo e($item->resume); ?></p>
                                <?php endif; ?>

                                <?php if($item->objectifs): ?>
                                    <h5>Objectifs</h5>
                                    <p class="module-text"><?php echo nl2br(e($item->objectifs)); ?></p>
                                <?php endif; ?>

                                <?php if($item->contenu_programme): ?>
                                    <h5>Contenu de la formation</h5>
                                    <p class="module-text"><?php echo nl2br(e($item->contenu_programme)); ?></p>
                                <?php endif; ?>

                                <div class="module-infos">
                                    <?php if($item->duree): ?>
                                        <div><span class="lbl">Volume horaire</span><span><?php echo e($item->duree); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->public_cible): ?>
                                        <div><span class="lbl">Public cible</span><span><?php echo e($item->public_cible); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->techniques): ?>
                                        <div><span class="lbl">Techniques</span><span><?php echo e($item->techniques); ?></span></div>
                                    <?php endif; ?>
                                    <?php if($item->places_min || $item->places_max): ?>
                                        <div><span class="lbl">Places par session</span><span><?php echo e($item->places_min); ?> à <?php echo e($item->places_max); ?> personnes</span></div>
                                    <?php endif; ?>
                                </div>

                                
                            </div>
                        </details>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p style="color:var(--ink-soft);">Aucun module à la carte disponible pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <style>
            #catalogue-complet { padding: 40px 0 80px; }
            .tab-btn .count { opacity: .65; font-size: .9em; }

            .catalogue-accordion {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 28px;
            }

            .module-card {
                border: 1px solid var(--line);
                background: var(--white);
            }

            .module-card summary {
                list-style: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 14px;
                padding: 16px 20px;
            }

            .module-card summary::-webkit-details-marker { display: none; }

            .module-code {
                font-family: "Fraunces", serif;
                font-weight: 700;
                color: var(--forest-deep);
                background: var(--paper-alt);
                padding: 2px 8px;
                font-size: 12px;
                flex-shrink: 0;
            }

            .module-title {
                flex: 1;
                font-weight: 600;
                font-size: 15px;
            }

            .module-meta {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 12.5px;
                color: var(--ink-soft);
                white-space: nowrap;
            }

            .module-card .chev {
                flex-shrink: 0;
                transition: transform .2s ease;
            }

            .module-card[open] .chev { transform: rotate(180deg); }

            .module-body {
                padding: 0 20px 22px;
                border-top: 1px solid var(--line);
                padding-top: 18px;
            }

            .module-body h5 {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--water);
                margin: 16px 0 8px;
            }

            .module-body p, .module-body .module-text { font-size: 14px; color: var(--ink); line-height: 1.6; }

            .module-infos {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 12px;
                margin: 18px 0;
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

    <?php $__env->startPush('scripts'); ?>
        <script>
            (function () {
                var tabs = document.querySelectorAll('#catalogue-complet .tab-btn[data-filter-group]');
                var panels = document.querySelectorAll('#catalogue-complet .catalogue-group[data-group-panel]');

                tabs.forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        tabs.forEach(function (t) { t.setAttribute('aria-selected', 'false'); });
                        tab.setAttribute('aria-selected', 'true');

                        var target = tab.dataset.filterGroup;
                        panels.forEach(function (panel) {
                            panel.hidden = panel.dataset.groupPanel !== target;
                        });
                    });
                });
            })();
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\formations\Catalogue.blade.php ENDPATH**/ ?>