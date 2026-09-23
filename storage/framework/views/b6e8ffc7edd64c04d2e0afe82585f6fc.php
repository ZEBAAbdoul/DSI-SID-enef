<?php $__env->startSection('title', 'Choisir une session de formation'); ?>

<?php $__env->startSection('content'); ?>

    <section class="hero" style="padding:60px 0;">
        <div class="container">
            <div class="eyebrow-line"><span class="rule"></span> Espace candidat</div>
            <h1>Choisissez votre session de formation</h1>
            <p class="hero-lede">Sélectionnez la session à laquelle vous souhaitez candidater.</p>
        </div>
    </section>

    <section class="alt">
        <div class="container">
            <?php $__errorArgs = ['session_formation_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="form-error" style="margin-bottom:20px;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <div class="sessions-choix-grid">
                <?php $__empty_1 = true; $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <form action="<?php echo e(route('inscription.store')); ?>" method="POST" class="session-choix-card">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="session_formation_id" value="<?php echo e($session->id); ?>">

                        <h4><?php echo e($session->formation->titre ?? 'Formation'); ?></h4>
                        <p class="session-choix-meta">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <?php echo e($session->lieu ?? 'Lieu à préciser'); ?>

                        </p>
                        <p class="session-choix-meta">
                            Du <?php echo e(\Carbon\Carbon::parse($session->date_debut)->translatedFormat('d M Y')); ?>

                            <?php if($session->date_fin): ?>
                                au <?php echo e(\Carbon\Carbon::parse($session->date_fin)->translatedFormat('d M Y')); ?>

                            <?php endif; ?>
                        </p>
                        <span class="places-badge"><?php echo e($session->places_disponibles); ?> / <?php echo e($session->places_totales); ?> places</span>

                        <button type="submit" class="btn btn-primary btn-sm">Candidater à cette session</button>
                    </form>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="color:var(--ink-soft);">Aucune session ouverte pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php $__env->startPush('styles'); ?>
        <style>
            .sessions-choix-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
            }

            .session-choix-card {
                display: flex;
                flex-direction: column;
                gap: 8px;
                background: var(--white);
                border: 1px solid var(--line);
                padding: 20px;
            }

            .session-choix-meta {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 13px;
                color: var(--ink-soft);
            }

            .session-choix-card .places-badge {
                align-self: flex-start;
                font-size: 11.5px;
                font-weight: 700;
                color: var(--water);
                background: var(--water-soft);
                padding: 4px 9px;
                margin: 4px 0 8px;
            }

            .form-error {
                color: #A32020;
                font-size: 13px;
            }
        </style>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\candidat\choisir-session.blade.php ENDPATH**/ ?>