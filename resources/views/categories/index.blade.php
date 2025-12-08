<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Categorías</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Categoría
                </a>
            </div>

            @include('components.alerts')

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                @foreach($categories as $category)
                    <div class="col">
                        <div class="card h-100 {{ $category->is_active ? '' : 'opacity-50' }}">
                            <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" class="card-img-top" style="height: 100px; object-fit: contain; background: rgba(255,255,255,0.05);">
                            <div class="card-body p-2 d-flex flex-column align-items-center text-center">
                                <h6 class="card-title fw-semibold text-body-emphasis mb-1 small">{{ Str::limit($category->name, 18) }}</h6>
                                <p class="text-body-secondary extra-small mb-0">{{ $category->products()->count() }} productos</p>
                                <div class="mt-1 mb-1">
                                    <span class="badge {{ $category->is_active ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }}" style="font-size: 0.65rem;">
                                        {{ $category->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>

                                <div class="mt-1 d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-success btn-sm py-0 px-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Eliminar categoría?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-0 px-1" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('categories.toggle', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $category->is_active ? 'btn-warning' : 'btn-primary' }} btn-sm py-0 px-1" title="{{ $category->is_active ? 'Deshabilitar' : 'Habilitar' }}">
                                            <i class="bi {{ $category->is_active ? 'bi-pause' : 'bi-play' }}"></i>
                                        </button>
                                    </form>
                                    @if($category->image && $category->image !== 'categories/categoria_comodin.webp')
                                        <form action="{{ route('categories.destroyImage', $category) }}" method="POST" onsubmit="return confirm('¿Eliminar imagen?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-warning btn-sm py-0 px-1" title="Borrar Imagen">
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
