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
        <h2 class="fw-semibold fs-4 text-white m-0"><?php echo e(__('Alta de Servicio')); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <?php if(session('info')): ?>
                        <div class="alert alert-warning mb-4">
                            <?php echo e(session('info')); ?>

                            <form action="<?php echo e(route('services.restore', session('service_id'))); ?>" method="POST" enctype="multipart/form-data" class="mt-2">
                                <?php echo csrf_field(); ?>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="file" name="image" accept="image/*" class="form-control form-control-sm" style="max-width: 250px;">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('services.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Nombre del Servicio')); ?></label>
                                <input name="name" value="<?php echo e(old('name')); ?>" required class="form-control" />
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Precio del Servicio')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="price" type="number" step="0.01" value="<?php echo e(old('price', 0)); ?>" required class="form-control" />
                                </div>
                                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Descripción del Servicio')); ?></label>
                                <textarea name="description" rows="3" class="form-control"><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Duración en Minutos')); ?></label>
                                <input name="duration_minutes" type="number" value="<?php echo e(old('duration_minutes', 30)); ?>" required class="form-control" />
                                <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Productos Asociados (opcional)')); ?></label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card bg-body-secondary">
                                            <div class="card-body p-2">
                                                <input type="text" id="productSearch" placeholder="<?php echo e(__('Buscar productos...')); ?>" class="form-control form-control-sm mb-2">
                                                <div id="availableProducts" style="height: 160px; overflow-y: auto;">
                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="d-flex align-items-center justify-content-between p-1 rounded hover-bg-gray-700" data-product-id="<?php echo e($product->id); ?>" data-product-name="<?php echo e($product->name); ?> (<?php echo e($product->product_id); ?>)">
                                                            <span class="small"><?php echo e($product->name); ?> (<?php echo e($product->product_id); ?>)</span>
                                                            <button type="button" class="add-product-btn btn btn-success btn-sm py-0 px-2"><?php echo e(__('Agregar')); ?></button>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-body-secondary">
                                            <div class="card-body p-2">
                                                <h6 class="mb-2"><?php echo e(__('Productos Seleccionados')); ?></h6>
                                                <div id="selectedProducts" style="height: 160px; overflow-y: auto;">
                                                    <!-- Selected products will be appended here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="products" id="productsInput">
                                <?php $__errorArgs = ['products'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Imagen del Servicio (opcional)')); ?></label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <img src="<?php echo e(asset('images/servicio_comodin.webp')); ?>" class="mt-2 rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="Placeholder">
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" checked class="form-check-input" id="isActive" />
                                    <label class="form-check-label" for="isActive"><?php echo e(__('Servicio Activo')); ?></label>
                                </div>
                                <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('services.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i><?php echo e(__('Cancelar')); ?>

                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i><?php echo e(__('Crear Servicio')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSearch = document.getElementById('productSearch');
            const availableProductsContainer = document.getElementById('availableProducts');
            const selectedProductsContainer = document.getElementById('selectedProducts');
            const productsInput = document.getElementById('productsInput');
            let selectedProductIds = new Set(JSON.parse(productsInput.value || '[]'));

            function updateProductsInput() {
                productsInput.value = JSON.stringify(Array.from(selectedProductIds));
            }

            function renderSelectedProducts() {
                selectedProductsContainer.innerHTML = '';
                selectedProductIds.forEach(productId => {
                    const productDiv = availableProductsContainer.querySelector(`[data-product-id="${productId}"]`);
                    if (productDiv) {
                        const productName = productDiv.dataset.productName;
                        const selectedProductElement = document.createElement('div');
                        selectedProductElement.className = 'd-flex align-items-center justify-content-between p-1 rounded hover-bg-gray-700';
                        selectedProductElement.dataset.productId = productId;
                        selectedProductElement.innerHTML = `
                            <span class="small">${productName}</span>
                            <button type="button" class="remove-product-btn btn btn-danger btn-sm py-0 px-2"><?php echo e(__('Eliminar')); ?></button>
                        `;
                        selectedProductsContainer.appendChild(selectedProductElement);
                    }
                });
                updateProductsInput();
            }

            function filterAvailableProducts() {
                const searchTerm = productSearch.value.toLowerCase();
                availableProductsContainer.querySelectorAll('[data-product-id]').forEach(productDiv => {
                    const productName = productDiv.dataset.productName.toLowerCase();
                    if (productName.includes(searchTerm) && !selectedProductIds.has(productDiv.dataset.productId)) {
                        productDiv.style.display = 'flex';
                    } else {
                        productDiv.style.display = 'none';
                    }
                });
            }

            availableProductsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('add-product-btn')) {
                    const productDiv = event.target.closest('[data-product-id]');
                    const productId = productDiv.dataset.productId;
                    if (!selectedProductIds.has(productId)) {
                        selectedProductIds.add(productId);
                        renderSelectedProducts();
                        filterAvailableProducts();
                    }
                }
            });

            selectedProductsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-product-btn')) {
                    const productDiv = event.target.closest('[data-product-id]');
                    const productId = productDiv.dataset.productId;
                    selectedProductIds.delete(productId);
                    renderSelectedProducts();
                    filterAvailableProducts();
                }
            });

            productSearch.addEventListener('input', filterAvailableProducts);

            // Initialize on load
            renderSelectedProducts();
            filterAvailableProducts();

            // Handle old input for products
            const oldProducts = <?php echo json_encode(old('products', []), 512) ?>;
            oldProducts.forEach(id => selectedProductIds.add(String(id)));
            renderSelectedProducts();
            filterAvailableProducts();
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/services/create.blade.php ENDPATH**/ ?>