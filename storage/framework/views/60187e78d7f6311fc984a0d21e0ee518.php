<?php if (isset($component)) { $__componentOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2812d824e80b3a65bceda8e6a9bfa7a0 = $attributes; } ?>
<?php $component = App\View\Components\Admin::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Nouvel enseignant']); ?>
    <div class="container-fluid py-4">
        <h1 class="h4 mb-4">Nouvel enseignant</h1>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.enseignants.store')); ?>">
                    <?php echo $__env->make('admin.enseignants._form', ['enseignant' => null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </form>
            </div>
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
<?php endif; ?><?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/admin/enseignants/create.blade.php ENDPATH**/ ?>