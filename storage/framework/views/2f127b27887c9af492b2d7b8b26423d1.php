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
        <h2 class="fw-semibold fs-4 text-white m-0"><?php echo e(isset($appointment) ? 'Editar Cita' : 'Crear Cita'); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container" style="max-width: 1000px;">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php if(isset($appointment)): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>

                        <div class="row g-4">
                            <!-- Columna Izquierda -->
                            <div class="col-lg-6">
                                <!-- Selección de Cliente -->
                                <div class="mb-3">
                                    <label for="client_id_select" class="form-label">Cliente</label>
                                    <select name="client_id" id="client_id_select" class="form-select">
                                        <option value="">Seleccionar Cliente</option>
                                        <?php $__currentLoopData = $allClients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($client->id); ?>" <?php echo e((old('client_id', $appointment->client_id ?? '') == $client->id) ? 'selected' : ''); ?>>
                                                <?php echo e($client->display_name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Selección de Productos/Servicios -->
                                <div class="mb-3">
                                    <label for="item_select" class="form-label">Productos o Servicios</label>
                                    <select id="item_select" class="form-select">
                                        <option value="">Seleccionar Producto o Servicio</option>
                                        <?php $__currentLoopData = $allItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>" data-type="<?php echo e($item->type); ?>" data-price="<?php echo e($item->price); ?>" data-sell_price="<?php echo e($item->sell_price ?? $item->price); ?>" data-stock="<?php echo e($item->stock ?? 'N/A'); ?>" data-duration="<?php echo e($item->duration_minutes ?? 'N/A'); ?>">
                                                <?php echo e($item->name); ?> (<?php echo e(ucfirst($item->type)); ?>) - $<?php echo e(number_format($item->price, 2)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="button" id="add_item_btn" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-lg me-1"></i>Agregar
                                    </button>
                                </div>

                                <!-- Estado -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="Pendiente" <?php echo e((isset($appointment) && $appointment->estatus == 'Pendiente') ? 'selected' : ''); ?>>Pendiente</option>
                                        <option value="Anticipo" <?php echo e((isset($appointment) && $appointment->estatus == 'Anticipo') ? 'selected' : ''); ?>>Anticipo</option>
                                        <option value="Pagado" <?php echo e((isset($appointment) && $appointment->estatus == 'Pagado') ? 'selected' : ''); ?>>Pagado</option>
                                        <option value="Cancelado" <?php echo e((isset($appointment) && $appointment->estatus == 'Cancelado') ? 'selected' : ''); ?>>Cancelado</option>
                                    </select>
                                </div>

                                <!-- Campos de Anticipo (condicionales) -->
                                <div id="deposit_fields" class="d-none">
                                    <div class="mb-3">
                                        <label for="deposit_type" class="form-label">Tipo de Anticipo</label>
                                        <select name="deposit_type" id="deposit_type" class="form-select">
                                            <option value="">Seleccionar Tipo</option>
                                            <option value="Efectivo" <?php echo e((isset($appointment) && $appointment->deposit_type == 'Efectivo') ? 'selected' : ''); ?>>Efectivo</option>
                                            <option value="Transferencia" <?php echo e((isset($appointment) && $appointment->deposit_type == 'Transferencia') ? 'selected' : ''); ?>>Transferencia</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 d-none" id="deposit_amount_field">
                                        <label for="deposit_amount" class="form-label">Monto de Anticipo</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="deposit_amount" id="deposit_amount" class="form-control" value="<?php echo e(old('deposit_amount', $appointment->deposit_amount ?? '')); ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3 d-none" id="deposit_folio_field">
                                        <label for="deposit_folio" class="form-label">Folio de Transferencia</label>
                                        <input type="text" name="deposit_folio" id="deposit_folio" class="form-control" value="<?php echo e(old('deposit_folio', $appointment->deposit_folio ?? '')); ?>">
                                    </div>
                                </div>

                                <!-- Fecha y Hora -->
                                <div class="mb-3">
                                    <label for="appointment_datetime" class="form-label">Fecha y Hora</label>
                                    <input type="datetime-local" name="appointment_datetime" id="appointment_datetime" class="form-control" value="<?php echo e(old('appointment_datetime', isset($appointment) ? $appointment->appointment_datetime->format('Y-m-d\TH:i') : '')); ?>">
                                </div>

                                <!-- Comentarios -->
                                <div class="mb-3">
                                    <label for="comments" class="form-label">Comentarios</label>
                                    <textarea name="comments" id="comments" rows="3" class="form-control"><?php echo e(old('comments', $appointment->comments ?? '')); ?></textarea>
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-lg-6">
                                <h5 class="mb-3">Resumen de la Cita</h5>
                                <div id="selected_items" class="card bg-body-secondary p-3 mb-3" style="min-height: 150px;">
                                    <p class="text-secondary">Aún no has añadido productos o servicios.</p>
                                </div>
                                <div class="text-end">
                                    <p class="mb-1">Anticipo: <span id="deposit_display" class="fw-medium">$0.00</span></p>
                                    <p class="mb-1">Total Restante: <span id="remaining_total_display" class="fw-medium">$0.00</span></p>
                                    <p class="fs-5 fw-bold">Total Cita: <span id="total_cost" class="text-success">$0.00</span></p>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="items" id="items_input">
                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger mt-3">
                                <strong>¡Error!</strong> Por favor, corrige los siguientes errores:
                                <ul class="mb-0 mt-2">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Regresar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i><?php echo e(isset($appointment) ? 'Actualizar Cita' : 'Crear Cita'); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cantidad -->
    <div class="modal fade" id="quantity-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cantidad para <span id="modal-item-name"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="quantity-input" class="form-label">Cantidad</label>
                        <input type="number" id="quantity-input" min="1" class="form-control" value="1">
                        <div class="form-text">
                            Precio: $<span id="modal-item-price"></span>
                            <span id="modal-stock-info"> | Stock: <span id="modal-item-stock"></span></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel-quantity">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-quantity">
                        <i class="bi bi-plus-lg me-1"></i>Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clientIdSelect = document.getElementById('client_id_select');
            const itemSelect = document.getElementById('item_select');
            const addItemBtn = document.getElementById('add_item_btn');
            const selectedItemsContainer = document.getElementById('selected_items');
            const totalCostEl = document.getElementById('total_cost');
            const depositAmountInput = document.getElementById('deposit_amount');
            const depositDisplayEl = document.getElementById('deposit_display');
            const remainingTotalDisplayEl = document.getElementById('remaining_total_display');
            let selectedItems = [];

            let selectedItemForModal = null;

            // Modal Bootstrap
            const quantityModalEl = document.getElementById('quantity-modal');
            const quantityModal = new bootstrap.Modal(quantityModalEl);
            const modalItemName = document.getElementById('modal-item-name');
            const modalItemPrice = document.getElementById('modal-item-price');
            const modalItemStock = document.getElementById('modal-item-stock');
            const quantityInput = document.getElementById('quantity-input');
            const cancelQuantityBtn = document.getElementById('cancel-quantity');
            const confirmQuantityBtn = document.getElementById('confirm-quantity');

            <?php if(isset($appointment) && $appointment->client_id): ?>
                clientIdSelect.value = "<?php echo e($appointment->client_id); ?>";
            <?php endif; ?>

            // Lógica para mostrar/ocultar campos de anticipo
            const statusSelect = document.getElementById('status');
            const depositFields = document.getElementById('deposit_fields');
            const depositTypeSelect = document.getElementById('deposit_type');
            const depositAmountField = document.getElementById('deposit_amount_field');
            const depositFolioField = document.getElementById('deposit_folio_field');

            function toggleDepositFields() {
                if (statusSelect.value === 'Anticipo') {
                    depositFields.classList.remove('d-none');
                    toggleDepositTypeFields();
                } else {
                    depositFields.classList.add('d-none');
                    depositAmountField.classList.add('d-none');
                    depositFolioField.classList.add('d-none');
                    depositTypeSelect.value = '';
                }
            }

            function toggleDepositTypeFields() {
                if (depositTypeSelect.value === 'Transferencia') {
                    depositAmountField.classList.remove('d-none');
                    depositFolioField.classList.remove('d-none');
                } else if (depositTypeSelect.value === 'Efectivo') {
                    depositAmountField.classList.remove('d-none');
                    depositFolioField.classList.add('d-none');
                } else {
                    depositAmountField.classList.add('d-none');
                    depositFolioField.classList.add('d-none');
                }
            }

            statusSelect.addEventListener('change', toggleDepositFields);
            depositTypeSelect.addEventListener('change', toggleDepositTypeFields);
            toggleDepositFields();

            function showQuantityModal(item) {
                selectedItemForModal = item;
                modalItemName.textContent = item.name;
                modalItemPrice.textContent = (item.sell_price || item.price).toFixed(2);
                quantityInput.value = 1;
                quantityInput.min = 1;

                if (item.type === 'product') {
                    modalItemStock.textContent = item.stock;
                    quantityInput.max = item.stock;
                    document.getElementById('modal-stock-info').classList.remove('d-none');
                } else {
                    modalItemStock.textContent = 'N/A';
                    quantityInput.max = 999;
                    document.getElementById('modal-stock-info').classList.add('d-none');
                }

                quantityModal.show();
            }

            confirmQuantityBtn.addEventListener('click', () => {
                const quantity = parseInt(quantityInput.value);
                if (quantity > 0) {
                    if (selectedItemForModal.type === 'product' && quantity > selectedItemForModal.stock) {
                        alert('Cantidad excede el stock disponible.');
                        return;
                    }
                    selectedItems.push({ ...selectedItemForModal, quantity: quantity });
                    itemSelect.value = '';
                    renderSelectedItems();
                    updateTotalCost();
                    quantityModal.hide();
                } else {
                    alert('Cantidad inválida.');
                }
            });

            addItemBtn.addEventListener('click', () => {
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                if (selectedOption.value) {
                    const item = {
                        id: selectedOption.value,
                        name: selectedOption.textContent.split('(')[0].trim(),
                        type: selectedOption.dataset.type,
                        price: parseFloat(selectedOption.dataset.price),
                        sell_price: parseFloat(selectedOption.dataset.sell_price),
                        stock: selectedOption.dataset.stock !== 'N/A' ? parseInt(selectedOption.dataset.stock) : null,
                        duration_minutes: selectedOption.dataset.duration !== 'N/A' ? parseInt(selectedOption.dataset.duration) : null,
                    };
                    showQuantityModal(item);
                } else {
                    alert('Por favor, selecciona un producto o servicio.');
                }
            });

            <?php if(isset($appointment) && isset($selectedAppointmentItems)): ?>
                selectedItems = <?php echo json_encode($selectedAppointmentItems, 15, 512) ?>;
                renderSelectedItems();
                updateTotalCost();
            <?php endif; ?>

            function renderSelectedItems() {
                if (selectedItems.length === 0) {
                    selectedItemsContainer.innerHTML = '<p class="text-secondary">Aún no has añadido productos o servicios.</p>';
                    return;
                }
                selectedItemsContainer.innerHTML = '';
                selectedItems.forEach((item, index) => {
                    const itemEl = document.createElement('div');
                    itemEl.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'p-2', 'border-bottom');
                    itemEl.innerHTML = `
                        <span>${item.name} x ${item.quantity}</span>
                        <div class="d-flex align-items-center gap-2">
                            <span>$${((item.sell_price || item.price) * item.quantity).toFixed(2)}</span>
                            <button type="button" data-index="${index}" class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i></button>
                        </div>
                    `;
                    selectedItemsContainer.appendChild(itemEl);
                });
            }

            selectedItemsContainer.addEventListener('click', function (e) {
                if (e.target.closest('button')) {
                    const index = e.target.closest('button').dataset.index;
                    selectedItems.splice(index, 1);
                    renderSelectedItems();
                    updateTotalCost();
                }
            });

            function updateTotalCost() {
                const total = selectedItems.reduce((sum, item) => sum + ((item.sell_price || item.price) * item.quantity), 0);
                const depositAmount = parseFloat(depositAmountInput.value) || 0;
                const remainingTotal = total - depositAmount;

                totalCostEl.textContent = `$${total.toFixed(2)}`;
                depositDisplayEl.textContent = `$${depositAmount.toFixed(2)}`;
                remainingTotalDisplayEl.textContent = `$${remainingTotal.toFixed(2)}`;
                document.getElementById('items_input').value = JSON.stringify(selectedItems.map(item => ({ id: item.id, type: item.type, quantity: item.quantity })));
            }

            depositAmountInput.addEventListener('input', updateTotalCost);
            updateTotalCost();
        });
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/appointments/form.blade.php ENDPATH**/ ?>