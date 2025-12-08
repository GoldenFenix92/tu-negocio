<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Gestión de Cupones') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-white mb-0">Listado de Cupones</h5>
                <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Crear Nuevo Cupón
                </a>
            </div>

            @include('components.alerts')

            <div class="mb-4">
                <form action="{{ route('coupons.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" placeholder="Buscar cupones..."
                           class="form-control" style="max-width: 300px;"
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Buscar
                    </button>
                </form>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Gestión de Descuento para Clientes Frecuentes</h6>
                    <form action="{{ route('coupons.update_client_discount') }}" method="POST" class="d-flex align-items-center gap-3">
                        @csrf
                        <div class="input-group" style="max-width: 200px;">
                            <input type="number" name="discount_percentage" id="client_discount" step="0.01" min="0" max="100"
                                   class="form-control"
                                   value="{{ old('discount_percentage', $clientDiscountCoupon->discount_percentage ?? '') }}" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-lg me-1"></i>Actualizar Descuento
                        </button>
                    </form>
                    @error('discount_percentage', 'clientDiscount')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($coupons as $coupon)
                    <div class="col">
                        <div class="card h-100 {{ !$coupon->is_active ? 'opacity-50' : '' }} {{ $coupon->deleted_at ? 'border-danger' : '' }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $coupon->name }}</h5>
                                <p class="card-text">Descuento: <span class="text-success fw-bold">{{ $coupon->discount_percentage }}%</span></p>
                                <p class="card-text small">Estado:
                                    <span class="{{ $coupon->is_active ? 'text-success' : 'text-danger' }}">
                                        {{ $coupon->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </p>
                                @if($coupon->deleted_at)
                                    <p class="text-danger small mt-2">Inhabilitado (Eliminado lógicamente)</p>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-end gap-2">
                                    @if (!$coupon->deleted_at)
                                        <a href="{{ route('coupons.edit', $coupon) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres inhabilitar este cupón?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle me-1"></i>Inhabilitar
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('coupons.restore', $coupon->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres restaurar este cupón?');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Restaurar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">No se encontraron cupones.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
