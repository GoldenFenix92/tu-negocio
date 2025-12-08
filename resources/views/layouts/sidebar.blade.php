<div class="offcanvas-header bg-gray-800 border-bottom border-secondary">
    <h5 class="offcanvas-title text-white" id="sidebarOffcanvasLabel">
        <i class="bi bi-shop me-2"></i>POS Admin
    </h5>
    <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
</div>

<div class="offcanvas-body bg-gray-800 p-0 d-flex flex-column">
    {{-- User Profile Section --}}
    <div class="p-3 border-bottom border-secondary">
        <a href="{{ route('profile.edit') }}" class="d-flex align-items-center p-2 rounded text-decoration-none text-white sidebar-link">
            <img src="{{ auth()->user()->imageUrl() }}"
                 alt="{{ auth()->user()->name }}"
                 class="rounded-circle object-fit-cover border border-secondary"
                 style="width: 48px; height: 48px;">
            <div class="ms-3 flex-fill overflow-hidden">
                <p class="small fw-medium text-white text-truncate mb-0">{{ auth()->user()->name }}</p>
                <p class="text-secondary text-truncate mb-0" style="font-size: 0.75rem;">{{ auth()->user()->email }}</p>
                <p class="text-secondary text-truncate mb-0" style="font-size: 0.75rem;">
                    @if(auth()->user()->role === 'admin')
                        Administrador
                    @elseif(auth()->user()->role === 'supervisor')
                        Supervisor
                    @else
                        Empleado
                    @endif
                </p>
            </div>
            <i class="bi bi-chevron-right text-secondary"></i>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="nav flex-column p-3 flex-fill">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="nav-link sidebar-link rounded d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>{{ __('Dashboard') }}</span>
        </a>

        {{-- Menú Operación --}}
        <div class="mt-3">
            <a href="#operacionMenu" class="nav-link sidebar-link rounded d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="operacionMenu">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-cart"></i>
                    <span>Operación</span>
                </span>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </a>
            <div class="collapse" id="operacionMenu">
                <nav class="nav flex-column ms-3 mt-1">
                    <a href="{{ route('pos.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('pos.index') ? 'active' : '' }}">
                        <i class="bi bi-cart"></i>
                        <span>Punto de Venta</span>
                    </a>
                    @can('sales_history.view')
                        <a href="{{ route('pos.sales_history') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('pos.sales_history') ? 'active' : '' }}">
                            <i class="bi bi-clipboard"></i>
                            <span>Historial de Ventas</span>
                        </a>
                    @endcan
                    @can('cash_control.access')
                        <a href="{{ route('cash_control.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('cash_control.*') ? 'active' : '' }}">
                            <i class="bi bi-cash-coin"></i>
                            <span>Control de Caja</span>
                        </a>
                        <a href="{{ route('cash_sessions.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('cash_sessions.index') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i>
                            <span>Sesiones de Caja</span>
                        </a>
                    @endcan
                    <a href="{{ route('appointments.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i>
                        <span>Calendario y Citas</span>
                    </a>
                </nav>
            </div>
        </div>
        
        {{-- Menú Inventario --}}
        <div class="mt-2">
            <a href="#inventarioMenu" class="nav-link sidebar-link rounded d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="inventarioMenu">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-box-seam"></i>
                    <span>Inventario</span>
                </span>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </a>
            <div class="collapse" id="inventarioMenu">
                <nav class="nav flex-column ms-3 mt-1">
                    <a href="{{ route('products.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Gestión de Productos</span>
                    </a>
                    <a href="{{ route('services.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('services.*') ? 'active' : '' }}">
                        <i class="bi bi-tools"></i>
                        <span>Gestión de Servicios</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Gestión de Categorías</span>
                    </a>
                    @can('stock_management.access')
                        <a href="{{ route('stock_movements.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('stock_movements.*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-left-right"></i>
                            <span>Movimientos</span>
                        </a>
                        <a href="{{ route('stock_alerts.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('stock_alerts.*') ? 'active' : '' }}">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span>Alertas de Stock</span>
                        </a>
                    @endcan
                </nav>
            </div>
        </div>
        
        {{-- Menú Administración --}}
        <div class="mt-2">
            <a href="#adminMenu" class="nav-link sidebar-link rounded d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="adminMenu">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-gear"></i>
                    <span>Administración</span>
                </span>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </a>
            <div class="collapse" id="adminMenu">
                <nav class="nav flex-column ms-3 mt-1">
                    <a href="{{ route('users.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Gestión de Usuarios</span>
                    </a>
                    <a href="{{ route('clients.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i>
                        <span>Gestión de Clientes</span>
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>
                        <span>Gestión de Proveedores</span>
                    </a>
                    @can('coupons.view')
                        <a href="{{ route('coupons.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Gestión de Cupones</span>
                        </a>
                    @endcan
                    @can('database.access')
                        <a href="{{ route('database.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('database.*') ? 'active' : '' }}">
                            <i class="bi bi-database"></i>
                            <span>Gestión de Base de Datos</span>
                        </a>
                    @endcan
                </nav>
            </div>
        </div>
    </nav>

    {{-- Logout button --}}
    <div class="p-3 border-top border-secondary mt-auto">
        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" id="logout-button" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('logout-button').addEventListener('click', async function(event) {
        event.preventDefault();

        try {
            const response = await fetch('{{ route('cash_sessions.check_active_session') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            });

            if (!response.ok) {
                console.error('Error checking cash session:', response.status, response.statusText);
                alert('Error al verificar la sesión de caja. No se puede cerrar sesión.');
                return;
            }

            const data = await response.json();

            if (data.has_active_session) {
                alert('No puedes cerrar sesión mientras tengas una sesión de caja activa. Por favor, cierra tu sesión de caja primero.');
            } else {
                document.getElementById('logout-form').submit();
            }
        } catch (error) {
            console.error('An error occurred during logout check:', error);
            alert('Ocurrió un error inesperado al intentar cerrar sesión.');
        }
    });
</script>
