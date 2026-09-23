<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <strong>Le formulaire contient des erreurs :</strong>
        <ul class="mb-0 mt-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="contenu" class="form-label">Témoignage <span class="text-danger">*</span></label>
                    <textarea id="contenu" name="contenu" rows="5" maxlength="600"
                        class="form-control <?php $__errorArgs = ['contenu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('contenu', $temoignage->contenu)); ?></textarea>
                    <div class="form-text"><span id="compteur">0</span> / 600 caractères</div>
                    <?php $__errorArgs = ['contenu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="auteur" class="form-label">Auteur <span class="text-danger">*</span></label>
                        <input type="text" id="auteur" name="auteur"
                            value="<?php echo e(old('auteur', $temoignage->auteur)); ?>"
                            class="form-control <?php $__errorArgs = ['auteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Ex : Aminata O."
                            required>
                        <?php $__errorArgs = ['auteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label for="fonction" class="form-label">Statut / fonction</label>
                        <input type="text" id="fonction" name="fonction"
                            value="<?php echo e(old('fonction', $temoignage->fonction)); ?>"
                            class="form-control <?php $__errorArgs = ['fonction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Ex : Ancienne élève, Promotion 2023">
                        <?php $__errorArgs = ['fonction'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-12">
                        <label for="formation_concernee" class="form-label">Formation concernée</label>
                        <input type="text" id="formation_concernee" name="formation_concernee"
                            value="<?php echo e(old('formation_concernee', $temoignage->formation_concernee)); ?>"
                            class="form-control <?php $__errorArgs = ['formation_concernee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Ex : SIG et Télédétection">
                        <?php $__errorArgs = ['formation_concernee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label for="note" class="form-label">Note <span class="text-danger">*</span></label>
                    <select id="note" name="note" class="form-select <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php for($i = 5; $i >= 1; $i--): ?>
                            <option value="<?php echo e($i); ?>" <?php if((int) old('note', $temoignage->note) === $i): echo 'selected'; endif; ?>>
                                <?php echo e(str_repeat('★', $i)); ?><?php echo e(str_repeat('☆', 5 - $i)); ?> (<?php echo e($i); ?>/5)
                            </option>
                        <?php endfor; ?>
                    </select>
                    <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="ordre" class="form-label">Ordre d'affichage</label>
                    <input type="number" id="ordre" name="ordre" min="0"
                        value="<?php echo e(old('ordre', $temoignage->ordre)); ?>"
                        class="form-control <?php $__errorArgs = ['ordre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <div class="form-text">Les plus petits numéros apparaissent en premier.</div>
                    <?php $__errorArgs = ['ordre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-check form-switch">
                    <input type="hidden" name="est_publie" value="0">
                    <input class="form-check-input" type="checkbox" role="switch" id="est_publie" name="est_publie"
                        value="1" <?php if(old('est_publie', $temoignage->est_publie)): echo 'checked'; endif; ?>>
                    <label class="form-check-label" for="est_publie">Publier sur le site</label>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <label for="image" class="form-label">Photo (optionnelle)</label>

                <?php if($temoignage->image_url): ?>
                    <div class="mb-3 text-center">
                        <img src="<?php echo e(asset($temoignage->image_url)); ?>" alt="Photo actuelle"
                            class="rounded-circle border" style="width:96px;height:96px;object-fit:cover;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="supprimer_image" value="1"
                                id="supprimer_image">
                            <label class="form-check-label" for="supprimer_image">Supprimer la photo</label>
                        </div>
                    </div>
                <?php endif; ?>

                <input type="file" id="image" name="image" accept="image/*"
                    class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <div class="form-text">JPG, PNG ou WebP, 2 Mo max. Sans photo, les initiales sont affichées.</div>
                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="<?php echo e(route('admin.temoignages.index')); ?>" class="btn btn-outline-secondary">Annuler</a>
    <button type="submit" class="btn btn-success"><?php echo e($submitLabel ?? 'Enregistrer'); ?></button>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function() {
            var champ = document.getElementById('contenu');
            var compteur = document.getElementById('compteur');
            if (!champ || !compteur) return;
            var maj = function() { compteur.textContent = champ.value.length; };
            champ.addEventListener('input', maj);
            maj();
        })();
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\temoignages\_form.blade.php ENDPATH**/ ?>