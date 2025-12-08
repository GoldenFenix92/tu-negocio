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
            <?php echo e(__('Sesiones de Caja')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1400px;">
            <div class="card">
                <div class="card-body p-4">

                    <!-- Filtros -->
                    <div class="mb-4">
                        <form method="GET" action="<?php echo e(route('cash_sessions.index')); ?>" class="row g-3">
                            <?php if(auth()->user()->role === 'admin' && isset($users)): ?>
                                <div class="col-12 col-md-6 col-lg">
                                    <label for="user_id" class="form-label">Usuario</label>
                                    <select id="user_id" name="user_id" class="form-select">
                                        <option value="">Todos los usuarios</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                                <?php echo e($user->name); ?> (<?php echo e(ucfirst($user->role)); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <div class="col-12 col-md-6 col-lg">
                                <label for="status" class="form-label">Estado</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="">Todas</option>
                                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Activas</option>
                                    <option value="closed" <?php echo e(request('status') === 'closed' ? 'selected' : ''); ?>>Cerradas</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg">
                                <label for="date_from" class="form-label">Desde</label>
                                <input id="date_from" class="form-control" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>">
                            </div>

                            <div class="col-12 col-md-6 col-lg">
                                <label for="date_to" class="form-label">Hasta</label>
                                <input id="date_to" class="form-control" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>">
                            </div>

                            <div class="col-12 col-md-6 col-lg-auto d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>Filtrar
                                </button>
                            </div>
                        </form>
                    </div>

                    <?php
                        $activeSession = \App\Models\CashSession::getActiveSession(auth()->id());
                    ?>

                    <?php if($activeSession): ?>
                        <div class="alert alert-success border-success mb-4">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div>
                                    <h5 class="alert-heading mb-2">
                                        <i class="bi bi-cash-stack me-1"></i>Tu Sesión de Caja Activa
                                    </h5>
                                    <p class="mb-1 small">Efectivo inicial: $<?php echo e(number_format((float) ($activeSession->initial_cash ?? 0), 2)); ?></p>
                                    <p class="mb-0 small">Ventas totales: $<?php echo e(number_format((float) ($activeSession->total_sales ?? 0), 2)); ?></p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('cash_sessions.show', $activeSession)); ?>" class="btn btn-success btn-sm">
                                        Ver Sesión
                                    </a>
                                    <a href="<?php echo e(route('pos.index')); ?>" class="btn btn-primary btn-sm">
                                        Ir a POS
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger border-danger mb-4">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div>
                                    <h5 class="alert-heading mb-2">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Sin Sesión de Caja Activa
                                    </h5>
                                    <p class="mb-0 small">Debes iniciar una sesión de caja para poder realizar ventas o gestionar tu caja.</p>
                                </div>
                                <a href="<?php echo e(route('cash_sessions.start_form')); ?>" class="btn btn-danger btn-sm">
                                    Iniciar Sesión de Caja
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Lista de sesiones -->
                    <?php if($sessions->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Estado</th>
                                        <th>Efectivo Inicial</th>
                                        <th>Total Ventas</th>
                                        <th>Folio Inicial</th>
                                        <th>Folio Final</th>
                                        <th>Vouchers</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-medium"><?php echo e($session->id); ?></td>
                                            <td><?php echo e($session->user->name); ?></td>
                                            <td><?php echo e($session->start_time->format('d/m/Y H:i')); ?></td>
                                            <td><?php echo e($session->end_time ? $session->end_time->format('d/m/Y H:i') : '-'); ?></td>
                                            <td>
                                                <span class="badge <?php echo e($session->estatus === 'active' ? 'bg-success' : 'bg-secondary'); ?>">
                                                    <?php echo e($session->estatus === 'active' ? 'Activa' : 'Cerrada'); ?>

                                                </span>
                                            </td>
                                            <td class="fw-medium">$<?php echo e(number_format($session->initial_cash, 2)); ?></td>
                                            <td class="fw-medium">$<?php echo e(number_format($session->total_sales, 2)); ?></td>
                                            <td><?php echo e($session->start_folio ?? '-'); ?></td>
                                            <td><?php echo e($session->end_folio ?? '-'); ?></td>
                                            <td><?php echo e($session->voucher_count); ?></td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="<?php echo e(route('cash_sessions.show', $session)); ?>" class="btn btn-outline-primary btn-sm">Gestionar</a>
                                                    <?php if($session->estatus === 'active'): ?>
                                                        <?php if($session->user_id === auth()->id() || auth()->user()->role === 'admin'): ?>
                                                            <form method="POST" action="<?php echo e(route('cash_sessions.close', $session)); ?>" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres cerrar esta sesión?')">
                                                                <?php echo csrf_field(); ?>
                                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                    <?php echo e($session->user_id === auth()->id() ? 'Cerrar' : 'Admin Cerrar'); ?>

                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php if(auth()->user()->role === 'admin' && $session->user_id !== auth()->id()): ?>
                                                            <form method="POST" action="<?php echo e(route('cash_sessions.admin_force_close', $session)); ?>" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres forzar el cierre de esta sesión como administrador?')">
                                                                <?php echo csrf_field(); ?>
                                                                <button type="submit" class="btn btn-outline-warning btn-sm">
                                                                    <i class="bi bi-lock"></i> Forzar
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('cash_sessions.report', $session)); ?>" class="btn btn-outline-info btn-sm">Reporte</a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-4">
                            <?php echo e($sessions->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <p class="text-muted mb-4">No hay sesiones de caja</p>
                            <a href="<?php echo e(route('cash_sessions.start_form')); ?>" class="btn btn-success">
                                <i class="bi bi-plus-lg me-1"></i>Iniciar Primera Sesión
                            </a>
                        </div>
                    <?php endif; ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/cash_sessions/index.blade.php ENDPATH**/ ?>