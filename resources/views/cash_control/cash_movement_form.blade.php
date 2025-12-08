<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-cash-coin me-2"></i>{{ __('Movimiento de Efectivo') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container" style="max-width: 800px;">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title h5 mb-0">Realizar Retiro o Ingreso de Efectivo</h3>
                </div>
                <div class="card-body">
                    <form id="cashMovementForm" class="d-flex flex-column gap-3">
                        @csrf

                        <div>
                            <label for="type" class="form-label">{{ __('Tipo de Movimiento') }}</label>
                            <select id="type" name="type" class="form-select">
                                <option value="withdrawal">{{ __('Retiro de Efectivo') }}</option>
                                <option value="deposit">{{ __('Ingreso de Efectivo') }}</option>
                            </select>
                        </div>

                        <div>
                            <label for="amount" class="form-label">{{ __('Monto') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" id="amount" name="amount" class="form-control" required min="0.01" placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label for="reason" class="form-label">{{ __('Motivo') }}</label>
                            <textarea id="reason" name="reason" rows="3" class="form-control" required placeholder="{{ __('Describe el motivo del movimiento...') }}"></textarea>
                        </div>

                        <div id="secretCodeField">
                            <label for="secret_code" class="form-label">{{ __('Clave Secreta') }}</label>
                            <input type="password" id="secret_code" name="secret_code" class="form-control" placeholder="{{ __('Ingresa tu clave de autorización') }}">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('cash_control.index') }}" class="btn btn-secondary">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>{{ __('Registrar Movimiento') }}
                            </button>
                        </div>
                    </form>

                    <div id="responseMessage" class="alert mt-3 d-none" role="alert"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const secretCodeField = document.getElementById('secretCodeField');
            const cashMovementForm = document.getElementById('cashMovementForm');
            const responseMessage = document.getElementById('responseMessage');

            function toggleSecretCodeField() {
                if (typeSelect.value === 'withdrawal') {
                    secretCodeField.style.display = 'block';
                    document.getElementById('secret_code').setAttribute('required', 'required');
                } else {
                    secretCodeField.style.display = 'none';
                    document.getElementById('secret_code').removeAttribute('required');
                    document.getElementById('secret_code').value = ''; // Clear value
                }
            }

            typeSelect.addEventListener('change', toggleSecretCodeField);
            toggleSecretCodeField(); // Set initial state

            cashMovementForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const type = formData.get('type');
                let url = '';

                if (type === 'withdrawal') {
                    url = '{{ route('cash_control.process_withdrawal') }}';
                } else {
                    url = '{{ route('cash_control.process_deposit') }}';
                }

                // Disable button to prevent double submit
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    responseMessage.classList.remove('d-none', 'alert-success', 'alert-danger');
                    
                    if (data.success) {
                        responseMessage.classList.add('alert-success');
                        responseMessage.textContent = data.message;
                        cashMovementForm.reset();
                        toggleSecretCodeField();
                        
                        // Redirect after short delay
                        setTimeout(() => {
                            window.location.href = '{{ route('cash_control.index') }}';
                        }, 1500);
                    } else {
                        responseMessage.classList.add('alert-danger');
                        responseMessage.textContent = data.message;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    responseMessage.classList.remove('d-none', 'alert-success');
                    responseMessage.classList.add('alert-danger');
                    responseMessage.textContent = 'Ocurrió un error al procesar la solicitud.';
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });
        });
    </script>
</x-app-layout>
