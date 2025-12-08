<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-white m-0">
                <i class="bi bi-receipt me-2"></i>Detalles de Venta - {{ $sale->folio }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('pos.sales_history') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
                <a href="{{ route('pos.pdf_preview', $sale) }}" class="btn btn-success">
                    <i class="bi bi-file-pdf me-1"></i>Ver PDF
                </a>
                @if($sale->client && $sale->client->phone)
                    @php
                        $phoneNumber = '52' . preg_replace('/[^0-9]/', '', $sale->client->phone);
                        $message = urlencode("¡Gracias por tu compra en EBC - Elise Beauty Center! Tu folio de compra es: " . $sale->folio . ".");
                        $whatsappLink = "https://wa.me/{$phoneNumber}?text={$message}";
                    @endphp
                    <a href="{{ $whatsappLink }}" target="_blank" class="btn btn-whatsapp">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 900px;">
            @include('components.alerts')

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
                                <span class="fw-bold font-monospace">{{ $sale->folio }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Fecha:</span>
                                <span class="fw-medium">{{ $sale->created_at->format('d/m/Y H:i:s') }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Cajero:</span>
                                <span class="fw-medium">{{ $sale->user->name }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Cliente:</span>
                                <span class="fw-medium">{{ $sale->client ? $sale->client->full_name : 'Cliente general' }}</span>
                            </div>
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Método de Pago:</span>
                                <span class="badge @if($sale->payment_method === 'efectivo') bg-success @elseif($sale->payment_method === 'tarjeta') bg-primary @elseif($sale->payment_method === 'transferencia') bg-purple @elseif($sale->payment_method === 'mixto') bg-info @else bg-secondary @endif">
                                    {{ ucfirst($sale->payment_method) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary">Estado:</span>
                                <span class="badge @if($sale->estatus === 'completada') bg-success @elseif($sale->estatus === 'pendiente') bg-warning text-dark @elseif($sale->estatus === 'cancelada') bg-danger @elseif($sale->estatus === 'transferida') bg-primary @else bg-secondary @endif">
                                    {{ ucfirst($sale->estatus) }}
                                </span>
                            </div>
                            @if($sale->discount_coupon)
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Cupón:</span>
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                        <i class="bi bi-tag me-1"></i>{{ $sale->discount_coupon }}
                                    </span>
                                </div>
                            @endif
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
                                <span class="fw-medium">${{ number_format($sale->subtotal, 2) }}</span>
                            </div>
                            @if($sale->discount_amount > 0)
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <span class="text-secondary">Descuento:</span>
                                    <span class="fw-medium text-success">-${{ number_format($sale->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fs-5 fw-bold">Total:</span>
                                <span class="fs-4 fw-bold text-primary">${{ number_format($sale->total_amount, 2) }}</span>
                            </div>

                            @if($sale->payment_method === 'efectivo' || $sale->payment_method === 'mixto')
                                <div class="mb-2 d-flex justify-content-between align-items-center small">
                                    <span class="text-secondary">Efectivo entregado:</span>
                                    <span>${{ number_format($sale->cash_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($sale->payment_method === 'tarjeta' || $sale->payment_method === 'mixto')
                                <div class="mb-2 d-flex justify-content-between align-items-center small">
                                    <span class="text-secondary">Monto tarjeta:</span>
                                    <span>${{ number_format($sale->card_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($sale->change_amount > 0)
                                <div class="d-flex justify-content-between align-items-center text-success">
                                    <span class="fw-medium">Cambio:</span>
                                    <span class="fw-bold">${{ number_format($sale->change_amount, 2) }}</span>
                                </div>
                            @endif
                        </div>

                        @if($sale->estatus !== 'cancelada' && !$sale->trashed())
                            <div class="card-footer">
                                <form action="{{ route('pos.cancel_sale', $sale) }}" method="POST"
                                      onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta venta? Se restaurará el stock de los productos.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-x-circle me-1"></i>Cancelar Venta
                                    </button>
                                </form>
                            </div>
                        @endif
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
                                @foreach($sale->details as $detail)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-medium">{{ $detail->item ? $detail->item->name : 'Producto no encontrado' }}</div>
                                            <small class="text-secondary">SKU: {{ $detail->item ? $detail->item->sku : 'N/A' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $detail->quantity }}</span>
                                        </td>
                                        <td class="text-end">${{ number_format($detail->price, 2) }}</td>
                                        <td class="text-end pe-3 fw-medium">${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold ps-3">Total de artículos:</td>
                                    <td class="text-end pe-3 fw-bold">{{ $sale->details->sum('quantity') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($sale->notes)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-sticky me-2"></i>Notas</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $sale->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
