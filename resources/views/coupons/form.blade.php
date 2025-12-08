<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ isset($coupon) ? __('Editar Cupón') : __('Crear Nuevo Cupón') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 500px;">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($coupon) ? route('coupons.update', $coupon) : route('coupons.store') }}" method="POST">
                        @csrf
                        @if(isset($coupon))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Cupón</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $coupon->name ?? '') }}" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discount_percentage" class="form-label">Porcentaje de Descuento</label>
                            <div class="input-group">
                                <input type="number" name="discount_percentage" id="discount_percentage" step="0.01" min="0" max="100"
                                       class="form-control"
                                       value="{{ old('discount_percentage', $coupon->discount_percentage ?? '') }}" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('discount_percentage') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input"
                                       @if(isset($coupon) && $coupon->is_active) checked @endif>
                                <label class="form-check-label" for="is_active">Activo</label>
                            </div>
                            @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ isset($coupon) ? __('Actualizar Cupón') : __('Guardar Cupón') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
