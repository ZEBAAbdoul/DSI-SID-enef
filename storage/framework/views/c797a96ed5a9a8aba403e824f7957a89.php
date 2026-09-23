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
        value="<?php echo e(old('titre', $photo->titre ?? '')); ?>"
        placeholder="Ex : Cérémonie officielle"
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
        placeholder="Description de la photo..."
    ><?php echo e(old('description', $photo->description ?? '')); ?></textarea>

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

    
    <div class="col-md-4">

        <div class="form-group">

            <label for="image">
                Image

                <?php if(!isset($photo)): ?>
                    <span class="text-danger">*</span>
                <?php endif; ?>
            </label>

            <div class="custom-file">

                <input
                    type="file"
                    name="image"
                    id="image"
                    class="custom-file-input <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                    <?php echo e(!isset($photo) ? 'required' : ''); ?>

                >

                <label
                    class="custom-file-label"
                    for="image"
                    id="image-label"
                >
                    Choisir une image
                </label>

            </div>

            <small class="form-text text-muted">
                JPG, JPEG, PNG, GIF, WEBP — 5 Mo maximum.
            </small>

            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-danger d-block mt-1">
                    <?php echo e($message); ?>

                </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        </div>

    </div>


    
    <div class="col-md-4">

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
                value="<?php echo e(old(
                    'ordre',
                    isset($photo)
                        ? $photo->ordre
                        : ($prochainOrdre ?? 1)
                )); ?>"
                min="0"
                max="32767"
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


    
    <div class="col-md-4">

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
                    <?php echo e(old(
                        'est_visible',
                        $photo->est_visible ?? true
                    ) ? 'checked' : ''); ?>

                >

                <label
                    class="custom-control-label"
                    for="est_visible"
                >
                    Photo visible
                </label>

            </div>

        </div>

    </div>

</div>






<div
    id="image-preview-container"
    class="form-group"
    style="display: none;"
>

    <label>
        Aperçu
    </label>

    <div>

        <img
            id="image-preview"
            src="#"
            alt="Aperçu"
            class="img-thumbnail"
            style="
                max-width: 300px;
                max-height: 200px;
                object-fit: contain;
            "
        >

    </div>

</div>







<?php if(isset($photo) && $photo->image_url): ?>

    <div class="form-group">

        <label>
            Image actuelle
        </label>

        <div>
            <img
                src="<?php echo e(asset($photo->image_url)); ?>"
                alt="<?php echo e($photo->titre); ?>"
                class="img-thumbnail"
                style="
                    max-width: 300px;
                    max-height: 200px;
                    object-fit: contain;
                "
            >
        </div>

    </div>

<?php endif; ?>






<div class="d-flex justify-content-between mt-4">

    <a
        href="<?php echo e(route('admin.photos.index')); ?>"
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

        <?php echo e(isset($photo)
            ? 'Enregistrer les modifications'
            : 'Ajouter la photo'); ?>


    </button>

</div>






<script>

document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('image');
    const imageLabel = document.getElementById('image-label');
    const previewContainer = document.getElementById(
        'image-preview-container'
    );
    const preview = document.getElementById('image-preview');


    if (!imageInput) {
        return;
    }


    imageInput.addEventListener('change', function (event) {

        const file = event.target.files[0];


        if (!file) {

            previewContainer.style.display = 'none';

            imageLabel.textContent = 'Choisir une image';

            return;
        }


        // Afficher le nom du fichier
        imageLabel.textContent = file.name;


        // Vérification du type
        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/gif',
            'image/webp'
        ];


        if (!allowedTypes.includes(file.type)) {

            previewContainer.style.display = 'none';

            return;
        }


        // Aperçu
        const reader = new FileReader();


        reader.onload = function (e) {

            preview.src = e.target.result;

            previewContainer.style.display = 'block';

        };


        reader.readAsDataURL(file);

    });

});

</script>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\photos\partials\form.blade.php ENDPATH**/ ?>