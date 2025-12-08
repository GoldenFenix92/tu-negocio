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
        <h2 class="fw-semibold fs-4 text-white m-0">Proveedores</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('suppliers.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Proveedor
                </a>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card h-100 <?php echo e($supplier->is_active ? '' : 'opacity-50'); ?>">
                            <img src="<?php echo e($supplier->imageUrl()); ?>" alt="<?php echo e($supplier->name); ?>" class="card-img-top" style="height: 160px; object-fit: cover;">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <h5 class="card-title fw-semibold text-body-emphasis mb-1"><?php echo e($supplier->name); ?></h5>
                                <p class="text-body-secondary small mb-1"><?php echo e($supplier->contact_person ?? 'Sin contacto'); ?></p>
                                <p class="text-body-secondary small mb-1"><?php echo e($supplier->phone ?? 'Sin teléfono'); ?></p>
                                <p class="text-body-tertiary extra-small mb-1"><?php echo e($supplier->email ?? 'Sin email'); ?></p>
                                <p class="text-body-secondary small mb-1"><?php echo e($supplier->products()->count()); ?> productos</p>
                                <p class="text-body-tertiary extra-small mb-1">ID: <?php echo e($supplier->id); ?></p>
                                <p class="text-body-tertiary extra-small mb-1"><?php echo e($supplier->created_at->format('d/m/Y')); ?></p>
                                <div class="mt-2">
                                    <span class="badge <?php echo e($supplier->is_active ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-danger-subtle text-danger-emphasis border border-danger-subtle'); ?>">
                                        <?php echo e($supplier->is_active ? 'Activo' : 'Inactivo'); ?>

                                    </span>
                                </div>

                                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                                    <a href="<?php echo e(route('suppliers.edit', $supplier)); ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                    <form action="<?php echo e(route('suppliers.destroy', $supplier)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?');" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash me-1"></i>Eliminar
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('suppliers.toggle', $supplier)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn <?php echo e($supplier->is_active ? 'btn-warning' : 'btn-primary'); ?> btn-sm">
                                            <i class="bi <?php echo e($supplier->is_active ? 'bi-pause' : 'bi-play'); ?> me-1"></i><?php echo e($supplier->is_active ? 'Deshabilitar' : 'Habilitar'); ?>

                                        </button>
                                    </form>
                                    <?php if($supplier->image && $supplier->image !== 'suppliers/proveedor_comodin.webp'): ?>
                                        <form action="<?php echo e(route('suppliers.destroyImage', $supplier)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-image me-1"></i>Borrar Imagen
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4">
                <?php echo e($suppliers->links()); ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/suppliers/index.blade.php ENDPATH**/ ?>