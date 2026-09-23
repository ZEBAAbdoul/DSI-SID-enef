
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
    <?php $__env->startSection('title', 'Saisie des notes'); ?>

    <?php if(session('status')): ?>
        <div class="alert alert-success"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Saisie des notes</h3>
            <div class="card-tools">
                <form action="<?php echo e(route('admin.notes.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:5px;">
                    <div class="input-group input-group-sm" style="width:160px;">
                        <select name="type_evaluation" class="form-control" onchange="this.form.submit()">
                            <option value="">Tous les types</option>
                            <option value="controle" <?php echo e(request('type_evaluation') === 'controle' ? 'selected' : ''); ?>>Contrôle</option>
                            <option value="examen" <?php echo e(request('type_evaluation') === 'examen' ? 'selected' : ''); ?>>Examen</option>
                            <option value="tp" <?php echo e(request('type_evaluation') === 'tp' ? 'selected' : ''); ?>>TP</option>
                            <option value="oral" <?php echo e(request('type_evaluation') === 'oral' ? 'selected' : ''); ?>>Oral</option>
                            <option value="projet" <?php echo e(request('type_evaluation') === 'projet' ? 'selected' : ''); ?>>Projet</option>
                        </select>
                    </div>
                </form>
                <form action="<?php echo e(route('admin.notes.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:5px;">
                    <div class="input-group input-group-sm" style="width:160px;">
                        <select name="formation_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Toutes les formations</option>
                            <?php $__currentLoopData = $formations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($f->id); ?>" <?php echo e(request('formation_id') == $f->id ? 'selected' : ''); ?>><?php echo e($f->titre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </form>
                <form action="<?php echo e(route('admin.notes.index')); ?>" method="GET" class="form-inline" style="display:inline-block;margin-right:10px;">
                    <div class="input-group input-group-sm" style="width:220px;">
                        <input type="text" name="recherche" value="<?php echo e(request('recherche')); ?>" class="form-control"
                            placeholder="Rechercher une note…">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                <a href="<?php echo e(route('admin.notes.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nouvelle note
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ÉLÈVE</th>
                            <th>FORMATION</th>
                            <th>MATIÈRE</th>
                            <th>TYPE</th>
                            <th>NOTE</th>
                            <th>NOTE /20</th>
                            <th>DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($note->eleve->name ?? '—'); ?></td>
                                <td><?php echo e($note->formation->titre ?? '—'); ?></td>
                                <td><?php echo e($note->matiere->nom ?? '—'); ?></td>
                                <td>
                                    <?php switch($note->type_evaluation):
                                        case ('controle'): ?>
                                            <span class="badge badge-info">Contrôle</span>
                                            <?php break; ?>
                                        <?php case ('examen'): ?>
                                            <span class="badge badge-danger">Examen</span>
                                            <?php break; ?>
                                        <?php case ('tp'): ?>
                                            <span class="badge badge-primary">TP</span>
                                            <?php break; ?>
                                        <?php case ('oral'): ?>
                                            <span class="badge badge-warning">Oral</span>
                                            <?php break; ?>
                                        <?php case ('projet'): ?>
                                            <span class="badge badge-success">Projet</span>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                </td>
                                <td>
                                    <strong><?php echo e($note->note); ?></strong> / <?php echo e($note->note_max); ?>

                                </td>
                                <td>
                                    <?php
                                        $sur20 = $note->note_sur_20;
                                        $color = $sur20 >= 10 ? 'success' : ($sur20 >= 8 ? 'warning' : 'danger');
                                    ?>
                                    <span class="badge badge-<?php echo e($color); ?>"><?php echo e($sur20); ?>/20</span>
                                </td>
                                <td><?php echo e($note->date_evaluation?->format('d/m/Y') ?? '—'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.notes.edit', $note)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.notes.destroy', $note)); ?>" method="POST" style="display:inline-block;"
                                        class="delete-note-form"
                                        data-note-eleve="<?php echo e($note->eleve->name ?? '—'); ?>"
                                        data-note-matiere="<?php echo e($note->matiere->nom ?? '—'); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Aucune note trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?php echo e($notes->links()); ?>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.delete-note-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const eleve = form.getAttribute('data-note-eleve');
                    const matiere = form.getAttribute('data-note-matiere');
                    const formToSubmit = form;

                    Swal.fire({
                        title: 'Supprimer cette note ?',
                        text: 'La note de « ' + eleve + ' » en « ' + matiere + ' » sera définitivement supprimée.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formToSubmit.submit();
                        }
                    });
                });
            });
        });
    </script>
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
<?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\admin\notes\index.blade.php ENDPATH**/ ?>