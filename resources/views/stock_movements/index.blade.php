<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Movimientos de Stock</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('stock_movements.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Nuevo Movimiento
                </a>
            </div>

            @include('components.alerts')

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($movements as $movement)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <img src="{{ $movement->imageUrl() }}" alt="{{ $movement->product->name }}" class="rounded mb-3" style="width: 160px; height: 160px; object-fit: cover;">
                                <div class="fw-semibold">{{ $movement->product->name }}</div>
                                <div class="small text-secondary mt-1">{{ $movement->product->product_id }}</div>
                                <div class="mt-2">
                                    @if($movement->type === 'in')
                                        <span class="badge bg-success">Entrada</span>
                                    @elseif($movement->type === 'out')
                                        <span class="badge bg-danger">Salida</span>
                                    @else
                                        <span class="badge bg-primary">Ajuste</span>
                                    @endif
                                </div>
                                <div class="fs-4 fw-bold mt-1">
                                    @if($movement->type === 'in')
                                        <span class="text-success">+{{ $movement->quantity }}</span>
                                    @elseif($movement->type === 'out')
                                        <span class="text-danger">-{{ $movement->quantity }}</span>
                                    @else
                                        <span class="text-primary">{{ $movement->quantity }}</span>
                                    @endif
                                </div>
                                <div class="extra-small text-secondary mt-1">{{ $movement->reason ?? 'Sin razón' }}</div>
                                <div class="extra-small text-secondary mt-1">{{ $movement->user->name ?? 'Usuario Eliminado' }}</div>
                                <div class="extra-small text-secondary mt-1">{{ $movement->created_at->format('d/m/Y H:i') }}</div>
                                <div class="extra-small text-secondary mt-1">ID: {{ $movement->id }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $movements->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
