<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Editar Categoría') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">{{ __('Nombre de la Categoría') }}</label>
                            <input name="name" value="{{ old('name', $category->name) }}" required class="form-control" placeholder="Ej: Electrónicos, Ropa, Alimentos" />
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="form-check-input" id="isActive">
                                <label class="form-check-label" for="isActive">Activo</label>
                            </div>
                            @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Imagen (opcional)') }}</label>
                            <input type="file" name="image" accept="image/*" class="form-control" />
                            @if($category->image)
                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <img src="{{ $category->imageUrl() }}" class="rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="">
                                    @if($category->image !== 'categories/categoria_comodin.webp')
                                        <form action="{{ route('categories.destroyImage', $category) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');">
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

                        <div class="mb-3">
                            <div class="card bg-body-secondary">
                                <div class="card-body p-3">
                                    <h6 class="mb-2">Información adicional:</h6>
                                    <p class="small text-secondary mb-1">
                                        Productos asociados: {{ $category->products()->count() }}
                                    </p>
                                    <p class="small text-secondary mb-1">
                                        Creado: {{ $category->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    @if($category->updated_at != $category->created_at)
                                        <p class="small text-secondary mb-0">
                                            Actualizado: {{ $category->updated_at->format('d/m/Y H:i') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>{{ __('Actualizar Categoría') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
