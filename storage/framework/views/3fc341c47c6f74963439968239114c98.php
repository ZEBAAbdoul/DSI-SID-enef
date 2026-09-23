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

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="contenu">Votre témoignage <span class="text-danger">*</span></label>
                    <textarea id="contenu" name="contenu" rows="6" maxlength="600"
                        class="form-control <?php $__errorArgs = ['contenu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Que vous a apporté votre formation à l'ENEF ?" required><?php echo e(old('contenu', $temoignage->contenu)); ?></textarea>
                    <small class="form-text text-muted"><span id="compteur">0</span> / 600 caractères</small>
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

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="auteur">Votre nom <span class="text-danger">*</span></label>
                        <input type="text" id="auteur" name="auteur"
                            value="<?php echo e(old('auteur', $temoignage->auteur)); ?>"
                            class="form-control <?php $__errorArgs = ['auteur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <small class="form-text text-muted">Vous pouvez n'indiquer que votre prénom et l'initiale de votre nom.</small>
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
                    <div class="form-group col-md-6">
                        <label for="fonction">Votre statut</label>
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
                            placeholder="Ex : Ancien élève, promotion 2023">
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
                </div>

                <div class="form-group mb-0">
                    <label for="formation_concernee">Formation concernée</label>
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

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="note">Votre note <span class="text-danger">*</span></label>
                    <select id="note" name="note" class="form-control <?php $__errorArgs = ['note'];
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

                <div class="form-group mb-0">
                    <label for="image">Photo (optionnelle)</label>

                    <?php if($temoignage->image_url): ?>
                        <div class="text-center mb-2">
                            <img src="<?php echo e(asset($temoignage->image_url)); ?>" alt="Photo actuelle"
                                class="rounded-circle border" style="width:96px;height:96px;object-fit:cover;">
                            <div class="mt-2">
                                <label class="mb-0" style="font-weight:400;">
                                    <input type="checkbox" name="supprimer_image" value="1"> Supprimer la photo
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <input type="file" id="image" name="image" accept="image/*"
                        class="form-control-file <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <small class="form-text text-muted">JPG, PNG ou WebP, 2 Mo max. Sans photo, vos initiales sont affichées.</small>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-right mt-3">
    <a href="<?php echo e(route('admin.mes-temoignages.index')); ?>" class="btn btn-outline-secondary">Annuler</a>
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
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\mes-temoignages\_form.blade.php ENDPATH**/ ?>