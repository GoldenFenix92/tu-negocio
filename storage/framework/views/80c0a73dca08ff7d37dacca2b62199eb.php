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
        <h2 class="fw-semibold fs-4 text-white m-0">Usuarios</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.role_management')); ?>" class="btn btn-purple me-2">
                            <i class="bi bi-bullseye"></i> Gestión de Roles
                        </a>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">Alta de Usuario</a>
                </div>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card h-100 <?php echo e($user->trashed() ? 'opacity-50' : ''); ?>">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <img src="<?php echo e($user->imageUrl()); ?>" alt="<?php echo e($user->name); ?>" class="rounded mb-3" style="width: 160px; height: 160px; object-fit: cover;">
                                <div class="fw-semibold text-body-emphasis"><?php echo e($user->name); ?></div>
                                <div class="small text-body-secondary mt-1"><?php echo e($user->email); ?></div>
                                <div class="mt-1">
                                    <?php if($user->role === 'admin'): ?>
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">Administrador</span>
                                    <?php elseif($user->role === 'supervisor'): ?>
                                        <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">Supervisor</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Empleado</span>
                                    <?php endif; ?>
                                </div>
                                <div class="small text-body-secondary mt-1"><?php echo e(number_format($user->commission_percentage, 2)); ?>% comisión</div>
                                <div class="extra-small text-body-tertiary mt-1">ID: <?php echo e($user->id); ?></div>
                                <div class="extra-small text-body-tertiary mt-1"><?php echo e($user->created_at->format('d/m/Y')); ?></div>
                                <div class="mt-2">
                                    <?php if($user->trashed()): ?>
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">Inhabilitado</span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Activo</span>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-3 d-flex gap-2">
                                    <?php if(!$user->trashed()): ?>
                                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-success btn-sm">
                                            Editar
                                        </a>
                                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('¿Inhabilitar usuario?');" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Inhabilitar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('users.restore', $user->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('POST'); ?>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                Reactivar
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
                <?php echo e($users->links()); ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/users/index.blade.php ENDPATH**/ ?>