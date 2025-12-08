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
        <h2 class="fw-semibold fs-4 text-white m-0"><?php echo e(__('Gestión de Cupones')); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white mb-0">Listado de Cupones</h5>
                <a href="<?php echo e(route('coupons.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Crear Nuevo Cupón
                </a>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="mb-4">
                <form action="<?php echo e(route('coupons.index')); ?>" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" placeholder="Buscar cupones..."
                           class="form-control" style="max-width: 300px;"
                           value="<?php echo e(request('search')); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Buscar
                    </button>
                </form>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Gestión de Descuento para Clientes Frecuentes</h6>
                    <form action="<?php echo e(route('coupons.update_client_discount')); ?>" method="POST" class="d-flex align-items-center gap-3">
                        <?php echo csrf_field(); ?>
                        <div class="input-group" style="max-width: 200px;">
                            <input type="number" name="discount_percentage" id="client_discount" step="0.01" min="0" max="100"
                                   class="form-control"
                                   value="<?php echo e(old('discount_percentage', $clientDiscountCoupon->discount_percentage ?? '')); ?>" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg me-1"></i>Actualizar Descuento
                        </button>
                    </form>
                    <?php $__errorArgs = ['discount_percentage', 'clientDiscount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col">
                        <div class="card h-100 <?php echo e(!$coupon->is_active ? 'opacity-50' : ''); ?> <?php echo e($coupon->deleted_at ? 'border-danger' : ''); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo e($coupon->name); ?></h5>
                                <p class="card-text">Descuento: <span class="text-success fw-bold"><?php echo e($coupon->discount_percentage); ?>%</span></p>
                                <p class="card-text small">Estado:
                                    <span class="<?php echo e($coupon->is_active ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($coupon->is_active ? 'Activo' : 'Inactivo'); ?>

                                    </span>
                                </p>
                                <?php if($coupon->deleted_at): ?>
                                    <p class="text-danger small mt-2">Inhabilitado (Eliminado lógicamente)</p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-end gap-2">
                                    <?php if(!$coupon->deleted_at): ?>
                                        <a href="<?php echo e(route('coupons.edit', $coupon)); ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form action="<?php echo e(route('coupons.destroy', $coupon)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres inhabilitar este cupón?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle me-1"></i>Inhabilitar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('coupons.restore', $coupon->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres restaurar este cupón?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restaurar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="alert alert-info">No se encontraron cupones.</div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <?php echo e($coupons->links()); ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/coupons/index.blade.php ENDPATH**/ ?>