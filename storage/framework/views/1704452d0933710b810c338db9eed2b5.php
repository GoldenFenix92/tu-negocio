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
        <h2 class="fw-semibold fs-4 text-white m-0">Gestión de Ventas</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1600px;">
            <!-- Action buttons -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <div class="d-flex flex-column flex-md-row gap-2">
                    <div class="input-group" style="max-width: 180px;">
                        <span class="input-group-text small">EBC-VNTA-</span>
                        <input type="text"
                               id="folio-search-input"
                               class="form-control"
                               placeholder="XXX"
                               maxlength="4"
                               value="<?php echo e(substr(request('folio'), -3)); ?>"
                               data-prefix="EBC-VNTA-">
                    </div>
                    <input type="text"
                           id="client-name-search-input"
                           class="form-control"
                           style="max-width: 200px;"
                           placeholder="Nombre del cliente..."
                           value="<?php echo e(request('client_name')); ?>">
                    <select id="status-filter" class="form-select" style="max-width: 180px;">
                        <option value="">Todos los estados</option>
                        <option value="completada" <?php echo e(request('status') === 'completada' ? 'selected' : ''); ?>>Completada</option>
                        <option value="pendiente" <?php echo e(request('status') === 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                        <option value="cancelada" <?php echo e(request('status') === 'cancelada' ? 'selected' : ''); ?>>Cancelada</option>
                        <option value="transferida" <?php echo e(request('status') === 'transferida' ? 'selected' : ''); ?>>Transferida</option>
                        <option value="eliminada" <?php echo e(request('status') === 'eliminada' ? 'selected' : ''); ?>>Eliminada</option>
                    </select>
                    <select id="payment-filter" class="form-select" style="max-width: 200px;">
                        <option value="">Todos los métodos</option>
                        <option value="efectivo" <?php echo e(request('payment_method') === 'efectivo' ? 'selected' : ''); ?>>Efectivo</option>
                        <option value="mixto" <?php echo e(request('payment_method') === 'mixto' ? 'selected' : ''); ?>>Mixto</option>
                        <option value="tarjeta" <?php echo e(request('payment_method') === 'tarjeta' ? 'selected' : ''); ?>>Tarjeta</option>
                        <option value="transferencia" <?php echo e(request('payment_method') === 'transferencia' ? 'selected' : ''); ?>>Transferencia</option>
                    </select>
                    <input type="date"
                           id="date-filter"
                           class="form-control"
                           style="max-width: 160px;"
                           value="<?php echo e(request('date')); ?>">
                    <button id="filter-btn" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Filtrar
                    </button>
                    <button id="clear-filters-btn" class="btn btn-secondary">
                        <i class="bi bi-x-lg me-1"></i>Limpiar
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('pos.index')); ?>" class="btn btn-primary">
                        <i class="bi bi-cart me-1"></i>Nueva Venta
                    </a>
                    <a href="<?php echo e(route('pos.export_all_pdf_preview', array_merge(request()->query()))); ?>" class="btn btn-success">
                        <i class="bi bi-file-pdf me-1"></i>Ver PDF
                    </a>
                </div>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Sales cards container -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <!-- Sale Card -->
                    <div class="col">
                        <div class="card h-100 <?php echo e($sale->trashed() ? 'opacity-50' : ''); ?>">
                            <!-- Status indicator bar -->
                            <div class="<?php if($sale->estatus === 'completada'): ?> bg-success <?php elseif($sale->estatus === 'pendiente'): ?> bg-warning <?php elseif($sale->estatus === 'cancelada'): ?> bg-danger <?php elseif($sale->estatus === 'transferida'): ?> bg-primary <?php else: ?> bg-secondary <?php endif; ?>" style="height: 4px;"></div>

                            <div class="card-body">
                                <!-- Folio and Date -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-1"><?php echo e($sale->folio); ?></h5>
                                        <p class="text-secondary small mb-0"><?php echo e($sale->created_at->format('d/m/Y H:i')); ?></p>
                                    </div>
                                    <!-- Status badge -->
                                    <span class="badge <?php if($sale->estatus === 'completada'): ?> bg-success <?php elseif($sale->estatus === 'pendiente'): ?> bg-warning text-dark <?php elseif($sale->estatus === 'cancelada'): ?> bg-danger <?php elseif($sale->estatus === 'transferida'): ?> bg-primary <?php endif; ?>">
                                        <?php echo e(ucfirst($sale->estatus)); ?>

                                    </span>
                                </div>

                                <!-- Client and Cashier -->
                                <div class="mb-3">
                                    <p class="small mb-1">
                                        <span class="fw-medium">Cliente:</span> <?php echo e($sale->client ? $sale->client->full_name : 'Cliente general'); ?>

                                    </p>
                                    <p class="small mb-0">
                                        <span class="fw-medium">Cajero:</span> <?php echo e($sale->user->name); ?>

                                    </p>
                                </div>

                                <!-- Payment info -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">Total:</span>
                                        <span class="fs-5 fw-bold text-success">$<?php echo e(number_format($sale->total_amount, 2)); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <span class="small">Método:</span>
                                        <span class="badge <?php if($sale->payment_method === 'efectivo'): ?> bg-success <?php elseif($sale->payment_method === 'tarjeta'): ?> bg-primary <?php elseif($sale->payment_method === 'mixto'): ?> bg-info <?php elseif($sale->payment_method === 'transferencia'): ?> bg-purple <?php else: ?> bg-secondary <?php endif; ?>">
                                            <?php echo e(ucfirst($sale->payment_method)); ?>

                                        </span>
                                    </div>
                                    <?php if($sale->voucher_count > 0): ?>
                                        <div class="mt-2 small text-purple">
                                            <span class="fw-medium"><?php echo e($sale->voucher_count); ?> voucher(s)</span>
                                            <?php if($sale->voucher_folios && count($sale->voucher_folios) > 0): ?>
                                                <br><?php echo e(implode(', ', $sale->voucher_folios)); ?>

                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Action buttons -->
                                <div class="d-flex flex-wrap gap-1 mt-3">
                                    <a href="<?php echo e(route('pos.show_sale', $sale)); ?>" class="btn btn-primary btn-sm flex-fill d-flex align-items-center justify-content-center">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if(!$sale->trashed()): ?>
                                        <?php if($sale->estatus !== 'cancelada'): ?>
                                            <form action="<?php echo e(route('pos.cancel_sale', $sale)); ?>" method="POST" class="flex-fill" onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta venta?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <button onclick="confirmDeleteSale(<?php echo e($sale->id); ?>, '<?php echo e($sale->folio); ?>')" class="btn btn-secondary btn-sm flex-fill d-flex align-items-center justify-content-center">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('pos.restore_sale', $sale)); ?>" method="POST" class="flex-fill" onsubmit="return confirm('¿Estás seguro de que quieres restaurar esta venta?')">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <a href="<?php echo e(route('pos.pdf_preview', $sale)); ?>" class="btn btn-success btn-sm flex-fill d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </div>

                                <?php if($sale->trashed()): ?>
                                    <div class="mt-2 pt-2 border-top">
                                        <p class="extra-small text-secondary mb-0">
                                            Eliminada por: <?php echo e($sale->deleted_by_id ? \App\Models\User::find($sale->deleted_by_id)?->name ?? 'Usuario no encontrado' : 'Sistema'); ?>

                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-file-earmark-x fs-1 text-secondary"></i>
                                <h5 class="mt-3 text-secondary">No se encontraron ventas</h5>
                                <p class="text-secondary">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                <?php echo e($sales->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>

    <script>
        const folioSearchInput = document.getElementById('folio-search-input');
        const clientNameSearchInput = document.getElementById('client-name-search-input');
        const statusFilter = document.getElementById('status-filter');
        const paymentFilter = document.getElementById('payment-filter');
        const dateFilter = document.getElementById('date-filter');
        const filterBtn = document.getElementById('filter-btn');
        const clearFiltersBtn = document.getElementById('clear-filters-btn');

        folioSearchInput.addEventListener('input', function() {
            let value = this.value.toUpperCase();
            value = value.replace(/[^0-9]/g, '');
            this.value = value.slice(0, 3);
        });

        function applyFilters() {
            const folioSuffix = folioSearchInput.value.trim();
            const folioPrefix = folioSearchInput.dataset.prefix;
            const fullFolio = folioSuffix ? folioPrefix + folioSuffix : '';
            const clientName = clientNameSearchInput.value.trim();
            const status = statusFilter.value;
            const payment = paymentFilter.value;
            const date = dateFilter.value;

            let url = '<?php echo e(route('pos.sales_history')); ?>';
            const params = new URLSearchParams();

            if (fullFolio) params.append('folio', fullFolio);
            if (clientName) params.append('client_name', clientName);
            if (status) params.append('status', status);
            if (payment) params.append('payment_method', payment);
            if (date) params.append('date', date);

            if (params.toString()) {
                url += '?' + params.toString();
            }

            window.location.href = url;
        }

        function clearFilters() {
            folioSearchInput.value = '';
            clientNameSearchInput.value = '';
            statusFilter.value = '';
            paymentFilter.value = '';
            dateFilter.value = '';
            window.location.href = '<?php echo e(route('pos.sales_history')); ?>';
        }

        filterBtn.addEventListener('click', applyFilters);
        clearFiltersBtn.addEventListener('click', clearFilters);

        folioSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        clientNameSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });

        function confirmDeleteSale(saleId, saleFolio) {
            const secretKey = prompt(`Para eliminar permanentemente la venta ${saleFolio}, ingresa la clave secreta:`);

            if (secretKey && secretKey.trim()) {
                if (secretKey === 'EBCADMIN') {
                    const deletionReason = prompt('Ingresa el motivo de la eliminación (opcional):');

                    if (confirm('¿Estás seguro de que quieres eliminar permanentemente esta venta?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/sales/${saleId}`;

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';

                        const secretKeyField = document.createElement('input');
                        secretKeyField.type = 'hidden';
                        secretKeyField.name = 'secret_key';
                        secretKeyField.value = secretKey;

                        const reasonField = document.createElement('input');
                        reasonField.type = 'hidden';
                        reasonField.name = 'deletion_reason';
                        reasonField.value = deletionReason || 'Eliminada permanentemente por administrador';

                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        form.appendChild(secretKeyField);
                        form.appendChild(reasonField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                } else {
                    alert('Clave secreta incorrecta. No se puede eliminar la venta.');
                }
            }
        }
    </script>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/pos/history.blade.php ENDPATH**/ ?>