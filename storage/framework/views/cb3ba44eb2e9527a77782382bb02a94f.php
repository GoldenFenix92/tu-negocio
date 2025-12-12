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
        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-semibold fs-4 text-white m-0">
                <i class="bi bi-clipboard-check"></i> Manual de Supervisor
            </h2>
            <a href="<?php echo e(route('manual.index')); ?>" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="card position-sticky" style="top: 1rem;">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">Contenido</h5>
                            <nav class="nav flex-column">
                                <a class="nav-link" href="#intro">Introducción</a>
                                <a class="nav-link" href="#inventario">Gestión de Inventario</a>
                                <a class="nav-link" href="#servicios">Gestión de Servicios</a>
                                <a class="nav-link" href="#clientes">Gestión de Clientes</a>
                                <a class="nav-link" href="#proveedores">Gestión de Proveedores</a>
                                <a class="nav-link" href="#reportes">Reportes</a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <!-- Introducción -->
                    <div class="card mb-4" id="intro">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-info-circle text-success"></i> Introducción</h3>
                            <p>Como supervisor, tienes acceso a funciones avanzadas de gestión de inventario, clientes, proveedores y reportes. Además de todas las funciones de usuario.</p>
                            <div class="alert alert-info">
                                <strong><i class="bi bi-book"></i> Nota:</strong> Consulta también el <a href="<?php echo e(route('manual.show', 'usuario')); ?>">Manual de Usuario</a> para las funciones básicas.
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Inventario -->
                    <div class="card mb-4" id="inventario">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-box-seam text-success"></i> Gestión de Inventario</h3>
                            
                            <h5 class="fw-semibold mt-4">Productos y Categorías</h5>
                            <p><strong>Crear Producto:</strong></p>
                            <ol>
                                <li>Ve a <strong>Inventario → Gestión de Productos</strong></li>
                                <li>Haz clic en "Nuevo Producto"</li>
                                <li>Completa la información (nombre, SKU, precio, categoría, stock)</li>
                                <li>Agrega una imagen (opcional)</li>
                                <li>Guarda el producto</li>
                            </ol>

                            <p><strong>Gestionar Categorías:</strong></p>
                            <ol>
                                <li>Ve a <strong>Inventario → Gestión de Categorías</strong></li>
                                <li>Crea, edita o elimina categorías</li>
                                <li>Activa/desactiva categorías según necesidad</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Movimientos de Stock</h5>
                            <p>Registra entradas y salidas de inventario:</p>
                            <ol>
                                <li>Ve a <strong>Inventario → Movimientos</strong></li>
                                <li>Selecciona el tipo (entrada o salida)</li>
                                <li>Elige el producto y cantidad</li>
                                <li>Agrega un motivo/nota</li>
                                <li>Confirma el movimiento</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Alertas de Stock</h5>
                            <p>Monitorea productos con stock bajo:</p>
                            <ul>
                                <li>Ve a <strong>Inventario → Alertas de Stock</strong></li>
                                <li>Consulta productos que requieren reabastecimiento</li>
                                <li>Exporta el reporte en PDF</li>
                                <li>Realiza pedidos a proveedores según necesidad</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Gestión de Servicios -->
                    <div class="card mb-4" id="servicios">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-tools text-success"></i> Gestión de Servicios</h3>
                            <p>Administra los servicios ofrecidos:</p>
                            <ol>
                                <li>Ve a <strong>Inventario → Gestión de Servicios</strong></li>
                                <li>Crea nuevos servicios con nombre, precio y duración</li>
                                <li>Edita servicios existentes</li>
                                <li>Activa/desactiva servicios temporalmente</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Gestión de Clientes -->
                    <div class="card mb-4" id="clientes">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-person text-success"></i> Gestión de Clientes</h3>
                            <p><strong>Crear/Editar Clientes:</strong></p>
                            <ol>
                                <li>Ve a <strong>Administración → Gestión de Clientes</strong></li>
                                <li>Registra información completa del cliente</li>
                                <li>Asigna descuentos especiales si aplica</li>
                                <li>Agrega foto del cliente (opcional)</li>
                            </ol>

                            <div class="alert alert-info">
                                <strong><i class="bi bi-lightbulb"></i> Consejo:</strong> Mantén actualizada la información de contacto para notificaciones de citas y promociones.
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Proveedores -->
                    <div class="card mb-4" id="proveedores">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-shop text-success"></i> Gestión de Proveedores</h3>
                            <p>Administra la información de proveedores:</p>
                            <ol>
                                <li>Ve a <strong>Administración → Gestión de Proveedores</strong></li>
                                <li>Registra nuevos proveedores con datos de contacto</li>
                                <li>Mantén actualizada la información</li>
                                <li>Consulta el historial de pedidos</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Reportes -->
                    <div class="card mb-4" id="reportes">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-file-earmark-text text-success"></i> Reportes</h3>
                            
                            <h5 class="fw-semibold mt-4">Reportes de Ventas</h5>
                            <p>Accede a reportes detallados:</p>
                            <ul>
                                <li><strong>Historial de Ventas:</strong> Consulta todas las ventas del sistema</li>
                                <li><strong>Control de Caja:</strong> Ve detalles de sesiones, arqueos y cortes</li>
                                <li><strong>Exportación:</strong> Genera PDF de cualquier reporte</li>
                            </ul>

                            <h5 class="fw-semibold mt-4">Estadísticas</h5>
                            <p>El Dashboard muestra:</p>
                            <ul>
                                <li>Ventas totales del día/semana/mes</li>
                                <li>Productos más vendidos</li>
                                <li>Ingresos por método de pago</li>
                                <li>Tendencias de ventas</li>
                            </ul>
                        </div>
                    </div>
                </div>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/manuals/supervisor.blade.php ENDPATH**/ ?>