<?php $__env->startSection('title', 'ENEF — Bibliothèque de documents'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Ressources documentaires</div>
            <h1>Bibliothèque de documents</h1>
            <p class="hero-lede">Rapports, brochures, textes réglementaires et supports pédagogiques de l'École
                Nationale des Eaux et Forêts. Les documents publics sont téléchargeables directement ; les documents
                à consultation restreinte disposent d'un code à présenter sur place.</p>
        </div>
    </section>

    <!-- ===================== FILTRES ===================== -->
    <section id="bibliotheque-filtres" style="padding:0 0 24px;">
        <div class="container">
            <form method="GET" action="<?php echo e(route('bibliotheque.index')); ?>" class="biblio-filters">
                <div class="filter-field">
                    <label for="categorie_id">Catégorie</label>
                    <select name="categorie_id" id="categorie_id" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categorie->id); ?>"
                                <?php if(request('categorie_id') == $categorie->id): echo 'selected'; endif; ?>>
                                <?php echo e($categorie->nom); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="filter-field">
                    <label for="type">Type</label>
                    <select name="type" id="type" onchange="this.form.submit()">
                        <option value="">Tous les types</option>
                        <?php $__currentLoopData = $typeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php if(request('type') === $key): echo 'selected'; endif; ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="filter-field">
                    <label for="q">Recherche</label>
                    <input type="text" name="q" id="q" value="<?php echo e(request('q')); ?>"
                           placeholder="Titre, mot-clé...">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
                    <?php if(request()->anyFilled(['categorie_id', 'type', 'q'])): ?>
                        <a href="<?php echo e(route('bibliotheque.index')); ?>" class="btn btn-outline btn-sm">Réinitialiser</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <!-- ===================== ONGLETS ===================== -->
    <section id="bibliotheque-liste">
        <div class="container">

            <div class="tabs" role="tablist">
                <button class="tab-btn" role="tab" aria-selected="true" data-filter-group="telechargeables">
                    Téléchargeables <span class="count">(<?php echo e($documentsTelechargeables->count()); ?>)</span>
                </button>
                <button class="tab-btn" role="tab" aria-selected="false" data-filter-group="consultation">
                    Consultation sur place <span class="count">(<?php echo e($documentsConsultation->count()); ?>)</span>
                </button>
            </div>

            <!-- ---------- Documents téléchargeables ---------- -->
            <div class="biblio-group" data-group-panel="telechargeables">
                <?php if($documentsTelechargeables->isEmpty()): ?>
                    <div class="biblio-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="42" height="42">
                            <path d="M12 3v12m0 0-4-4m4 4 4-4" />
                            <path d="M4 19.5h16" />
                        </svg>
                        <p>Aucun document téléchargeable ne correspond à votre recherche.</p>
                    </div>
                <?php else: ?>
                    <div class="biblio-grid">
                        <?php $__currentLoopData = $documentsTelechargeables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="biblio-card">
                                <div class="biblio-card-top">
                                    <span class="biblio-format"><?php echo e(strtoupper($document->format_fichier ?? '—')); ?></span>
                                    <?php if($document->categorie): ?>
                                        <span class="biblio-categorie"><?php echo e($document->categorie->nom); ?></span>
                                    <?php endif; ?>
                                </div>

                                <h3 class="biblio-title"><?php echo e($document->titre); ?></h3>

                                <?php if($document->description): ?>
                                    <p class="biblio-desc"><?php echo e(Str::limit($document->description, 160)); ?></p>
                                <?php endif; ?>

                                <div class="biblio-meta">
                                    <?php if($document->version): ?>
                                        <span><span class="lbl">Version</span> <?php echo e($document->version); ?></span>
                                    <?php endif; ?>
                                    <?php if($document->taille_fichier_ko): ?>
                                        <span><span class="lbl">Taille</span>
                                            <?php echo e($document->taille_fichier_ko >= 1024
                                                ? number_format($document->taille_fichier_ko / 1024, 1) . ' Mo'
                                                : $document->taille_fichier_ko . ' Ko'); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($document->publie_le): ?>
                                        <span><span class="lbl">Publié le</span>
                                            <?php echo e($document->publie_le->format('d/m/Y')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="biblio-card-footer">
                                    <a href="<?php echo e(route('documents.telecharger', $document)); ?>"
                                       class="btn btn-primary btn-sm">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             width="15" height="15">
                                            <path d="M12 3v12m0 0-4-4m4 4 4-4" />
                                            <path d="M4 19.5h16" />
                                        </svg>
                                        Télécharger
                                    </a>
                                    <span class="biblio-count"><?php echo e($document->nombre_telechargements); ?> téléchargement(s)</span>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ---------- Documents en consultation sur place ---------- -->
            <div class="biblio-group" data-group-panel="consultation" hidden>
                <?php if($documentsConsultation->isEmpty()): ?>
                    <div class="biblio-empty">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="42" height="42">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 8v4l3 2" />
                        </svg>
                        <p>Aucun document en consultation sur place ne correspond à votre recherche.</p>
                    </div>
                <?php else: ?>
                    <div class="biblio-grid">
                        <?php $__currentLoopData = $documentsConsultation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="biblio-card">
                                <div class="biblio-card-top">
                                    <span class="biblio-format"><?php echo e(strtoupper($document->format_fichier ?? '—')); ?></span>
                                    <?php if($document->categorie): ?>
                                        <span class="biblio-categorie"><?php echo e($document->categorie->nom); ?></span>
                                    <?php endif; ?>
                                </div>

                                <h3 class="biblio-title"><?php echo e($document->titre); ?></h3>

                                <?php if($document->description): ?>
                                    <p class="biblio-desc"><?php echo e(Str::limit($document->description, 160)); ?></p>
                                <?php endif; ?>

                                <div class="biblio-meta">
                                    <?php if($document->version): ?>
                                        <span><span class="lbl">Version</span> <?php echo e($document->version); ?></span>
                                    <?php endif; ?>
                                    <?php if($document->publie_le): ?>
                                        <span><span class="lbl">Publié le</span>
                                            <?php echo e($document->publie_le->format('d/m/Y')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="biblio-card-footer">
                                    <div class="biblio-consultation">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             width="15" height="15">
                                            <circle cx="12" cy="12" r="9" />
                                            <path d="M12 8v4l3 2" />
                                        </svg>
                                        <div>
                                            <span class="biblio-consultation-label">Consultation sur place</span>
                                            <?php if($document->code_consultation): ?>
                                                <span class="biblio-code">Code : <?php echo e($document->code_consultation); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <style>
            #bibliotheque-liste {
                padding: 12px 0 80px;
            }

            .tabs .count {
                opacity: .65;
                font-size: .9em;
            }

            .biblio-group {
                margin-top: 28px;
            }

            /* --- Filtres --- */
            .biblio-filters {
                display: flex;
                align-items: flex-end;
                gap: 16px;
                flex-wrap: wrap;
                padding: 20px;
                background: var(--paper-alt);
                border: 1px solid var(--line);
            }

            .filter-field {
                display: flex;
                flex-direction: column;
                gap: 6px;
                min-width: 180px;
            }

            .filter-field label {
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .03em;
                color: var(--ink-soft);
            }

            .filter-field select,
            .filter-field input {
                border: 1px solid var(--line);
                background: var(--white);
                padding: 8px 10px;
                font-size: 14px;
                color: var(--ink);
            }

            .filter-actions {
                display: flex;
                gap: 8px;
            }

            /* --- Grille de cartes --- */
            .biblio-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 20px;
            }

            .biblio-card {
                display: flex;
                flex-direction: column;
                border: 1px solid var(--line);
                background: var(--white);
                padding: 20px;
            }

            .biblio-card-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
            }

            .biblio-format {
                font-family: "Fraunces", serif;
                font-weight: 700;
                font-size: 11px;
                color: var(--forest-deep);
                background: var(--paper-alt);
                padding: 2px 8px;
            }

            .biblio-categorie {
                font-size: 12px;
                color: var(--ink-soft);
            }

            .biblio-title {
                font-family: "Fraunces", serif;
                font-size: 17px;
                line-height: 1.35;
                margin: 0 0 8px;
                color: var(--ink);
            }

            .biblio-desc {
                font-size: 13.5px;
                line-height: 1.55;
                color: var(--ink-soft);
                margin: 0 0 14px;
                flex-grow: 1;
            }

            .biblio-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 4px 14px;
                font-size: 12.5px;
                color: var(--ink-soft);
                margin-bottom: 16px;
            }

            .biblio-meta .lbl {
                font-weight: 700;
                color: var(--ink);
            }

            .biblio-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
                padding-top: 14px;
                border-top: 1px solid var(--line);
            }

            .biblio-card-footer .btn svg {
                margin-right: 4px;
                vertical-align: -2px;
            }

            .biblio-count {
                font-size: 11.5px;
                color: var(--ink-soft);
            }

            .biblio-consultation {
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--clay, #b5654a);
            }

            .biblio-consultation-label {
                display: block;
                font-size: 12.5px;
                font-weight: 700;
            }

            .biblio-code {
                display: block;
                font-family: "Fraunces", serif;
                font-size: 13px;
                color: var(--ink);
            }

            /* --- États vides --- */
            .biblio-empty {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
                padding: 60px 20px;
                color: var(--ink-soft);
                text-align: center;
            }

            @media (max-width: 640px) {
                .biblio-filters {
                    flex-direction: column;
                    align-items: stretch;
                }
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            (function() {
                var tabs = document.querySelectorAll('#bibliotheque-liste .tab-btn[data-filter-group]');
                var panels = document.querySelectorAll('#bibliotheque-liste .biblio-group[data-group-panel]');

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
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\bibliotheque\index.blade.php ENDPATH**/ ?>