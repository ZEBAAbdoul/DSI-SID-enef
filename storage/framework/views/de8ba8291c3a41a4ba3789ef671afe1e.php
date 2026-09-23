<?php $__env->startSection('title', 'ENEF — Catalogue de formations'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== EN-TÊTE CATALOGUE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Formation initiale et formation continue</div>
            <h1>Catalogue de formations continues</h1>
            <p class="hero-lede">Cycles de formation initiale (Eaux et Forêts, Environnement) et formation continue
                2025-2026 — formations programmées à dates fixes et modules à la carte, conçus pour les
                professionnels de l'environnement et des ressources naturelles.</p>
            <div class="hero-ctas">
                
            </div>
        </div>
    </section>

    <!-- ===================== CATALOGUE ===================== -->
    <section id="catalogue-complet">
        <div class="container">

            <div class="tabs" role="tablist">
                
                <button class="tab-btn" role="tab" aria-selected="true" data-filter-group="programmee">
                    Formations programmées <span class="count">(<?php echo e($formationsProgrammees->count()); ?>)</span>
                </button>
                <button class="tab-btn" role="tab" aria-selected="false" data-filter-group="carte">
                    Formations à la carte <span class="count">(<?php echo e($formationsALaCarte->count()); ?>)</span>
                </button>
            </div>

            <!-- ---------- Formations initiales ---------- -->
            

            <!-- ---------- Formations programmées ---------- -->
            <div class="catalogue-group" data-group-panel="programmee">
                <div class="catalogue-accordion">
                    <?php $__empty_1 = true; $__currentLoopData = $formationsProgrammees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <details class="module-card">
                            <summary>
                                <span class="module-code"><?php echo e($item->code_module); ?></span>
                                <span class="module-title"><?php echo e($item->titre); ?></span>
                                <span class="module-meta">
                                    <?php if($item->duree): ?>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            width="14" height="14">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 7v5l3 3" />
                                        </svg>
                                        <?php echo e($item->duree); ?>

                                    <?php endif; ?>
                                </span>
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" width="18" height="18">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </summary>

                            <div class="module-body">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="module-content flex-grow-1">
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
                                                <div><span class="lbl">Volume
                                                        horaire</span><span><?php echo e($item->duree); ?></span></div>
                                            <?php endif; ?>
                                            <?php if($item->public_cible): ?>
                                                <div><span class="lbl">Public
                                                        cible</span><span><?php echo e($item->public_cible); ?></span></div>
                                            <?php endif; ?>
                                            <?php if($item->techniques): ?>
                                                <div><span
                                                        class="lbl">Techniques</span><span><?php echo e($item->techniques); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($item->places_min || $item->places_max): ?>
                                                <div><span class="lbl">Places par
                                                        session</span><span><?php echo e($item->places_min); ?> à
                                                        <?php echo e($item->places_max); ?> personnes</span></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    
                                    

                                    <section id="infos-complementaires">
                                        <div class="container">

                                            <!-- ---------- Frais annexes ---------- -->
                                            <div id="frais" class="infos-section">
                                                <div class="section-head">
                                                    <div>
                                                        <span class="kicker kicker-clay">Informations complementaires</span>
                                                        <h2>Frais annexes</h2>
                                                        <p class="desc">Ces montants s'ajoutent aux frais de scolarité
                                                            propres à chaque cycle ou
                                                            module, consultables sur la fiche de chaque formation.</p>
                                                    </div>
                                                </div>

                                                <div class="infos-block infos-block--accent-clay">
                                                    <table class="infos-table">
                                                        <tbody>
                                                            <?php $__empty_2 = true; $__currentLoopData = $frais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <tr>
                                                                    <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                                                    <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                <tr>
                                                                    <td colspan="2" class="empty-cell">Aucune information
                                                                        disponible pour le moment.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- ---------- Modalités de paiement ---------- -->
                                            <div id="paiement" class="infos-section">
                                                <div class="section-head">
                                                    <div>
                                                        <span class="kicker kicker-water">Échéancier</span>
                                                        <h2>Modalités de paiement</h2>
                                                        <p class="desc">L'échéancier diffère selon qu'il s'agit d'une
                                                            classe intermédiaire ou d'une
                                                            classe terminale du cycle.</p>
                                                    </div>
                                                </div>

                                                <div class="infos-cols">
                                                    <div class="infos-block infos-block--accent-water">
                                                        <div class="infos-block-label">Classes intermédiaires</div>
                                                        <table class="infos-table">
                                                            <tbody>
                                                                <?php $__empty_2 = true; $__currentLoopData = $paiementIntermediaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                    <tr>
                                                                        <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                                                        <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                    <tr>
                                                                        <td colspan="2" class="empty-cell">Aucune
                                                                            information disponible.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="infos-block infos-block--accent-water">
                                                        <div class="infos-block-label">Classes terminales</div>
                                                        <table class="infos-table">
                                                            <tbody>
                                                                <?php $__empty_2 = true; $__currentLoopData = $paiementTerminale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                    <tr>
                                                                        <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                                                        <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                    <tr>
                                                                        <td colspan="2" class="empty-cell">Aucune
                                                                            information disponible.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ---------- Composition du dossier ---------- -->
                                            <div id="dossier" class="infos-section">
                                                <div class="section-head">
                                                    <div>
                                                        <span class="kicker kicker-forest">Pièces à fournir</span>
                                                        <h2>Composition du dossier</h2>
                                                        <p class="desc">L'ensemble des pièces suivantes doit être réuni au
                                                            moment du dépôt de
                                                            candidature.</p>
                                                    </div>
                                                </div>

                                                <div class="infos-block infos-block--accent-forest">
                                                    <ol class="infos-dossier-list">
                                                        <?php $__empty_2 = true; $__currentLoopData = $dossier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $piece): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                            <li>
                                                                <span class="dossier-num"><?php echo e($loop->iteration); ?></span>
                                                                <span><?php echo e($piece->libelle); ?></span>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                            <li class="empty-cell">Aucune pièce référencée.</li>
                                                        <?php endif; ?>
                                                    </ol>
                                                </div>
                                            </div>

                                            <!-- ---------- Bandeau contact ---------- -->
                                            <div class="infos-cta">
                                                <div>
                                                    <h3>Une question sur votre dossier ?</h3>
                                                    <p>L'équipe des admissions de l'ENEF vous répond par e-mail ou par
                                                        téléphone.</p>
                                                </div>
                                                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                                                    <a href="mailto:infos@enef.gov.bf" class="btn btn-primary">Nous
                                                        écrire</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
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
                                <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" width="18" height="18">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </summary>

                            <div class="module-body d-flex">
                                <div class="module-content flex-grow-1">
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
                                            <div><span class="lbl">Volume
                                                    horaire</span><span><?php echo e($item->duree); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($item->public_cible): ?>
                                            <div><span class="lbl">Public
                                                    cible</span><span><?php echo e($item->public_cible); ?></span></div>
                                        <?php endif; ?>
                                        <?php if($item->techniques): ?>
                                            <div><span
                                                    class="lbl">Techniques</span><span><?php echo e($item->techniques); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($item->places_min || $item->places_max): ?>
                                            <div><span class="lbl">Places par
                                                    session</span><span><?php echo e($item->places_min); ?> à
                                                    <?php echo e($item->places_max); ?> personnes</span></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                
                                <section id="infos-complementaires">
                                        <div class="container">

                                            <!-- ---------- Frais annexes ---------- -->
                                            <div id="frais" class="infos-section">
                                                <div class="section-head">
                                                    <div>
                                                        <span class="kicker kicker-clay">Informations complementaires</span>
                                                        <h2>Frais annexes</h2>
                                                        <p class="desc">Ces montants s'ajoutent aux frais de scolarité
                                                            propres à chaque cycle ou
                                                            module, consultables sur la fiche de chaque formation.</p>
                                                    </div>
                                                </div>

                                                <div class="infos-block infos-block--accent-clay">
                                                    <table class="infos-table">
                                                        <tbody>
                                                            <?php $__empty_2 = true; $__currentLoopData = $frais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <tr>
                                                                    <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                                                    <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                <tr>
                                                                    <td colspan="2" class="empty-cell">Aucune information
                                                                        disponible pour le moment.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- ---------- Modalités de paiement ---------- -->
                                            <div id="paiement" class="infos-section">
                                                <div class="section-head">
                                                    <div>
                                                        <span class="kicker kicker-water">Échéancier</span>
                                                        <h2>Modalités de paiement</h2>
                                                        <p class="desc">L'échéancier diffère selon qu'il s'agit d'une
                                                            classe intermédiaire ou d'une
                                                            classe terminale du cycle.</p>
                                                    </div>
                                                </div>

                                                <div class="infos-cols">
                                                    <div class="infos-block infos-block--accent-water">
                                                        <div class="infos-block-label">Classes intermédiaires</div>
                                                        <table class="infos-table">
                                                            <tbody>
                                                                <?php $__empty_2 = true; $__currentLoopData = $paiementIntermediaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                    <tr>
                                                                        <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                                                        <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                    <tr>
                                                                        <td colspan="2" class="empty-cell">Aucune
                                                                            information disponible.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="infos-block infos-block--accent-water">
                                                        <div class="infos-block-label">Classes terminales</div>
                                                        <table class="infos-table">
                                                            <tbody>
                                                                <?php $__empty_2 = true; $__currentLoopData = $paiementTerminale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                    <tr>
                                                                        <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                                                        <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                    <tr>
                                                                        <td colspan="2" class="empty-cell">Aucune
                                                                            information disponible.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ---------- Composition du dossier ---------- -->
                                            <div id="dossier" class="infos-section">
                                                <div class="section-head">
                                                    <div>
                                                        <span class="kicker kicker-forest">Pièces à fournir</span>
                                                        <h2>Composition du dossier</h2>
                                                        <p class="desc">L'ensemble des pièces suivantes doit être réuni au
                                                            moment du dépôt de
                                                            candidature.</p>
                                                    </div>
                                                </div>

                                                <div class="infos-block infos-block--accent-forest">
                                                    <ol class="infos-dossier-list">
                                                        <?php $__empty_2 = true; $__currentLoopData = $dossier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $piece): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                            <li>
                                                                <span class="dossier-num"><?php echo e($loop->iteration); ?></span>
                                                                <span><?php echo e($piece->libelle); ?></span>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                            <li class="empty-cell">Aucune pièce référencée.</li>
                                                        <?php endif; ?>
                                                    </ol>
                                                </div>
                                            </div>

                                            <!-- ---------- Bandeau contact ---------- -->
                                            <div class="infos-cta">
                                                <div>
                                                    <h3>Une question sur votre dossier ?</h3>
                                                    <p>L'équipe des admissions de l'ENEF vous répond par e-mail ou par
                                                        téléphone.</p>
                                                </div>
                                                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                                                    <a href="mailto:infos@enef.gov.bf" class="btn btn-primary">Nous
                                                        écrire</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </section>
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
            #catalogue-complet {
                padding: 40px 0 80px;
            }

            .tab-btn .count {
                opacity: .65;
                font-size: .9em;
            }

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

            .module-card summary::-webkit-details-marker {
                display: none;
            }

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

            .module-card[open] .chev {
                transform: rotate(180deg);
            }

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

            .module-body p,
            .module-body .module-text {
                font-size: 14px;
                color: var(--ink);
                line-height: 1.6;
            }

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

            .module-infos>div span:last-child {
                font-size: 13.5px;
            }

            /* style du buton a droite  */
            .module-layout {
                display: flex;
                align-items: flex-start;
                gap: 24px;
            }

            .module-content {
                flex: 1;
                min-width: 0;
            }

            .module-action {
                flex-shrink: 0;
            }

            @media (max-width: 640px) {
                .module-layout {
                    flex-direction: column;
                }

                .module-action,
                .module-action .btn {
                    width: 100%;
                }
            }

            /* ===================== INFOS COMPLÉMENTAIRES ===================== */
