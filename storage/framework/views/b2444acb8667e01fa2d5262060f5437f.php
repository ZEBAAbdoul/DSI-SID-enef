
<?php
    $s = $session ?? null;
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
        <label for="formation_id">Formation</label>
        <select id="formation_id" name="formation_id" class="form-control" required>
            <option value="">Sélectionner…</option>
            <?php $__currentLoopData = $formations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($formation->id); ?>" <?php if(old('formation_id', $s?->formation_id) == $formation->id): echo 'selected'; endif; ?>>
                    <?php echo e($formation->titre); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" class="form-control"
                    value="<?php echo e(old('date_debut', $s?->date_debut?->format('Y-m-d'))); ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="date_fin">Date de fin (optionnel)</label>
                <input type="date" id="date_fin" name="date_fin" class="form-control"
                    value="<?php echo e(old('date_fin', $s?->date_fin?->format('Y-m-d'))); ?>">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="lieu">Lieu</label>
        <input type="text" id="lieu" name="lieu" class="form-control"
            value="<?php echo e(old('lieu', $s?->lieu)); ?>" placeholder="Ex : Ouagadougou - Campus principal">
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="places_totales">Places totales</label>
                <input type="number" id="places_totales" name="places_totales" class="form-control" min="1"
                    value="<?php echo e(old('places_totales', $s?->places_totales ?? 20)); ?>" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="places_disponibles">Places disponibles</label>
                <input type="number" id="places_disponibles" name="places_disponibles" class="form-control" min="0"
                    value="<?php echo e(old('places_disponibles', $s?->places_disponibles ?? 20)); ?>" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="statut">Statut</label>
                <select id="statut" name="statut" class="form-control" required>
                    <option value="ouverte" <?php if(old('statut', $s?->statut) === 'ouverte'): echo 'selected'; endif; ?>>Ouverte</option>
                    <option value="complete" <?php if(old('statut', $s?->statut) === 'complete'): echo 'selected'; endif; ?>>Complète</option>
                    <option value="cloturee" <?php if(old('statut', $s?->statut) === 'cloturee'): echo 'selected'; endif; ?>>Clôturée</option>
                </select>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/admin/sessions-formation/partials/form.blade.php ENDPATH**/ ?>