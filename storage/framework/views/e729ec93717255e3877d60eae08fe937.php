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
        <h2 class="fw-semibold fs-4 text-white m-0">Categorías</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Categoría
                </a>
            </div>

            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <div class="card h-100 <?php echo e($category->is_active ? '' : 'opacity-50'); ?>">
                            <img src="<?php echo e($category->imageUrl()); ?>" alt="<?php echo e($category->name); ?>" class="card-img-top" style="height: 100px; object-fit: contain; background: rgba(255,255,255,0.05);">
                            <div class="card-body p-2 d-flex flex-column align-items-center text-center">
                                <h6 class="card-title fw-semibold text-body-emphasis mb-1 small"><?php echo e(Str::limit($category->name, 18)); ?></h6>
                                <p class="text-body-secondary extra-small mb-0"><?php echo e($category->products()->count()); ?> productos</p>
                                <div class="mt-1 mb-1">
                                    <span class="badge <?php echo e($category->is_active ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis'); ?>" style="font-size: 0.65rem;">
                                        <?php echo e($category->is_active ? 'Activo' : 'Inactivo'); ?>

                                    </span>
                                </div>

                                <div class="mt-1 d-flex flex-wrap gap-1 justify-content-center">
                                    <a href="<?php echo e(route('categories.edit', $category)); ?>" class="btn btn-success btn-sm py-0 px-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" onsubmit="return confirm('¿Eliminar categoría?');" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm py-0 px-1" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('categories.toggle', $category)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn <?php echo e($category->is_active ? 'btn-warning' : 'btn-primary'); ?> btn-sm py-0 px-1" title="<?php echo e($category->is_active ? 'Deshabilitar' : 'Habilitar'); ?>">
                                            <i class="bi <?php echo e($category->is_active ? 'bi-pause' : 'bi-play'); ?>"></i>
                                        </button>
                                    </form>
                                    <?php if($category->image && $category->image !== 'categories/categoria_comodin.webp'): ?>
                                        <form action="<?php echo e(route('categories.destroyImage', $category)); ?>" method="POST" onsubmit="return confirm('¿Eliminar imagen?');" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-warning btn-sm py-0 px-1" title="Borrar Imagen">
                                                <i class="bi bi-image"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4">
                <?php echo e($categories->links()); ?>

            </div>
        </div>
    </div>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/categories/index.blade.php ENDPATH**/ ?>