<style>
    /* Nuclear Option: High Specificity Overrides */
    html body .offcanvas-lg .sidebar-link, 
    html body .offcanvas-lg .sidebar-link-sub, 
    html body .offcanvas-lg .nav-link {
        transition: all 0.2s ease-in-out;
    }

    /* Main Sidebar Links */
    html body .offcanvas-lg .sidebar-link:hover, 
    html body .offcanvas-lg .sidebar-link[aria-expanded="true"] {
        background-color: var(--color-primary) !important;
        color: #fff !important;
        opacity: 1 !important;
    }
    
    html body .offcanvas-lg .sidebar-link.active {
        background-color: var(--color-primary) !important;
        color: #fff !important;
        opacity: 1 !important;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(var(--color-primary-rgb), 0.3);
    }

    /* Sub-menu Links */
    html body .offcanvas-lg .sidebar-link-sub:hover {
        color: var(--color-primary) !important;
        background-color: rgba(var(--color-primary-rgb), 0.1) !important;
        padding-left: 1rem !important;
    }
    
    html body .offcanvas-lg .sidebar-link-sub.active {
        color: var(--color-primary) !important;
        background-color: rgba(var(--color-primary-rgb), 0.15) !important;
        font-weight: 700 !important;
        border-right: 3px solid var(--color-primary);
    }

    /* Sidebar Container Override */
    html body .sidebar-offcanvas {
        background-color: var(--color-secondary) !important;
        border-right-color: var(--text-primary) !important;
    }
</style>
<div class="offcanvas-header border-bottom" style="background-color: var(--color-secondary); border-color: var(--text-primary) !important;">
    <h5 class="offcanvas-title" id="sidebarOffcanvasLabel" style="color: var(--text-primary);">
        <img src="{{ $appSettings['logo'] ?? asset('images/brand-logo.png') }}" alt="{{ $appSettings['app_name'] ?? 'POS Admin' }}" style="max-height: 40px;">
        <span class="ms-2">{{ $appSettings['app_name'] ?? 'POS Admin' }}</span>
    </h5>
    <button type="button" class="btn-close d-lg-none" style="filter: invert(1) grayscale(100%) brightness(200%);" data-bs-dismiss="offcanvas" data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
</div>

