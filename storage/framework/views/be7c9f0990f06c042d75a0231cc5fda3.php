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
        <h2 class="fw-semibold fs-4 text-white m-0">Clientes</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('clients.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Cliente
                </a>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card h-100 <?php echo e($client->trashed() ? 'opacity-50' : ''); ?>">
                            <img src="<?php echo e($client->imageUrl()); ?>" alt="<?php echo e($client->name); ?>" class="card-img-top" style="height: 160px; object-fit: cover;">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <h5 class="card-title fw-semibold text-body-emphasis mb-1"><?php echo e($client->name); ?> <?php echo e($client->paternal_lastname); ?> <?php echo e($client->maternal_lastname); ?></h5>
                                <p class="text-body-secondary small mb-1"><?php echo e($client->phone); ?></p>
                                <p class="text-body-tertiary extra-small mb-1"><?php echo e($client->email); ?></p>
                                <p class="text-body-tertiary extra-small font-monospace mb-1"><?php echo e($client->eight_digit_barcode); ?></p>
                                <p class="text-body-tertiary extra-small mb-1">ID: <?php echo e($client->id); ?></p>
                                <div class="mt-2">
                                    <?php if($client->trashed()): ?>
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">Inhabilitado</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Activo</span>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                                    <?php if(!$client->trashed()): ?>
                                        <a href="<?php echo e(route('clients.show', $client->id)); ?>" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="<?php echo e(route('clients.edit', $client->id)); ?>" class="btn btn-success btn-sm">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form action="<?php echo e(route('clients.destroy', $client->id)); ?>" method="POST" onsubmit="return confirm('¿Inhabilitar cliente?');" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle me-1"></i>Inhabilitar
                                            </button>
                                        </form>
                                        <?php if($client->image && $client->image !== 'clients/cliente_comodin.webp'): ?>
                                            <form action="<?php echo e(route('clients.destroyImage', $client)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-image me-1"></i>Borrar Imagen
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('clients.restore', $client->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('POST'); ?>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar
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
                <?php echo e($clients->links()); ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/clients/index.blade.php ENDPATH**/ ?>