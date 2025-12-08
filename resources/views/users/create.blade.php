<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Nuevo Usuario</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 800px;">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required />
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" name="password" type="password" class="form-control" required />
                                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required />
                                @error('password_confirmation') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">Rol</label>
                                <select id="role" name="role" class="form-select">
                                    <option value="">Seleccionar rol</option>
                                    @foreach($roles as $key => $label)
                                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="commission_percentage" class="form-label">Porcentaje de Comisión (%)</label>
                                <div class="input-group">
                                    <input id="commission_percentage" name="commission_percentage" type="number" step="0.01" min="0" max="100" class="form-control" value="{{ old('commission_percentage', 0) }}" />
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text">Porcentaje de comisión que recibe el usuario por ventas</div>
                                @error('commission_percentage') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus me-1"></i>Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
