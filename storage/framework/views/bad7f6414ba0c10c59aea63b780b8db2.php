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
        <h2 class="fw-semibold fs-4 text-white m-0">Servicios</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor'): ?>
                <div class="d-flex justify-content-end mb-4">
                    <a href="<?php echo e(route('services.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Alta de Servicio
                    </a>
                </div>
            <?php endif; ?>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card h-100 position-relative <?php echo e($service->trashed() ? 'opacity-50' : ''); ?>">
                            <?php if(!$service->is_active): ?>
                                <span class="position-absolute top-0 end-0 m-1 badge bg-danger" style="font-size: 0.6rem;">Inactivo</span>
                            <?php endif; ?>
                            <?php if($service->trashed()): ?>
                                <span class="position-absolute top-0 start-0 m-1 badge bg-secondary" style="font-size: 0.6rem;">Eliminado</span>
                            <?php endif; ?>
                            <img src="<?php echo e($service->imageUrl()); ?>" alt="<?php echo e($service->name); ?>" class="card-img-top" style="height: 100px; object-fit: contain; background: rgba(255,255,255,0.05);">
                            <div class="card-body p-2 d-flex flex-column align-items-center text-center">
                                <h6 class="card-title fw-semibold text-body-emphasis mb-1 small"><?php echo e(Str::limit($service->name, 20)); ?></h6>
                                <p class="text-body-secondary extra-small mb-0"><?php echo e($service->service_id); ?></p>
                                <p class="text-body-tertiary extra-small mb-0"><?php echo e(Str::limit($service->description, 25)); ?></p>
                                <p class="fw-semibold text-body-secondary extra-small mb-0"><?php echo e($service->duration_minutes); ?> min</p>
                                <p class="fw-bold text-body-emphasis small mb-0">$<?php echo e(number_format($service->price, 2)); ?></p>

                                <div class="mt-2 d-flex flex-wrap gap-1 justify-content-center">
                                    <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor'): ?>
                                        <?php if($service->trashed()): ?>
                                            <form action="<?php echo e(route('services.restore', $service->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-primary btn-sm py-0 px-1" title="Restaurar">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('services.edit', $service)); ?>" class="btn btn-success btn-sm py-0 px-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('services.toggleStatus', $service)); ?>" method="POST" onsubmit="return confirm('¿Cambiar estado?');" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <button type="submit" class="btn <?php echo e($service->is_active ? 'btn-warning' : 'btn-primary'); ?> btn-sm py-0 px-1" title="<?php echo e($service->is_active ? 'Inhabilitar' : 'Habilitar'); ?>">
                                                    <i class="bi <?php echo e($service->is_active ? 'bi-pause' : 'bi-play'); ?>"></i>
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('services.destroy', $service)); ?>" method="POST" onsubmit="return confirm('¿Eliminar servicio?');" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm py-0 px-1" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4">
                <?php echo e($services->links()); ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/services/index.blade.php ENDPATH**/ ?>