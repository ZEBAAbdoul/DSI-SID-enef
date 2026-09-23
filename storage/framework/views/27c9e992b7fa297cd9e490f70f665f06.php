<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', 'Modifier la formation'); ?>

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier la formation
                </h3>
            </div>

            <form action="<?php echo e(route('admin.formations.update', $formation)); ?>"
                  method="POST"
                  enctype="multipart/form-data">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="card-body">

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <strong>
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Veuillez corriger les erreurs suivantes :
                            </strong>

                            <ul class="mb-0 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="row">

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Type <span class="text-danger">*</span>
                                </label>

                                <select name="type"
                                        class="form-control"
                                        required>

                                    <option value="academique"
                                        <?php echo e(old('type', $formation->type) == 'academique' ? 'selected' : ''); ?>>
                                        Académique
                                    </option>

                                    <option value="continue_programmee"
                                        <?php echo e(old('type', $formation->type) == 'continue_programmee' ? 'selected' : ''); ?>>
                                        Continue Programmée
                                    </option>

                                    <option value="continue_a_la_carte"
                                        <?php echo e(old('type', $formation->type) == 'continue_a_la_carte' ? 'selected' : ''); ?>>
                                        Continue à la Carte
                                    </option>

                                </select>

                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Statut <span class="text-danger">*</span>
                                </label>

                                <select name="statut"
                                        class="form-control"
                                        required>

                                    <option value="brouillon"
                                        <?php echo e(old('statut', $formation->statut) == 'brouillon' ? 'selected' : ''); ?>>
                                        Brouillon
                                    </option>

                                    <option value="ouverte"
                                        <?php echo e(old('statut', $formation->statut) == 'ouverte' ? 'selected' : ''); ?>>
                                        Ouverte
                                    </option>

                                    <option value="cloturee"
                                        <?php echo e(old('statut', $formation->statut) == 'cloturee' ? 'selected' : ''); ?>>
                                        Clôturée
                                    </option>

                                </select>

                                <?php $__errorArgs = ['statut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    Titre <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                       name="titre"
                                       value="<?php echo e(old('titre', $formation->titre)); ?>"
                                       class="form-control"
                                       required>

                                <?php $__errorArgs = ['titre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filière</label>

                                <select name="filiere_id"
                                        class="form-control">

                                    <option value="">
                                        -- Aucune filière --
                                    </option>

                                    <?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($filiere->id); ?>"
                                            <?php echo e(old('filiere_id', $formation->filiere_id) == $filiere->id ? 'selected' : ''); ?>>
                                            <?php echo e($filiere->nom); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    Catégorie <span class="text-danger">*</span>
                                </label>

                                <select name="categorie_id"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        -- Sélectionner --
                                    </option>

                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categorie->id); ?>"
                                            <?php echo e(old('categorie_id', $formation->categorie_id) == $categorie->id ? 'selected' : ''); ?>>
                                            <?php echo e($categorie->nom); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Résumé</label>

                                <textarea name="resume"
                                          rows="3"
                                          class="form-control"><?php echo e(old('resume', $formation->resume)); ?></textarea>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Objectifs</label>

                                <textarea name="objectifs"
                                          rows="5"
                                          class="form-control"><?php echo e(old('objectifs', $formation->objectifs)); ?></textarea>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contenu du programme</label>

                                <textarea name="contenu_programme"
                                          rows="5"
                                          class="form-control"><?php echo e(old('contenu_programme', $formation->contenu_programme)); ?></textarea>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Durée</label>

                                <input type="text"
                                       name="duree"
                                       value="<?php echo e(old('duree', $formation->duree)); ?>"
                                       class="form-control">
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coût indicatif (FCFA)</label>

                                <input type="number"
                                       name="cout_indicatif"
                                       value="<?php echo e(old('cout_indicatif', $formation->cout_indicatif)); ?>"
                                       min="0"
                                       step="0.01"
                                       class="form-control">
                            </div>
                        </div>

                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Public cible</label>

                                <textarea name="public_cible"
                                          rows="3"
                                          class="form-control"><?php echo e(old('public_cible', $formation->public_cible)); ?></textarea>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mots-clés</label>

                                <input type="text"
                                       name="mots_cles"
                                       value="<?php echo e(old('mots_cles', $formation->mots_cles)); ?>"
                                       class="form-control">

                                <small class="form-text text-muted">
                                    Séparez les mots-clés par des virgules.
                                </small>
                            </div>
                        </div>

                        
                        <div class="col-md-6">
                            <div class="form-group">

                                <label>Image</label>

                                <?php if($formation->image_url): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset($formation->image_url)); ?>"
                                             alt="<?php echo e($formation->titre); ?>"
                                             class="img-thumbnail"
                                             style="max-height: 150px;">
                                    </div>
                                <?php endif; ?>

                                <input type="file"
                                       name="image"
                                       class="form-control-file"
                                       accept=".jpg,.jpeg,.png,.webp">

                                <small class="form-text text-muted">
                                    Laisser vide pour conserver l'image actuelle.
                                </small>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <a href="<?php echo e(route('admin.formations.index')); ?>"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Annuler
                    </a>

                    <button type="submit"
                            class="btn btn-primary float-right">
                        <i class="fas fa-save mr-1"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $attributes = $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0)): ?>
<?php $component = $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0; ?>
<?php unset($__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0); ?>
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\formations\edit.blade.php ENDPATH**/ ?>