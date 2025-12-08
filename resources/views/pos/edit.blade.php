<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Editar Venta - {{ $sale->folio }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('pos.show_sale', $sale) }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    ← Volver a Detalles
                </a>
                <a href="{{ route('pos.sales_history') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="bi bi-clipboard"></i> Ver Historial
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('pos.update_sale', $sale) }}" method="POST" id="edit-sale-form">
                        @csrf
                        @method('PUT')

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
                                        <option value="{{ $client->id }}" {{ $sale->client_id == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }} {{ $client->lastname }}
                                        </option>
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
                        </div>

                        <!-- Cupón de descuento -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Cupón de Descuento
                            </label>
                            <input type="text"
                                   name="discount_coupon"
                                   value="{{ $sale->discount_coupon }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Código de cupón">
                        </div>

                        <!-- Método de pago (Solo efectivo) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Método de Pago
                            </label>
                            <div class="p-3 bg-green-50 dark:bg-green-900 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="efectivo" {{ $sale->payment_method === 'efectivo' ? 'checked' : '' }}
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

                        <!-- Estado -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Estado
                            </label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="completada" {{ $sale->status === 'completada' ? 'checked' : '' }}
                                           class="mr-2 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Completada</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="pendiente" {{ $sale->status === 'pendiente' ? 'checked' : '' }}
                                           class="mr-2 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Pendiente</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="cancelada" {{ $sale->status === 'cancelada' ? 'checked' : '' }}
                                           class="mr-2 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Cancelada</span>
                                </label>
                            </div>
                        </div>

                        <!-- Resumen de productos (solo lectura) -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Productos Vendidos
                            </h3>
                            <div class="space-y-3">
                                @foreach($sale->details as $detail)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $detail->item ? $detail->item->name : 'Producto no encontrado' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                SKU: {{ $detail->item ? $detail->item->sku : 'N/A' }} |
                                                Cantidad: {{ $detail->quantity }} |
                                                Precio: ${{ number_format($detail->price, 2) }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                ${{ number_format($detail->price * $detail->quantity, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Totales (solo lectura) -->
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mb-6">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                                    <span class="font-medium">${{ number_format($sale->subtotal, 2) }}</span>
                                </div>
                                @if($sale->discount_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Descuento:</span>
                                        <span class="font-medium text-green-600">-${{ number_format($sale->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-600 pt-2">
                                    <span class="text-gray-900 dark:text-gray-100">Total:</span>
                                    <span class="text-blue-600 dark:text-blue-400">${{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Información adicional (solo lectura) -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Cajero:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100 ml-2">{{ $sale->user->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Fecha:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100 ml-2">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex gap-4">
                            <button type="submit"
                                    class="flex-1 py-3 px-4 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="bi bi-database"></i> Actualizar Venta
                            </button>
                            <button type="button" id="cancel-edit"
                                    class="px-6 py-3 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cancelar edición
        document.getElementById('cancel-edit').addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres cancelar la edición? Los cambios no se guardarán.')) {
                window.location.href = '{{ route('pos.show_sale', $sale) }}';
            }
        });

        // Confirmar cambios antes de enviar
        document.getElementById('edit-sale-form').addEventListener('submit', function(e) {
            if (!confirm('¿Estás seguro de que quieres actualizar esta venta?')) {
                e.preventDefault();
            }
        });

        // Escanear tarjeta de lealtad
        const scanLoyaltyCardBtn = document.getElementById('scan-loyalty-card');
        const clientSelect = document.querySelector('select[name="client_id"]');

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
