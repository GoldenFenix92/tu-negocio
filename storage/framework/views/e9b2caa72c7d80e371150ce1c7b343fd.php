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
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Vista Previa de Documento
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="container-fluid py-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-end gap-2 mb-3">
                    <a href="<?php echo e($pdfUrl); ?>" class="btn btn-primary" download>
                        <i class="bi bi-download"></i> Descargar PDF
                    </a>
                    <button onclick="printPdf()" class="btn btn-secondary">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="ratio ratio-1x1" style="height: 80vh;">
                    <iframe src="<?php echo e($pdfUrl); ?>" title="Vista previa del PDF" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printPdf() {
            const iframe = document.querySelector('iframe');
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.print();
            } else {
                alert('No se pudo cargar el contenido del PDF para imprimir.');
            }
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/components/pdf-viewer.blade.php ENDPATH**/ ?>