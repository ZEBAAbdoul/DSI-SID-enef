<nav class="main-header navbar navbar-expand navbar-<?php echo e(Auth::user()->mode); ?> navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-dark small"><?php echo e(Auth::user()->username); ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- Header du user -->
                <div class="dropdown-header text-center">
                    <img class="img-profile rounded-circle mb-2"
                        src="<?php echo e(Auth::user()->avatar ?? asset('admin/dist/img/user.jpg')); ?>" width="60"
                        height="60">
                    <p class="mb-0"><?php echo e(Auth::user()->name); ?> <?php echo e(Auth::user()->forname); ?></p>
                    <small class="text-muted"><?php echo e(Auth::user()->username); ?></small>
                    <br>
                    <small class="text-primary">
                        <?php echo e(Auth::user()->roles->pluck('name')->join(', ')); ?>

                    </small>
                </div>
                <div class="dropdown-divider"></div>
                <!-- Déconnexion -->
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Déconnexion
                </a>
                <!-- Formulaire de déconnexion caché -->
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </li>
    </ul>
</nav>
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/components/navbar.blade.php ENDPATH**/ ?>