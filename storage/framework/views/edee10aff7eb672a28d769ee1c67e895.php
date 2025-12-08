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
        <h2 class="fw-semibold fs-4 text-white m-0"><?php echo e(__('Editar Producto')); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Nombre')); ?></label>
                                <input name="name" value="<?php echo e(old('name', $product->name)); ?>" required class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Código de Barras (SKU)')); ?></label>
                                <div class="input-group">
                                    <input name="sku" value="<?php echo e(old('sku', $product->sku)); ?>" class="form-control" />
                                    <button type="button" onclick="generateSKU()" class="btn btn-secondary">
                                        <i class="bi bi-shuffle me-1"></i><?php echo e(__('Generar')); ?>

                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Categoría')); ?></label>
                                <select name="category_id" required class="form-select">
                                    <option value="">-- <?php echo e(__('Seleccionar')); ?> --</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>" <?php if(old('category_id', $product->category_id) == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Proveedor')); ?></label>
                                <select name="supplier_id" class="form-select">
                                    <option value="">-- <?php echo e(__('Seleccionar')); ?> --</option>
                                    <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($supplier->id); ?>" <?php if(old('supplier_id', $product->supplier_id) == $supplier->id): echo 'selected'; endif; ?>><?php echo e($supplier->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Presentación')); ?></label>
                                <select name="presentation" class="form-select">
                                    <option value="">-- <?php echo e(__('Seleccionar')); ?> --</option>
                                    <?php $__currentLoopData = $presentations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p); ?>" <?php if(old('presentation', $product->presentation) == $p): echo 'selected'; endif; ?>><?php echo e(ucfirst($p)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Precio de Compra')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="cost_price" type="number" step="0.01" value="<?php echo e(old('cost_price', $product->cost_price)); ?>" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Precio de Venta')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input name="sell_price" type="number" step="0.01" value="<?php echo e(old('sell_price', $product->sell_price)); ?>" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><?php echo e(__('Stock')); ?></label>
                                <input name="stock" type="number" value="<?php echo e(old('stock', $product->stock)); ?>" class="form-control" />
                            </div>

                            <div class="col-12">
                                <label class="form-label"><?php echo e(__('Imagen (opcional)')); ?></label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                <?php if($product->image): ?>
                                    <div class="mt-3 d-flex align-items-center gap-3">
                                        <img src="<?php echo e($product->imageUrl()); ?>" class="rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="">
                                        <?php if($product->image !== 'products/producto_comodin.webp'): ?>
                                            <form action="<?php echo e(route('products.destroyImage', $product)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash me-1"></i><?php echo e(__('Eliminar Imagen')); ?>

                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i><?php echo e(__('Cancelar')); ?>

                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-lg me-1"></i><?php echo e(__('Actualizar')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateSKU() {
            let sku = '';
            for (let i = 0; i < 8; i++) {
                sku += Math.floor(Math.random() * 10);
            }
            document.querySelector('input[name="sku"]').value = sku;
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/products/edit.blade.php ENDPATH**/ ?>