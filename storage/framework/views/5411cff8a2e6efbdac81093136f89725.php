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
        <?php echo e('Log in'); ?>

    <?php $__env->stopSection(); ?>
    <?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?php echo e(url('/')); ?>" class="brand-link d-flex flex-column align-items-center justify-content-center"
                    style="min-height: 100px;">
                    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo ENEF"
                        class="brand-logo-img" style="max-height: 80px; width: auto;">
                    <span class="brand-name mt-2">ENEF</span>
                    <span class="brand-subtitle">École Nationale des Eaux et Forêts</span>
                </a>

                <style>
                    .brand-name {
                        font-family: 'Poppins', sans-serif;
                        font-size: 1.4rem;
                        font-weight: 700;
                        color: #000000;
                        letter-spacing: 1px;
                    }

                    .brand-subtitle {
                        font-family: 'Poppins', sans-serif;
                        font-size: 0.85rem;
                        color: #555;
                        font-style: italic;
                    }

                    .brand-logo-img {
                        transition: transform 0.3s ease;
                    }

                    .brand-link:hover .brand-logo-img {
                        transform: scale(1.05);
                    }

                    .form-label {
                        font-weight: 600;
                        color: #333;
                        margin-bottom: 0.4rem;
                        font-size: 0.95rem;
                    }

                    .login-footer-links {
                        display: flex;
                        gap: 10px;
                        margin-top: 16px;
                    }

                    .login-footer-links .btn {
                        flex: 1;
                    }
                </style>
            </div>
            <div class="card-body">
                <h3 class="login-box-msg text-center">Connexion</h3>

                <form action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input id="email" class="form-control" type="email" name="email" value="<?php echo e(old('email')); ?>"
                                required autofocus autocomplete="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <input id="password" class="form-control" type="password" name="password" required
                                autocomplete="current-password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Se souvenir
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="login-footer-links">
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-secondary">
                        Retour à l'accueil
                    </a>
                    <a href="<?php echo e(route('inscription')); ?>" class="btn btn-outline-primary">
                        Créer un compte
                    </a>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\auth\login.blade.php ENDPATH**/ ?>