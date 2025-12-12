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
            <h2 class="fw-semibold fs-4 text-white m-0">
                <i class="bi bi-receipt me-2"></i>Detalles de Venta - <?php echo e($sale->folio); ?>

            </h2>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('pos.sales_history')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
                <a href="<?php echo e(route('pos.pdf_preview', $sale)); ?>" class="btn btn-success">
                    <i class="bi bi-file-pdf me-1"></i>Ver PDF
                </a>
                <?php if($sale->client && $sale->client->phone): ?>
                    <?php
                        $phoneNumber = '52' . preg_replace('/[^0-9]/', '', $sale->client->phone);
                        $message = urlencode("¡Gracias por tu compra en EBC - Elise Beauty Center! Tu folio de compra es: " . $sale->folio . ".");
                        $whatsappLink = "https://wa.me/{$phoneNumber}?text={$message}";
                    ?>
                    <a href="<?php echo e($whatsappLink); ?>" target="_blank" class="btn btn-whatsapp">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                <?php endif; ?>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container" style="max-width: 900px;">
            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row g-4">
                <!-- Información de la venta -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información General</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Folio:</span>
                                <span class="fw-bold font-monospace"><?php echo e($sale->folio); ?></span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Fecha:</span>
                                <span class="fw-medium"><?php echo e($sale->created_at->format('d/m/Y H:i:s')); ?></span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Cajero:</span>
                                <span class="fw-medium"><?php echo e($sale->user->name); ?></span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Cliente:</span>
                                <span class="fw-medium"><?php echo e($sale->client ? $sale->client->full_name : 'Cliente general'); ?></span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Método de Pago:</span>
                                <span class="badge <?php if($sale->payment_method === 'efectivo'): ?> bg-success <?php elseif($sale->payment_method === 'tarjeta'): ?> bg-primary <?php elseif($sale->payment_method === 'transferencia'): ?> bg-purple <?php elseif($sale->payment_method === 'mixto'): ?> bg-info <?php else: ?> bg-secondary <?php endif; ?>">
                                    <?php echo e(ucfirst($sale->payment_method)); ?>

                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Estado:</span>
                                <span class="badge <?php if($sale->estatus === 'completada'): ?> bg-success <?php elseif($sale->estatus === 'pendiente'): ?> bg-warning text-dark <?php elseif($sale->estatus === 'cancelada'): ?> bg-danger <?php elseif($sale->estatus === 'transferida'): ?> bg-primary <?php else: ?> bg-secondary <?php endif; ?>">
                                    <?php echo e(ucfirst($sale->estatus)); ?>

                                </span>
                            </div>
                            <?php if($sale->discount_coupon): ?>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Cupón:</span>
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                        <i class="bi bi-tag me-1"></i><?php echo e($sale->discount_coupon); ?>

                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Totales -->
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Resumen de Totales</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Subtotal:</span>
                                <span class="fw-medium">$<?php echo e(number_format($sale->subtotal, 2)); ?></span>
                            </div>
                            <?php if($sale->discount_amount > 0): ?>
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Descuento:</span>
                                    <span class="fw-medium text-success">-$<?php echo e(number_format($sale->discount_amount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fs-5 fw-bold">Total:</span>
                                <span class="fs-4 fw-bold text-primary">$<?php echo e(number_format($sale->total_amount, 2)); ?></span>
                            </div>

                            <?php if($sale->payment_method === 'efectivo' || $sale->payment_method === 'mixto'): ?>
                                <div class="mb-2 d-flex justify-content-between align-items-center small">
                                    <span class="text-secondary">Efectivo entregado:</span>
                                    <span>$<?php echo e(number_format($sale->cash_amount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($sale->payment_method === 'tarjeta' || $sale->payment_method === 'mixto'): ?>
                                <div class="mb-2 d-flex justify-content-between align-items-center small">
                                    <span class="text-secondary">Monto tarjeta:</span>
                                    <span>$<?php echo e(number_format($sale->card_amount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($sale->change_amount > 0): ?>
                                <div class="d-flex justify-content-between align-items-center text-success">
                                    <span class="fw-medium">Cambio:</span>
                                    <span class="fw-bold">$<?php echo e(number_format($sale->change_amount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if($sale->estatus !== 'cancelada' && !$sale->trashed()): ?>
                            <div class="card-footer">
                                <form action="<?php echo e(route('pos.cancel_sale', $sale)); ?>" method="POST"
                                      onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta venta? Se restaurará el stock de los productos.')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar Venta
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Detalles de productos -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Productos Vendidos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-3">Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unit.</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $sale->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-medium"><?php echo e($detail->item ? $detail->item->name : 'Producto no encontrado'); ?></div>
                                            <small class="text-secondary">SKU: <?php echo e($detail->item ? $detail->item->sku : 'N/A'); ?></small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary"><?php echo e($detail->quantity); ?></span>
                                        </td>
                                        <td class="text-end">$<?php echo e(number_format($detail->price, 2)); ?></td>
                                        <td class="text-end pe-3 fw-medium">$<?php echo e(number_format($detail->price * $detail->quantity, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold ps-3">Total de artículos:</td>
                                    <td class="text-end pe-3 fw-bold"><?php echo e($sale->details->sum('quantity')); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <?php if($sale->notes): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-sticky me-2"></i>Notas</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?php echo e($sale->notes); ?></p>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/pos/show.blade.php ENDPATH**/ ?>