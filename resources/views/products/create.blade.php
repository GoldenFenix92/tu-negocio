<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Alta de Producto') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    @if(session('info'))
                        <div class="alert alert-warning mb-4">
                            {{ session('info') }}
                            <form action="{{ route('products.restore', session('product_id')) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <div class="d-flex align-items-center gap-3">
                                    <input type="file" name="image" accept="image/*" class="form-control form-control-sm" style="max-width: 250px;">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nombre') }}</label>
                                <input name="name" value="{{ old('name') }}" required class="form-control" />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Código de Barras (SKU)') }}</label>
                                <div class="input-group">
                                    <input name="sku" value="{{ old('sku') }}" class="form-control" placeholder="Escanea o escribe el código" />
                                    <button type="button" onclick="generateSKU()" class="btn btn-secondary">
                                        <i class="bi bi-shuffle me-1"></i>{{ __('Generar') }}
                                    </button>
                                </div>
                                @error('sku') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Categoría') }}</label>
                                <select name="category_id" required class="form-select">
                                    <option value="">-- {{ __('Seleccionar') }} --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Proveedor') }}</label>
                                <select name="supplier_id" class="form-select">
                                    <option value="">-- {{ __('Seleccionar') }} --</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Presentación') }}</label>
                                <select name="presentation" class="form-select">
                                    <option value="">-- {{ __('Seleccionar') }} --</option>
                                    @foreach($presentations as $p)
                                        <option value="{{ $p }}" @selected(old('presentation') == $p)>{{ ucfirst($p) }}</option>
                                    @endforeach
                                </select>
                                @error('presentation') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Precio de Compra') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="cost_price" type="number" step="0.01" value="{{ old('cost_price', 0) }}" class="form-control" />
                                </div>
                                @error('cost_price') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Precio de Venta') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="sell_price" type="number" step="0.01" value="{{ old('sell_price', 0) }}" class="form-control" />
                                </div>
                                @error('sell_price') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Stock Inicial') }}</label>
                                <input name="stock" type="number" value="{{ old('stock', 0) }}" class="form-control" />
                                @error('stock') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Imagen (opcional)') }}</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ __('Crear') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateSKU() {
            let sku = '';
            for (let i = 0; i < 8; i++) {
                sku += Math.floor(Math.random() * 10);
            }
            document.querySelector('input[name="sku"]').value = sku;
        }
    </script>
</x-app-layout>
