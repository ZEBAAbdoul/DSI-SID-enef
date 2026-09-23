
<?php
    $p = $partenaire ?? null;
    $enEdition = $p !== null;
    $ordreAff = $p?->ordre_affichage ?? ($prochainOrdre ?? 0);
    $types = [
        'institutionnel' => 'Institutionnel',
        'financier' => 'Financier',
        'technique' => 'Technique',
        'academique' => 'Académique',
        'collectivite' => 'Collectivité territoriale',
    ];
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

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="nom">Nom du partenaire *</label>
                <input type="text" id="nom" name="nom" class="form-control" maxlength="150" required
                    value="<?php echo e(old('nom', $p?->nom)); ?>" placeholder="Ex : PONASI">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="type">Type *</label>
                <select id="type" name="type" class="form-control" required>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($typeKey); ?>" <?php echo e(old('type', $p?->type) === $typeKey ? 'selected' : ''); ?>>
                            <?php echo e($typeLabel); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="site_web">Site web</label>
                <input type="url" id="site_web" name="site_web" class="form-control" maxlength="255"
                    value="<?php echo e(old('site_web', $p?->site_web)); ?>" placeholder="https://... (optionnel)">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ordre_affichage">Ordre d'affichage</label>
                <?php if($enEdition): ?>
                    <input type="number" id="ordre_affichage" name="ordre_affichage" class="form-control"
                        min="0" max="32767" value="<?php echo e(old('ordre_affichage', $ordreAff)); ?>" required>
                    <small class="form-text text-muted">Saisissez un numéro libre. S'il est déjà pris, vous pourrez
                        échanger les positions.</small>
                <?php else: ?>
                    <input type="number" id="ordre_affichage" class="form-control"
                        value="<?php echo e(old('ordre_affichage', $ordreAff)); ?>" disabled readonly>
                    <small class="form-text text-muted">Affecté automatiquement à la création (numéro suivant).</small>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="logo_url">Logo</label>
        <input type="file" id="logo_url" name="logo_url" class="form-control" accept="image/*">
        <small class="form-text text-muted">JPG, PNG, WEBP, GIF — 2 Mo max.</small>

        <div class="mt-2" id="logo_preview_wrapper" <?php if(!$p?->logo_url): ?> style="display:none;" <?php endif; ?>>
            <img id="logo_preview" src="<?php echo e($p?->logo_url ? asset($p->logo_url) : ''); ?>" alt="Aperçu du logo"
                class="border rounded p-1" style="max-height:60px; background:#fff;">
            <small class="text-muted ml-2" id="logo_preview_label">
                <?php if($p?->logo_url): ?>
                    Logo actuel — laissez vide pour le conserver.
                <?php endif; ?>
            </small>
        </div>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3" maxlength="1000"
            placeholder="Courte présentation du partenaire (optionnel)"><?php echo e(old('description', $p?->description)); ?></textarea>
    </div>

    <div class="toggle-wrapper">

        <label class="toggle mb-0">
            <input type="checkbox" name="actif" id="actif" value="1"
                <?php echo e(old('actif', $p?->actif ?? true) ? 'checked' : ''); ?>>

            <span class="toggle-slider"></span>
        </label>

        <span class="toggle-label" id="actifLabel">
            <?php echo e(old('actif', $p?->actif ?? true) ? 'Partenaire actif' : 'Partenaire inactif'); ?>

        </span>

    </div>



</div>
<style>
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toggle {
        position: relative;
        width: 50px;
        height: 26px;
    }

    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .toggle-slider {
        position: absolute;
        inset: 0;
        cursor: pointer;
        background-color: #adb5bd;
        border-radius: 30px;
        transition: 0.25s ease;
    }

    .toggle-slider::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        left: 3px;
        top: 3px;
        background-color: #fff;
        border-radius: 50%;
        transition: 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .25);
    }

    .toggle input:checked+.toggle-slider {
        background-color: #198754;
    }

    .toggle input:checked+.toggle-slider::before {
        transform: translateX(24px);
    }

    .toggle-label {
        font-weight: 600;
        min-width: 130px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('logo_url');
        var preview = document.getElementById('logo_preview');
        var wrapper = document.getElementById('logo_preview_wrapper');
        var label = document.getElementById('logo_preview_label');

        input.addEventListener('change', function() {
            var file = input.files && input.files[0];

            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    label.textContent = 'Nouveau logo (sera enregistré à la validation).';
                    wrapper.style.display = '';
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const toggle = document.getElementById('actif');
        const label = document.getElementById('actifLabel');

        toggle.addEventListener('change', function() {
            label.textContent = this.checked ?
                'Partenaire actif' :
                'Partenaire inactif';
        });

    });
</script>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\partenaires\partials\form.blade.php ENDPATH**/ ?>