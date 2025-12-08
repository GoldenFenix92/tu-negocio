<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Nuevo Proveedor') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Nombre del Proveedor') }} *</label>
                                <input name="name" value="{{ old('name') }}" required class="form-control" placeholder="Ej: Coca-Cola Company" />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Persona de Contacto') }}</label>
                                <input name="contact_person" value="{{ old('contact_person') }}" class="form-control" placeholder="Ej: Juan Pérez" />
                                @error('contact_person') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Teléfono') }}</label>
                                <input name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Ej: +52 55 1234 5678" />
                                @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('Email') }}</label>
                                <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="Ej: contacto@cocacola.com" />
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Dirección') }}</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Ej: Calle Principal #123, Colonia Centro, Ciudad de México">{{ old('address') }}</textarea>
                                @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('RFC / ID Fiscal') }}</label>
                                <input name="tax_id" value="{{ old('tax_id') }}" class="form-control" placeholder="Ej: COC123456ABC" />
                                @error('tax_id') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Notas') }}</label>
                                <textarea name="notes" rows="3" class="form-control" placeholder="Información adicional sobre el proveedor">{{ old('notes') }}</textarea>
                                @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" checked class="form-check-input" id="isActive">
                                    <label class="form-check-label" for="isActive">Activo</label>
                                </div>
                                @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ __('Imagen (opcional)') }}</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>{{ __('Crear Proveedor') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
