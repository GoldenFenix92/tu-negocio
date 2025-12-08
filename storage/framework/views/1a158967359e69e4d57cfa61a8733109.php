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
        <h2 class="fw-semibold fs-4 text-white m-0"><?php echo e(__('Detalles del Cliente')); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><?php echo e(__('Información del Cliente')); ?></h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card bg-body-secondary">
                                <div class="card-body">
                                    <h6 class="mb-3"><?php echo e(__('Datos Personales')); ?></h6>
                                    <p class="mb-2"><strong class="text-secondary"><?php echo e(__('Nombre')); ?>:</strong> <?php echo e($client->name); ?></p>
                                    <p class="mb-2"><strong class="text-secondary"><?php echo e(__('Apellido Paterno')); ?>:</strong> <?php echo e($client->paternal_lastname); ?></p>
                                    <p class="mb-0"><strong class="text-secondary"><?php echo e(__('Apellido Materno')); ?>:</strong> <?php echo e($client->maternal_lastname); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-body-secondary">
                                <div class="card-body">
                                    <h6 class="mb-3"><?php echo e(__('Información de Contacto')); ?></h6>
                                    <p class="mb-2"><strong class="text-secondary"><?php echo e(__('Teléfono')); ?>:</strong> <?php echo e($client->phone); ?></p>
                                    <p class="mb-2"><strong class="text-secondary"><?php echo e(__('Correo')); ?>:</strong> <?php echo e($client->email); ?></p>
                                    <p class="mb-0"><strong class="text-secondary"><?php echo e(__('Código de Barras')); ?>:</strong> <span class="font-monospace fs-5"><?php echo e($client->eight_digit_barcode); ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 flex-wrap">
                        <a href="<?php echo e(route('clients.edit', $client->id)); ?>" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i><?php echo e(__('Editar')); ?>

                        </a>
                        <form action="<?php echo e(route('clients.destroy', $client->id)); ?>" method="POST" onsubmit="return confirm('¿Eliminar cliente?');" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i><?php echo e(__('Eliminar')); ?>

                            </button>
                        </form>
                        <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i><?php echo e(__('Volver a la Lista')); ?>

                        </a>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/clients/show.blade.php ENDPATH**/ ?>