#infos-complementaires {
    --clay: #b5654a;
    --clay-soft: #f7e9e2;
    --water-soft: #e6f0f2;
    --forest-soft: #e9f1e9;
    padding: 56px 0 24px;
}

#infos-complementaires .infos-section {
    margin-bottom: 44px;
}

#infos-complementaires .section-head {
    max-width: 640px;
    margin-bottom: 20px;
}

#infos-complementaires .kicker {
    display: inline-block;
    font-family: "Fraunces", serif;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 4px 10px;
    margin-bottom: 10px;
    border-radius: 2px;
}
#infos-complementaires .kicker-clay   { background: var(--clay-soft);   color: var(--clay); }
#infos-complementaires .kicker-water  { background: var(--water-soft);  color: var(--water); }
#infos-complementaires .kicker-forest { background: var(--forest-soft); color: var(--forest-deep); }

#infos-complementaires .section-head h2 {
    font-family: "Fraunces", serif;
    font-size: 24px;
    margin: 0 0 8px;
    color: var(--ink);
}

#infos-complementaires .section-head .desc {
    font-size: 14px;
    line-height: 1.6;
    color: var(--ink-soft);
    margin: 0;
}

/* --- Blocs (cartes) --- */
#infos-complementaires .infos-block {
    background: var(--white);
    border: 1px solid var(--line);
    border-left: 4px solid var(--line);
    padding: 4px;
}
#infos-complementaires .infos-block--accent-clay   { border-left-color: var(--clay); }
#infos-complementaires .infos-block--accent-water  { border-left-color: var(--water); }
#infos-complementaires .infos-block--accent-forest { border-left-color: var(--forest-deep); }

