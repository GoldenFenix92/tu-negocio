<section>
    <header>
        <h5 class="fw-medium">Actualizar Contraseña</h5>
        <p class="small text-secondary">Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerse segura.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Contraseña Actual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            @error('current_password', 'updatePassword') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Nueva Contraseña</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
            @error('password', 'updatePassword') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>Guardar
            </button>

            @if (session('status') === 'password-updated')
                <p class="small text-success mb-0">Guardado.</p>
            @endif
        </div>
    </form>
</section>
