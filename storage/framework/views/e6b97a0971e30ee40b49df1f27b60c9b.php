
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
        <?php echo e('Connexion'); ?>

    <?php $__env->stopSection(); ?>

    <br>
    <br>
    <br>
    <div class="enef-auth">
        <div class="enef-card">

            <?php echo $__env->make('auth.partials.enef-aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            
            <main class="enef-main">

                <header class="enef-heading">
                    <h1>Connexion</h1>
                    <p>Accédez à votre espace personnel</p>
                </header>

                
                <?php if(session('success')): ?>
                    <div class="enef-alert enef-alert--success" role="status">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        <div><?php echo e(session('success')); ?></div>
                    </div>
                <?php endif; ?>

                
                <?php if(session('status')): ?>
                    <div class="enef-alert enef-alert--info" role="status">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
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

                <form action="<?php echo e(route('login')); ?>" method="POST" id="enefLoginForm">
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
                                autocomplete="username" <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        </div>
                    </div>

                    
                    <div class="enef-group">
                        <label for="password" class="enef-label">Mot de passe</label>
                        <div class="enef-field">
                            <i class="fas fa-lock enef-icon" aria-hidden="true"></i>
                            <input id="password" name="password" type="password"
                                class="enef-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="••••••••" required autocomplete="current-password"
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                            <button type="button" class="enef-toggle" id="enefTogglePassword"
                                aria-label="Afficher le mot de passe" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    
                    <div class="enef-options">
                        <label class="enef-check" for="remember">
                            <input type="checkbox" name="remember" id="remember"
                                <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <span>Se souvenir de moi</span>
                        </label>

                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="enef-forgot">
                                Mot de passe oublié ?
                            </a>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="enef-btn" id="enefSubmit">
                        <span class="enef-spinner" aria-hidden="true"></span>
                        <span class="enef-btn-label">Se connecter</span>
                    </button>
                </form>

                <div class="enef-divider"><span>Pas encore de compte ?</span></div>

                <div class="enef-links">
                    <a href="<?php echo e(route('inscription')); ?>" class="enef-link enef-link--primary">
                        <i class="fas fa-user-plus" aria-hidden="true"></i> Créer un compte
                    </a>
                    <a href="<?php echo e(url('/')); ?>" class="enef-link">
                        <i class="fas fa-home" aria-hidden="true"></i> Retour à l'accueil
                    </a>
                </div>

                <p class="enef-security">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    Pour votre sécurité, ne communiquez jamais votre mot de passe.
                </p>
            </main>
        </div>
    </div>

    <?php echo $__env->make('auth.partials.enef-styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        (function() {
            // Afficher / masquer le mot de passe
            var toggle = document.getElementById('enefTogglePassword');
            var pwd = document.getElementById('password');

            if (toggle && pwd) {
                toggle.addEventListener('click', function() {
                    var visible = pwd.type === 'password';
                    pwd.type = visible ? 'text' : 'password';
                    toggle.setAttribute('aria-pressed', visible ? 'true' : 'false');
                    toggle.setAttribute('aria-label', visible ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                    toggle.querySelector('i').className = visible ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }

            // Anti double-clic : état "chargement" à l'envoi
            var form = document.getElementById('enefLoginForm');
            var btn = document.getElementById('enefSubmit');

            if (form && btn) {
                var label = btn.querySelector('.enef-btn-label');
                var spinner = btn.querySelector('.enef-spinner');

                var reset = function() {
                    btn.disabled = false;
                    label.textContent = 'Se connecter';
                    spinner.style.display = 'none';
                };

                form.addEventListener('submit', function() {
                    btn.disabled = true;
                    label.textContent = 'Connexion en cours…';
                    spinner.style.display = 'inline-block';
                });

                // Retour arrière du navigateur : on réactive le bouton
                window.addEventListener('pageshow', function(e) {
                    if (e.persisted) reset();
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
<?php endif; ?><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/auth/login.blade.php ENDPATH**/ ?>