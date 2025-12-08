<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Alertas de Stock</h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid" style="max-width: 1400px;">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('stock_alerts.pdf_preview') }}" class="btn btn-danger">
                    <i class="bi bi-file-pdf me-1"></i>Ver PDF
                </a>
            </div>

            @include('components.alerts')

            @if($lowStockProducts->count() > 0)
                <div class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Se encontraron {{ $lowStockProducts->count() }} productos con stock bajo (menos de 10 unidades).
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($lowStockProducts as $product)
                        <div class="col">
                            <div class="card h-100 {{ $product->stock <= 0 ? 'border-danger border-2' : 'border-warning border-2' }}">
                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                                <div class="card-body d-flex flex-column align-items-center text-center">
                                    <h5 class="card-title fw-semibold text-body-emphasis mb-1">{{ $product->name }}</h5>
                                    <p class="text-body-secondary small mb-1">{{ $product->product_id }}</p>
                                    <p class="text-body-tertiary extra-small mb-1">{{ $product->category->name ?? 'Sin categoría' }}</p>
                                    <p class="fs-4 fw-bold mb-1 {{ $product->stock <= 0 ? 'text-danger' : 'text-warning' }}">
                                        {{ $product->stock }}
                                    </p>
                                    <p class="text-body-secondary small mb-2">${{ number_format($product->sell_price, 2) }}</p>
                                    <div>
                                        @if($product->stock <= 0)
                                            <span class="badge bg-danger">Agotado</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Stock Bajo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $lowStockProducts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-check-circle text-success display-1"></i>
                    <h5 class="mt-3 text-body-emphasis">¡Todo en orden!</h5>
                    <p class="text-muted">No hay productos con stock bajo en este momento.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
