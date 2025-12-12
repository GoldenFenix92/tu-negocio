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
            <i class="bi bi-shield-lock"></i> Gestión de Roles y Permisos
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                <!-- Resumen de Roles -->
                <div class="mb-4">
                    <h3 class="h5 fw-semibold mb-3">Resumen de Roles</h3>
                    <div class="row g-3">

                        <!-- Administradores -->
                        <div class="col-md-4">
                            <div class="card border-danger" style="background-color: rgba(220, 53, 69, 0.1); box-shadow: var(--shadow-sm);">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <img class="me-2" src="<?php echo e(asset('images/administrador.webp')); ?>" alt="Admin" style="width: 32px; height: 32px;">
                                        <div class="flex-grow-1">
                                            <div class="px-2 py-1 rounded" style="background-color: rgba(220, 53, 69, 0.2);">
                                                <h5 class="card-title mb-0 fw-semibold" style="color: #a71d2a;">Administradores</h5>
                                            </div>
                                            <p class="card-text small mt-1 px-2" style="color: #721c24; font-weight: 500;">Acceso completo al sistema</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-danger"><?php echo e($roleCounts['admin'] ?? 0); ?> usuarios</span>
                                </div>
                            </div>
                        </div>

                        <!-- Supervisores -->
                        <div class="col-md-4">
                            <div class="card border-primary" style="background-color: color-mix(in srgb, var(--color-primary), transparent 90%); box-shadow: var(--shadow-sm);">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <img class="me-2" src="<?php echo e(asset('images/supervisor.webp')); ?>" alt="Supervisor" style="width: 32px; height: 32px;">
                                        <div class="flex-grow-1">
                                            <div class="px-2 py-1 rounded" style="background-color: color-mix(in srgb, var(--color-primary), transparent 80%);">
                                                <h5 class="card-title mb-0 fw-semibold" style="color: color-mix(in srgb, var(--color-primary), black 20%);">Supervisores</h5>
                                            </div>
                                            <p class="card-text small mt-1 px-2" style="color: color-mix(in srgb, var(--color-primary), black 30%); font-weight: 500;">Gestión y reportes</p>
                                        </div>
                                    </div>
                                    <span class="badge" style="background-color: var(--color-primary); color: white;"><?php echo e($roleCounts['supervisor'] ?? 0); ?> usuarios</span>
                                </div>
                            </div>
                        </div>

                        <!-- Empleados -->
                        <div class="col-md-4">
                            <div class="card border-success" style="background-color: rgba(25, 135, 84, 0.1); box-shadow: var(--shadow-sm);">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <img class="me-2" src="<?php echo e(asset('images/empleado.webp')); ?>" alt="Empleado" style="width: 32px; height: 32px;">
                                        <div class="flex-grow-1">
                                            <div class="px-2 py-1 rounded" style="background-color: rgba(25, 135, 84, 0.2);">
                                                <h5 class="card-title mb-0 fw-semibold" style="color: #0a5c32;">Empleados</h5>
                                            </div>
                                            <p class="card-text small mt-1 px-2" style="color: #0f5132; font-weight: 500;">Operaciones básicas</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-success"><?php echo e($roleCounts['empleado'] ?? 0); ?> usuarios</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Matriz de Permisos -->
                <div class="mb-4">
                    <h3 class="h5 fw-semibold mb-3">Matriz de Permisos por Rol</h3>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="min-width: 150px;">Módulo</th>
                                    <th class="text-center" style="min-width: 120px;">Admin</th>
                                    <th class="text-center" style="min-width: 120px;">Supervisor</th>
                                    <th class="text-center" style="min-width: 120px;">Empleado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Punto de Venta -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-cart3 me-2 text-primary"></i>Punto de Venta (POS)</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                </tr>

                                <!-- Historial de Ventas -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-clock-history me-2 text-info"></i>Historial de Ventas</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-pencil me-1"></i>Completo + Eliminar</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-pencil me-1"></i>Ver/Editar/Cancelar</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                </tr>

                                <!-- Control de Caja -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-cash-coin me-2 text-success"></i>Control de Caja</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                </tr>

                                <!-- Productos -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-box-seam me-2 text-warning"></i>Productos</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-plus-circle me-1"></i>Ver/Crear</span>
                                    </td>
                                </tr>

                                <!-- Categorías -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-tags me-2 text-warning"></i>Categorías</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-plus-circle me-1"></i>Ver/Crear</span>
                                    </td>
                                </tr>

                                <!-- Servicios -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-tools me-2 text-info"></i>Servicios</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-eye me-1"></i>Solo lectura</span>
                                    </td>
                                </tr>

                                <!-- Gestión de Stock -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-boxes me-2 text-primary"></i>Gestión de Stock</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                </tr>

                                <!-- Clientes -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-people me-2 text-success"></i>Clientes</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-pencil me-1"></i>Ver/Crear/Editar</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-eye me-1"></i>Solo lectura</span>
                                    </td>
                                </tr>

                                <!-- Proveedores -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-shop me-2 text-info"></i>Proveedores</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-plus-circle me-1"></i>Ver/Crear</span>
                                    </td>
                                </tr>

                                <!-- Cupones -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-tag me-2 text-danger"></i>Cupones de Descuento</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                </tr>

                                <!-- Citas y Calendario -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-calendar-event me-2 text-primary"></i>Citas y Calendario</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                </tr>

                                <!-- Usuarios -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-person-gear me-2 text-danger"></i>Gestión de Usuarios</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>CRUD Completo</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-pencil me-1"></i>Ver/Editar</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark"><i class="bi bi-eye me-1"></i>Solo lectura</span>
                                    </td>
                                </tr>

                                <!-- Base de Datos -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-database me-2 text-danger"></i>Base de Datos (Backups)</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                </tr>

                                <!-- Configuración de Marca -->
                                <tr>
                                    <td class="fw-medium"><i class="bi bi-palette me-2 text-danger"></i>Configuración de Marca</td>
                                    <td class="text-center">
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sin acceso</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Acciones Rápidas -->
                <div class="mb-4">
                    <h3 class="h5 fw-semibold mb-3">Acciones Rápidas</h3>
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo e(route('users.index')); ?>" class="card border-primary text-decoration-none" style="background-color: color-mix(in srgb, var(--color-primary), transparent 85%); box-shadow: var(--shadow-sm); transition: transform 0.2s;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-people fs-1 me-3" style="color: color-mix(in srgb, var(--color-primary), black 20%);"></i>
                                        <div>
                                            <h5 class="card-title mb-0 fw-semibold" style="color: color-mix(in srgb, var(--color-primary), black 30%);">Gestionar Usuarios</h5>
                                            <p class="card-text small mb-0" style="color: var(--text-primary);">Crear, editar y asignar roles</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo e(route('database.index')); ?>" class="card border-success text-decoration-none" style="background-color: rgba(25, 135, 84, 0.15); box-shadow: var(--shadow-sm); transition: transform 0.2s;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-database fs-1 me-3" style="color: #0a5c32;"></i>
                                        <div>
                                            <h5 class="card-title mb-0 fw-semibold" style="color: #0f5132;">Base de Datos</h5>
                                            <p class="card-text small mb-0" style="color: var(--text-primary);">Respaldos y restauración</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo e(route('cash_control.reports')); ?>" class="card border-info text-decoration-none" style="background-color: rgba(13, 202, 240, 0.15); box-shadow: var(--shadow-sm); transition: transform 0.2s;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-bar-chart fs-1 me-3" style="color: #055160;"></i>
                                        <div>
                                            <h5 class="card-title mb-0 fw-semibold" style="color: #055160;">Reportes</h5>
                                            <p class="card-text small mb-0" style="color: var(--text-primary);">Ver reportes del sistema</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="<?php echo e(route('pos.sales_history')); ?>" class="card border-warning text-decoration-none" style="background-color: rgba(255, 193, 7, 0.15); box-shadow: var(--shadow-sm); transition: transform 0.2s;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock-history fs-1 me-3" style="color: #664d03;"></i>
                                        <div>
                                            <h5 class="card-title mb-0 fw-semibold" style="color: #664d03;">Historial</h5>
                                            <p class="card-text small mb-0" style="color: var(--text-primary);">Ventas y auditoría</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Información del Sistema -->
                <div class="card" style="background-color: color-mix(in srgb, var(--color-secondary), transparent 50%); box-shadow: var(--shadow-sm);">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-3">Información del Sistema</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <span class="text-muted">Total de usuarios:</span>
                                <span class="fw-bold ms-2"><?php echo e(array_sum($roleCounts ?? [])); ?></span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted">Última actualización:</span>
                                <span class="fw-bold ms-2"><?php echo e(now()->format('d/m/Y H:i')); ?></span>
                            </div>
                            <div class="col-md-4">
                                <span class="text-muted">Estado del sistema:</span>
                                <span class="badge bg-success ms-2"><i class="bi bi-check-circle me-1"></i>Operativo</span>
                            </div>
                        </div>
                    </div>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/admin/role-management.blade.php ENDPATH**/ ?>