<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Productos</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Producto
                </a>
            </div>

            @include('components.alerts')

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="card-img-top" style="height: 100px; object-fit: contain; background: rgba(255,255,255,0.05);">
                            <div class="card-body p-2 d-flex flex-column align-items-center text-center">
                                <h6 class="card-title fw-semibold text-body-emphasis mb-1 small">{{ Str::limit($product->name, 20) }}</h6>
                                <p class="text-body-secondary extra-small mb-0">{{ $product->product_id }}</p>
                                <p class="text-body-tertiary extra-small mb-0">{{ Str::limit($product->category->name ?? 'Sin categoría', 15) }}</p>
                                <p class="fw-semibold text-body-secondary extra-small mb-0">Stock: {{ $product->stock }}</p>
                                <p class="fw-bold text-body-emphasis small mb-0">${{ number_format($product->sell_price, 2) }}</p>

                                <div class="mt-2 d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-success btn-sm py-0 px-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-0 px-1" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @if($product->image && $product->image !== 'products/producto_comodin.webp')
                                        <form action="{{ route('products.destroyImage', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar imagen?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm py-0 px-1" title="Borrar Imagen">
                                                <i class="bi bi-image"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
