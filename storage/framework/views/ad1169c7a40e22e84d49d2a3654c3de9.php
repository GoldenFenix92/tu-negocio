



<div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1100; max-width: 450px;"></div>


<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-check-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Éxito!</strong> <?php echo e(session('success')); ?>

            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-x-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Error!</strong> <?php echo e(session('error')); ?>

            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php if(session('warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Atención!</strong> <?php echo e(session('warning')); ?>

            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <?php echo e(session('info')); ?>

            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>


<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-x-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Error de validación!</strong>
                <ul class="mb-0 mt-1 ps-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="small"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/components/alerts.blade.php ENDPATH**/ ?>