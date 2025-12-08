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
            <i class="bi bi-cash-coin me-2"></i><?php echo e(__('Sesión de Caja')); ?> - <?php echo e($cashSession->id); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>¡Error!</strong> <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>¡Éxito!</strong> <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Información de la sesión -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-body-secondary h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-info-circle me-1"></i>Información General</h6>
                                    <p class="small mb-1">Usuario: <?php echo e($cashSession->user->name); ?></p>
                                    <p class="small mb-1">Inicio: <?php echo e($cashSession->start_time->format('d/m/Y H:i')); ?></p>
                                    <?php if($cashSession->end_time): ?>
                                        <p class="small mb-1">Fin: <?php echo e($cashSession->end_time->format('d/m/Y H:i')); ?></p>
                                    <?php endif; ?>
                                    <?php if($cashSession->start_folio): ?>
                                        <p class="small mb-1">Folio Inicial: <?php echo e($cashSession->start_folio); ?></p>
                                    <?php endif; ?>
                                    <?php if($cashSession->end_folio): ?>
                                        <p class="small mb-1">Folio Final: <?php echo e($cashSession->end_folio); ?></p>
                                    <?php endif; ?>
                                    <span class="badge <?php echo e($cashSession->status === 'active' ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e($cashSession->status === 'active' ? 'Activa' : 'Cerrada'); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-success bg-opacity-75 text-white h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-cash me-1"></i>Efectivo Inicial</h6>
                                    <p class="fs-4 fw-bold mb-0">$<?php echo e(number_format($cashSession->initial_cash, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-primary bg-opacity-75 text-white h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-cart-check me-1"></i>Total Ventas</h6>
                                    <p class="fs-4 fw-bold mb-1">$<?php echo e(number_format($totalSales, 2)); ?></p>
                                    <p class="small mb-0"><?php echo e($sales->count()); ?> ventas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white h-100" style="background-color: #7c3aed;">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-ticket-perforated me-1"></i>Vouchers</h6>
                                    <p class="fs-4 fw-bold mb-1"><?php echo e($voucherCount); ?></p>
                                    <?php if($voucherFolios->count() > 0): ?>
                                        <p class="small mb-0"><?php echo e($voucherFolios->count()); ?> folios únicos</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Balances en Tiempo Real -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-warning bg-opacity-75 text-dark h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-currency-dollar me-1"></i>Efectivo Actual</h6>
                                    <p class="fs-4 fw-bold mb-0">$<?php echo e(number_format($currentCashBalance, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info bg-opacity-75 text-white h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-credit-card me-1"></i>Tarjeta Actual</h6>
                                    <p class="fs-4 fw-bold mb-0">$<?php echo e(number_format($currentCardBalance, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white h-100" style="background-color: #db2777;">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-ticket-perforated me-1"></i>Voucher Actual</h6>
                                    <p class="fs-4 fw-bold mb-0">$<?php echo e(number_format($currentVoucherBalance, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de pagos -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-success bg-opacity-75 text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-cash-stack me-1"></i>Efectivo</h6>
                                    <p class="fs-5 fw-bold mb-0">$<?php echo e(number_format($totalCash, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary bg-opacity-75 text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-credit-card me-1"></i>Tarjeta</h6>
                                    <p class="fs-5 fw-bold mb-0">$<?php echo e(number_format($totalCard, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white h-100" style="background-color: #ea580c;">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-arrow-repeat me-1"></i>Mixto</h6>
                                    <p class="fs-5 fw-bold mb-0">$<?php echo e(number_format($totalMixed, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <?php if($cashSession->status === 'active'): ?>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <?php if($cashSession->user_id === auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('cash_sessions.close', $cashSession)); ?>" onsubmit="return confirm('¿Estás seguro de que quieres cerrar esta sesión de caja?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle me-1"></i><?php echo e(__('Cerrar Sesión de Caja')); ?>

                                    </button>
                                </form>
                            <?php endif; ?>

                            <?php if(auth()->user()->role === 'admin' && $cashSession->user_id !== auth()->id()): ?>
                                <form method="POST" action="<?php echo e(route('cash_sessions.admin_close', $cashSession)); ?>" onsubmit="return confirm('¿Estás seguro de que quieres forzar el cierre de esta sesión como administrador? Esta acción cerrará la sesión de <?php echo e($cashSession->user->name); ?>.')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn text-white" style="background-color: #7c3aed;">
                                        <i class="bi bi-lock me-1"></i>Forzar Cierre (Admin)
                                    </button>
                                </form>
                            <?php endif; ?>

                            <a href="<?php echo e(route('cash_sessions.report', $cashSession)); ?>" class="btn btn-primary">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i>Ver Reporte
                            </a>
                        </div>

                        <?php if(auth()->user()->role === 'admin' && $cashSession->user_id !== auth()->id()): ?>
                            <div class="alert alert-warning mb-4">
                                <div class="d-flex">
                                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                                    <div>
                                        <h6 class="mb-1">Sesión de otro usuario</h6>
                                        <p class="mb-0 small">Esta es la sesión activa de <strong><?php echo e($cashSession->user->name); ?></strong>. Como administrador, puedes forzar el cierre de esta sesión si es necesario.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="mb-4">
                            <a href="<?php echo e(route('cash_sessions.report', $cashSession)); ?>" class="btn btn-primary">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i>Ver Reporte Detallado
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Lista de ventas -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-cart me-2"></i>Ventas de la Sesión</h5>
                        <?php if($sales->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Método de Pago</th>
                                            <th>Total</th>
                                            <th>Vouchers</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="fw-semibold"><?php echo e($sale->folio); ?></td>
                                                <td><?php echo e($sale->client ? $sale->client->full_name : 'Cliente general'); ?></td>
                                                <td>
                                                    <span class="badge <?php if($sale->payment_method === 'efectivo'): ?> bg-success <?php elseif($sale->payment_method === 'tarjeta'): ?> bg-primary <?php elseif($sale->payment_method === 'mixto'): ?> bg-info <?php else: ?> bg-secondary <?php endif; ?>">
                                                        <?php echo e(ucfirst($sale->payment_method)); ?>

                                                    </span>
                                                </td>
                                                <td class="fw-semibold">$<?php echo e(number_format($sale->total_amount, 2)); ?></td>
                                                <td>
                                                    <?php if($sale->voucher_count > 0): ?>
                                                        <span class="text-info fw-semibold"><?php echo e($sale->voucher_count); ?></span>
                                                        <?php if($sale->voucher_folios): ?>
                                                            <br><small class="text-muted"><?php echo e(implode(', ', $sale->voucher_folios)); ?></small>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($sale->created_at->format('d/m/Y H:i')); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('pos.show_sale', $sale)); ?>" class="btn btn-info btn-sm">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-cart-x fs-1"></i>
                                <p class="mt-2">No hay ventas en esta sesión</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Vouchers únicos -->
                    <?php if($voucherFolios->count() > 0): ?>
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-ticket-perforated me-2"></i>Folios de Vouchers Utilizados</h5>
                            <div class="card" style="background-color: #7c3aed; border-color: #6d28d9;">
                                <div class="card-body text-white">
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $voucherFolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge rounded-pill fs-6" style="background-color: rgba(255,255,255,0.2);"><?php echo e($folio); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <p class="small mt-3 mb-0">Total de vouchers únicos: <?php echo e($voucherFolios->count()); ?></p>
                                </div>
                            </div>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/cash_sessions/show.blade.php ENDPATH**/ ?>