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
        <h2 class="fw-semibold fs-4 text-white m-0"><?php echo e(__('Agregar Nuevo Cliente')); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4"><?php echo e(__('Información del Cliente')); ?></h5>

                    <form method="POST" action="<?php echo e(route('clients.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label"><?php echo e(__('Nombre')); ?></label>
                                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus class="form-control" />
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4">
                                <label for="paternal_lastname" class="form-label"><?php echo e(__('Apellido Paterno')); ?></label>
                                <input id="paternal_lastname" type="text" name="paternal_lastname" value="<?php echo e(old('paternal_lastname')); ?>" required class="form-control" />
                                <?php $__errorArgs = ['paternal_lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-4">
                                <label for="maternal_lastname" class="form-label"><?php echo e(__('Apellido Materno')); ?></label>
                                <input id="maternal_lastname" type="text" name="maternal_lastname" value="<?php echo e(old('maternal_lastname')); ?>" required class="form-control" />
                                <?php $__errorArgs = ['maternal_lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label"><?php echo e(__('Teléfono')); ?></label>
                                <input id="phone" type="text" name="phone" value="<?php echo e(old('phone')); ?>" required class="form-control" />
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label"><?php echo e(__('Correo')); ?></label>
                                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required class="form-control" />
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="eight_digit_barcode" class="form-label"><?php echo e(__('Código de Barras')); ?></label>
                                <div class="input-group">
                                    <input id="eight_digit_barcode" type="text" name="eight_digit_barcode" value="<?php echo e(old('eight_digit_barcode')); ?>" required class="form-control" />
                                    <button type="button" class="btn btn-secondary" onclick="generateBarcode()">
                                        <i class="bi bi-shuffle me-1"></i><?php echo e(__('Generar')); ?>

                                    </button>
                                </div>
                                <?php $__errorArgs = ['eight_digit_barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label"><?php echo e(__('Imagen (opcional)')); ?></label>
                                <input type="file" name="image" id="image" accept="image/*" class="form-control" />
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i><?php echo e(__('Cancelar')); ?>

                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i><?php echo e(__('Guardar Cliente')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateBarcode() {
            let barcode = '';
            for (let i = 0; i < 8; i++) {
                barcode += Math.floor(Math.random() * 10);
            }
            document.getElementById('eight_digit_barcode').value = barcode;
        }
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/clients/create.blade.php ENDPATH**/ ?>