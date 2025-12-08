<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Gestión de Ventas</h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1600px;">
            <!-- Action buttons -->
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <div class="d-flex flex-column flex-md-row gap-2">
                    <div class="input-group" style="max-width: 180px;">
                        <span class="input-group-text small">EBC-VNTA-</span>
                        <input type="text"
                               id="folio-search-input"
                               class="form-control"
                               placeholder="XXX"
                               maxlength="4"
                               value="{{ substr(request('folio'), -3) }}"
                               data-prefix="EBC-VNTA-">
                    </div>
                    <input type="text"
                           id="client-name-search-input"
                           class="form-control"
                           style="max-width: 200px;"
                           placeholder="Nombre del cliente..."
                           value="{{ request('client_name') }}">
                    <select id="status-filter" class="form-select" style="max-width: 180px;">
                        <option value="">Todos los estados</option>
                        <option value="completada" {{ request('status') === 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="pendiente" {{ request('status') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        <option value="transferida" {{ request('status') === 'transferida' ? 'selected' : '' }}>Transferida</option>
                        <option value="eliminada" {{ request('status') === 'eliminada' ? 'selected' : '' }}>Eliminada</option>
                    </select>
                    <select id="payment-filter" class="form-select" style="max-width: 200px;">
                        <option value="">Todos los métodos</option>
                        <option value="efectivo" {{ request('payment_method') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="mixto" {{ request('payment_method') === 'mixto' ? 'selected' : '' }}>Mixto</option>
                        <option value="tarjeta" {{ request('payment_method') === 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="transferencia" {{ request('payment_method') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                    </select>
                    <input type="date"
                           id="date-filter"
                           class="form-control"
                           style="max-width: 160px;"
                           value="{{ request('date') }}">
                    <button id="filter-btn" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Filtrar
                    </button>
                    <button id="clear-filters-btn" class="btn btn-secondary">
                        <i class="bi bi-x-lg me-1"></i>Limpiar
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('pos.index') }}" class="btn btn-primary">
                        <i class="bi bi-cart me-1"></i>Nueva Venta
                    </a>
                    <a href="{{ route('pos.export_all_pdf_preview', array_merge(request()->query())) }}" class="btn btn-success">
                        <i class="bi bi-file-pdf me-1"></i>Ver PDF
                    </a>
                </div>
            </div>

            @include('components.alerts')

            <!-- Sales cards container -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @forelse($sales as $sale)
                    <!-- Sale Card -->
                    <div class="col">
                        <div class="card h-100 {{ $sale->trashed() ? 'opacity-50' : '' }}">
                            <!-- Status indicator bar -->
                            <div class="@if($sale->estatus === 'completada') bg-success @elseif($sale->estatus === 'pendiente') bg-warning @elseif($sale->estatus === 'cancelada') bg-danger @elseif($sale->estatus === 'transferida') bg-primary @else bg-secondary @endif" style="height: 4px;"></div>

                            <div class="card-body">
                                <!-- Folio and Date -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title fw-bold mb-1">{{ $sale->folio }}</h5>
                                        <p class="text-secondary small mb-0">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <!-- Status badge -->
                                    <span class="badge @if($sale->estatus === 'completada') bg-success @elseif($sale->estatus === 'pendiente') bg-warning text-dark @elseif($sale->estatus === 'cancelada') bg-danger @elseif($sale->estatus === 'transferida') bg-primary @endif">
                                        {{ ucfirst($sale->estatus) }}
                                    </span>
                                </div>

                                <!-- Client and Cashier -->
                                <div class="mb-3">
                                    <p class="small mb-1">
                                        <span class="fw-medium">Cliente:</span> {{ $sale->client ? $sale->client->full_name : 'Cliente general' }}
                                    </p>
                                    <p class="small mb-0">
                                        <span class="fw-medium">Cajero:</span> {{ $sale->user->name }}
                                    </p>
                                </div>

                                <!-- Payment info -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">Total:</span>
                                        <span class="fs-5 fw-bold text-success">${{ number_format($sale->total_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <span class="small">Método:</span>
                                        <span class="badge @if($sale->payment_method === 'efectivo') bg-success @elseif($sale->payment_method === 'tarjeta') bg-primary @elseif($sale->payment_method === 'mixto') bg-info @elseif($sale->payment_method === 'transferencia') bg-purple @else bg-secondary @endif">
                                            {{ ucfirst($sale->payment_method) }}
                                        </span>
                                    </div>
                                    @if($sale->voucher_count > 0)
                                        <div class="mt-2 small text-purple">
                                            <span class="fw-medium">{{ $sale->voucher_count }} voucher(s)</span>
                                            @if($sale->voucher_folios && count($sale->voucher_folios) > 0)
                                                <br>{{ implode(', ', $sale->voucher_folios) }}
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Action buttons -->
                                <div class="d-flex flex-wrap gap-1 mt-3">
                                    <a href="{{ route('pos.show_sale', $sale) }}" class="btn btn-primary btn-sm flex-fill d-flex align-items-center justify-content-center">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if(!$sale->trashed())
                                        @if($sale->estatus !== 'cancelada')
                                            <form action="{{ route('pos.cancel_sale', $sale) }}" method="POST" class="flex-fill" onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta venta?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button onclick="confirmDeleteSale({{ $sale->id }}, '{{ $sale->folio }}')" class="btn btn-secondary btn-sm flex-fill d-flex align-items-center justify-content-center">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('pos.restore_sale', $sale) }}" method="POST" class="flex-fill" onsubmit="return confirm('¿Estás seguro de que quieres restaurar esta venta?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('pos.pdf_preview', $sale) }}" class="btn btn-success btn-sm flex-fill d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </div>

                                @if($sale->trashed())
                                    <div class="mt-2 pt-2 border-top">
                                        <p class="extra-small text-secondary mb-0">
                                            Eliminada por: {{ $sale->deleted_by_id ? \App\Models\User::find($sale->deleted_by_id)?->name ?? 'Usuario no encontrado' : 'Sistema' }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-file-earmark-x fs-1 text-secondary"></i>
                                <h5 class="mt-3 text-secondary">No se encontraron ventas</h5>
                                <p class="text-secondary">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $sales->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        const folioSearchInput = document.getElementById('folio-search-input');
        const clientNameSearchInput = document.getElementById('client-name-search-input');
        const statusFilter = document.getElementById('status-filter');
        const paymentFilter = document.getElementById('payment-filter');
        const dateFilter = document.getElementById('date-filter');
        const filterBtn = document.getElementById('filter-btn');
        const clearFiltersBtn = document.getElementById('clear-filters-btn');

        folioSearchInput.addEventListener('input', function() {
            let value = this.value.toUpperCase();
            value = value.replace(/[^0-9]/g, '');
            this.value = value.slice(0, 3);
        });

        function applyFilters() {
            const folioSuffix = folioSearchInput.value.trim();
            const folioPrefix = folioSearchInput.dataset.prefix;
            const fullFolio = folioSuffix ? folioPrefix + folioSuffix : '';
            const clientName = clientNameSearchInput.value.trim();
            const status = statusFilter.value;
            const payment = paymentFilter.value;
            const date = dateFilter.value;

            let url = '{{ route('pos.sales_history') }}';
            const params = new URLSearchParams();

            if (fullFolio) params.append('folio', fullFolio);
            if (clientName) params.append('client_name', clientName);
            if (status) params.append('status', status);
            if (payment) params.append('payment_method', payment);
            if (date) params.append('date', date);

            if (params.toString()) {
                url += '?' + params.toString();
            }

            window.location.href = url;
        }

        function clearFilters() {
            folioSearchInput.value = '';
            clientNameSearchInput.value = '';
            statusFilter.value = '';
            paymentFilter.value = '';
            dateFilter.value = '';
            window.location.href = '{{ route('pos.sales_history') }}';
        }

        filterBtn.addEventListener('click', applyFilters);
        clearFiltersBtn.addEventListener('click', clearFilters);

        folioSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        clientNameSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });

        function confirmDeleteSale(saleId, saleFolio) {
            const secretKey = prompt(`Para eliminar permanentemente la venta ${saleFolio}, ingresa la clave secreta:`);

            if (secretKey && secretKey.trim()) {
                if (secretKey === 'EBCADMIN') {
                    const deletionReason = prompt('Ingresa el motivo de la eliminación (opcional):');

                    if (confirm('¿Estás seguro de que quieres eliminar permanentemente esta venta?')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/sales/${saleId}`;

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';

                        const secretKeyField = document.createElement('input');
                        secretKeyField.type = 'hidden';
                        secretKeyField.name = 'secret_key';
                        secretKeyField.value = secretKey;

                        const reasonField = document.createElement('input');
                        reasonField.type = 'hidden';
                        reasonField.name = 'deletion_reason';
                        reasonField.value = deletionReason || 'Eliminada permanentemente por administrador';

                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        form.appendChild(secretKeyField);
                        form.appendChild(reasonField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                } else {
                    alert('Clave secreta incorrecta. No se puede eliminar la venta.');
                }
            }
        }
    </script>
</x-app-layout>
