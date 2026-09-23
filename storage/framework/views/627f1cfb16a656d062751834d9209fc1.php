<?php $__env->startSection('title', 'ENEF — Documents en consultation sur place'); ?>

<?php $__env->startSection('content'); ?>

    <!-- ===================== EN-TÊTE ===================== -->
    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Ressources documentaires</div>
            <h1>Documents en consultation sur place</h1>
            <p class="hero-lede">Ces documents ne sont pas téléchargeables en ligne. Munissez-vous du code de
                consultation indiqué et présentez-vous à l'ENEF pour les consulter. Pour les documents
                téléchargeables, rendez-vous sur la
                <a href="<?php echo e(route('bibliotheque.index')); ?>">page des documents téléchargeables</a>.</p>
        </div>
    </section>

    <!-- ===================== FILTRES ===================== -->
    <section id="bibliotheque-filtres" style="padding:0 0 24px;">
        <div class="container">
            <form method="GET" action="<?php echo e(route('bibliotheque.consultation')); ?>" class="biblio-filters">
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
                        <a href="<?php echo e(route('bibliotheque.consultation')); ?>" class="btn btn-outline btn-sm">Réinitialiser</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <!-- ===================== LISTE ===================== -->
    <section id="bibliotheque-liste">
        <div class="container">

            <?php if($documents->isEmpty()): ?>
                <div class="biblio-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="42" height="42">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 8v4l3 2" />
                    </svg>
                    <p>Aucun document en consultation sur place ne correspond à votre recherche.</p>
                </div>
            <?php else: ?>
                <div class="biblio-grid">
                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

                <div class="biblio-pagination">
                    <?php echo e($documents->links('vendor.pagination.enef')); ?>

                </div>
            <?php endif; ?>

        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <?php echo $__env->make('bibliotheque._styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/bibliotheque/consultation.blade.php ENDPATH**/ ?>