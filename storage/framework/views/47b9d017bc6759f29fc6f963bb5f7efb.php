<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-book"></i> Manuales de Usuario
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row g-4">
                <?php $__currentLoopData = $availableManuals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manual): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo e(route('manual.show', $manual['type'])); ?>" class="text-decoration-none">
                            <div class="card h-100 hover-lift" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="bi <?php echo e($manual['icon']); ?> display-4" style="color: var(--color-primary);"></i>
                                    </div>
                                    <h3 class="h5 mb-3 fw-semibold"><?php echo e($manual['title']); ?></h3>
                                    <p class="text-muted mb-3"><?php echo e($manual['description']); ?></p>
                                    <span class="btn btn-sm btn-outline-primary">
                                        Ver Manual <i class="bi bi-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-info-circle fs-4" style="color: var(--color-primary);"></i>
                        <div>
                            <h5 class="fw-semibold mb-2">Información</h5>
                            <p class="mb-0 text-muted">
                                Los manuales están diseñados según tu rol en el sistema. 
                                Si tienes dudas sobre alguna función específica, consulta el manual correspondiente o contacta a tu supervisor.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/manuals/index.blade.php ENDPATH**/ ?>