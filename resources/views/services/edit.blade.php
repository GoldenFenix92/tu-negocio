<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Editar Servicio') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nombre del Servicio') }}</label>
                                <input name="name" value="{{ old('name', $service->name) }}" required class="form-control" />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Precio del Servicio') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="price" type="number" step="0.01" value="{{ old('price', $service->price) }}" required class="form-control" />
                                </div>
                                @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Descripción del Servicio') }}</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description', $service->description) }}</textarea>
                                @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Duración en Minutos') }}</label>
                                <input name="duration_minutes" type="number" value="{{ old('duration_minutes', $service->duration_minutes) }}" required class="form-control" />
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
                                                        <div class="d-flex align-items-center justify-content-between p-1 rounded" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }} ({{ $product->product_id }})">
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
                                                <div id="selectedProducts" style="height: 160px; overflow-y: auto;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="products" id="productsInput" value="{{ json_encode(old('products', $selectedProducts)) }}">
                                @error('products') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Imagen del Servicio (opcional)') }}</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror

                                @if($service->image_path && $service->image_path !== 'images/servicio_comodin.webp')
                                    <img src="{{ asset('storage/' . $service->image_path) }}" class="mt-2 rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="{{ $service->name }}">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="remove_image" value="1" class="form-check-input" id="removeImage">
                                        <label class="form-check-label text-danger" for="removeImage">{{ __('Eliminar imagen actual') }}</label>
                                    </div>
                                @else
                                    <img src="{{ asset('images/servicio_comodin.webp') }}" class="mt-2 rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="Placeholder">
                                @endif
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active)) class="form-check-input" id="isActive" />
                                    <label class="form-check-label" for="isActive">{{ __('Servicio Activo') }}</label>
                                </div>
                                @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-pencil me-1"></i>{{ __('Actualizar Servicio') }}
                                </button>
                            @endif
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
            let selectedProductIds = new Set(JSON.parse(productsInput.value || '[]').map(String));

            const allAvailableProducts = Array.from(availableProductsContainer.querySelectorAll('[data-product-id]')).map(div => ({
                id: div.dataset.productId,
                name: div.dataset.productName,
                element: div
            }));

            function updateProductsInput() {
                productsInput.value = JSON.stringify(Array.from(selectedProductIds));
            }

            function renderSelectedProducts() {
                selectedProductsContainer.innerHTML = '';
                selectedProductIds.forEach(productId => {
                    const productData = allAvailableProducts.find(p => p.id === productId);
                    if (productData) {
                        const selectedProductElement = document.createElement('div');
                        selectedProductElement.className = 'd-flex align-items-center justify-content-between p-1 rounded';
                        selectedProductElement.dataset.productId = productId;
                        selectedProductElement.innerHTML = `
                            <span class="small">${productData.name}</span>
                            <button type="button" class="remove-product-btn btn btn-danger btn-sm py-0 px-2">{{ __('Eliminar') }}</button>
                        `;
                        selectedProductsContainer.appendChild(selectedProductElement);
                    }
                });
                updateProductsInput();
            }

            function filterAvailableProducts() {
                const searchTerm = productSearch.value.toLowerCase();
                allAvailableProducts.forEach(product => {
                    const isSelected = selectedProductIds.has(product.id);
                    const matchesSearch = product.name.toLowerCase().includes(searchTerm);
                    product.element.style.display = (matchesSearch && !isSelected) ? 'flex' : 'none';
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
            renderSelectedProducts();
            filterAvailableProducts();
        });
    </script>
</x-app-layout>
