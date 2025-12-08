<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-file-earmark-bar-graph me-2"></i>{{ __('Reporte de Sesión de Caja') }} - {{ $cashSession->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <!-- Información de la sesión -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-body-secondary h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-info-circle me-1"></i>Información General</h6>
                                    <p class="small mb-1">Usuario: {{ $cashSession->user->name }}</p>
                                    <p class="small mb-1">Inicio: {{ $cashSession->start_time->format('d/m/Y H:i') }}</p>
                                    @if($cashSession->end_time)
                                        <p class="small mb-1">Fin: {{ $cashSession->end_time->format('d/m/Y H:i') }}</p>
                                    @endif
                                    <span class="badge {{ $cashSession->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $cashSession->status === 'active' ? 'Activa' : 'Cerrada' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-success bg-opacity-75 text-white h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-cash me-1"></i>Efectivo Inicial</h6>
                                    <p class="fs-4 fw-bold mb-0">${{ number_format($cashSession->initial_cash, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card bg-primary bg-opacity-75 text-white h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-cart-check me-1"></i>Total Ventas</h6>
                                    <p class="fs-4 fw-bold mb-1">${{ number_format($cashSession->total_sales, 2) }}</p>
                                    <p class="small mb-0">{{ $sales->count() }} ventas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white h-100" style="background-color: #7c3aed;">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-ticket-perforated me-1"></i>Vouchers</h6>
                                    <p class="fs-4 fw-bold mb-1">{{ $cashSession->voucher_count }}</p>
                                    @if($vouchers->count() > 0)
                                        <p class="small mb-0">{{ $vouchers->count() }} folios únicos</p>
                                    @endif
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
                                    <p class="fs-4 fw-bold mb-0">${{ number_format($currentCashBalance, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info bg-opacity-75 text-white h-100">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-credit-card me-1"></i>Tarjeta Actual</h6>
                                    <p class="fs-4 fw-bold mb-0">${{ number_format($currentCardBalance, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white h-100" style="background-color: #db2777;">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-ticket-perforated me-1"></i>Voucher Actual</h6>
                                    <p class="fs-4 fw-bold mb-0">${{ number_format($currentVoucherBalance, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Movimientos de Efectivo -->
                    @if($cashMovements->count() > 0)
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-arrow-left-right me-2"></i>Movimientos de Efectivo</h5>
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Razón</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cashMovements as $movement)
                                            <tr>
                                                <td class="{{ $movement->type === 'in' ? 'text-success' : 'text-danger' }} fw-semibold">
                                                    {{ $movement->type === 'in' ? 'Entrada' : 'Salida' }}
                                                </td>
                                                <td class="fw-semibold">${{ number_format($movement->amount, 2) }}</td>
                                                <td>{{ $movement->reason }}</td>
                                                <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Resumen de pagos -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success bg-opacity-75 text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-cash-stack me-1"></i>Efectivo</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($paymentSummary['efectivo'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary bg-opacity-75 text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-credit-card me-1"></i>Tarjeta</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($paymentSummary['tarjeta'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white h-100" style="background-color: #ea580c;">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-arrow-repeat me-1"></i>Transferencia</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($paymentSummary['transferencia'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-body-secondary h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-three-dots me-1"></i>Otro</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($paymentSummary['otro'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vouchers utilizados -->
                    @if($vouchers->count() > 0)
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-ticket-perforated me-2"></i>Folios de Vouchers Utilizados</h5>
                            <div class="card" style="background-color: #7c3aed; border-color: #6d28d9;">
                                <div class="card-body text-white">
                                    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-2">
                                        @foreach($vouchers as $folio)
                                            <div class="col">
                                                <span class="d-block text-center py-2 rounded" style="background-color: rgba(255,255,255,0.2);">{{ $folio }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="small mt-3 mb-0">
                                        Total de vouchers únicos: {{ $vouchers->count() }} | Total de vouchers: {{ $cashSession->voucher_count }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Lista detallada de ventas -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-list-ul me-2"></i>Ventas Detalladas</h5>
                        @if($sales->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Método</th>
                                            <th>Total</th>
                                            <th>Efectivo</th>
                                            <th>Tarjeta</th>
                                            <th>Vouchers</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td class="fw-semibold">{{ $sale->folio }}</td>
                                                <td>{{ $sale->client ? $sale->client->full_name : 'Cliente general' }}</td>
                                                <td>
                                                    <span class="badge @if($sale->payment_method === 'efectivo') bg-success @elseif($sale->payment_method === 'tarjeta') bg-primary @elseif($sale->payment_method === 'mixto') bg-info @else bg-secondary @endif">
                                                        {{ ucfirst($sale->payment_method) }}
                                                    </span>
                                                </td>
                                                <td class="fw-semibold">${{ number_format($sale->total_amount, 2) }}</td>
                                                <td>${{ number_format($sale->cash_amount, 2) }}</td>
                                                <td>${{ number_format($sale->card_amount, 2) }}</td>
                                                <td>
                                                    @if($sale->voucher_count > 0)
                                                        <span class="text-info fw-semibold">{{ $sale->voucher_count }}</span>
                                                        @if($sale->voucher_folios)
                                                            <br><small class="text-muted">{{ implode(', ', $sale->voucher_folios) }}</small>
                                                        @endif
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-cart-x fs-1"></i>
                                <p class="mt-2">No hay ventas en esta sesión</p>
                            </div>
                        @endif
                    </div>

                    <!-- Resumen final -->
                    <div class="card bg-body-secondary mb-4">
                        <div class="card-body">
                            <h5 class="mb-4"><i class="bi bi-clipboard-data me-2"></i>Resumen Final</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-3"><i class="bi bi-arrow-down-up me-1"></i>Flujo de Efectivo</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Efectivo inicial:</span>
                                        <span class="fw-semibold">${{ number_format($cashSession->initial_cash, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Ventas en efectivo:</span>
                                        <span class="fw-semibold text-success">${{ number_format($paymentSummary['efectivo'], 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between pt-2 border-top">
                                        <span class="fw-semibold">Total efectivo esperado:</span>
                                        <span class="fw-bold text-success">${{ number_format($cashSession->initial_cash + $paymentSummary['efectivo'], 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3"><i class="bi bi-bar-chart me-1"></i>Estadísticas</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Total de ventas:</span>
                                        <span class="fw-semibold">{{ $sales->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Monto promedio por venta:</span>
                                        <span class="fw-semibold">${{ $sales->count() > 0 ? number_format($cashSession->total_sales / $sales->count(), 2) : '0.00' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Vouchers utilizados:</span>
                                        <span class="fw-semibold text-info">{{ $cashSession->voucher_count }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Duración de la sesión:</span>
                                        <span class="fw-semibold">
                                            @if($cashSession->end_time)
                                                {{ $cashSession->start_time->diffInHours($cashSession->end_time) }} horas
                                            @else
                                                {{ $cashSession->start_time->diffInHours(now()) }} horas (activa)
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="d-flex gap-3">
                        <a href="{{ route('cash_sessions.show', $cashSession) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Volver a la Sesión
                        </a>
                        <a href="{{ route('cash_sessions.index') }}" class="btn btn-primary">
                            <i class="bi bi-list-ul me-1"></i>Ver Todas las Sesiones
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
