<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Editar Proveedor') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nombre del Proveedor') }} *</label>
                                <input name="name" value="{{ old('name', $supplier->name) }}" required class="form-control" placeholder="Ej: Coca-Cola Company" />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Persona de Contacto') }}</label>
                                <input name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" class="form-control" placeholder="Ej: Juan Pérez" />
                                @error('contact_person') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Teléfono') }}</label>
                                <input name="phone" value="{{ old('phone', $supplier->phone) }}" class="form-control" placeholder="Ej: +52 55 1234 5678" />
                                @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input name="email" type="email" value="{{ old('email', $supplier->email) }}" class="form-control" placeholder="Ej: contacto@cocacola.com" />
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Dirección') }}</label>
                                <textarea name="address" rows="2" class="form-control" placeholder="Ej: Calle Principal #123, Colonia Centro, Ciudad de México">{{ old('address', $supplier->address) }}</textarea>
                                @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('RFC / ID Fiscal') }}</label>
                                <input name="tax_id" value="{{ old('tax_id', $supplier->tax_id) }}" class="form-control" placeholder="Ej: COC123456ABC" />
                                @error('tax_id') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Notas') }}</label>
                                <textarea name="notes" rows="2" class="form-control" placeholder="Información adicional sobre el proveedor">{{ old('notes', $supplier->notes) }}</textarea>
                                @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $supplier->is_active) ? 'checked' : '' }} class="form-check-input" id="isActive">
                                    <label class="form-check-label" for="isActive">Activo</label>
                                </div>
                                @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Imagen (opcional)') }}</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @if($supplier->image)
                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <img src="{{ $supplier->imageUrl() }}" class="rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="">
                                        @if($supplier->image !== 'suppliers/proveedor_comodin.webp')
                                            <form action="{{ route('suppliers.destroyImage', $supplier) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');">
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

                        <div class="card bg-body-secondary mt-3">
                            <div class="card-body p-3">
                                <h6 class="mb-2">Información adicional:</h6>
                                <p class="small text-secondary mb-1">Productos asociados: {{ $supplier->products()->count() }}</p>
                                <p class="small text-secondary mb-1">Creado: {{ $supplier->created_at->format('d/m/Y H:i') }}</p>
                                @if($supplier->updated_at != $supplier->created_at)
                                    <p class="small text-secondary mb-0">Actualizado: {{ $supplier->updated_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>{{ __('Actualizar Proveedor') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
