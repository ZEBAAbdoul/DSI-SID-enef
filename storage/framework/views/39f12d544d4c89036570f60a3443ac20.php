
<?php
    $c = $categorie ?? null;
?>

<div class="card-body">
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="nom">Nom de la catégorie</label>
        <input type="text" id="nom" name="nom" class="form-control" maxlength="150" required
            value="<?php echo e(old('nom', $c?->nom)); ?>" placeholder="Ex : Bureautique">
    </div>
</div>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\categories-formation\partials\form.blade.php ENDPATH**/ ?>