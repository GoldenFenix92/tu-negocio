<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-currency-dollar"></i> Control de Caja
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <!-- Contenedor de alertas dinámicas -->
            <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1100; max-width: 450px;"></div>

            @include('components.alerts')

            <!-- Resumen del día -->
            <div class="row g-3 mb-4">
                <!-- Total de Ventas -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-primary bg-gradient text-white rounded-3 flex-shrink-0">
                                    <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ms-3">
                                    <p class="text-muted small mb-1">Ventas del Día</p>
                                    <p class="fs-4 fw-semibold mb-0">{{ $dailyTotals['total_sales'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Efectivo en Caja (Inicial + Ventas) -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-success bg-gradient text-white rounded-3 flex-shrink-0">
                                    <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="ms-3">
                                    <p class="text-muted small mb-1">Efectivo en Caja</p>
                                    <p class="fs-4 fw-semibold mb-0">${{ number_format($expectedCashInRegister, 2) }}</p>
                                    @if($initialCash > 0)
                                    <p class="text-muted extra-small mb-0">Inicial: ${{ number_format($initialCash, 2) }}</p>
                                    @endif
                                    @if($totalDeposits > 0)
                                        <p class="text-success extra-small mb-0">Ingresos: ${{ number_format($totalDeposits, 2) }}</p>
                                    @endif
                                    @if($totalWithdrawals > 0)
                                        <p class="text-danger extra-small mb-0">Retiros: ${{ number_format($totalWithdrawals, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total en Tarjeta -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-2 text-white rounded-3 flex-shrink-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div class="ms-3">
                                    <p class="text-muted small mb-1">Tarjeta</p>
                                    <p class="fs-4 fw-semibold mb-0">${{ number_format($dailyTotals['card_amount'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total General -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-warning bg-gradient text-white rounded-3 flex-shrink-0">
                                    <svg class="bi" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="ms-3">
                                    <p class="text-muted small mb-1">Total General</p>
                                    <p class="fs-4 fw-semibold mb-0">${{ number_format($dailyTotals['total_amount'], 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado actual de caja -->
            <div class="row g-3 mb-4">
                <!-- Último Arqueo -->
                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="fs-5 fw-medium mb-0">Último Arqueo</h3>
                                @if($lastCashCount)
                                    <span class="badge 
                                        @if($lastCashCount->status === 'completed') 
                                            bg-success-subtle text-success-emphasis border-success-subtle
                                        @elseif($lastCashCount->status === 'pending') 
                                            bg-warning-subtle text-warning-emphasis border-warning-subtle
                                        @else 
                                            bg-danger-subtle text-danger-emphasis border-danger-subtle
                                        @endif">
                                        {{ $lastCashCount->status_text }}
                                    </span>
                                @endif
                            </div>

                            @if($lastCashCount)
                                <div class="vstack gap-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Folio:</span>
                                        <span class="small fw-medium">{{ $lastCashCount->folio }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Esperado:</span>
                                        <span class="small fw-medium">${{ number_format($lastCashCount->expected_cash, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Real:</span>
                                        <span class="small fw-medium">${{ number_format($lastCashCount->actual_cash, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Diferencia:</span>
                                        <span class="small fw-medium 
                                            @if($lastCashCount->difference > 0) text-success
                                            @elseif($lastCashCount->difference < 0) text-danger
                                            @else text-secondary
                                            @endif">
                                            ${{ number_format($lastCashCount->difference, 2) }}
                                            @if($lastCashCount->difference > 0) (Sobra)
                                            @elseif($lastCashCount->difference < 0) (Falta)
                                            @else (Exacto) @endif
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Fecha:</span>
                                        <span class="small fw-medium">{{ $lastCashCount->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted small mb-0">No hay arqueos realizados hoy</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Estado del Corte -->
                <div class="col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="fs-5 fw-medium mb-0">Corte de Caja</h3>
                                @if($lastCashCut)
                                    <span class="badge 
                                        @if($lastCashCut->status === 'open') 
                                            bg-success-subtle text-success-emphasis border-success-subtle
                                        @elseif($lastCashCut->status === 'closed') 
                                            bg-danger-subtle text-danger-emphasis border-danger-subtle
                                        @else 
                                            bg-warning-subtle text-warning-emphasis border-warning-subtle
                                        @endif">
                                        {{ $lastCashCut->status_text }}
                                    </span>
                                @endif
                            </div>

                            @if($lastCashCut)
                                <div class="vstack gap-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Folio:</span>
                                        <span class="small fw-medium">{{ $lastCashCut->folio }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Esperado:</span>
                                        <span class="small fw-medium">${{ number_format($lastCashCut->expected_cash, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Real:</span>
                                        <span class="small fw-medium">${{ number_format($lastCashCut->actual_cash, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Diferencia:</span>
                                        <span class="small fw-medium 
                                            @if($lastCashCut->difference > 0) text-success
                                            @elseif($lastCashCut->difference < 0) text-danger
                                            @else text-secondary
                                            @endif">
                                            ${{ number_format($lastCashCut->difference, 2) }}
                                            @if($lastCashCut->difference > 0) (Sobra)
                                            @elseif($lastCashCut->difference < 0) (Falta)
                                            @else (Exacto) @endif
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted small">Fecha:</span>
                                        <span class="small fw-medium">{{ $lastCashCut->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if($lastCashCut->status === 'open')
                                        <div class="pt-2 mt-2 border-top">
                                            <button id="close-cash-cut-btn"
                                                    data-cash-cut-id="{{ $lastCashCut->id }}"
                                                    class="btn btn-danger btn-sm w-100">
                                                <i class="bi bi-lock-fill"></i> Cerrar Corte de Caja
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-muted small mb-0">No hay cortes realizados hoy</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones de Control de Caja -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="fs-5 fw-medium mb-3">Acciones de Control</h3>

                    <div class="row g-3">
                        <!-- Arqueo de Caja -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2 bg-primary bg-gradient text-white rounded-3 flex-shrink-0">
                                            <svg class="bi" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002 2"></path>
                                            </svg>
                                        </div>
                                        <h4 class="fs-6 fw-medium mb-0 ms-2">Arqueo de Caja</h4>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        Realiza un conteo temporal del efectivo para verificar el estado actual de la caja.
                                    </p>
                                    <button id="cash-count-btn" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#cash-count-modal">
                                        <i class="bi bi-search"></i> Realizar Arqueo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Corte de Caja -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2 bg-danger bg-gradient text-white rounded-3 flex-shrink-0">
                                            <svg class="bi" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="fs-6 fw-medium mb-0 ms-2">Corte de Caja</h4>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        Realiza el corte final del día. Requiere código de autorización especial.
                                    </p>
                                    <button id="cash-cut-btn" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#cash-cut-modal">
                                        <i class="bi bi-scissors"></i> Realizar Corte
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Movimientos de Efectivo -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card border h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2 bg-warning bg-gradient text-white rounded-3 flex-shrink-0">
                                            <svg class="bi" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </div>
                                        <h4 class="fs-6 fw-medium mb-0 ms-2">Movimientos de Efectivo</h4>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        Registra retiros o ingresos de efectivo de la caja.
                                    </p>
                                    <a href="{{ route('cash_control.movement_form') }}" class="btn btn-warning w-100">
                                        <i class="bi bi-cash-stack"></i> Movimiento de Efectivo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movimientos de Efectivo Recientes -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="fs-5 fw-medium mb-3">Movimientos de Efectivo Recientes</h3>

                    @if($cashMovements->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-uppercase small">Tipo</th>
                                        <th class="text-uppercase small">Monto</th>
                                        <th class="text-uppercase small">Motivo</th>
                                        <th class="text-uppercase small">Usuario</th>
                                        <th class="text-uppercase small">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cashMovements->take(5) as $movement)
                                        <tr>
                                            <td class="small fw-medium 
                                                @if($movement->type === 'withdrawal') text-danger
                                                @else text-success
                                                @endif">
                                                {{ ucfirst($movement->type === 'withdrawal' ? 'Retiro' : 'Ingreso') }}
                                            </td>
                                            <td class="small fw-medium">
                                                ${{ number_format($movement->amount, 2) }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $movement->reason }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $movement->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $movement->created_at->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-5 mb-0">
                            No hay movimientos de efectivo registrados hoy.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Ventas Recientes -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="fs-5 fw-medium mb-0">Ventas del Día</h3>
                        <a href="{{ route('cash_control.reports') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-text me-1"></i> Ver Reportes
                        </a>
                    </div>

                    @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-uppercase small">Folio</th>
                                        <th class="text-uppercase small">Cliente</th>
                                        <th class="text-uppercase small">Método</th>
                                        <th class="text-uppercase small">Total</th>
                                        <th class="text-uppercase small">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales->take(10) as $sale)
                                        <tr>
                                            <td class="small fw-medium">
                                                {{ $sale->folio }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $sale->client ? $sale->client->full_name : 'Cliente general' }}
                                            </td>
                                            <td>
                                                <span class="badge 
                                                    @if($sale->payment_method === 'efectivo') 
                                                        bg-success-subtle text-success-emphasis border-success-subtle
                                                    @elseif($sale->payment_method === 'tarjeta') 
                                                        text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                                    @elseif($sale->payment_method === 'transferencia') 
                                                        bg-primary-subtle text-primary-emphasis border-primary-subtle
                                                    @else 
                                                        bg-secondary-subtle text-secondary-emphasis border-secondary-subtle
                                                    @endif">
                                                    {{ ucfirst($sale->payment_method) }}
                                                </span>
                                            </td>
                                            <td class="small fw-medium">
                                                ${{ number_format($sale->total_amount, 2) }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $sale->created_at->format('H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-5 mb-0">
                            No hay ventas registradas hoy
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Arqueo -->
    <div class="modal fade" id="cash-count-modal" tabindex="-1" aria-labelledby="cashCountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashCountModalLabel">
                        <i class="bi bi-currency-dollar"></i> Arqueo de Caja
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-start mb-3" role="alert">
                        <div class="flex-shrink-0 me-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading mb-1">Requiere Autorización</h6>
                            <p class="mb-0 small">El arqueo de caja requiere un código de autorización especial.</p>
                        </div>
                    </div>
                    <form id="cash-count-form">
                        @csrf
                        <div class="mb-3">
                            <label for="cash-count-secret-code" class="form-label">Código de Autorización</label>
                            <input type="password"
                                   id="cash-count-secret-code"
                                   name="secret_code"
                                   class="form-control"
                                   placeholder="Ingrese el código secreto"
                                   required>
                            <div class="form-text">
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                                    Código requerido para arqueo
                                @else
                                    Código requerido para arqueo
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cash-in-register" class="form-label">Efectivo en Caja</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       id="cash-in-register"
                                       name="cash_in_register"
                                       step="0.01"
                                       min="0"
                                       class="form-control"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cash-count-notes" class="form-label">Notas (Opcional)</label>
                            <textarea id="cash-count-notes"
                                      name="notes"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Observaciones del arqueo..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="cash-count-form" class="btn btn-primary">Realizar Arqueo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Corte -->
    <div class="modal fade" id="cash-cut-modal" tabindex="-1" aria-labelledby="cashCutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashCutModalLabel">
                        <i class="bi bi-scissors"></i> Corte de Caja
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-flex align-items-start mb-3" role="alert">
                        <div class="flex-shrink-0 me-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading mb-1">Requiere Autorización</h6>
                            <p class="mb-0 small">El corte de caja requiere un código de autorización especial.</p>
                        </div>
                    </div>
                    <form id="cash-cut-form">
                        @csrf
                        <div class="mb-3">
                            <label for="secret-code" class="form-label">Código de Autorización</label>
                            <input type="password"
                                   id="secret-code"
                                   name="secret_code"
                                   class="form-control"
                                   placeholder="Ingrese el código secreto"
                                   required>
                            <div class="form-text">
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                                    Código requerido para corte de caja
                                @else
                                    Código requerido para corte de caja
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cash-cut-in-register" class="form-label">Efectivo en Caja</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       id="cash-cut-in-register"
                                       name="cash_in_register"
                                       step="0.01"
                                       min="0"
                                       class="form-control"
                                       placeholder="0.00"
                                       required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cash-cut-notes" class="form-label">Notas (Opcional)</label>
                            <textarea id="cash-cut-notes"
                                      name="notes"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Observaciones del corte..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="cash-cut-form" class="btn btn-danger">Realizar Corte</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // ==================== VERIFICACIÓN DE DEPENDENCIAS ====================
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap no está cargado');
                    alert('Error: La librería Bootstrap no se ha cargado correctamente. Por favor, recarga la página.');
                    return;
                }

                // ==================== SISTEMA DE ALERTAS BOOTSTRAP ====================
                function showAlert(type, title, message, autoHide = true) {
                    const alertContainer = document.getElementById('alert-container');
                    if (!alertContainer) {
                        console.error('Contenedor de alertas no encontrado');
                        return;
                    }
                    
                    const alertId = 'alert-' + Date.now();
                    
                    const icons = {
                        'success': 'bi-check-circle-fill',
                        'danger': 'bi-x-circle-fill',
                        'warning': 'bi-exclamation-triangle-fill',
                        'info': 'bi-info-circle-fill'
                    };
                    
                    const alertHtml = `
                        <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show shadow-lg mb-2" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="bi ${icons[type] || icons['info']} me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong>${title}</strong>
                                    <div class="small mt-1">${message}</div>
                                </div>
                                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    `;
                    
                    alertContainer.insertAdjacentHTML('beforeend', alertHtml);
                    
                    if (autoHide) {
                        setTimeout(() => {
                            const alertElement = document.getElementById(alertId);
                            if (alertElement) {
                                alertElement.classList.remove('show');
                                setTimeout(() => alertElement.remove(), 150);
                            }
                        }, 8000);
                    }
                }

                function showSuccessAlert(title, message) { showAlert('success', title, message); }
                function showErrorAlert(title, message) { showAlert('danger', title, message, false); }
                function showWarningAlert(title, message) { showAlert('warning', title, message); }
                function showInfoAlert(title, message) { showAlert('info', title, message); }

                // Función para mostrar resumen en alerta
                function showSummaryAlert(type, title, data) {
                    let message = `<ul class="mb-0 ps-3">`;
                    message += `<li>Ventas: ${data.totals.total_sales}</li>`;
                    message += `<li>Total: $${data.totals.total_amount.toFixed(2)}</li>`;
                    message += `<li>Efectivo: $${data.totals.cash_amount.toFixed(2)}</li>`;
                    message += `<li>Tarjeta: $${data.totals.card_amount.toFixed(2)}</li>`;
                    
                    const diffLabel = data.difference > 0 ? '(Sobra)' : data.difference < 0 ? '(Falta)' : '(Exacto)';
                    const diffClass = data.difference > 0 ? 'text-success' : data.difference < 0 ? 'text-danger' : '';
                    message += `<li>Diferencia: <span class="${diffClass}">$${data.difference.toFixed(2)} ${diffLabel}</span></li>`;
                    message += `</ul>`;
                    
                    showAlert(type, title, message, false);
                }

                // ==================== ELEMENTOS DEL DOM ====================
                const cashCountForm = document.getElementById('cash-count-form');
                const cashCutForm = document.getElementById('cash-cut-form');
                const closeCashCutBtn = document.getElementById('close-cash-cut-btn');
                const cashCountModalEl = document.getElementById('cash-count-modal');
                const cashCutModalEl = document.getElementById('cash-cut-modal');

                if (!cashCountForm || !cashCutForm || !cashCountModalEl || !cashCutModalEl) {
                    console.error('Elementos del DOM no encontrados');
                    return;
                }

                // Variable de sesión activa desde PHP
                const hasActiveSession = {{ $hasActiveSession ? 'true' : 'false' }};

                // ==================== MODAL DE ARQUEO ====================
                cashCountModalEl.addEventListener('show.bs.modal', function(event) {
                    if (!hasActiveSession) {
                        event.preventDefault();
                        showErrorAlert('Sin Sesión Activa', 'Debes tener una sesión de caja activa para realizar un arqueo. Por favor, inicia una sesión de caja primero.');
                    } else {
                        setTimeout(() => {
                            const input = document.getElementById('cash-count-secret-code');
                            if (input) input.focus();
                        }, 500);
                    }
                });

                // ==================== MODAL DE CORTE ====================
                cashCutModalEl.addEventListener('show.bs.modal', function(event) {
                    if (!hasActiveSession) {
                        event.preventDefault();
                        showErrorAlert('Sin Sesión Activa', 'Debes tener una sesión de caja activa para realizar un corte de caja. Por favor, inicia una sesión de caja primero.');
                    } else {
                        setTimeout(() => {
                            const input = document.getElementById('secret-code');
                            if (input) input.focus();
                        }, 500);
                    }
                });

                // Limpiar formularios al cerrar modales
                cashCountModalEl.addEventListener('hidden.bs.modal', function () {
                    cashCountForm.reset();
                });

                cashCutModalEl.addEventListener('hidden.bs.modal', function () {
                    cashCutForm.reset();
                });

                // ==================== ENVIAR FORMULARIO DE ARQUEO ====================
                cashCountForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    try {
                        // Validación del lado del cliente (opcional, pero buena práctica)
                        const secretCodeInput = document.getElementById('cash-count-secret-code');
                        if (secretCodeInput) {
                            // Normalizar a mayúsculas para evitar errores de usuario
                            secretCodeInput.value = secretCodeInput.value.trim().toUpperCase();
                        }

                        const formData = new FormData(this);
                        // FIX: Button is outside the form, use form attribute selector
                        const submitBtn = document.querySelector(`button[type="submit"][form="${this.id}"]`);
                        
                        if (!submitBtn) {
                            console.error('Botón de submit no encontrado para el formulario:', this.id);
                            // Fallback if button not found (should not happen if HTML is correct)
                            return; 
                        }
                        
                        const originalText = submitBtn.innerHTML;

                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Procesando...';

                        fetch('{{ route('cash_control.cash_count') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showSummaryAlert('success', '✓ ' + data.message, data);
                                
                                const modalInstance = bootstrap.Modal.getInstance(cashCountModalEl);
                                
                                // Si hay una sesión activa, preguntar si quiere cerrarla
                                if (data.ask_for_session_close) {
                                    if (confirm('¿Deseas cerrar la sesión de caja ahora?')) {
                                        fetch('{{ route('cash_sessions.close_active') }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                'Accept': 'application/json',
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(sessionData => {
                                            if (sessionData.success) {
                                                showSuccessAlert('¡Completado!', 'Sesión de caja cerrada exitosamente');
                                            } else {
                                                showWarningAlert('Atención', 'Arqueo realizado, pero no se pudo cerrar la sesión: ' + sessionData.message);
                                            }
                                            if (modalInstance) modalInstance.hide();
                                            cashCountForm.reset();
                                            setTimeout(() => location.reload(), 2000);
                                        })
                                        .catch(error => {
                                            console.error('Error cerrando sesión:', error);
                                            showErrorAlert('Error de Conexión', 'Arqueo realizado, pero no se pudo cerrar la sesión. Error: ' + error.message);
                                            if (modalInstance) modalInstance.hide();
                                            cashCountForm.reset();
                                            setTimeout(() => location.reload(), 3000);
                                        });
                                    } else {
                                        if (modalInstance) modalInstance.hide();
                                        cashCountForm.reset();
                                        setTimeout(() => location.reload(), 2000);
                                    }
                                } else {
                                    if (modalInstance) modalInstance.hide();
                                    cashCountForm.reset();
                                    setTimeout(() => location.reload(), 2000);
                                }
                            } else {
                                showErrorAlert('Error en Arqueo', data.message || 'No se pudo completar el arqueo');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showErrorAlert('Error de Conexión', 'No se pudo conectar con el servidor. Verifica tu conexión e intenta de nuevo.');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                    } catch (err) {
                        console.error('Error en submit arqueo:', err);
                        alert('Ocurrió un error inesperado al procesar el formulario: ' + err.message);
                    }
                });

                // ==================== CERRAR CORTE DE CAJA ====================
                if (closeCashCutBtn) {
                    closeCashCutBtn.addEventListener('click', function() {
                        if (confirm('¿Estás seguro de que quieres cerrar el corte de caja? Esta acción no se puede deshacer.')) {
                            const submitBtn = this;
                            const originalText = submitBtn.innerHTML;

                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Cerrando...';

                            const cashCutId = submitBtn.dataset.cashCutId || {{ $lastCashCut->id ?? 'null' }};

                            fetch(`{{ url('/cash-control/cash-cut') }}/${cashCutId}/close`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => {
                                        throw new Error(data.message || 'Error al cerrar el corte');
                                    });
                                }
                                showSuccessAlert('¡Éxito!', 'Corte de caja cerrado correctamente');
                                setTimeout(() => window.location.reload(), 1500);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showErrorAlert('Error al Cerrar Corte', error.message || 'No se pudo cerrar el corte de caja');
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            });
                        }
                    });
                }

                // ==================== ENVIAR FORMULARIO DE CORTE ====================
                cashCutForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    try {
                        const secretCodeInput = document.getElementById('secret-code');
                        if (!secretCodeInput) {
                            console.error('Input de código secreto no encontrado');
                            return;
                        }

                        // Normalizar input
                        const secretCode = secretCodeInput.value.trim().toUpperCase();
                        const userRole = '{{ auth()->user()->role }}';
                        let validCodes = ['EBCADMIN'];

                        if (userRole === 'admin' || userRole === 'supervisor') {
                            validCodes.push('EBCFCADMIN');
                        }

                        if (!validCodes.includes(secretCode)) {
                            showErrorAlert('Código Incorrecto', 'El código de autorización ingresado no es válido. Verifique que el código sea correcto.');
                            return;
                        }

                        // Actualizar valor en el input para que se envíe limpio
                        secretCodeInput.value = secretCode;

                        const formData = new FormData(this);
                        // FIX: Button is outside the form, use form attribute selector
                        const submitBtn = document.querySelector(`button[type="submit"][form="${this.id}"]`);

                        if (!submitBtn) {
                            console.error('Botón de submit no encontrado para el formulario:', this.id);
                             // Fallback if button not found
                            return;
                        }

                        const originalText = submitBtn.innerHTML;

                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Procesando...';

                        fetch('{{ route('cash_control.cash_cut') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showSummaryAlert('success', '✓ ' + data.message, data);

                                const modalInstance = bootstrap.Modal.getInstance(cashCutModalEl);
                                if (modalInstance) modalInstance.hide();
                                cashCutForm.reset();

                                if (data.redirect_to_login) {
                                    showInfoAlert('Redirigiendo...', 'Serás redirigido al inicio de sesión');
                                    setTimeout(() => window.location.href = '/login', 2500);
                                } else {
                                    setTimeout(() => location.reload(), 2000);
                                }
                            } else {
                                showErrorAlert('Error en Corte de Caja', data.message || 'No se pudo completar el corte de caja');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showErrorAlert('Error de Conexión', 'No se pudo conectar con el servidor. Verifica tu conexión e intenta de nuevo.');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                    } catch (err) {
                        console.error('Error en submit corte:', err);
                        alert('Ocurrió un error inesperado al procesar el formulario: ' + err.message);
                    }
                });
            } catch (globalErr) {
                console.error('Error global en script de control de caja:', globalErr);
            }
        });
    </script>
</x-app-layout>
