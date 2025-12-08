<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                <i class="bi bi-bar-chart me-2"></i> Reportes de Control de Caja
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('cash_control.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
                <a href="{{ route('cash_control.reports_pdf_preview', request()->query()) }}" class="btn btn-danger">
                    <i class="bi bi-file-pdf me-1"></i> Ver PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">

            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Filtros</h5>

                    <form method="GET" action="{{ route('cash_control.reports') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Usuario</label>
                            <select name="user_id" class="form-select">
                                <option value="">Todos los usuarios</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Método de Pago</label>
                            <select name="payment_method" class="form-select">
                                <option value="">Todos los métodos</option>
                                <option value="efectivo" {{ request('payment_method') === 'efectivo' ? 'selected' : '' }}>Solo Efectivo</option>
                                <option value="mixto" {{ request('payment_method') === 'mixto' ? 'selected' : '' }}>Mixto (Efectivo + Tarjeta)</option>
                                <option value="tarjeta" {{ request('payment_method') === 'tarjeta' ? 'selected' : '' }}>Solo Tarjeta</option>
                                <option value="transferencia" {{ request('payment_method') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i> Filtrar
                            </button>
                            <a href="{{ route('cash_control.reports') }}" class="btn btn-secondary">
                                <i class="bi bi-trash me-1"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen de Totales -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-primary">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cart-check fs-3 text-primary"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Total Ventas</p>
                                <h4 class="mb-0 fw-bold">{{ number_format($totals['total_sales']) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-success">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <i class="bi bi-cash-coin fs-3 text-success"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Efectivo</p>
                                <h4 class="mb-0 fw-bold">${{ number_format($totals['cash_amount'], 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-info">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                <i class="bi bi-credit-card fs-3 text-info"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Tarjeta</p>
                                <h4 class="mb-0 fw-bold">${{ number_format($totals['card_amount'], 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100 border-start border-4 border-warning">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                <i class="bi bi-wallet2 fs-3 text-warning"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">Total General</p>
                                <h4 class="mb-0 fw-bold">${{ number_format($totals['total_amount'], 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ventas -->
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title mb-0">Ventas</h5>
                </div>
                <div class="card-body">
                    @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Cliente</th>
                                        <th>Usuario</th>
                                        <th>Método</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td class="fw-bold">{{ $sale->folio }}</td>
                                            <td>{{ $sale->client ? $sale->client->full_name : 'Cliente general' }}</td>
                                            <td>{{ $sale->user->name ?? 'Usuario eliminado' }}</td>
                                            <td>
                                                @if($sale->payment_method === 'efectivo')
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success">Efectivo</span>
                                                @elseif($sale->payment_method === 'tarjeta')
                                                    <span class="badge bg-info bg-opacity-10 text-info border border-info">Tarjeta</span>
                                                @elseif($sale->payment_method === 'transferencia')
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Transferencia</span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">{{ ucfirst($sale->payment_method) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">${{ number_format($sale->total_amount, 2) }}</td>
                                            <td class="text-muted small">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-3">
                            {{ $sales->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No hay ventas que coincidan con los filtros seleccionados
                        </div>
                    @endif
                </div>
            </div>

            <!-- Arqueos de Caja -->
            @if($cashCounts->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h5 class="card-title mb-0">Arqueos de Caja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Usuario</th>
                                        <th>Ventas</th>
                                        <th>Esperado</th>
                                        <th>Real</th>
                                        <th>Diferencia</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cashCounts as $cashCount)
                                        <tr>
                                            <td class="fw-bold">{{ $cashCount->folio }}</td>
                                            <td>{{ $cashCount->user->name ?? 'Usuario eliminado' }}</td>
                                            <td>{{ $cashCount->total_sales }}</td>
                                            <td>${{ number_format($cashCount->expected_cash, 2) }}</td>
                                            <td>${{ number_format($cashCount->actual_cash, 2) }}</td>
                                            <td>
                                                @if($cashCount->difference > 0)
                                                    <span class="text-success fw-bold">+${{ number_format($cashCount->difference, 2) }} (Sobra)</span>
                                                @elseif($cashCount->difference < 0)
                                                    <span class="text-danger fw-bold">-${{ number_format(abs($cashCount->difference), 2) }} (Falta)</span>
                                                @else
                                                    <span class="text-muted">Exacto</span>
                                                @endif
                                            </td>
                                            <td class="text-muted small">{{ $cashCount->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Cortes de Caja -->
            @if($cashCuts->count() > 0)
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3">
                        <h5 class="card-title mb-0">Cortes de Caja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Folio</th>
                                        <th>Usuario</th>
                                        <th>Ventas</th>
                                        <th>Esperado</th>
                                        <th>Real</th>
                                        <th>Diferencia</th>
                                        <th>Estado</th>
                                        <th>Cerrado por</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cashCuts as $cashCut)
                                        <tr>
                                            <td class="fw-bold">{{ $cashCut->folio }}</td>
                                            <td>{{ $cashCut->user->name ?? 'Usuario eliminado' }}</td>
                                            <td>{{ $cashCut->total_sales }}</td>
                                            <td>${{ number_format($cashCut->expected_cash, 2) }}</td>
                                            <td>${{ number_format($cashCut->actual_cash, 2) }}</td>
                                            <td>
                                                @if($cashCut->difference > 0)
                                                    <span class="text-success fw-bold">+${{ number_format($cashCut->difference, 2) }} (Sobra)</span>
                                                @elseif($cashCut->difference < 0)
                                                    <span class="text-danger fw-bold">-${{ number_format(abs($cashCut->difference), 2) }} (Falta)</span>
                                                @else
                                                    <span class="text-muted">Exacto</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($cashCut->status === 'open')
                                                    <span class="badge bg-success">Abierto</span>
                                                @elseif($cashCut->status === 'closed')
                                                    <span class="badge bg-danger">Cerrado</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ $cashCut->status_text }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $cashCut->closedBy->name ?? '-' }}</td>
                                            <td class="text-muted small">{{ $cashCut->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
