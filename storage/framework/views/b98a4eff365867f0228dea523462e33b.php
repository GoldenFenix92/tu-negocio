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
        <h2 class="fw-semibold fs-4 text-white m-0">Alertas de Stock</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1400px;">
            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('stock_alerts.pdf_preview')); ?>" class="btn btn-danger">
                    <i class="bi bi-file-pdf me-1"></i>Ver PDF
                </a>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php if($lowStockProducts->count() > 0): ?>
                <div class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Se encontraron <?php echo e($lowStockProducts->count()); ?> productos con stock bajo (menos de 10 unidades).
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="card h-100 <?php echo e($product->stock <= 0 ? 'border-danger border-2' : 'border-warning border-2'); ?>">
                                <img src="<?php echo e($product->imageUrl()); ?>" alt="<?php echo e($product->name); ?>" class="card-img-top" style="height: 160px; object-fit: cover;">
                                <div class="card-body d-flex flex-column align-items-center text-center">
                                    <h5 class="card-title fw-semibold text-body-emphasis mb-1"><?php echo e($product->name); ?></h5>
                                    <p class="text-body-secondary small mb-1"><?php echo e($product->product_id); ?></p>
                                    <p class="text-body-tertiary extra-small mb-1"><?php echo e($product->category->name ?? 'Sin categoría'); ?></p>
                                    <p class="fs-4 fw-bold mb-1 <?php echo e($product->stock <= 0 ? 'text-danger' : 'text-warning'); ?>">
                                        <?php echo e($product->stock); ?>

                                    </p>
                                    <p class="text-body-secondary small mb-2">$<?php echo e(number_format($product->sell_price, 2)); ?></p>
                                    <div>
                                        <?php if($product->stock <= 0): ?>
                                            <span class="badge bg-danger">Agotado</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Stock Bajo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-4">
                    <?php echo e($lowStockProducts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-check-circle text-success display-1"></i>
                    <h5 class="mt-3 text-body-emphasis">¡Todo en orden!</h5>
                    <p class="text-muted">No hay productos con stock bajo en este momento.</p>
                </div>
            <?php endif; ?>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/stock_alerts/index.blade.php ENDPATH**/ ?>