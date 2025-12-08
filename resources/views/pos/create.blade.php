<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Nueva Venta - {{ $nextFolio }}
            </h2>
            <a href="{{ route('pos.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                ← Volver al POS
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('pos.complete_sale') }}" method="POST" id="sale-form">
                        @csrf

                        <!-- Información del cliente -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cliente (Opcional)
                            </label>
                            <div class="flex gap-2">
                                <select name="client_id"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Cliente general</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }} {{ $client->lastname }}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="scan-loyalty-card"
                                        class="px-3 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                        title="Escanear tarjeta de lealtad">
                                    <i class="bi bi-phone"></i> Escanear Tarjeta
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Selecciona un cliente o escanea su tarjeta de lealtad
                            </p>
                            <div id="client-discount-notification" class="text-sm text-green-600 mt-2"></div>
                        </div>

                        <!-- Productos -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Productos
                                </h3>
                                <button type="button" id="add-product"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    + Agregar Producto
                                </button>
                            </div>

                            <div id="products-list" class="space-y-4">
                                <!-- Productos se agregarán aquí dinámicamente -->
                            </div>
                        </div>

                        <!-- Cupón de descuento -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cupón de Descuento
                            </label>
                            <input type="text"
                                   name="discount_coupon"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Código de cupón">
                        </div>

                        <!-- Totales -->
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mb-6">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                    <span id="subtotal" class="font-medium text-gray-200 dark:text-gray-200">$0.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Descuento:</span>
                                    <span id="discount-amount" class="font-medium text-green-600">-$0.00</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-600 pt-2">
                                    <span class="text-gray-900 dark:text-gray-100">Total:</span>
                                    <span id="total" class="text-blue-600 dark:text-blue-400">$0.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Método de pago (Solo efectivo) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Método de Pago
                            </label>
                            <div class="p-3 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="efectivo" checked
                                           class="mr-2 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-green-800 dark:text-green-200"><i class="bi bi-cash-stack"></i> Efectivo</span>
                                </div>
                                <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                    Solo se acepta pago en efectivo
                                </p>
                            </div>
                            <!-- Hidden input to ensure efectivo is always selected -->
                            <input type="hidden" name="payment_method" value="efectivo">
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4">
                            <button type="submit"
                                    class="flex-1 py-3 px-4 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                <i class="bi bi-currency-dollar"></i> Completar Venta
                            </button>
                            <button type="button" id="cancel-sale"
                                    class="px-6 py-3 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de productos -->
    <div id="product-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Seleccionar Producto
                </h3>
                <div class="mb-4">
                    <input type="text"
                           id="product-search-modal"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Buscar producto...">
                </div>
                <div id="product-list-modal" class="max-h-64 overflow-y-auto">
                    @foreach($products as $product)
                        <div class="product-item-modal p-3 border-b border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
                             data-product-id="{{ $product->id }}"
                             data-product-name="{{ $product->name }}"
                             data-product-price="{{ $product->sell_price }}"
                             data-product-stock="{{ $product->stock }}">
                            <div class="font-medium">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Stock: {{ $product->stock }} | ${{ number_format($product->sell_price, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end gap-3 mt-4">
                    <button id="close-modal"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedProducts = [];
        let clientDiscountPercentage = 0;

        // Elementos del DOM
        const saleForm = document.getElementById('sale-form');
        const productsList = document.getElementById('products-list');
        const addProductBtn = document.getElementById('add-product');
        const subtotalEl = document.getElementById('subtotal');
        const discountAmountEl = document.getElementById('discount-amount');
        const totalEl = document.getElementById('total');
        const clientDiscountNotificationEl = document.getElementById('client-discount-notification');
        const submitBtn = saleForm.querySelector('button[type="submit"]');
        const cancelBtn = document.getElementById('cancel-sale');

        // Modal elements
        const productModal = document.getElementById('product-modal');
        const productSearchModal = document.getElementById('product-search-modal');
        const productListModal = document.getElementById('product-list-modal');
        const closeModalBtn = document.getElementById('close-modal');

        let selectedProduct = null;

        // Abrir modal de productos
        addProductBtn.addEventListener('click', function() {
            productModal.classList.remove('hidden');
            productSearchModal.focus();
        });

        // Cerrar modal
        closeModalBtn.addEventListener('click', function() {
            productModal.classList.add('hidden');
            selectedProduct = null;
        });

        // Cerrar modal al hacer clic fuera
        productModal.addEventListener('click', function(e) {
            if (e.target === this) {
                productModal.classList.add('hidden');
                selectedProduct = null;
            }
        });

        // Buscar productos en modal
        productSearchModal.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const productItems = productListModal.querySelectorAll('.product-item-modal');

            productItems.forEach(item => {
                const productName = item.querySelector('.font-medium').textContent.toLowerCase();
                if (productName.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Seleccionar producto del modal
        document.querySelectorAll('.product-item-modal').forEach(item => {
            item.addEventListener('click', function() {
                selectedProduct = {
                    id: this.dataset.productId,
                    name: this.dataset.productName,
                    price: parseFloat(this.dataset.productPrice),
                    stock: parseInt(this.dataset.productStock)
                };
                productModal.classList.add('hidden');
                showQuantityModal(selectedProduct);
            });
        });

        // Modal de cantidad
        function showQuantityModal(product) {
            const quantity = prompt(`Cantidad para ${product.name} (Stock disponible: ${product.stock})`);
            if (quantity && parseInt(quantity) > 0 && parseInt(quantity) <= product.stock) {
                addProductToSale(product, parseInt(quantity));
            } else if (quantity) {
                alert('Cantidad inválida o stock insuficiente');
            }
        }

        // Agregar producto a la venta
        function addProductToSale(product, quantity) {
            const existingIndex = selectedProducts.findIndex(p => p.id === product.id);

            if (existingIndex >= 0) {
                selectedProducts[existingIndex].quantity += quantity;
            } else {
                selectedProducts.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: quantity
                });
            }

            updateProductsDisplay();
        }

        // Actualizar display de productos
        function updateProductsDisplay() {
            if (selectedProducts.length === 0) {
                productsList.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-8">No hay productos seleccionados</div>';
                submitBtn.disabled = true;
                return;
            }

            const productsHtml = selectedProducts.map((product, index) => `
                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 dark:text-gray-100">${product.name}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            $${product.price.toFixed(2)} × ${product.quantity}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-medium text-gray-900 dark:text-gray-100">
                            $${(product.price * product.quantity).toFixed(2)}
                        </div>
                        <button onclick="removeProduct(${index})"
                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm">
                            Eliminar
                        </button>
                    </div>
                </div>
            `).join('');

            productsList.innerHTML = productsHtml;
            submitBtn.disabled = false;
            updateTotals();
        }

        // Remover producto
        function removeProduct(index) {
            selectedProducts.splice(index, 1);
            updateProductsDisplay();
            updateTotals(); // Asegurar que los totales se actualicen inmediatamente
        }

        // Actualizar totales
        function updateTotals() {
            const subtotal = selectedProducts.reduce((sum, product) => sum + (product.price * product.quantity), 0);
            const discount = subtotal * (clientDiscountPercentage / 100);
            const total = subtotal - discount;

            subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
            discountAmountEl.textContent = `-$${discount.toFixed(2)}`;
            totalEl.textContent = `$${total.toFixed(2)}`;
        }

        // Cancelar venta
        cancelBtn.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres cancelar esta venta?')) {
                window.location.href = '{{ route('pos.index') }}';
            }
        });

        // Enviar formulario
        saleForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (selectedProducts.length === 0) {
                alert('Debes seleccionar al menos un producto');
                return;
            }

            const formData = new FormData(saleForm);
            formData.append('products', JSON.stringify(selectedProducts));

            submitBtn.disabled = true;
            submitBtn.textContent = 'Procesando...';

            fetch(saleForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Venta completada exitosamente!\nFolio: ' + data.folio);
                    window.location.href = '{{ route('pos.sales_history') }}';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la venta');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = '<i class="bi bi-currency-dollar"></i> Completar Venta';
            });
        });

        // Escanear tarjeta de lealtad
        const scanLoyaltyCardBtn = document.getElementById('scan-loyalty-card');
        const clientSelect = saleForm.querySelector('select[name="client_id"]');

        clientSelect.addEventListener('change', function() {
            const clientId = this.value;

            if (clientId) {
                fetch(`/clients/${clientId}/discount`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.discount_percentage > 0) {
                            clientDiscountPercentage = data.discount_percentage;
                            clientDiscountNotificationEl.textContent = `<i class="bi bi-party-popper"></i> Cliente registrado: ${clientDiscountPercentage}% de descuento aplicado`;
                        } else {
                            clientDiscountPercentage = 0;
                            clientDiscountNotificationEl.textContent = '';
                        }
                        updateTotals();
                    })
                    .catch(error => {
                        console.error('Error fetching client discount:', error);
                        clientDiscountPercentage = 0;
                        updateTotals();
                    });
            } else {
                clientDiscountPercentage = 0;
                clientDiscountNotificationEl.textContent = '';
                updateTotals();
            }
        });

        scanLoyaltyCardBtn.addEventListener('click', function() {
            const barcode = prompt('Ingresa el código de barras de la tarjeta de lealtad:');
            if (barcode && barcode.trim()) {
                // Buscar cliente por código de barras (8 dígitos)
                if (barcode.length === 8 && /^\d+$/.test(barcode)) {
                    fetch(`{{ route('clients.index') }}?search=${encodeURIComponent(barcode)}`)
                        .then(response => response.text())
                        .then(html => {
                            // Parse the HTML to find if client exists
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const clientLinks = doc.querySelectorAll('a[href*="/clients/"]');

                            if (clientLinks.length > 0) {
                                // Extract client ID from the first link
                                const href = clientLinks[0].getAttribute('href');
                                const clientId = href.match(/\/clients\/(\d+)/)?.[1];

                                if (clientId) {
                                    clientSelect.value = clientId;
                                    alert('Cliente encontrado y seleccionado automáticamente');
                                } else {
                                    alert('Cliente no encontrado con ese código de barras');
                                }
                            } else {
                                alert('Cliente no encontrado con ese código de barras');
                            }
                        })
                        .catch(error => {
                            console.error('Error searching client:', error);
                            alert('Error al buscar el cliente');
                        });
                } else {
                    alert('El código de barras debe tener 8 dígitos numéricos');
                }
            }
        });
    </script>
</x-app-layout>
