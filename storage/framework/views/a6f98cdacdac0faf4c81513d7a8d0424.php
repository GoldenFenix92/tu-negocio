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
        <h2 class="fw-semibold fs-4 text-white m-0">Editar Usuario</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container" style="max-width: 900px;">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('users.update', $user)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input id="name" name="name" type="text" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required />
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input id="email" name="email" type="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required />
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                                <input id="password" name="password" type="password" class="form-control" />
                                <div class="form-text">Dejar vacío para mantener la contraseña actual</div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" />
                                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">Rol</label>
                                <select id="role" name="role" class="form-select">
                                    <option value="">Seleccionar rol</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e(old('role', $user->role) == $key ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="form-text text-info"><i class="bi bi-lightbulb me-1"></i>Cambia el rol para ver los permisos que se asignarán</div>
                                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="commission_percentage" class="form-label">Porcentaje de Comisión (%)</label>
                                <div class="input-group">
                                    <input id="commission_percentage" name="commission_percentage" type="number" step="0.01" min="0" max="100" class="form-control" value="<?php echo e(old('commission_percentage', $user->commission_percentage)); ?>" />
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text">Porcentaje de comisión que recibe el usuario por ventas</div>
                                <?php $__errorArgs = ['commission_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor'): ?>
                        <div class="mt-4 pt-4 border-top">
                            <h5 class="mb-3"><i class="bi bi-shield-check me-1"></i>Control de Permisos</h5>
                            <div class="row g-3">
                                <?php
                                    $groupedPermissions = [];
                                    foreach ($permissions as $permission) {
                                        $parts = explode('.', $permission);
                                        $group = $parts[0];
                                        if (!isset($groupedPermissions[$group])) {
                                            $groupedPermissions[$group] = [];
                                        }
                                        $groupedPermissions[$group][] = $permission;
                                    }
                                ?>

                                <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $perms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card bg-body-secondary h-100">
                                            <div class="card-body p-3">
                                                <h6 class="mb-2"><?php echo e(ucfirst($group)); ?></h6>
                                                <?php $__currentLoopData = $perms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="form-check">
                                                        <input type="checkbox" name="permissions[]" value="<?php echo e($permission); ?>"
                                                               class="form-check-input"
                                                               id="perm_<?php echo e($permission); ?>"
                                                               <?php echo e(in_array($permission, old('permissions', $user->permissions ?? [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label small" for="perm_<?php echo e($permission); ?>"><?php echo e(explode('.', $permission)[1]); ?></label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>Actualizar Usuario
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

<script>
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        const defaultPermissions = {
            'admin': <?php echo json_encode(\App\Models\User::getDefaultPermissionsForRole('admin'), 15, 512) ?>,
            'supervisor': <?php echo json_encode(\App\Models\User::getDefaultPermissionsForRole('supervisor'), 15, 512) ?>,
            'empleado': <?php echo json_encode(\App\Models\User::getDefaultPermissionsForRole('empleado'), 15, 512) ?>,
        };

        const permissionsCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
        const rolePermissions = defaultPermissions[role] || [];

        permissionsCheckboxes.forEach(checkbox => {
            checkbox.checked = rolePermissions.includes(checkbox.value);
        });
    });
</script><?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/users/edit.blade.php ENDPATH**/ ?>