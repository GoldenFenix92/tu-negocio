<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            {{ __('Elise Beauty Center') }} {{-- AQUI SE CAMBIA EL NOMBRE DEL DASHBOARD --}}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-fluid" style="max-width: 1400px;">
            {{-- Logo centrado sobre la tarjeta de bienvenida --}}
            <div class="d-flex justify-content-center mb-4">
                <a href="{{ url('/') }}" class="d-inline-block">
                    <img src="{{ asset('images/brand-logo.png') }}" alt="{{ config('app.name') }}" class="img-fluid" style="height: 10rem; width: auto;">
                </a>
            </div>

            <div class="card bg-gray-700 shadow-sm rounded">
                <div class="card-body p-4 text-center">
                    <h3 class="fw-bold text-white mb-0">
                        {{ __("Bienvenido al Dashboard") }}, {{ auth()->user()->name ?? auth()->user()->email }}
                    </h3>
                </div>
            </div>

            {{-- Información de sesión de caja para empleados --}}
            @if(auth()->user()->role === 'empleado')
                @php
                    $activeSession = \App\Models\CashSession::getActiveSession(auth()->id());
                @endphp

                <div class="mt-4">
                    @if($activeSession)
                        <div class="alert alert-success border border-success rounded p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="h5 fw-medium text-success mb-2">
                                        <i class="bi bi-cash-stack"></i> Sesión de Caja Activa
                                    </h3>
                                    <p class="small text-success mb-1">Efectivo inicial: ${{ number_format($activeSession->initial_cash ?? 0, 2) }}</p>
                                    <p class="small text-success mb-0">Ventas totales: ${{ number_format($activeSession->total_sales ?? 0, 2) }}</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('cash_sessions.show', $activeSession) }}" class="btn btn-success btn-sm text-uppercase fw-semibold">
                                        Ver Sesión
                                    </a>
                                    <a href="{{ route('pos.index') }}" class="btn btn-primary btn-sm text-uppercase fw-semibold">
                                        Ir a POS
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger border border-danger rounded p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="h5 fw-medium text-danger mb-2">
                                        <i class="bi bi-exclamation-triangle"></i> Sin Sesión de Caja
                                    </h3>
                                    <p class="small text-danger mb-0">Debes iniciar una sesión de caja para poder realizar ventas.</p>
                                </div>
                                <a href="{{ route('cash_sessions.start_form') }}" class="btn btn-danger btn-sm text-uppercase fw-semibold">
                                    Iniciar Sesión de Caja
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Información de sesiones activas para administradores y supervisores --}}
            @if(in_array(auth()->user()->role, ['admin', 'supervisor']))
                @if($activeSessions->count() > 0)
                    <div class="mt-4">
                        <div class="alert alert-warning border border-warning rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h3 class="h5 fw-medium text-warning mb-2">
                                        <i class="bi bi-people"></i> Sesiones de Caja Activas ({{ $activeSessions->count() }})
                                    </h3>
                                    <p class="small text-warning mb-0">Hay empleados con sesiones de caja activas.</p>
                                </div>
                                <a href="{{ route('cash_sessions.index', ['status' => 'active']) }}" class="btn btn-warning btn-sm text-uppercase fw-semibold">
                                    Gestionar Sesiones
                                </a>
                            </div>
                            <div class="row g-3">
                                @foreach($activeSessions->take(3) as $session)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card bg-gray-800 border rounded p-3">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="flex-fill">
                                                    <div class="fw-medium small text-white mb-1">{{ $session->user->name }}</div>
                                                    <div class="extra-small text-gray-300 mb-1">{{ $session->start_time->diffForHumans() }}</div>
                                                    <div class="extra-small text-gray-300">Efectivo: ${{ number_format($session->current_cash_balance, 2) }}</div>
                                                    <div class="extra-small text-gray-300">Tarjeta: ${{ number_format($session->current_card_balance, 2) }}</div>
                                                    <div class="extra-small text-gray-300">Voucher: ${{ number_format($session->current_voucher_balance, 2) }}</div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="small fw-medium text-white">${{ number_format($session->sales->sum('total_amount'), 2) }}</div>
                                                    <div class="extra-small text-gray-300 mb-2">{{ $session->sales->count() }} ventas</div>
                                                    <form action="{{ route('cash_sessions.admin_force_close', $session) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('¿Estás seguro de que quieres cerrar la sesión de {{ $session->user->name }}?')">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm w-100 extra-small">
                                                            Cerrar Sesión
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($activeSessions->count() > 3)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card bg-gray-800 border border-dashed rounded p-3 d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                            <span class="small text-gray-300">+{{ $activeSessions->count() - 3 }} más...</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Access rápidos --}}
            <div class="mt-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="{{ route('pos.index') }}" class="card border border-primary bg-primary bg-opacity-10 text-decoration-none h-100 hover-lift">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center bg-primary text-white" style="width: 3rem; height: 3rem;">
                                            <i class="bi bi-cart fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="small fw-medium text-primary mb-1">Punto de Venta</h3>
                                        <p class="extra-small text-primary mb-0">Realizar ventas</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="{{ route('pos.sales_history') }}" class="card border border-success bg-success bg-opacity-10 text-decoration-none h-100 hover-lift">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center bg-success text-white" style="width: 3rem; height: 3rem;">
                                            <i class="bi bi-clipboard fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="small fw-medium text-success mb-1">Historial de Ventas</h3>
                                        <p class="extra-small text-success mb-0">Ver ventas realizadas</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="{{ route('cash_control.index') }}" class="card border border-warning bg-warning bg-opacity-10 text-decoration-none h-100 hover-lift">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center bg-warning text-white" style="width: 3rem; height: 3rem;">
                                            <i class="bi bi-currency-dollar fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="small fw-medium text-warning mb-1">Control de Caja</h3>
                                        <p class="extra-small text-warning mb-0">Arqueos y cortes</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    @if(in_array(auth()->user()->role, ['admin', 'supervisor']))
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="{{ route('stock_alerts.index') }}" class="card border border-danger bg-danger bg-opacity-10 text-decoration-none h-100 hover-lift">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center bg-danger text-white" style="width: 3rem; height: 3rem;">
                                            <i class="bi bi-exclamation-triangle fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="small fw-medium text-danger mb-1">Alertas de Stock</h3>
                                        <p class="extra-small text-danger mb-0">Productos bajos en stock</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif

                    @if(auth()->user()->role === 'admin')
                    <div class="col-12 col-md-6 col-lg-3">
                        <a href="{{ route('database.index') }}" class="card border border-info bg-info bg-opacity-10 text-decoration-none h-100 hover-lift">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded d-flex align-items-center justify-content-center bg-info text-white" style="width: 3rem; height: 3rem;">
                                            <i class="bi bi-archive fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h3 class="small fw-medium text-info mb-1">Base de Datos</h3>
                                        <p class="extra-small text-info mb-0">Backups y gestión</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
