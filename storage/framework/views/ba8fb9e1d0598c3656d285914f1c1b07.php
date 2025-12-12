<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="fw-semibold fs-4 text-white m-0">
            <?php echo e(__('Iniciar Sesión de Caja')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container" style="max-width: 640px;">
            <div class="card">
                <div class="card-body p-4">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger mb-4" role="alert">
                            <strong>¡Error!</strong> <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success mb-4" role="alert">
                            <strong>¡Éxito!</strong> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

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

                    <form id="session-form" method="POST" action="<?php echo e(route('cash_sessions.start')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'initial_cash','value' => __('Monto inicial en efectivo')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'initial_cash','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('Monto inicial en efectivo'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'initial_cash','class' => 'mt-2','type' => 'number','name' => 'initial_cash','step' => '0.01','min' => '0.01','value' => old('initial_cash'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'initial_cash','class' => 'mt-2','type' => 'number','name' => 'initial_cash','step' => '0.01','min' => '0.01','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('initial_cash')),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('initial_cash'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('initial_cash')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            <p class="text-muted small mt-2">Ingresa el monto exacto en efectivo que tienes al inicio de tu turno (mínimo $0.01)</p>
                        </div>

                        <!-- Hidden password field -->
                        <input type="hidden" name="password" id="password-field">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="button" id="start-session-btn" class="btn btn-primary">
                                <?php echo e(__('Iniciar Sesión de Caja')); ?>

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/cash_sessions/start.blade.php ENDPATH**/ ?>