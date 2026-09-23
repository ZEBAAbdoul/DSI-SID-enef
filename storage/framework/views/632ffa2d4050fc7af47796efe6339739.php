

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

    <?php $__env->startSection('title', 'Détail de la vidéo'); ?>

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-video mr-2"></i>

                Détail de la vidéo

            </h3>


            <div class="card-tools">

                <a
                    href="<?php echo e(route('admin.videos.edit', $video)); ?>"
                    class="btn btn-warning btn-sm"
                >

                    <i class="fas fa-edit mr-1"></i>

                    Modifier

                </a>

            </div>

        </div>


        <div class="card-body">

            <div class="row">

                <div class="col-md-8">

                    <div class="embed-responsive embed-responsive-16by9 bg-dark">

                        <iframe
                            class="embed-responsive-item"
                            src="<?php echo e($video->url); ?>"
                            allowfullscreen
                        ></iframe>

                    </div>

                    <div class="mt-3">

                        <a
                            href="<?php echo e($video->url); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-external-link-alt mr-1"></i>

                            Ouvrir la vidéo

                        </a>

                    </div>

                </div>


                <div class="col-md-4">

                    <h4>
                        <?php echo e($video->titre); ?>

                    </h4>


                    <hr>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-align-left mr-1"></i>
                            Description
                        </strong>

                        <div class="text-muted mt-1">

                            <?php if($video->description): ?>

                                <?php echo nl2br(e($video->description)); ?>


                            <?php else: ?>

                                <em>
                                    Aucune description.
                                </em>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-link mr-1"></i>
                            Lien
                        </strong>

                        <div class="mt-1">

                            <a
                                href="<?php echo e($video->url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <?php echo e($video->url); ?>

                            </a>

                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-sort-numeric-down mr-1"></i>
                            Ordre
                        </strong>

                        <span class="ml-2">
                            <?php echo e($video->ordre); ?>

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-eye mr-1"></i>
                            Visibilité
                        </strong>

                        <span class="ml-2">

                            <?php if($video->est_visible): ?>

                                <span class="badge badge-success">

                                    <i class="fas fa-check mr-1"></i>

                                    Visible

                                </span>

                            <?php else: ?>

                                <span class="badge badge-secondary">

                                    <i class="fas fa-times mr-1"></i>

                                    Masquée

                                </span>

                            <?php endif; ?>

                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-plus mr-1"></i>
                            Créée le
                        </strong>

                        <span class="ml-2">

                            <?php echo e($video->created_at?->format('d/m/Y H:i')); ?>


                        </span>

                    </div>


                    <div class="mb-3">

                        <strong>
                            <i class="fas fa-calendar-edit mr-1"></i>
                            Modifiée le
                        </strong>

                        <span class="ml-2">

                            <?php echo e($video->updated_at?->format('d/m/Y H:i')); ?>


                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="card-footer">

            <a
                href="<?php echo e(route('admin.videos.index')); ?>"
                class="btn btn-secondary"
            >

                <i class="fas fa-arrow-left mr-1"></i>

                Retour à la liste

            </a>

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
<?php endif; ?>

<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\videos\show.blade.php ENDPATH**/ ?>