<section>
    <header>
        <h5 class="fw-medium text-danger">Eliminar Cuenta</h5>
        <p class="small text-secondary">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.</p>
    </header>

    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        <i class="bi bi-trash me-1"></i>Eliminar Cuenta
    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">¿Estás seguro de que deseas eliminar tu cuenta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-secondary">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor ingresa tu contraseña para confirmar que deseas eliminar tu cuenta permanentemente.</p>

                        <div class="mt-3">
                            <label for="delete_password" class="form-label">Contraseña</label>
                            <input id="delete_password" name="password" type="password" class="form-control" placeholder="Contraseña" />
                            @error('password', 'userDeletion') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Eliminar Cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
