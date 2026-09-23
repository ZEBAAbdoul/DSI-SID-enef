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

<?php $__env->startSection('title', 'Modifier l’actualité'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4">

    <div class="mb-4">

        <h1 class="h3 fw-bold">
            Modifier l'actualité
        </h1>

        <p class="text-muted">
            <?php echo e($actualite->titre); ?>

        </p>

    </div>


    <?php if($errors->any()): ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        action="<?php echo e(route('admin.actualites.update', $actualite)); ?>"
        enctype="multipart/form-data"
    >

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>


        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="row g-4">

                    
                    <div class="col-md-8">

                        <label class="form-label fw-bold">
                            Titre *
                        </label>

                        <input
                            type="text"
                            name="titre"
                            class="form-control"
                            value="<?php echo e(old('titre', $actualite->titre)); ?>"
                            required
                        >

                    </div>


                    
                    <div class="col-md-4">

                        <label class="form-label fw-bold">
                            Type *
                        </label>

                        <select
                            name="type"
                            class="form-select"
                            required
                        >

                            <?php $__currentLoopData = [
                                'institutionnelle' => 'Institutionnelle',
                                'formation' => 'Formation',
                                'evenement' => 'Événement',
                                'partenariat' => 'Partenariat',
                                'communique' => 'Communiqué'
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option
                                    value="<?php echo e($key); ?>"
                                    <?php if(old('type', $actualite->type) === $key): echo 'selected'; endif; ?>
                                >
                                    <?php echo e($label); ?>

                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>


                    
                    <div class="col-12">

                        <label class="form-label fw-bold">
                            Chapo
                        </label>

                        <textarea
                            name="chapo"
                            rows="3"
                            class="form-control"
                        ><?php echo e(old('chapo', $actualite->chapo)); ?></textarea>

                    </div>


                    
                    <div class="col-12">

                        <label class="form-label fw-bold">
                            Contenu *
                        </label>

                        <textarea
                            name="contenu"
                            rows="12"
                            class="form-control"
                            required
                        ><?php echo e(old('contenu', $actualite->contenu)); ?></textarea>

                    </div>


                    
                    <div class="col-md-6">

                        <label class="form-label fw-bold d-block">
                            Image actuelle
                        </label>

                        <img
                            src="<?php echo e($actualite->image); ?>"
                            alt="<?php echo e($actualite->titre); ?>"
                            class="img-thumbnail mb-3"
                            style="max-height:180px;"
                        >

                        <label class="form-label fw-bold d-block">
                            Remplacer l'image
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                    </div>


                    
                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Ordre
                        </label>

                        <input
                            type="number"
                            name="ordre_menu"
                            class="form-control"
                            value="<?php echo e(old('ordre_menu', $actualite->ordre_menu)); ?>"
                            min="0"
                        >

                    </div>


                    
                    <div class="col-md-3">

                        <label class="form-label fw-bold d-block">
                            Publication
                        </label>

                        <div class="form-check form-switch mt-2">

                            <input
                                type="checkbox"
                                name="is_publiee"
                                value="1"
                                class="form-check-input"
                                id="is_publiee"
                                <?php if(old('is_publiee', $actualite->is_publiee)): echo 'checked'; endif; ?>
                            >

                            <label
                                class="form-check-label"
                                for="is_publiee"
                            >
                                Publiée
                            </label>

                        </div>

                    </div>


                    
                    <div class="col-12">

                        <label class="form-label fw-bold">
                            Meta description
                        </label>

                        <textarea
                            name="meta_description"
                            rows="2"
                            maxlength="160"
                            class="form-control"
                        ><?php echo e(old('meta_description', $actualite->meta_description)); ?></textarea>

                    </div>

                </div>

            </div>


            <div class="card-footer bg-white d-flex justify-content-between">

                <a
                    href="<?php echo e(route('admin.actualites.index')); ?>"
                    class="btn btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="fas fa-save me-1"></i>

                    Enregistrer les modifications

                </button>

            </div>

        </div>

    </form>

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
<?php endif; ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\actualites\edit.blade.php ENDPATH**/ ?>