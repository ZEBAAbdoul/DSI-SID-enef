<?php echo csrf_field(); ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $erreur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($erreur); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<h5 class="mt-2 mb-3">Identité</h5>
<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Nom <span class="text-danger">*</span></label>
        <input type="text" name="nom" class="form-control"
               value="<?php echo e(old('nom', $enseignant->personne->nom ?? '')); ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Prénom <span class="text-danger">*</span></label>
        <input type="text" name="prenom" class="form-control"
               value="<?php echo e(old('prenom', $enseignant->personne->prenom ?? '')); ?>" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Sexe <span class="text-danger">*</span></label>
        <select name="sexe" class="form-select" required>
            <option value="M" <?php if(old('sexe', $enseignant->personne->sexe ?? '') === 'M'): echo 'selected'; endif; ?>>Masculin</option>
            <option value="F" <?php if(old('sexe', $enseignant->personne->sexe ?? '') === 'F'): echo 'selected'; endif; ?>>Féminin</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Date de naissance <span class="text-danger">*</span></label>
        <input type="date" name="date_naissance" class="form-control"
               value="<?php echo e(old('date_naissance', optional($enseignant->personne->date_naissance ?? null)->format('Y-m-d'))); ?>" required>
    </div>

    <div class="col-md-5">
        <label class="form-label">Lieu de naissance <span class="text-danger">*</span></label>
        <input type="text" name="lieu_naissance" class="form-control"
               value="<?php echo e(old('lieu_naissance', $enseignant->personne->lieu_naissance ?? '')); ?>" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Nationalité <span class="text-danger">*</span></label>
        <select name="nationalite_type" class="form-select" required>
            <option value="nationale" <?php if(old('nationalite_type', $enseignant->personne->nationalite_type ?? 'nationale') === 'nationale'): echo 'selected'; endif; ?>>Nationale</option>
            <option value="internationale" <?php if(old('nationalite_type', $enseignant->personne->nationalite_type ?? '') === 'internationale'): echo 'selected'; endif; ?>>Internationale</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Pays de nationalité</label>
        <input type="text" name="pays_nationalite" class="form-control"
               value="<?php echo e(old('pays_nationalite', $enseignant->personne->pays_nationalite ?? 'Burkina Faso')); ?>">
    </div>

</div>

<h5 class="mt-4 mb-3">Pièce d'identité</h5>
<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label">Type de pièce <span class="text-danger">*</span></label>
        <select name="piece_type" class="form-select" required>
            <option value="cnib" <?php if(old('piece_type', $enseignant->personne->piece_type ?? '') === 'cnib'): echo 'selected'; endif; ?>>CNIB</option>
            <option value="passeport" <?php if(old('piece_type', $enseignant->personne->piece_type ?? '') === 'passeport'): echo 'selected'; endif; ?>>Passeport</option>
        </select>
    </div>

    <div class="col-md-8">
        <label class="form-label">Numéro de la pièce <span class="text-danger">*</span></label>
        <input type="text" name="piece_numero" class="form-control"
               value="<?php echo e(old('piece_numero', $enseignant->personne->piece_numero ?? '')); ?>" required>
    </div>

</div>

<h5 class="mt-4 mb-3">Contact</h5>
<div class="row g-3">

    <div class="col-md-2">
        <label class="form-label">Indicatif</label>
        <input type="text" name="telephone_indicatif" class="form-control"
               value="<?php echo e(old('telephone_indicatif', $enseignant->personne->telephone_indicatif ?? '+226')); ?>">
    </div>

    <div class="col-md-4">
        <label class="form-label">Téléphone <span class="text-danger">*</span></label>
        <input type="text" name="telephone_personne" class="form-control"
               value="<?php echo e(old('telephone_personne', $enseignant->personne->telephone ?? '')); ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control"
               value="<?php echo e(old('email', $enseignant->user->email ?? '')); ?>" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control"
               value="<?php echo e(old('ville', $enseignant->personne->ville ?? '')); ?>">
    </div>

    <div class="col-md-8">
        <label class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control"
               value="<?php echo e(old('adresse', $enseignant->personne->adresse ?? '')); ?>">
    </div>

</div>

<h5 class="mt-4 mb-3">Profil enseignant</h5>
<div class="row g-3">

    <div class="col-md-5">
        <label class="form-label">Spécialité</label>
        <input type="text" name="specialite" class="form-control"
               value="<?php echo e(old('specialite', $enseignant->specialite ?? '')); ?>">
    </div>

    <div class="col-md-3">
        <label class="form-label">Statut <span class="text-danger">*</span></label>
        <select name="statut" class="form-select" required>
            <option value="actif" <?php if(old('statut', $enseignant->statut ?? 'actif') === 'actif'): echo 'selected'; endif; ?>>Actif</option>
            <option value="inactif" <?php if(old('statut', $enseignant->statut ?? '') === 'inactif'): echo 'selected'; endif; ?>>Inactif</option>
            <option value="suspendu" <?php if(old('statut', $enseignant->statut ?? '') === 'suspendu'): echo 'selected'; endif; ?>>Suspendu</option>
        </select>
    </div>

    

</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="<?php echo e(route('admin.enseignants.index')); ?>" class="btn btn-outline-secondary">Annuler</a>
</div><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/admin/enseignants/_form.blade.php ENDPATH**/ ?>