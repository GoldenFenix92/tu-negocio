<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Editar Usuario</h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 900px;">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                                <input id="password" name="password" type="password" class="form-control" />
                                <div class="form-text">Dejar vacío para mantener la contraseña actual</div>
                                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" />
                                @error('password_confirmation') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="role" class="form-label">Rol</label>
                                <select id="role" name="role" class="form-select">
                                    <option value="">Seleccionar rol</option>
                                    @foreach($roles as $key => $label)
                                        <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text text-info"><i class="bi bi-lightbulb me-1"></i>Cambia el rol para ver los permisos que se asignarán</div>
                                @error('role') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="commission_percentage" class="form-label">Porcentaje de Comisión (%)</label>
                                <div class="input-group">
                                    <input id="commission_percentage" name="commission_percentage" type="number" step="0.01" min="0" max="100" class="form-control" value="{{ old('commission_percentage', $user->commission_percentage) }}" />
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text">Porcentaje de comisión que recibe el usuario por ventas</div>
                                @error('commission_percentage') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                        <div class="mt-4 pt-4 border-top">
                            <h5 class="mb-3"><i class="bi bi-shield-check me-1"></i>Control de Permisos</h5>
                            <div class="row g-3">
                                @php
                                    $groupedPermissions = [];
                                    foreach ($permissions as $permission) {
                                        $parts = explode('.', $permission);
                                        $group = $parts[0];
                                        if (!isset($groupedPermissions[$group])) {
                                            $groupedPermissions[$group] = [];
                                        }
                                        $groupedPermissions[$group][] = $permission;
                                    }
                                @endphp

                                @foreach ($groupedPermissions as $group => $perms)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card bg-body-secondary h-100">
                                            <div class="card-body p-3">
                                                <h6 class="mb-2">{{ ucfirst($group) }}</h6>
                                                @foreach ($perms as $permission)
                                                    <div class="form-check">
                                                        <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                                               class="form-check-input"
                                                               id="perm_{{ $permission }}"
                                                               {{ in_array($permission, old('permissions', $user->permissions ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label small" for="perm_{{ $permission }}">{{ explode('.', $permission)[1] }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        const defaultPermissions = {
            'admin': @json(\App\Models\User::getDefaultPermissionsForRole('admin')),
            'supervisor': @json(\App\Models\User::getDefaultPermissionsForRole('supervisor')),
            'empleado': @json(\App\Models\User::getDefaultPermissionsForRole('empleado')),
        };

        const permissionsCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
        const rolePermissions = defaultPermissions[role] || [];

        permissionsCheckboxes.forEach(checkbox => {
            checkbox.checked = rolePermissions.includes(checkbox.value);
        });
    });
</script>