<div class="offcanvas-body p-0 d-flex flex-column" style="background-color: var(--color-secondary);">
    {{-- User Profile Section --}}
    <div class="p-3 border-bottom" style="border-color: var(--text-primary) !important; opacity: 0.8;">
        <a href="{{ route('profile.edit') }}" class="d-flex align-items-center p-2 rounded text-decoration-none sidebar-link" style="color: var(--text-primary);">
            <img src="{{ auth()->user()->imageUrl() }}"
                 alt="{{ auth()->user()->name }}"
                 class="rounded-circle object-fit-cover border"
                 style="width: 48px; height: 48px; border-color: var(--text-primary) !important;">
            <div class="ms-3 flex-fill overflow-hidden">
                <p class="small fw-medium text-truncate mb-0" style="color: var(--text-primary);">{{ auth()->user()->name }}</p>
                <p class="text-truncate mb-0" style="font-size: 0.75rem; color: var(--text-primary); opacity: 0.7;">{{ auth()->user()->email }}</p>
                <p class="text-truncate mb-0" style="font-size: 0.75rem; color: var(--text-primary); opacity: 0.7;">
                    @if(auth()->user()->role === 'admin')
                        Administrador
                    @elseif(auth()->user()->role === 'supervisor')
                        Supervisor
                    @else
                        Empleado
                    @endif
                </p>
            </div>
            <i class="bi bi-chevron-right" style="color: var(--text-primary); opacity: 0.7;"></i>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="nav flex-column p-3 flex-fill">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="nav-link sidebar-link rounded d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: var(--text-primary);">
            <i class="bi bi-speedometer2"></i>
            <span>{{'Dashboard'}}</span>
        </a>

        {{-- Menú Operación --}}
        <div class="mt-3">
            <a href="#operacionMenu" class="nav-link sidebar-link rounded d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="operacionMenu" style="color: var(--text-primary);">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-cart"></i>
                    <span>Operación</span>
                </span>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </a>
            <div class="collapse" id="operacionMenu">
                <nav class="nav flex-column ms-3 mt-1">
                    <a href="{{ route('pos.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('pos.index') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-cart"></i>
                        <span>Punto de Venta</span>
                    </a>
                    @can('sales_history.view')
                        <a href="{{ route('pos.sales_history') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('pos.sales_history') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-clipboard"></i>
                            <span>Historial de Ventas</span>
                        </a>
                    @endcan
                    @can('cash_control.access')
                        <a href="{{ route('cash_control.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('cash_control.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-cash-coin"></i>
                            <span>Control de Caja</span>
                        </a>
                        <a href="{{ route('cash_sessions.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('cash_sessions.index') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-cash-stack"></i>
                            <span>Sesiones de Caja</span>
                        </a>
                    @endcan
                    <a href="{{ route('appointments.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('appointments.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-calendar-event"></i>
                        <span>Calendario y Citas</span>
                    </a>
                </nav>
            </div>
        </div>
        
        {{-- Menú Inventario --}}
        <div class="mt-2">
            <a href="#inventarioMenu" class="nav-link sidebar-link rounded d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="inventarioMenu" style="color: var(--text-primary);">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-box-seam"></i>
                    <span>Inventario</span>
                </span>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </a>
            <div class="collapse" id="inventarioMenu">
                <nav class="nav flex-column ms-3 mt-1">
                    <a href="{{ route('products.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('products.index') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-box-seam"></i>
                        <span>Gestión de Productos</span>
                    </a>
                    <a href="{{ route('services.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('services.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-tools"></i>
                        <span>Gestión de Servicios</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('categories.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-tags"></i>
                        <span>Gestión de Categorías</span>
                    </a>
                    @can('stock_management.access')
                        <a href="{{ route('stock_movements.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('stock_movements.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-arrow-left-right"></i>
                            <span>Movimientos</span>
                        </a>
                        <a href="{{ route('stock_alerts.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('stock_alerts.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span>Alertas de Stock</span>
                        </a>
                    @endcan
                </nav>
            </div>
        </div>
        
        {{-- Menú Administración --}}
        <div class="mt-2">
            <a href="#adminMenu" class="nav-link sidebar-link rounded d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="adminMenu" style="color: var(--text-primary);">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-gear"></i>
                    <span>Administración</span>
                </span>
                <i class="bi bi-chevron-down collapse-icon"></i>
            </a>
            <div class="collapse" id="adminMenu">
                <nav class="nav flex-column ms-3 mt-1">
                    <a href="{{ route('users.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('users.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-people"></i>
                        <span>Gestión de Usuarios</span>
                    </a>
                    <a href="{{ route('clients.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('clients.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-person"></i>
                        <span>Gestión de Clientes</span>
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                        <i class="bi bi-shop"></i>
                        <span>Gestión de Proveedores</span>
                    </a>
                    @can('coupons.view')
                        <a href="{{ route('coupons.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('coupons.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-ticket-perforated"></i>
                            <span>Gestión de Cupones</span>
                        </a>
                    @endcan
                    @can('database.access')
                        <a href="{{ route('database.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('database.*') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-database"></i>
                            <span>Gestión de Base de Datos</span>
                        </a>
                    @endcan
                    @can('user_management.view')
                        <a href="{{ route('settings.index') }}" class="nav-link sidebar-link-sub rounded small d-flex align-items-center gap-2 {{ request()->routeIs('settings.index') ? 'active' : '' }}" style="color: var(--text-primary); opacity: 0.9;">
                            <i class="bi bi-gear-wide-connected"></i>
                            <span>Configuración</span>
                        </a>
                    @endcan
                </nav>
            </div>
        </div>
    </nav>

    {{-- Logout button --}}
    <div class="p-3 border-top mt-auto" style="border-color: var(--text-primary) !important; opacity: 0.8;">
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
