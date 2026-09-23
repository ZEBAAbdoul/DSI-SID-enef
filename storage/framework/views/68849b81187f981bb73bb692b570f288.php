

<div class="form-group">

    <label for="titre">
        Titre
        <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="titre"
        id="titre"
        class="form-control <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('titre', $video->titre ?? '')); ?>"
        placeholder="Ex : Présentation de l'institution"
        maxlength="255"
        required
        autofocus
    >

    <?php $__errorArgs = ['titre'];
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


<div class="form-group">

    <label for="url">
        Lien de la vidéo
        <span class="text-danger">*</span>
    </label>

    <input
        type="url"
        name="url"
        id="url"
        class="form-control <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        value="<?php echo e(old('url', $video->url ?? '')); ?>"
        placeholder="https://www.youtube.com/watch?v=..."
        required
    >

    <?php $__errorArgs = ['url'];
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

    <small class="form-text text-muted">
        Entrez le lien complet de la vidéo.
        Exemple : YouTube, Facebook, Vimeo, etc.
    </small>

</div>


<div class="form-group">

    <label for="description">
        Description
    </label>

    <textarea
        name="description"
        id="description"
        rows="4"
        class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        placeholder="Description de la vidéo..."
    ><?php echo e(old('description', $video->description ?? '')); ?></textarea>

    <?php $__errorArgs = ['description'];
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


<div class="row">

    <div class="col-md-6">

        <div class="form-group">

            <label for="ordre">
                Ordre d'affichage
            </label>

            <input
                type="number"
                name="ordre"
                id="ordre"
                class="form-control <?php $__errorArgs = ['ordre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                value="<?php echo e(old('ordre', $video->ordre ?? 0)); ?>"
                min="0"
            >

            <?php $__errorArgs = ['ordre'];
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

    </div>


    <div class="col-md-6">

        <div class="form-group">

            <label>
                Visibilité
            </label>

            <div class="custom-control custom-switch mt-2">

                <input
                    type="checkbox"
                    name="est_visible"
                    value="1"
                    class="custom-control-input"
                    id="est_visible"
                    <?php echo e(old('est_visible', $video->est_visible ?? true) ? 'checked' : ''); ?>

                >

                <label
                    class="custom-control-label"
                    for="est_visible"
                >
                    Vidéo visible
                </label>

            </div>

        </div>

    </div>

</div>


<div class="d-flex justify-content-between mt-4">

    <a
        href="<?php echo e(route('admin.videos.index')); ?>"
        class="btn btn-secondary"
    >
        <i class="fas fa-arrow-left mr-1"></i>
        Retour
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        <i class="fas fa-save mr-1"></i>

        <?php echo e(isset($video)
            ? 'Enregistrer les modifications'
            : 'Ajouter la vidéo'); ?>


    </button>

</div>

<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\videos\partials\form.blade.php ENDPATH**/ ?>