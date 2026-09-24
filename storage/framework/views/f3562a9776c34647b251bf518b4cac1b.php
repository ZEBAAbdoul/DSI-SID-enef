<div class="btn-group" role="group">
    <a href="<?php echo e(route('admin.user.edit', $user)); ?>" class="btn btn-sm btn-warning">
        <i class="fas fa-edit"></i>
    </a>

    <?php if (\Illuminate\Support\Facades\Blade::check('role', ['super-admin', 'admin'])): ?>
        <?php if (! ($user->is(auth()->user()))): ?>
            <button type="button" class="btn btn-sm btn-outline-warning resetPasswordBtn" data-id="<?php echo e($user->id); ?>"
                title="Réinitialiser le mot de passe">
                <i class="fas fa-key"></i>
            </button>
        <?php endif; ?>
    <?php endif; ?>

    
</div>
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/admin/user/partials/actions.blade.php ENDPATH**/ ?>