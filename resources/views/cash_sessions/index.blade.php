<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            {{ __('Sesiones de Caja') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1400px;">
            <div class="card">
                <div class="card-body p-4">

                    <!-- Filtros -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route('cash_sessions.index') }}" class="row g-3">
                            @if(auth()->user()->role === 'admin' && isset($users))
                                <div class="col-12 col-md-6 col-lg">
                                    <label for="user_id" class="form-label">Usuario</label>
                                    <select id="user_id" name="user_id" class="form-select">
                                        <option value="">Todos los usuarios</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ ucfirst($user->role) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-12 col-md-6 col-lg">
                                <label for="status" class="form-label">Estado</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="">Todas</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Cerradas</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg">
                                <label for="date_from" class="form-label">Desde</label>
                                <input id="date_from" class="form-control" type="date" name="date_from" value="{{ request('date_from') }}">
                            </div>

                            <div class="col-12 col-md-6 col-lg">
                                <label for="date_to" class="form-label">Hasta</label>
                                <input id="date_to" class="form-control" type="date" name="date_to" value="{{ request('date_to') }}">
                            </div>

                            <div class="col-12 col-md-6 col-lg-auto d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>Filtrar
                                </button>
                            </div>
                        </form>
                    </div>

                    @php
                        $activeSession = \App\Models\CashSession::getActiveSession(auth()->id());
                    @endphp

                    @if($activeSession)
                        <div class="alert alert-success border-success mb-4">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div>
                                    <h5 class="alert-heading mb-2">
                                        <i class="bi bi-cash-stack me-1"></i>Tu Sesión de Caja Activa
                                    </h5>
                                    <p class="mb-1 small">Efectivo inicial: ${{ number_format((float) ($activeSession->initial_cash ?? 0), 2) }}</p>
                                    <p class="mb-0 small">Ventas totales: ${{ number_format((float) ($activeSession->total_sales ?? 0), 2) }}</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('cash_sessions.show', $activeSession) }}" class="btn btn-success btn-sm">
                                        Ver Sesión
                                    </a>
                                    <a href="{{ route('pos.index') }}" class="btn btn-primary btn-sm">
                                        Ir a POS
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger border-danger mb-4">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                <div>
                                    <h5 class="alert-heading mb-2">
                                        <i class="bi bi-exclamation-triangle me-1"></i>Sin Sesión de Caja Activa
                                    </h5>
                                    <p class="mb-0 small">Debes iniciar una sesión de caja para poder realizar ventas o gestionar tu caja.</p>
                                </div>
                                <a href="{{ route('cash_sessions.start_form') }}" class="btn btn-danger btn-sm">
                                    Iniciar Sesión de Caja
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Lista de sesiones -->
                    @if($sessions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Estado</th>
                                        <th>Efectivo Inicial</th>
                                        <th>Total Ventas</th>
                                        <th>Folio Inicial</th>
                                        <th>Folio Final</th>
                                        <th>Vouchers</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sessions as $session)
                                        <tr>
                                            <td class="fw-medium">{{ $session->id }}</td>
                                            <td>{{ $session->user->name }}</td>
                                            <td>{{ $session->start_time->format('d/m/Y H:i') }}</td>
                                            <td>{{ $session->end_time ? $session->end_time->format('d/m/Y H:i') : '-' }}</td>
                                            <td>
                                                <span class="badge {{ $session->estatus === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $session->estatus === 'active' ? 'Activa' : 'Cerrada' }}
                                                </span>
                                            </td>
                                            <td class="fw-medium">${{ number_format($session->initial_cash, 2) }}</td>
                                            <td class="fw-medium">${{ number_format($session->total_sales, 2) }}</td>
                                            <td>{{ $session->start_folio ?? '-' }}</td>
                                            <td>{{ $session->end_folio ?? '-' }}</td>
                                            <td>{{ $session->voucher_count }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="{{ route('cash_sessions.show', $session) }}" class="btn btn-outline-primary btn-sm">Gestionar</a>
                                                    @if($session->estatus === 'active')
                                                        @if($session->user_id === auth()->id() || auth()->user()->role === 'admin')
                                                            <form method="POST" action="{{ route('cash_sessions.close', $session) }}" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres cerrar esta sesión?')">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                    {{ $session->user_id === auth()->id() ? 'Cerrar' : 'Admin Cerrar' }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if(auth()->user()->role === 'admin' && $session->user_id !== auth()->id())
                                                            <form method="POST" action="{{ route('cash_sessions.admin_force_close', $session) }}" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres forzar el cierre de esta sesión como administrador?')">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-warning btn-sm">
                                                                    <i class="bi bi-lock"></i> Forzar
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('cash_sessions.report', $session) }}" class="btn btn-outline-info btn-sm">Reporte</a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="mt-4">
                            {{ $sessions->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted mb-4">No hay sesiones de caja</p>
                            <a href="{{ route('cash_sessions.start_form') }}" class="btn btn-success">
                                <i class="bi bi-plus-lg me-1"></i>Iniciar Primera Sesión
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
