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
        <h2 class="fw-semibold fs-4 text-white m-0">Movimientos de Stock</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('stock_movements.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Nuevo Movimiento
                </a>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <img src="<?php echo e($movement->imageUrl()); ?>" alt="<?php echo e($movement->product->name); ?>" class="rounded mb-3" style="width: 160px; height: 160px; object-fit: cover;">
                                <div class="fw-semibold"><?php echo e($movement->product->name); ?></div>
                                <div class="small text-secondary mt-1"><?php echo e($movement->product->product_id); ?></div>
                                <div class="mt-2">
                                    <?php if($movement->type === 'in'): ?>
                                        <span class="badge bg-success">Entrada</span>
                                    <?php elseif($movement->type === 'out'): ?>
                                        <span class="badge bg-danger">Salida</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Ajuste</span>
                                    <?php endif; ?>
                                </div>
                                <div class="fs-4 fw-bold mt-1">
                                    <?php if($movement->type === 'in'): ?>
                                        <span class="text-success">+<?php echo e($movement->quantity); ?></span>
                                    <?php elseif($movement->type === 'out'): ?>
                                        <span class="text-danger">-<?php echo e($movement->quantity); ?></span>
                                    <?php else: ?>
                                        <span class="text-primary"><?php echo e($movement->quantity); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="extra-small text-secondary mt-1"><?php echo e($movement->reason ?? 'Sin razón'); ?></div>
                                <div class="extra-small text-secondary mt-1"><?php echo e($movement->user->name ?? 'Usuario Eliminado'); ?></div>
                                <div class="extra-small text-secondary mt-1"><?php echo e($movement->created_at->format('d/m/Y H:i')); ?></div>
                                <div class="extra-small text-secondary mt-1">ID: <?php echo e($movement->id); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4">
                <?php echo e($movements->links()); ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/stock_movements/index.blade.php ENDPATH**/ ?>