#infos-complementaires .infos-cols {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
}

#infos-complementaires .infos-block-label {
    font-family: "Fraunces", serif;
    font-weight: 700;
    font-size: 13px;
    color: var(--ink);
    padding: 12px 16px 6px;
}

/* --- Tableaux --- */
#infos-complementaires .infos-table {
    width: 100%;
    border-collapse: collapse;
}
#infos-complementaires .infos-table tr:not(:last-child) td {
    border-bottom: 1px solid var(--line);
}
#infos-complementaires .infos-table td {
    padding: 12px 16px;
    font-size: 14px;
    vertical-align: top;
}
#infos-complementaires .infos-table .lbl-cell {
    color: var(--ink-soft);
    font-weight: 600;
    width: 55%;
}
#infos-complementaires .infos-table .val-cell {
    color: var(--ink);
    text-align: right;
    font-weight: 600;
}
#infos-complementaires .infos-table .empty-cell {
    text-align: center;
    color: var(--ink-soft);
    font-style: italic;
    padding: 20px;
}

/* --- Liste "composition du dossier" --- */
#infos-complementaires .infos-dossier-list {
    list-style: none;
    margin: 0;
    padding: 6px;
}
#infos-complementaires .infos-dossier-list li {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 12px 16px;
    font-size: 14px;
    color: var(--ink);
}
#infos-complementaires .infos-dossier-list li:not(:last-child) {
    border-bottom: 1px solid var(--line);
}
#infos-complementaires .dossier-num {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--forest-soft);
    color: var(--forest-deep);
    font-family: "Fraunces", serif;
    font-weight: 700;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* --- Bandeau de contact --- */
