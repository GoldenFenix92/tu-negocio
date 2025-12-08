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
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h2 class="fw-semibold fs-4 text-white m-0">
                Punto de Venta - <?php echo e($nextFolio); ?>

            </h2>
            <?php
                $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());
            ?>
            <?php if($activeSession): ?>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-2">
                        <i class="bi bi-cash-stack me-1"></i> Sesión Activa: $<?php echo e(number_format($activeSession->initial_cash ?? 0, 2)); ?>

                    </span>
                    </span>
                    <a href="<?php echo e(route('cash_sessions.show', $activeSession)); ?>" class="text-primary small">
                        Ver Sesión
                    </a>
                </div>
            <?php else: ?>
                <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-2">
                    <i class="bi bi-exclamation-triangle me-1"></i> Sin Sesión de Caja
                </span>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="pos-container">
        <div class="product-panel">
            <div class="product-search-bar">
                <input type="text" id="product-search" class="form-control bg-dark text-white border-secondary" placeholder="Buscar producto por nombre o código...">
                <div id="search-results" class="position-absolute z-3 w-100 bg-dark border border-secondary rounded shadow-lg d-none"></div>
            </div>
            <h5 class="text-white fw-bold mb-3 px-3 pt-3">Productos</h5>
            <div class="product-grid">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card"
                        data-item-id="<?php echo e($product->id); ?>"
                        data-item-name="<?php echo e($product->name); ?>"
                        data-item-price="<?php echo e($product->sell_price); ?>"
                        data-item-stock="<?php echo e($product->stock); ?>"
                        data-item-type="product">
                        <img src="<?php echo e($product->imageUrl()); ?>" alt="<?php echo e($product->name); ?>" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="fw-semibold small lh-sm"><?php echo e($product->name); ?></div>
                        <div class="text-secondary extra-small">$<?php echo e(number_format($product->sell_price, 2)); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <h5 class="text-white fw-bold mb-3 px-3 pt-4">Servicios</h5>
            <div class="product-grid">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card"
                        data-item-id="<?php echo e($service->id); ?>"
                        data-item-name="<?php echo e($service->name); ?>"
                        data-item-price="<?php echo e($service->price); ?>"
                        data-item-type="service"
                        data-item-duration="<?php echo e($service->duration_minutes); ?>">
                        <img src="<?php echo e($service->imageUrl()); ?>" alt="<?php echo e($service->name); ?>" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="fw-semibold small lh-sm"><?php echo e($service->name); ?></div>
                        <div class="text-secondary extra-small">$<?php echo e(number_format($service->price, 2)); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="cart-panel">
            <div class="cart-header d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0">Carrito</h5>
                <button id="clear-cart" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash me-1"></i>Limpiar
                </button>
            </div>
            <div class="p-3">
                <label class="form-label small fw-medium">Cliente</label>
                <select id="client-select" class="form-select form-select-sm bg-dark text-white border-secondary">
                    <option value="">Cliente general</option>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($client->id); ?>"><?php echo e($client->full_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div id="client-discount-notice" class="d-none mt-2 p-2 bg-success bg-opacity-10 border border-success rounded small text-success">
                </div>
            </div>
            <div id="cart-items" class="cart-items-container">
                <div class="text-center text-secondary py-4">No hay productos</div>
            </div>
            <div class="cart-summary">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span id="subtotal">$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Descuento Cliente:</span>
                    <span id="client-discount">-$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Descuento Cupón:</span>
                    <span id="coupon-discount">-$0.00</span>
                </div>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total:</span>
                    <span id="total">$0.00</span>
                </div>
                <div class="mt-3">
                    <label class="form-label small fw-medium">Método de Pago</label>
                    <select id="payment-method-select" class="form-select bg-dark text-white border-secondary">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="mixto">Mixto</option>
                    </select>
                </div>

                <!-- Payment method specific inputs -->
                <div id="card-payment-details" class="mt-3 d-none">
                    <label class="form-label small fw-medium">Tipo de Tarjeta</label>
                    <select id="card-type-select" class="form-select bg-dark text-white border-secondary">
                        <option value="debito">Débito</option>
                        <option value="credito">Crédito</option>
                    </select>

                    <label class="form-label small fw-medium mt-2">Folio de Voucher</label>
                    <input type="text" id="voucher-folio-input" class="form-control bg-dark text-white border-secondary" placeholder="Folio del voucher">
                </div>

                <div id="mixed-payment-details" class="mt-3 d-none">
                    <label class="form-label small fw-medium">Monto en Tarjeta (Mixto)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-secondary text-white">$</span>
                        <input type="number" id="card-amount-input" class="form-control bg-dark text-white border-secondary" placeholder="0.00" step="0.01" min="0">
                    </div>
                </div>

                <!-- Discount coupon inputs -->
                <div class="mt-3">
                    <label class="form-label small fw-medium">Cupón de Descuento</label>
                    <div class="input-group">
                        <input type="text" id="coupon-code-input" class="form-control bg-dark text-white border-secondary" placeholder="Código de cupón">
                        <button id="coupon-btn" class="btn btn-primary">Aplicar</button>
                    </div>
                    <div id="coupon-status-message" class="mt-1 small text-secondary"></div>
                </div>

                <button id="complete-sale" class="btn btn-primary w-100 mt-3 py-2 fw-semibold" disabled>
                    <i class="bi bi-cart-check me-1"></i>Completar Venta
                </button>
            </div>
        </div>
    </div>

    <!-- Quantity Modal -->
    <div id="quantity-modal" class="modal-backdrop-custom d-none">
        <div class="modal-dialog-custom">
            <div class="modal-content-custom">
                <h5 class="fw-medium mb-3">Cantidad para <span id="modal-product-name"></span></h5>
                <div class="mb-3">
                    <label class="form-label small fw-medium">Cantidad</label>
                    <input type="number" id="quantity-input" min="1" class="form-control bg-dark text-white border-secondary" value="1">
                    <div class="small text-secondary mt-1">
                        Precio: $<span id="modal-product-price"></span>
                        <span id="modal-stock-info"> | <span id="modal-stock-label">Stock</span>: <span id="modal-product-stock"></span></span>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button id="cancel-quantity" class="btn btn-secondary">Cancelar</button>
                    <button id="confirm-quantity" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal-backdrop-custom d-none">
        <div class="modal-dialog-custom" style="max-width: 500px;">
            <div class="modal-content-custom text-center">
                <h4 class="fw-bold mb-3">Confirmar Venta</h4>
                <div id="confirmation-summary" class="text-start mb-4 border-bottom border-secondary pb-3"></div>
                <div id="cash-payment-inputs" class="mb-4 d-none">
                    <label id="cash-received-label" class="form-label fs-5 fw-medium">Monto Recibido (Efectivo)</label>
                    <input type="number" id="cash-received-input" class="form-control form-control-lg text-center bg-dark text-white border-secondary" placeholder="0.00">
                </div>
                <div id="change-display" class="mb-4 p-3 bg-success bg-opacity-25 rounded d-none">
                    <p class="fs-5 fw-medium mb-1">Su Cambio:</p>
                    <p id="change-amount" class="display-4 fw-bold text-success m-0">$0.00</p>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <button id="cancel-confirmation" class="btn btn-secondary btn-lg px-4">Cancelar</button>
                    <button id="confirm-sale-button" class="btn btn-success btn-lg px-4 fw-semibold">Confirmar Venta</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let selectedProduct = null;
        let selectedClientId = null;

        const productSearch = document.getElementById('product-search');
        const searchResults = document.getElementById('search-results');
        const cartItems = document.getElementById('cart-items');
        const clearCartBtn = document.getElementById('clear-cart');
        const subtotalEl = document.getElementById('subtotal');
        const clientDiscountEl = document.getElementById('client-discount');
        const couponDiscountEl = document.getElementById('coupon-discount');
        const totalEl = document.getElementById('total');
        const completeSaleBtn = document.getElementById('complete-sale');
        const clientSelect = document.getElementById('client-select');
        const clientDiscountNotice = document.getElementById('client-discount-notice');
        const paymentMethodSelect = document.getElementById('payment-method-select');
        const quantityModal = document.getElementById('quantity-modal');
        const modalProductName = document.getElementById('modal-product-name');
        const modalProductPrice = document.getElementById('modal-product-price');
        const modalProductStock = document.getElementById('modal-product-stock');
        const quantityInput = document.getElementById('quantity-input');
        const cancelQuantityBtn = document.getElementById('cancel-quantity');
        const confirmQuantityBtn = document.getElementById('confirm-quantity');
        const confirmationModal = document.getElementById('confirmation-modal');
        const confirmationSummary = document.getElementById('confirmation-summary');
        const cashPaymentInputs = document.getElementById('cash-payment-inputs');
        const cashReceivedInput = document.getElementById('cash-received-input');
        const changeDisplay = document.getElementById('change-display');
        const changeAmount = document.getElementById('change-amount');
        const cancelConfirmationBtn = document.getElementById('cancel-confirmation');
        const confirmSaleBtn = document.getElementById('confirm-sale-button');
        const cashReceivedLabel = document.getElementById('cash-received-label');

        // New elements for payment details
        const cardPaymentDetails = document.getElementById('card-payment-details');
        const cardTypeSelect = document.getElementById('card-type-select');
        const voucherFolioInput = document.getElementById('voucher-folio-input');
        const mixedPaymentDetails = document.getElementById('mixed-payment-details');
        const cardAmountInput = document.getElementById('card-amount-input');

        // New elements for discount coupon
        const couponCodeInput = document.getElementById('coupon-code-input');
        const couponBtn = document.getElementById('coupon-btn');
        const couponStatusMessage = document.getElementById('coupon-status-message');

        let appliedCoupon = null;
        let clientDiscountPercentage = 0;



        function displaySearchResults(items) {
            if (items.length === 0) {
                searchResults.classList.add('d-none');
                return;
            }
            searchResults.innerHTML = items.map(item => `
                <div class="search-result-item px-3 py-2 cursor-pointer hover-bg"
                    data-item-id="${item.id}"
                    data-item-name="${item.name}"
                    data-item-price="${item.sell_price}"
                    data-item-stock="${item.stock}"
                    data-item-type="${item.type}"
                    data-item-duration="${item.duration_minutes || ''}">
                    <div class="fw-medium">${item.name}</div>
                    <div class="small text-secondary">
                        ${item.type === 'product' ? `SKU: ${item.sku} | Stock: ${item.stock}` : `Duración: ${item.duration_minutes} min`}
                    </div>
                </div>
            `).join('');
            searchResults.classList.remove('d-none');
            searchResults.querySelectorAll('.search-result-item').forEach(itemEl => {
                itemEl.addEventListener('click', () => {
                    showQuantityModal({
                        id: itemEl.dataset.itemId,
                        name: itemEl.dataset.itemName,
                        price: parseFloat(itemEl.dataset.itemPrice),
                        stock: itemEl.dataset.itemStock ? parseInt(itemEl.dataset.itemStock) : null,
                        type: itemEl.dataset.itemType,
                        duration_minutes: itemEl.dataset.itemDuration ? parseInt(itemEl.dataset.itemDuration) : null
                    });
                    searchResults.classList.add('d-none');
                    productSearch.value = '';
                });
            });
        }

        productSearch.addEventListener('input', () => {
            const query = productSearch.value;
            if (query.length < 2) {
                searchResults.classList.add('d-none');
                return;
            }
            fetch(`<?php echo e(route('pos.search_products')); ?>?q=${query}`)
                .then(res => res.json())
                .then(data => displaySearchResults(data));
        });

        function showQuantityModal(item) {
            selectedProduct = item;
            modalProductName.textContent = item.name;
            modalProductPrice.textContent = item.price.toFixed(2);
            quantityInput.value = 1;
            quantityInput.min = 1;

            if (item.type === 'product') {
                modalProductStock.textContent = item.stock;
                quantityInput.max = item.stock;
                document.getElementById('modal-stock-label').textContent = 'Stock:';
                document.getElementById('modal-stock-info').classList.remove('d-none');
            } else {
                modalProductStock.textContent = 'N/A';
                quantityInput.max = 999;
                document.getElementById('modal-stock-info').classList.add('d-none');
            }

            quantityModal.classList.remove('d-none');
            quantityInput.focus();
        }

        function hideQuantityModal() {
            quantityModal.classList.add('d-none');
        }

        confirmQuantityBtn.addEventListener('click', () => {
            const quantity = parseInt(quantityInput.value);
            if (quantity > 0) {
                if (selectedProduct.type === 'product' && quantity > selectedProduct.stock) {
                    alert('Cantidad excede el stock disponible.');
                    return;
                }
                addToCart(selectedProduct, quantity);
                hideQuantityModal();
            } else {
                alert('Cantidad inválida.');
            }
        });

        cancelQuantityBtn.addEventListener('click', hideQuantityModal);
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', () => {
                showQuantityModal({
                    id: card.dataset.itemId,
                    name: card.dataset.itemName,
                    price: parseFloat(card.dataset.itemPrice),
                    stock: card.dataset.itemStock ? parseInt(card.dataset.itemStock) : null,
                    type: card.dataset.itemType,
                    duration_minutes: card.dataset.itemDuration ? parseInt(card.dataset.itemDuration) : null
                });
            });
        });

        function addToCart(item, quantity) {
            const existingItem = cart.find(cartItem => cartItem.id === item.id && cartItem.type === item.type);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ ...item, quantity });
            }
            updateCartDisplay();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }
        window.removeFromCart = removeFromCart;

        function updateCartDisplay() {
            if (cart.length === 0) {
                cartItems.innerHTML = `<div class="text-center text-secondary py-4">No hay productos en el carrito</div>`;
            } else {
                cartItems.innerHTML = cart.map((item, index) => `
                    <div class="d-flex justify-content-between align-items-center p-2 bg-dark rounded mb-2">
                        <div>
                            <div class="fw-medium">${item.name} (${item.type === 'product' ? 'Producto' : 'Servicio'})</div>
                            <div class="small text-secondary">$${item.price.toFixed(2)} × ${item.quantity}</div>
                        </div>
                        <button onclick="removeFromCart(${index})" class="btn btn-link text-danger p-0 small">Eliminar</button>
                    </div>
                `).join('');
            }
            updateTotals();
            completeSaleBtn.disabled = cart.length === 0;
        }

        function updateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            
            let clientDiscount = 0;
            if (selectedClientId && selectedClientId !== "") {
                clientDiscount = subtotal * (clientDiscountPercentage / 100);
            } else {
                clientDiscountNotice.classList.add('d-none');
            }

            let couponDiscount = 0;
            if (appliedCoupon) {
                couponDiscount = subtotal * (appliedCoupon.discount_percentage / 100);
            }

            const totalDiscount = clientDiscount + couponDiscount;
            let total = subtotal - totalDiscount;

            if (total < 0) total = 0;

            subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
            clientDiscountEl.textContent = `-$${clientDiscount.toFixed(2)}`;
            couponDiscountEl.textContent = `-$${couponDiscount.toFixed(2)}`;
            totalEl.textContent = `$${total.toFixed(2)}`;
        }

        clientSelect.addEventListener('change', (e) => {
            selectedClientId = e.target.value;

            if (selectedClientId) {
                fetch(`/clients/${selectedClientId}/discount`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            clientDiscountPercentage = data.discount_percentage;
                            clientDiscountNotice.textContent = `¡Se aplicará un ${data.discount_percentage}% de descuento!`;
                            clientDiscountNotice.classList.remove('d-none');
                        } else {
                            clientDiscountPercentage = 0;
                            clientDiscountNotice.textContent = 'El cliente no tiene un descuento aplicable.';
                            clientDiscountNotice.classList.remove('d-none');
                        }
                        updateTotals();
                    })
                    .catch(error => {
                        console.error('Error fetching client discount:', error);
                        clientDiscountPercentage = 0;
                        clientDiscountNotice.classList.add('d-none');
                        updateTotals();
                    });
            } else {
                clientDiscountPercentage = 0;
                clientDiscountNotice.classList.add('d-none');
                updateTotals();
            }
        });

        paymentMethodSelect.addEventListener('change', () => {
            const method = paymentMethodSelect.value;
            cardPaymentDetails.classList.toggle('d-none', method === 'efectivo');
            mixedPaymentDetails.classList.toggle('d-none', method !== 'mixto');

            if (method === 'efectivo') {
                cardTypeSelect.value = 'debito';
                voucherFolioInput.value = '';
            }
            if (method !== 'mixto') {
                cardAmountInput.value = '';
            }
        });

        couponBtn.addEventListener('click', async () => {
            if (appliedCoupon) {
                appliedCoupon = null;
                couponCodeInput.value = '';
                couponCodeInput.disabled = false;
                couponStatusMessage.textContent = '';
                couponBtn.textContent = 'Aplicar';
                couponBtn.classList.remove('btn-danger');
                couponBtn.classList.add('btn-primary');
                updateTotals();
            } else {
                const couponCode = couponCodeInput.value.trim();
                if (couponCode) {
                    try {
                        const response = await fetch(`<?php echo e(url('/pos/validate-coupon')); ?>/${couponCode}`);
                        const data = await response.json();

                        if (data.success) {
                            appliedCoupon = data.coupon;
                            couponStatusMessage.textContent = `Cupón '${appliedCoupon.name}' aplicado: ${appliedCoupon.discount_percentage}% de descuento.`;
                            couponStatusMessage.classList.remove('text-danger');
                            couponStatusMessage.classList.add('text-success');
                            couponCodeInput.disabled = true;
                            couponBtn.textContent = 'Eliminar';
                            couponBtn.classList.remove('btn-primary');
                            couponBtn.classList.add('btn-danger');
                        } else {
                            appliedCoupon = null;
                            couponStatusMessage.textContent = data.message;
                            couponStatusMessage.classList.remove('text-success');
                            couponStatusMessage.classList.add('text-danger');
                        }
                    } catch (error) {
                        appliedCoupon = null;
                        couponStatusMessage.textContent = 'Error al validar el cupón.';
                        couponStatusMessage.classList.remove('text-success');
                        couponStatusMessage.classList.add('text-danger');
                    }
                } else {
                    appliedCoupon = null;
                    couponStatusMessage.textContent = '';
                }
                updateTotals();
            }
        });

        clearCartBtn.addEventListener('click', () => {
            if (confirm('¿Limpiar el carrito?')) {
                cart = [];
                selectedClientId = null;
                clientSelect.value = '';
                updateCartDisplay();
            }
        });

        completeSaleBtn.addEventListener('click', () => {
            openConfirmationModal();
        });

        function openConfirmationModal() {
            const total = parseFloat(totalEl.textContent.replace('$', ''));
            let summaryHtml = `
                <div class="fs-5 fw-bold mb-3">Resumen de Venta</div>
                <div class="mb-3">
                    ${cart.map(item => `
                        <div class="d-flex justify-content-between small">
                            <span>${item.name} x ${item.quantity}</span>
                            <span>$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="border-top border-secondary pt-2 mt-2">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>${subtotalEl.textContent}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Descuento:</span>
                        <span>${clientDiscountEl.textContent}</span>
                    </div>
                    <div class="d-flex justify-content-between fs-5 fw-bold text-primary">
                        <span>Total:</span>
                        <span>${totalEl.textContent}</span>
                    </div>
                    ${paymentMethodSelect.value === 'mixto' ? `
                        <div class="d-flex justify-content-between small mt-2">
                            <span>Monto en Tarjeta (Voucher):</span>
                            <span>$${(parseFloat(cardAmountInput.value) || 0).toFixed(2)}</span>
                        </div>
                    ` : ''}
                </div>
            `;
            confirmationSummary.innerHTML = summaryHtml;
            const paymentMethod = paymentMethodSelect.value;
            cashPaymentInputs.classList.toggle('d-none', paymentMethod !== 'efectivo' && paymentMethod !== 'mixto');
            cashReceivedInput.value = '';
            changeDisplay.classList.add('d-none');

            let amountToPayInCash = total;
            if (paymentMethod === 'mixto') {
                const cardAmount = parseFloat(cardAmountInput.value) || 0;
                amountToPayInCash = total - cardAmount;
                if (amountToPayInCash < 0) amountToPayInCash = 0;
                cashReceivedLabel.textContent = 'Monto Restante (Efectivo)';
                cashReceivedInput.placeholder = `Restante: ${amountToPayInCash.toFixed(2)}`;
                cashReceivedInput.value = amountToPayInCash.toFixed(2);
            } else {
                cashReceivedLabel.textContent = 'Monto Recibido (Efectivo)';
                cashReceivedInput.placeholder = '0.00';
            }

            confirmationModal.classList.remove('d-none');
            if (cashPaymentInputs.offsetParent !== null) {
                cashReceivedInput.focus();
            }
            cashReceivedInput.dispatchEvent(new Event('input'));
        }

        cashReceivedInput.addEventListener('input', () => {
            const total = parseFloat(totalEl.textContent.replace('$', ''));
            const received = parseFloat(cashReceivedInput.value) || 0;
            const paymentMethod = paymentMethodSelect.value;

            let amountNeeded = total;
            if (paymentMethod === 'mixto') {
                const cardAmount = parseFloat(cardAmountInput.value) || 0;
                amountNeeded = total - cardAmount;
                if (amountNeeded < 0) amountNeeded = 0;
            }

            if (received >= amountNeeded) {
                const change = received - amountNeeded;
                changeAmount.textContent = `$${change.toFixed(2)}`;
                changeDisplay.classList.remove('d-none');
            } else {
                changeDisplay.classList.add('d-none');
            }
        });

        cancelConfirmationBtn.addEventListener('click', () => confirmationModal.classList.add('d-none'));

        confirmSaleBtn.addEventListener('click', async () => {
            const paymentMethod = paymentMethodSelect.value;

            if ((paymentMethod === 'tarjeta' || paymentMethod === 'mixto') && voucherFolioInput.value.trim() !== '') {
                const folio = voucherFolioInput.value.trim();
                const response = await fetch('<?php echo e(route('pos.check_voucher_folio')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ voucher_folio: folio })
                });
                const data = await response.json();
                if (!data.is_unique) {
                    alert('Error: El folio de voucher ya existe. Por favor, ingrese uno diferente.');
                    return;
                }
            }

            const saleData = {
                client_id: selectedClientId,
                items: cart.map(item => ({ id: item.id, quantity: item.quantity, type: item.type })),
                payment_method: paymentMethod,
                discount_coupon: appliedCoupon ? appliedCoupon.name : null,
            };

            if (paymentMethod === 'tarjeta' || paymentMethod === 'mixto') {
                saleData.card_type = cardTypeSelect.value;
                saleData.voucher_folio = voucherFolioInput.value;
            }

            if (paymentMethod === 'mixto') {
                saleData.voucher_amount = parseFloat(cardAmountInput.value);
            }

            if (paymentMethod === 'efectivo' || paymentMethod === 'mixto') {
                saleData.cash_tendered = parseFloat(cashReceivedInput.value);
            }

            fetch('<?php echo e(route('pos.complete_sale')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(saleData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = `<?php echo e(url('/pos/pdf-preview')); ?>/${data.sale_id}`;
                } else {
                    let errorMessage = data.message;
                    if (data.errors) {
                        errorMessage += '\n\nDetalles:\n';
                        for (const field in data.errors) {
                            errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
                        }
                    }
                    alert(errorMessage);
                }
            });
        });
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/pos/index.blade.php ENDPATH**/ ?>