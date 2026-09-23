<?php $__env->startSection('title', 'ENEF — Informations complémentaires'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== EN-TÊTE ===================== -->
    

    <!-- ===================== CONTENU ===================== -->
    <section id="infos-complementaires">
        <div class="container">

            <!-- ---------- Frais annexes ---------- -->
            <div id="frais" class="infos-section">
                <div class="section-head">
                    <div>
                        <span class="kicker kicker-clay">Budget à prévoir</span>
                        <h2>Frais annexes</h2>
                        <p class="desc">Ces montants s'ajoutent aux frais de scolarité propres à chaque cycle ou
                            module, consultables sur la fiche de chaque formation.</p>
                    </div>
                </div>

                <div class="infos-block infos-block--accent-clay">
                    <table class="infos-table">
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $frais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                    <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="2" class="empty-cell">Aucune information disponible pour le moment.</td>
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
                        <p class="desc">L'échéancier diffère selon qu'il s'agit d'une classe intermédiaire ou d'une
                            classe terminale du cycle.</p>
                    </div>
                </div>

                <div class="infos-cols">
                    <div class="infos-block infos-block--accent-water">
                        <div class="infos-block-label">Classes intermédiaires</div>
                        <table class="infos-table">
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $paiementIntermediaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                        <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="empty-cell">Aucune information disponible.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="infos-block infos-block--accent-water">
                        <div class="infos-block-label">Classes terminales</div>
                        <table class="infos-table">
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $paiementTerminale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="lbl-cell"><?php echo e($ligne->libelle); ?></td>
                                        <td class="val-cell"><?php echo e($ligne->valeur); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="empty-cell">Aucune information disponible.</td>
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
                        <p class="desc">L'ensemble des pièces suivantes doit être réuni au moment du dépôt de
                            candidature.</p>
                    </div>
                </div>

                <div class="infos-block infos-block--accent-forest">
                    <ol class="infos-dossier-list">
                        <?php $__empty_1 = true; $__currentLoopData = $dossier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $piece): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <span class="dossier-num"><?php echo e($loop->iteration); ?></span>
                                <span><?php echo e($piece->libelle); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="empty-cell">Aucune pièce référencée.</li>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>

            <!-- ---------- Bandeau contact ---------- -->
            <div class="infos-cta">
                <div>
                    <h3>Une question sur votre dossier ?</h3>
                    <p>L'équipe des admissions de l'ENEF vous répond par e-mail ou par téléphone.</p>
                </div>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="mailto:infos@enef.gov.bf" class="btn btn-primary">Nous écrire</a>
                    
                </div>
            </div>
        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <style>
            /* ---------- Fil d'Ariane ---------- */
            .breadcrumb {
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 13px;
                color: #b9c9b4;
                margin-bottom: 22px;
                flex-wrap: wrap;
            }

            .breadcrumb a {
                color: #b9c9b4;
            }

            .breadcrumb a:hover {
                color: #fff;
                text-decoration: underline;
            }

            .breadcrumb .sep {
                opacity: .6;
            }

            .breadcrumb .current {
                color: #fff;
                font-weight: 600;
            }

            /* ---------- Navigation rapide (dans le hero) ---------- */
            .quick-nav {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: 34px;
                padding-top: 26px;
                border-top: 1px solid rgba(255, 255, 255, .22);
            }

            .quick-nav-item {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 13.5px;
                font-weight: 600;
                color: #e3ecdf;
                background: rgba(255, 255, 255, .08);
                border: 1px solid rgba(255, 255, 255, .18);
                padding: 8px 14px;
                border-radius: 20px;
                transition: background .2s ease, border-color .2s ease;
            }

            .quick-nav-item:hover {
                background: rgba(255, 255, 255, .16);
                border-color: rgba(255, 255, 255, .35);
            }

            .quick-nav .dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            .dot-clay {
                background: var(--clay);
            }

            .dot-water {
                background: var(--water);
            }

            .dot-forest {
                background: var(--leaf);
            }

            /* ---------- Sections ---------- */
            #infos-complementaires {
                padding: 64px 0 84px;
            }

            .infos-section {
                margin-bottom: 56px;
                scroll-margin-top: 90px;
            }

            .infos-section:last-of-type {
                margin-bottom: 0;
            }

            .infos-section .section-head {
                margin-bottom: 24px;
            }

            .kicker-clay {
                color: var(--clay);
            }

            .kicker-water {
                color: var(--water);
            }

            .kicker-forest {
                color: var(--forest-mid);
            }

            /* ---------- Cartes ---------- */
            .infos-block {
                background: var(--white);
                border: 1px solid var(--line);
                border-top: 3px solid var(--line);
                padding: 8px 28px;
                box-shadow: 0 6px 18px -14px rgba(15, 30, 20, .3);
            }

            .infos-block--accent-clay {
                border-top-color: var(--clay);
            }

            .infos-block--accent-water {
                border-top-color: var(--water);
            }

            .infos-block--accent-forest {
                border-top-color: var(--forest-accent);
            }

            .infos-block-label {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .04em;
                color: var(--water);
                padding-top: 18px;
            }

            .infos-cols {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 22px;
            }

            /* ---------- Tables ---------- */
            .infos-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14.5px;
            }

            .infos-table tr {
                transition: background .15s ease;
            }

            .infos-table tr:hover {
                background: var(--paper-alt);
            }

            .infos-table td {
                padding: 14px 4px;
                border-bottom: 1px solid var(--line);
                vertical-align: top;
            }

            .infos-table tr:last-child td {
                border-bottom: none;
            }

            .lbl-cell {
                color: var(--ink-soft);
                width: 52%;
            }

            .val-cell {
                color: var(--forest-deep);
                font-weight: 700;
                text-align: right;
            }

            .empty-cell {
                color: var(--ink-soft);
                text-align: center;
                padding: 20px 4px;
            }

            /* ---------- Composition du dossier ---------- */
            .infos-dossier-list {
                list-style: none;
                margin: 0;
                padding: 20px 0;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px 32px;
            }

            .infos-dossier-list li {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                font-size: 14.5px;
                color: var(--ink);
                line-height: 1.5;
            }

            .dossier-num {
                flex-shrink: 0;
                width: 26px;
                height: 26px;
                border-radius: 50%;
                background: var(--forest-deep);
                color: #fff;
                font-family: "Fraunces", serif;
                font-weight: 680;
                font-size: 12.5px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 1px;
            }

            /* ---------- Bandeau contact ---------- */
            .infos-cta {
                margin-top: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 24px;
                flex-wrap: wrap;
                background: var(--forest-deep);
                color: #fff;
                padding: 34px 38px;
            }

            .infos-cta h3 {
                color: #fff;
                font-size: 20px;
                margin-bottom: 6px;
            }

            .infos-cta p {
                color: #cddbc9;
                font-size: 14.5px;
                margin: 0;
            }

            .btn-outline-light {
                background: transparent;
                border: 1.5px solid rgba(255, 255, 255, .55);
                color: #fff;
            }

            .btn-outline-light:hover {
                background: rgba(255, 255, 255, .12);
            }

            /* ---------- Responsive ---------- */
            @media (max-width: 780px) {
                .infos-cols {
                    grid-template-columns: 1fr;
                }

                .infos-dossier-list {
                    grid-template-columns: 1fr;
                }

                .val-cell {
                    text-align: right;
                }

                .infos-cta {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }

            @media (max-width: 560px) {
                .quick-nav {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\formations\informations-complementaires.blade.php ENDPATH**/ ?>