#infos-complementaires .infos-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    background: var(--forest-deep);
    color: #fff;
    padding: 28px 32px;
    margin-top: 32px;
}
#infos-complementaires .infos-cta h3 {
    font-family: "Fraunces", serif;
    font-size: 18px;
    margin: 0 0 4px;
}
#infos-complementaires .infos-cta p {
    margin: 0;
    font-size: 14px;
    opacity: .85;
}
#infos-complementaires .infos-cta .btn-primary {
    background: #fff;
    color: var(--forest-deep);
    border: none;
}
#infos-complementaires .infos-cta .btn-primary:hover {
    background: var(--paper-alt);
}

@media (max-width: 640px) {
    #infos-complementaires .infos-table .val-cell { text-align: left; }
    #infos-complementaires .infos-cta { flex-direction: column; align-items: flex-start; }
}
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            (function() {
                var tabs = document.querySelectorAll('#catalogue-complet .tab-btn[data-filter-group]');
                var panels = document.querySelectorAll('#catalogue-complet .catalogue-group[data-group-panel]');

                tabs.forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        tabs.forEach(function(t) {
                            t.setAttribute('aria-selected', 'false');
                        });
                        tab.setAttribute('aria-selected', 'true');

                        var target = tab.dataset.filterGroup;
                        panels.forEach(function(panel) {
                            panel.hidden = panel.dataset.groupPanel !== target;
                        });
                    });
                });
            })();
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\formations\Catalogue_formation_continue.blade.php ENDPATH**/ ?>