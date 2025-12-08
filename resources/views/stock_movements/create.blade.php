<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Nuevo Movimiento de Stock</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 800px;">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('stock_movements.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Producto</label>
                            <select id="product_id" name="product_id" class="form-select">
                                <option value="">Seleccionar producto</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stock: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo de Movimiento</label>
                            <select id="type" name="type" class="form-select">
                                <option value="">Seleccionar tipo</option>
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input id="quantity" name="quantity" type="number" class="form-control" value="{{ old('quantity') }}" required />
                            @error('quantity') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Razón (opcional)</label>
                            <input id="reason" name="reason" type="text" class="form-control" value="{{ old('reason') }}" />
                            @error('reason') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('stock_movements.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>Registrar Movimiento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
