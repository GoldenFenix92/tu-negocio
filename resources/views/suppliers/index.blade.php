<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Proveedores</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Proveedor
                </a>
            </div>

            @include('components.alerts')

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($suppliers as $supplier)
                    <div class="col">
                        <div class="card h-100 {{ $supplier->is_active ? '' : 'opacity-50' }}">
                            <img src="{{ $supplier->imageUrl() }}" alt="{{ $supplier->name }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <h5 class="card-title fw-semibold text-body-emphasis mb-1">{{ $supplier->name }}</h5>
                                <p class="text-body-secondary small mb-1">{{ $supplier->contact_person ?? 'Sin contacto' }}</p>
                                <p class="text-body-secondary small mb-1">{{ $supplier->phone ?? 'Sin teléfono' }}</p>
                                <p class="text-body-tertiary extra-small mb-1">{{ $supplier->email ?? 'Sin email' }}</p>
                                <p class="text-body-secondary small mb-1">{{ $supplier->products()->count() }} productos</p>
                                <p class="text-body-tertiary extra-small mb-1">ID: {{ $supplier->id }}</p>
                                <p class="text-body-tertiary extra-small mb-1">{{ $supplier->created_at->format('d/m/Y') }}</p>
                                <div class="mt-2">
                                    <span class="badge {{ $supplier->is_active ? 'bg-success-subtle text-success-emphasis border border-success-subtle' : 'bg-danger-subtle text-danger-emphasis border border-danger-subtle' }}">
                                        {{ $supplier->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>

                                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil me-1"></i>Editar
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proveedor?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash me-1"></i>Eliminar
                                        </button>
                                    </form>
                                    <form action="{{ route('suppliers.toggle', $supplier) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $supplier->is_active ? 'btn-warning' : 'btn-primary' }} btn-sm">
                                            <i class="bi {{ $supplier->is_active ? 'bi-pause' : 'bi-play' }} me-1"></i>{{ $supplier->is_active ? 'Deshabilitar' : 'Habilitar' }}
                                        </button>
                                    </form>
                                    @if($supplier->image && $supplier->image !== 'suppliers/proveedor_comodin.webp')
                                        <form action="{{ route('suppliers.destroyImage', $supplier) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-image me-1"></i>Borrar Imagen
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
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
