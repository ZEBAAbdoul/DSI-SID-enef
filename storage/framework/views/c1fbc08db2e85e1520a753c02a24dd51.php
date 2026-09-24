
<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title'); ?>
        <?php echo e('Mot de passe oublié'); ?>

    <?php $__env->stopSection(); ?>

    <br>
    <br>
    <br>
    <div class="enef-auth">
        <div class="enef-card">

            <?php echo $__env->make('auth.partials.enef-aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            
            <main class="enef-main">

                <header class="enef-heading">
                    <span class="enef-badge-icon" aria-hidden="true">
                        <i class="fas fa-key"></i>
                    </span>
                    <h1>Mot de passe oublié ?</h1>
                    <p class="enef-lead">
                        Aucun problème. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien
                        de réinitialisation qui vous permettra de choisir un nouveau mot de passe.
                    </p>
                </header>

                
                <?php if(session('status')): ?>
                    <div class="enef-alert enef-alert--success" role="status">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        <div><?php echo e(session('status')); ?></div>
                    </div>
                <?php endif; ?>

                
                <?php if($errors->any()): ?>
                    <div class="enef-alert enef-alert--danger" role="alert">
                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                        <div>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><?php echo e($error); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('password.email')); ?>" method="POST" id="enefForgotForm">
                    <?php echo csrf_field(); ?>

                    <div class="enef-group">
                        <label for="email" class="enef-label">Adresse e-mail</label>
                        <div class="enef-field">
                            <i class="fas fa-envelope enef-icon" aria-hidden="true"></i>
                            <input id="email" name="email" type="email"
                                class="enef-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('email')); ?>" placeholder="exemple@domaine.bf" required autofocus
                                autocomplete="email" <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        </div>
                    </div>

                    <button type="submit" class="enef-btn" id="enefSubmit">
                        <span class="enef-spinner" aria-hidden="true"></span>
                        <span class="enef-btn-label">Envoyer le lien de réinitialisation</span>
                    </button>
                </form>

                <div class="enef-divider"><span>Vous vous souvenez de votre mot de passe ?</span></div>

                <div class="enef-links">
                    <a href="<?php echo e(route('login')); ?>" class="enef-link enef-link--primary">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i> Retour à la connexion
                    </a>
                </div>

                <p class="enef-security">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    Le lien reçu est valable pour une durée limitée. Pensez à vérifier vos courriers indésirables.
                </p>
            </main>
        </div>
    </div>

    <?php echo $__env->make('auth.partials.enef-styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        (function() {
            // État "chargement" à l'envoi (anti double-clic)
            var form = document.getElementById('enefForgotForm');
            var btn = document.getElementById('enefSubmit');

            if (form && btn) {
                var label = btn.querySelector('.enef-btn-label');
                var spinner = btn.querySelector('.enef-spinner');
                var texte = label.textContent;

                form.addEventListener('submit', function() {
                    btn.disabled = true;
                    label.textContent = 'Envoi en cours…';
                    spinner.style.display = 'inline-block';
                });

                // Retour arrière du navigateur : on réactive le bouton
                window.addEventListener('pageshow', function(e) {
                    if (e.persisted) {
                        btn.disabled = false;
                        label.textContent = texte;
                        spinner.style.display = 'none';
                    }
                });
            }
        })();
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>