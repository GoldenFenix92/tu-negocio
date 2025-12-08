<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Alta de Servicio') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    @if(session('info'))
                        <div class="alert alert-warning mb-4">
                            {{ session('info') }}
                            <form action="{{ route('services.restore', session('service_id')) }}" method="POST" enctype="multipart/form-data" class="mt-2">
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

                    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nombre del Servicio') }}</label>
                                <input name="name" value="{{ old('name') }}" required class="form-control" />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Precio del Servicio') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="price" type="number" step="0.01" value="{{ old('price', 0) }}" required class="form-control" />
                                </div>
                                @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Descripción del Servicio') }}</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Duración en Minutos') }}</label>
                                <input name="duration_minutes" type="number" value="{{ old('duration_minutes', 30) }}" required class="form-control" />
                                @error('duration_minutes') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Productos Asociados (opcional)') }}</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card bg-body-secondary">
                                            <div class="card-body p-2">
                                                <input type="text" id="productSearch" placeholder="{{ __('Buscar productos...') }}" class="form-control form-control-sm mb-2">
                                                <div id="availableProducts" style="height: 160px; overflow-y: auto;">
                                                    @foreach($products as $product)
                                                        <div class="d-flex align-items-center justify-content-between p-1 rounded hover-bg-gray-700" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }} ({{ $product->product_id }})">
                                                            <span class="small">{{ $product->name }} ({{ $product->product_id }})</span>
                                                            <button type="button" class="add-product-btn btn btn-success btn-sm py-0 px-2">{{ __('Agregar') }}</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-body-secondary">
                                            <div class="card-body p-2">
                                                <h6 class="mb-2">{{ __('Productos Seleccionados') }}</h6>
                                                <div id="selectedProducts" style="height: 160px; overflow-y: auto;">
                                                    <!-- Selected products will be appended here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="products" id="productsInput">
                                @error('products') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Imagen del Servicio (opcional)') }}</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                                <img src="{{ asset('images/servicio_comodin.webp') }}" class="mt-2 rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="Placeholder">
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" checked class="form-check-input" id="isActive" />
                                    <label class="form-check-label" for="isActive">{{ __('Servicio Activo') }}</label>
                                </div>
                                @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ __('Crear Servicio') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSearch = document.getElementById('productSearch');
            const availableProductsContainer = document.getElementById('availableProducts');
            const selectedProductsContainer = document.getElementById('selectedProducts');
            const productsInput = document.getElementById('productsInput');
            let selectedProductIds = new Set(JSON.parse(productsInput.value || '[]'));

            function updateProductsInput() {
                productsInput.value = JSON.stringify(Array.from(selectedProductIds));
            }

            function renderSelectedProducts() {
                selectedProductsContainer.innerHTML = '';
                selectedProductIds.forEach(productId => {
                    const productDiv = availableProductsContainer.querySelector(`[data-product-id="${productId}"]`);
                    if (productDiv) {
                        const productName = productDiv.dataset.productName;
                        const selectedProductElement = document.createElement('div');
                        selectedProductElement.className = 'd-flex align-items-center justify-content-between p-1 rounded hover-bg-gray-700';
                        selectedProductElement.dataset.productId = productId;
                        selectedProductElement.innerHTML = `
                            <span class="small">${productName}</span>
                            <button type="button" class="remove-product-btn btn btn-danger btn-sm py-0 px-2">{{ __('Eliminar') }}</button>
                        `;
                        selectedProductsContainer.appendChild(selectedProductElement);
                    }
                });
                updateProductsInput();
            }

            function filterAvailableProducts() {
                const searchTerm = productSearch.value.toLowerCase();
                availableProductsContainer.querySelectorAll('[data-product-id]').forEach(productDiv => {
                    const productName = productDiv.dataset.productName.toLowerCase();
                    if (productName.includes(searchTerm) && !selectedProductIds.has(productDiv.dataset.productId)) {
                        productDiv.style.display = 'flex';
                    } else {
                        productDiv.style.display = 'none';
                    }
                });
            }

            availableProductsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('add-product-btn')) {
                    const productDiv = event.target.closest('[data-product-id]');
                    const productId = productDiv.dataset.productId;
                    if (!selectedProductIds.has(productId)) {
                        selectedProductIds.add(productId);
                        renderSelectedProducts();
                        filterAvailableProducts();
                    }
                }
            });

            selectedProductsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-product-btn')) {
                    const productDiv = event.target.closest('[data-product-id]');
                    const productId = productDiv.dataset.productId;
                    selectedProductIds.delete(productId);
                    renderSelectedProducts();
                    filterAvailableProducts();
                }
            });

            productSearch.addEventListener('input', filterAvailableProducts);

            // Initialize on load
            renderSelectedProducts();
            filterAvailableProducts();

            // Handle old input for products
            const oldProducts = @json(old('products', []));
            oldProducts.forEach(id => selectedProductIds.add(String(id)));
            renderSelectedProducts();
            filterAvailableProducts();
        });
    </script>
</x-app-layout>
