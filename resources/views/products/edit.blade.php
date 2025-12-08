<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Editar Producto') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nombre') }}</label>
                                <input name="name" value="{{ old('name', $product->name) }}" required class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Código de Barras (SKU)') }}</label>
                                <div class="input-group">
                                    <input name="sku" value="{{ old('sku', $product->sku) }}" class="form-control" />
                                    <button type="button" onclick="generateSKU()" class="btn btn-secondary">
                                        <i class="bi bi-shuffle me-1"></i>{{ __('Generar') }}
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Categoría') }}</label>
                                <select name="category_id" required class="form-select">
                                    <option value="">-- {{ __('Seleccionar') }} --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Proveedor') }}</label>
                                <select name="supplier_id" class="form-select">
                                    <option value="">-- {{ __('Seleccionar') }} --</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Presentación') }}</label>
                                <select name="presentation" class="form-select">
                                    <option value="">-- {{ __('Seleccionar') }} --</option>
                                    @foreach($presentations as $p)
                                        <option value="{{ $p }}" @selected(old('presentation', $product->presentation) == $p)>{{ ucfirst($p) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Precio de Compra') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="cost_price" type="number" step="0.01" value="{{ old('cost_price', $product->cost_price) }}" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Precio de Venta') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="sell_price" type="number" step="0.01" value="{{ old('sell_price', $product->sell_price) }}" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Stock') }}</label>
                                <input name="stock" type="number" value="{{ old('stock', $product->stock) }}" class="form-control" />
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Imagen (opcional)') }}</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @if($product->image)
                                    <div class="mt-3 d-flex align-items-center gap-3">
                                        <img src="{{ $product->imageUrl() }}" class="rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="">
                                        @if($product->image !== 'products/producto_comodin.webp')
                                            <form action="{{ route('products.destroyImage', $product) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash me-1"></i>{{ __('Eliminar Imagen') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-lg me-1"></i>{{ __('Actualizar') }}
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
