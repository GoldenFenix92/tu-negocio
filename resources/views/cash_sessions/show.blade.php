<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-cash-coin me-2"></i>{{ __('Sesión de Caja') }} - {{ $cashSession->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>¡Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>¡Éxito!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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
                                    @if($cashSession->start_folio)
                                        <p class="small mb-1">Folio Inicial: {{ $cashSession->start_folio }}</p>
                                    @endif
                                    @if($cashSession->end_folio)
                                        <p class="small mb-1">Folio Final: {{ $cashSession->end_folio }}</p>
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
                                    <p class="fs-4 fw-bold mb-1">${{ number_format($totalSales, 2) }}</p>
                                    <p class="small mb-0">{{ $sales->count() }} ventas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="card text-white h-100" style="background-color: #7c3aed;">
                                <div class="card-body">
                                    <h6 class="mb-2"><i class="bi bi-ticket-perforated me-1"></i>Vouchers</h6>
                                    <p class="fs-4 fw-bold mb-1">{{ $voucherCount }}</p>
                                    @if($voucherFolios->count() > 0)
                                        <p class="small mb-0">{{ $voucherFolios->count() }} folios únicos</p>
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

                    <!-- Resumen de pagos -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-success bg-opacity-75 text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-cash-stack me-1"></i>Efectivo</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($totalCash, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary bg-opacity-75 text-white h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-credit-card me-1"></i>Tarjeta</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($totalCard, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white h-100" style="background-color: #ea580c;">
                                <div class="card-body text-center">
                                    <h6 class="mb-2"><i class="bi bi-arrow-repeat me-1"></i>Mixto</h6>
                                    <p class="fs-5 fw-bold mb-0">${{ number_format($totalMixed, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    @if($cashSession->status === 'active')
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @if($cashSession->user_id === auth()->id())
                                <form method="POST" action="{{ route('cash_sessions.close', $cashSession) }}" onsubmit="return confirm('¿Estás seguro de que quieres cerrar esta sesión de caja?')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-x-circle me-1"></i>{{ __('Cerrar Sesión de Caja') }}
                                    </button>
                                </form>
                            @endif

                            @if(auth()->user()->role === 'admin' && $cashSession->user_id !== auth()->id())
                                <form method="POST" action="{{ route('cash_sessions.admin_close', $cashSession) }}" onsubmit="return confirm('¿Estás seguro de que quieres forzar el cierre de esta sesión como administrador? Esta acción cerrará la sesión de {{ $cashSession->user->name }}.')">
                                    @csrf
                                    <button type="submit" class="btn text-white" style="background-color: #7c3aed;">
                                        <i class="bi bi-lock me-1"></i>Forzar Cierre (Admin)
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('cash_sessions.report', $cashSession) }}" class="btn btn-primary">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i>Ver Reporte
                            </a>
                        </div>

                        @if(auth()->user()->role === 'admin' && $cashSession->user_id !== auth()->id())
                            <div class="alert alert-warning mb-4">
                                <div class="d-flex">
                                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                                    <div>
                                        <h6 class="mb-1">Sesión de otro usuario</h6>
                                        <p class="mb-0 small">Esta es la sesión activa de <strong>{{ $cashSession->user->name }}</strong>. Como administrador, puedes forzar el cierre de esta sesión si es necesario.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="mb-4">
                            <a href="{{ route('cash_sessions.report', $cashSession) }}" class="btn btn-primary">
                                <i class="bi bi-file-earmark-bar-graph me-1"></i>Ver Reporte Detallado
                            </a>
                        </div>
                    @endif

                    <!-- Lista de ventas -->
                    <div class="mb-4">
                        <h5 class="mb-3"><i class="bi bi-cart me-2"></i>Ventas de la Sesión</h5>
                        @if($sales->count() > 0)
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
                                                <td>
                                                    <a href="{{ route('pos.show_sale', $sale) }}" class="btn btn-info btn-sm">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
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

                    <!-- Vouchers únicos -->
                    @if($voucherFolios->count() > 0)
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-ticket-perforated me-2"></i>Folios de Vouchers Utilizados</h5>
                            <div class="card" style="background-color: #7c3aed; border-color: #6d28d9;">
                                <div class="card-body text-white">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($voucherFolios as $folio)
                                            <span class="badge rounded-pill fs-6" style="background-color: rgba(255,255,255,0.2);">{{ $folio }}</span>
                                        @endforeach
                                    </div>
                                    <p class="small mt-3 mb-0">Total de vouchers únicos: {{ $voucherFolios->count() }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
