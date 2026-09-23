

<div class="form-group">
    <label for="nom">
        Nom de la catégorie
        <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="nom"
        id="nom"
        class="form-control <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('nom', $categorie->nom ?? '')); ?>"
        placeholder="Ex : Documents administratifs"
        maxlength="150"
        required
        autofocus
    >

    <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-feedback">
            <?php echo e($message); ?>

        </span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="d-flex justify-content-between mt-4">

    <a
        href="<?php echo e(route('admin.categories-documents.index')); ?>"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Retour
    </a>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i>

        <?php echo e(isset($categorie)
            ? 'Enregistrer les modifications'
            : 'Créer la catégorie'); ?>

    </button>

</div>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\categories-documents\partials\form.blade.php ENDPATH**/ ?>