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

<?php $__env->startSection('title', 'Nouvelle actualité'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4">

    <div class="mb-4">

        <h1 class="h3 fw-bold">
            Nouvelle actualité
        </h1>

        <p class="text-muted">
            Publier une nouvelle information sur le site de l'ENEF.
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
        action="<?php echo e(route('admin.actualites.store')); ?>"
        enctype="multipart/form-data"
    >

        <?php echo csrf_field(); ?>


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
                            value="<?php echo e(old('titre')); ?>"
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

                            <option value="">
                                Sélectionner
                            </option>

                            <option value="institutionnelle">
                                Institutionnelle
                            </option>

                            <option value="formation">
                                Formation
                            </option>

                            <option value="evenement">
                                Événement
                            </option>

                            <option value="partenariat">
                                Partenariat
                            </option>

                            <option value="communique">
                                Communiqué
                            </option>

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
                            maxlength="1000"
                        ><?php echo e(old('chapo')); ?></textarea>

                        <small class="text-muted">
                            Résumé court de l'actualité.
                        </small>

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
                        ><?php echo e(old('contenu')); ?></textarea>

                    </div>


                    
                    <div class="col-md-6">

                        <label class="form-label fw-bold">
                            Image de couverture
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted">
                            JPG, PNG ou WEBP — maximum 4 Mo.
                        </small>

                    </div>


                    
                    <div class="col-md-3">

                        <label class="form-label fw-bold">
                            Ordre
                        </label>

                        <input
                            type="number"
                            name="ordre_menu"
                            class="form-control"
                            value="<?php echo e(old('ordre_menu', 0)); ?>"
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
                            >

                            <label
                                class="form-check-label"
                                for="is_publiee"
                            >
                                Publier immédiatement
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
                        ><?php echo e(old('meta_description')); ?></textarea>

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
                    class="btn btn-success"
                >

                    <i class="fas fa-save me-1"></i>

                    Enregistrer

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
<?php endif; ?>
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\actualites\create.blade.php ENDPATH**/ ?>