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
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                <i class="bi bi-bar-chart me-2"></i> Reportes de Control de Caja
            </h2>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('cash_control.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
                <a href="<?php echo e(route('cash_control.reports_pdf_preview', request()->query())); ?>" class="btn btn-danger">
                    <i class="bi bi-file-pdf me-1"></i> Ver PDF
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid">

            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filtros</h5>

                    <form method="GET" action="<?php echo e(route('cash_control.reports')); ?>" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Usuario</label>
                            <select name="user_id" class="form-select">
                                <option value="">Todos los usuarios</option>
                                <?php $__currentLoopData = \App\Models\User::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                        <?php echo e($user->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Método de Pago</label>
                            <select name="payment_method" class="form-select">
                                <option value="">Todos los métodos</option>
                                <option value="efectivo" <?php echo e(request('payment_method') === 'efectivo' ? 'selected' : ''); ?>>Solo Efectivo</option>
                                <option value="mixto" <?php echo e(request('payment_method') === 'mixto' ? 'selected' : ''); ?>>Mixto (Efectivo + Tarjeta)</option>
                                <option value="tarjeta" <?php echo e(request('payment_method') === 'tarjeta' ? 'selected' : ''); ?>>Solo Tarjeta</option>
                                <option value="transferencia" <?php echo e(request('payment_method') === 'transferencia' ? 'selected' : ''); ?>>Transferencia</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i> Filtrar
                            </button>
                            <a href="<?php echo e(route('cash_control.reports')); ?>" class="btn btn-secondary">
                                <i class="bi bi-trash me-1"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen de Totales -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-primary">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cart-check fs-3 text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Total Ventas</p>
                                <h4 class="mb-0 fw-bold"><?php echo e(number_format($totals['total_sales'])); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-success">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cash-coin fs-3 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Efectivo</p>
                                <h4 class="mb-0 fw-bold">$<?php echo e(number_format($totals['cash_amount'], 2)); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-info">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="bi bi-credit-card fs-3 text-info"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Tarjeta</p>
                                <h4 class="mb-0 fw-bold">$<?php echo e(number_format($totals['card_amount'], 2)); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-warning">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                <i class="bi bi-wallet2 fs-3 text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Total General</p>
                                <h4 class="mb-0 fw-bold">$<?php echo e(number_format($totals['total_amount'], 2)); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ventas -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Ventas</h5>
                </div>
                <div class="card-body">
                    <?php if($sales->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Cliente</th>
                                        <th>Usuario</th>
                                        <th>Método</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo e($sale->folio); ?></td>
                                            <td><?php echo e($sale->client ? $sale->client->full_name : 'Cliente general'); ?></td>
                                            <td><?php echo e($sale->user->name ?? 'Usuario eliminado'); ?></td>
                                            <td>
                                                <?php if($sale->payment_method === 'efectivo'): ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">Efectivo</span>
                                                <?php elseif($sale->payment_method === 'tarjeta'): ?>
                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info">Tarjeta</span>
                                                <?php elseif($sale->payment_method === 'transferencia'): ?>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Transferencia</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary"><?php echo e(ucfirst($sale->payment_method)); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="fw-bold">$<?php echo e(number_format($sale->total_amount, 2)); ?></td>
                                            <td class="text-muted small"><?php echo e($sale->created_at->format('d/m/Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-3">
                            <?php echo e($sales->appends(request()->query())->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No hay ventas que coincidan con los filtros seleccionados
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Arqueos de Caja -->
            <?php if($cashCounts->count() > 0): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h5 class="card-title mb-0">Arqueos de Caja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Usuario</th>
                                        <th>Ventas</th>
                                        <th>Esperado</th>
                                        <th>Real</th>
                                        <th>Diferencia</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cashCounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cashCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo e($cashCount->folio); ?></td>
                                            <td><?php echo e($cashCount->user->name ?? 'Usuario eliminado'); ?></td>
                                            <td><?php echo e($cashCount->total_sales); ?></td>
                                            <td>$<?php echo e(number_format($cashCount->expected_cash, 2)); ?></td>
                                            <td>$<?php echo e(number_format($cashCount->actual_cash, 2)); ?></td>
                                            <td>
                                                <?php if($cashCount->difference > 0): ?>
                                                    <span class="text-success fw-bold">+$<?php echo e(number_format($cashCount->difference, 2)); ?> (Sobra)</span>
                                                <?php elseif($cashCount->difference < 0): ?>
                                                    <span class="text-danger fw-bold">-$<?php echo e(number_format(abs($cashCount->difference), 2)); ?> (Falta)</span>
                                                <?php else: ?>
                                                    <span class="text-muted">Exacto</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-muted small"><?php echo e($cashCount->created_at->format('d/m/Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Cortes de Caja -->
            <?php if($cashCuts->count() > 0): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h5 class="card-title mb-0">Cortes de Caja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Usuario</th>
                                        <th>Ventas</th>
                                        <th>Esperado</th>
                                        <th>Real</th>
                                        <th>Diferencia</th>
                                        <th>Estado</th>
                                        <th>Cerrado por</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cashCuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cashCut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo e($cashCut->folio); ?></td>
                                            <td><?php echo e($cashCut->user->name ?? 'Usuario eliminado'); ?></td>
                                            <td><?php echo e($cashCut->total_sales); ?></td>
                                            <td>$<?php echo e(number_format($cashCut->expected_cash, 2)); ?></td>
                                            <td>$<?php echo e(number_format($cashCut->actual_cash, 2)); ?></td>
                                            <td>
                                                <?php if($cashCut->difference > 0): ?>
                                                    <span class="text-success fw-bold">+$<?php echo e(number_format($cashCut->difference, 2)); ?> (Sobra)</span>
                                                <?php elseif($cashCut->difference < 0): ?>
                                                    <span class="text-danger fw-bold">-$<?php echo e(number_format(abs($cashCut->difference), 2)); ?> (Falta)</span>
                                                <?php else: ?>
                                                    <span class="text-muted">Exacto</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($cashCut->status === 'open'): ?>
                                                    <span class="badge bg-success">Abierto</span>
                                                <?php elseif($cashCut->status === 'closed'): ?>
                                                    <span class="badge bg-danger">Cerrado</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark"><?php echo e($cashCut->status_text); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($cashCut->closedBy->name ?? '-'); ?></td>
                                            <td class="text-muted small"><?php echo e($cashCut->created_at->format('d/m/Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/cash_control/reports.blade.php ENDPATH**/ ?>