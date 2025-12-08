<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            {{ __('Iniciar Sesión de Caja') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 640px;">
            <div class="card">
                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger mb-4" role="alert">
                            <strong>¡Error!</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            <strong>¡Éxito!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-info-circle fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-medium mb-2">Información importante</h6>
                                <p class="mb-0 small">Para iniciar tu sesión de caja, debes especificar el monto inicial en efectivo que tienes disponible. Este monto se registrará para el control y arqueo de caja.</p>
                            </div>
                        </div>
                    </div>

                    <form id="session-form" method="POST" action="{{ route('cash_sessions.start') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="initial_cash" :value="__('Monto inicial en efectivo')" />
                            <x-text-input id="initial_cash" class="mt-2" type="number" name="initial_cash" step="0.01" min="0.01" :value="old('initial_cash')" required />
                            <x-input-error :messages="$errors->get('initial_cash')" class="mt-2" />
                            <p class="text-muted small mt-2">Ingresa el monto exacto en efectivo que tienes al inicio de tu turno (mínimo $0.01)</p>
                        </div>

                        <!-- Hidden password field -->
                        <input type="hidden" name="password" id="password-field">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="button" id="start-session-btn" class="btn btn-primary">
                                {{ __('Iniciar Sesión de Caja') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Confirmation Modal -->
    <div id="password-modal" class="modal-backdrop-custom d-none">
        <div class="modal-dialog-custom" style="max-width: 400px;">
            <div class="modal-content-custom">
                <h5 class="fw-medium mb-4">Confirmar Contraseña</h5>
                <div class="mb-4">
                    <label class="form-label small fw-medium">
                        Ingresa tu contraseña para confirmar
                    </label>
                    <input type="password"
                           id="password-input"
                           class="form-control"
                           placeholder="Tu contraseña">
                    <p class="text-muted small mt-2">
                        Por seguridad, confirma tu identidad antes de iniciar la sesión de caja.
                    </p>
                </div>
                <div class="d-flex justify-content-end gap-3">
                    <button id="cancel-password" class="btn btn-secondary">
                        Cancelar
                    </button>
                    <button id="confirm-password" class="btn btn-primary">
                        Confirmar e Iniciar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const startSessionBtn = document.getElementById('start-session-btn');
        const passwordModal = document.getElementById('password-modal');
        const passwordInput = document.getElementById('password-input');
        const passwordField = document.getElementById('password-field');
        const sessionForm = document.getElementById('session-form');
        const initialCashInput = document.getElementById('initial_cash');
        const cancelPasswordBtn = document.getElementById('cancel-password');
        const confirmPasswordBtn = document.getElementById('confirm-password');

        startSessionBtn.addEventListener('click', function() {
            const initialCash = parseFloat(initialCashInput.value);

            if (!initialCash || initialCash < 0.01) {
                alert('Error: Debes ingresar un monto inicial válido (mínimo $0.01) para iniciar la sesión de caja.');
                initialCashInput.focus();
                return;
            }

            // Show password confirmation modal
            passwordModal.classList.remove('d-none');
            passwordInput.focus();
        });

        cancelPasswordBtn.addEventListener('click', function() {
            passwordModal.classList.add('d-none');
            passwordInput.value = '';
        });

        confirmPasswordBtn.addEventListener('click', function() {
            const password = passwordInput.value.trim();

            if (!password) {
                alert('Error: Debes ingresar tu contraseña para confirmar el inicio de sesión de caja.');
                passwordInput.focus();
                return;
            }

            // Set password in hidden field and submit form
            passwordField.value = password;
            sessionForm.submit();
        });

        // Allow Enter key to confirm password
        passwordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                confirmPasswordBtn.click();
            }
        });

        // Close modal when clicking outside
        passwordModal.addEventListener('click', function(e) {
            if (e.target === this) {
                cancelPasswordBtn.click();
            }
        });
    </script>
</x-app-layout>
