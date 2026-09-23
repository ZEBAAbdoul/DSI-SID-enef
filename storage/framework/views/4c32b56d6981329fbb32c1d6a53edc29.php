<?php if(session()->has('success')): ?>
    <script>
        toastr.success("<?php echo e(session()->get('success')); ?>")
    </script>
<?php endif; ?>
<?php if(session()->has('warning')): ?>
    <script>
        toastr.warning("<?php echo e(session()->get('warning')); ?>")
    </script>
<?php endif; ?>
<?php if(session()->has('info')): ?>
    <script>
        toastr.info("<?php echo e(session()->get('info')); ?>")
    </script>
<?php endif; ?>
<?php if(session()->has('error')): ?>
    <script>
        toastr.error("<?php echo e(session()->get('error')); ?>")
    </script>
<?php endif; ?>
<?php /**PATH C:\Users\hp\Desktop\Proje_DGTI\Projet_POSTGRE\DSI-SID-enef\resources\views/components/alert.blade.php ENDPATH**/ ?>