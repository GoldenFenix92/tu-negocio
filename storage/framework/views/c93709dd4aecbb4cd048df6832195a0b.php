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
            <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(__('Limpiar Base de Datos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                            <div>
                                <h6 class="mb-2">Acción destructiva</h6>
                                <p class="mb-0">Estás a punto de limpiar la base de datos. Esta acción eliminará todos los registros de las tablas de negocio pero preservará las tablas esenciales del sistema y el usuario administrador para que puedas seguir usando la aplicación.</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('database.delete_database')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="master_code" class="form-label"><?php echo e(__('Código Maestro')); ?></label>
                            <input type="password" id="master_code" name="master_code" class="form-control" required>
                            <?php $__errorArgs = ['master_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Ingresa el código maestro para confirmar la eliminación</div>
                        </div>

                        <div class="alert alert-warning mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle me-3 fs-5"></i>
                                <div>
                                    <h6 class="mb-2">Advertencia importante</h6>
                                    <ul class="mb-0 ps-3">
                                        <li>Esta acción eliminará todos los REGISTROS de las tablas de negocio pero NO eliminará las tablas</li>
                                        <li>Se preservarán completamente las tablas: migrations, cache, cache_locks, sessions</li>
                                        <li>En la tabla users se preservarán los usuarios administradores (email con 'admin' o role 'admin')</li>
                                        <li>Se perderán permanentemente todos los datos de negocio (clientes, productos, ventas, etc.)</li>
                                        <li>La limpieza no se puede deshacer</li>
                                        <li>Se desactivarán temporalmente las restricciones de claves foráneas</li>
                                        <li>Podrás iniciar sesión como administrador después de la limpieza para restaurar datos</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('database.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás COMPLETAMENTE seguro de que quieres limpiar la base de datos? Esta acción eliminará todos los REGISTROS de las tablas de negocio pero NO eliminará las tablas. Se preservarán las tablas esenciales (migrations, cache, cache_locks, sessions) y los usuarios administradores. NO se puede deshacer.')">
                                <i class="bi bi-trash me-1"></i><?php echo e(__('Limpiar Base de Datos')); ?>

                            </button>
                        </div>
                    </form>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/database/delete.blade.php ENDPATH**/ ?>