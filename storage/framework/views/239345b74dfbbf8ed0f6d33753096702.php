
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
        <?php echo e('Nouveau mot de passe'); ?>

    <?php $__env->stopSection(); ?>

    <br>
    <br>
    
    <div class="enef-auth">
        <div class="enef-card">

            <?php echo $__env->make('auth.partials.enef-aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            
            <main class="enef-main">

                <header class="enef-heading">
                    <span class="enef-badge-icon" aria-hidden="true">
                        <i class="fas fa-unlock-alt"></i>
                    </span>
                    <h1>Nouveau mot de passe</h1>
                    <p class="enef-lead">
                        Vous êtes à une étape de retrouver votre accès. Choisissez un nouveau mot de passe
                        pour votre compte.
                    </p>
                </header>

                
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

                <form method="POST" action="<?php echo e(route('password.store')); ?>" id="enefResetForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

                    
                    <div class="enef-group">
                        <label for="email" class="enef-label">Adresse e-mail du compte</label>
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
                                value="<?php echo e(old('email', $request->email)); ?>" required readonly
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
                        <label for="password" class="enef-label">Nouveau mot de passe</label>
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
                                placeholder="Saisissez votre nouveau mot de passe" required autofocus
                                autocomplete="new-password" aria-describedby="enefStrengthText"
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                            <button type="button" class="enef-toggle" data-target="password"
                                aria-label="Afficher le mot de passe" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>

                        
                        <div class="enef-meter" aria-hidden="true">
                            <span class="enef-meter-bar" id="enefStrengthBar"></span>
                        </div>
                        <small class="enef-hint" id="enefStrengthText" aria-live="polite">
                            Utilisez des majuscules, des minuscules, des chiffres et des symboles.
                        </small>
                    </div>

                    
                    <div class="enef-group">
                        <label for="password_confirmation" class="enef-label">Confirmer le mot de passe</label>
                        <div class="enef-field">
                            <i class="fas fa-lock enef-icon" aria-hidden="true"></i>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="enef-input <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Saisissez-le une seconde fois" required autocomplete="new-password"
                                aria-describedby="enefMatchText"
                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                            <button type="button" class="enef-toggle" data-target="password_confirmation"
                                aria-label="Afficher la confirmation" aria-pressed="false">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <small class="enef-hint" id="enefMatchText" aria-live="polite"></small>
                    </div>

                    <button type="submit" class="enef-btn" id="enefSubmit">
                        <span class="enef-spinner" aria-hidden="true"></span>
                        <span class="enef-btn-label">Réinitialiser le mot de passe</span>
                    </button>
                </form>

                <div class="enef-links" style="margin-top: 1.25rem;">
                    <a href="<?php echo e(route('login')); ?>" class="enef-link">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i> Retour à la connexion
                    </a>
                </div>

                <p class="enef-security">
                    <i class="fas fa-lock" aria-hidden="true"></i>
                    Après la réinitialisation, vous pourrez vous connecter avec votre nouveau mot de passe.
                </p>
            </main>
        </div>
    </div>

    <?php echo $__env->make('auth.partials.enef-styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <style>
        /* Spécifique à cette page */
        .enef-input[readonly] {
            background: #eef2ee;
            color: #5d6b60;
            cursor: not-allowed;
        }

        .enef-meter {
            height: 6px;
            margin-top: .55rem;
            border-radius: 6px;
            background: #e3e9e4;
            overflow: hidden;
        }

        .enef-meter-bar {
            display: block;
            width: 0;
            height: 100%;
            border-radius: 6px;
            background: #c62828;
            transition: width .3s ease, background-color .3s ease;
        }

        .enef-hint {
            display: block;
            margin-top: .35rem;
            min-height: 1.1em;
            font-size: .76rem;
            color: #7a8a7d;
        }

        .enef-hint.is-ok {
            color: #1e5b26;
        }

        .enef-hint.is-bad {
            color: #8a1c1c;
        }

        @media (prefers-reduced-motion: reduce) {
            .enef-meter-bar {
                transition: none;
            }
        }
    </style>

    <script>
        (function() {
            var pwd = document.getElementById('password');
            var conf = document.getElementById('password_confirmation');
            var bar = document.getElementById('enefStrengthBar');
            var strengthText = document.getElementById('enefStrengthText');
            var matchText = document.getElementById('enefMatchText');
            var defaultHint = strengthText.textContent;

            // Afficher / masquer (un bouton par champ)
            document.querySelectorAll('.enef-toggle[data-target]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var input = document.getElementById(btn.getAttribute('data-target'));
                    var visible = input.type === 'password';
                    input.type = visible ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', visible ? 'true' : 'false');
                    btn.querySelector('i').className = visible ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            });

            // Robustesse du mot de passe (indicatif : la règle réelle est appliquée par le serveur)
            var niveaux = [
                { txt: 'Très faible', color: '#c62828' },
                { txt: 'Faible', color: '#e65100' },
                { txt: 'Moyen', color: '#f9a825' },
                { txt: 'Bon', color: '#7cb342' },
                { txt: 'Excellent', color: '#2e7d32' }
            ];

            function score(v) {
                var s = 0;
                if (v.length >= 8) s++;
                if (v.length >= 12) s++;
                if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s++;
                if (/\d/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s++;
                return s; // 0 à 5
            }

            function majRobustesse() {
                var v = pwd.value;
                if (!v) {
                    bar.style.width = '0';
                    strengthText.textContent = defaultHint;
                    strengthText.className = 'enef-hint';
                    return;
                }
                var s = Math.min(score(v), 5);
                var niveau = niveaux[Math.max(s - 1, 0)];
                bar.style.width = (s / 5 * 100) + '%';
                bar.style.backgroundColor = niveau.color;
                strengthText.textContent = 'Robustesse : ' + niveau.txt;
                strengthText.className = 'enef-hint';
            }

            function majCorrespondance() {
                if (!conf.value) {
                    matchText.textContent = '';
                    matchText.className = 'enef-hint';
                    return;
                }
                var ok = conf.value === pwd.value;
                matchText.textContent = ok ? 'Les mots de passe correspondent.' : 'Les mots de passe ne correspondent pas.';
                matchText.className = 'enef-hint ' + (ok ? 'is-ok' : 'is-bad');
            }

            pwd.addEventListener('input', function() { majRobustesse(); majCorrespondance(); });
            conf.addEventListener('input', majCorrespondance);

            // Envoi : blocage si les deux champs diffèrent, sinon état "chargement"
            var form = document.getElementById('enefResetForm');
            var btn = document.getElementById('enefSubmit');
            var label = btn.querySelector('.enef-btn-label');
            var spinner = btn.querySelector('.enef-spinner');
            var texte = label.textContent;

            form.addEventListener('submit', function(e) {
                if (pwd.value !== conf.value) {
                    e.preventDefault();
                    majCorrespondance();
                    conf.focus();
                    return;
                }
                btn.disabled = true;
                label.textContent = 'Enregistrement…';
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
<?php endif; ?><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>