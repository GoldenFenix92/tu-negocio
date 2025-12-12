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
                <i class="bi bi-person-circle"></i> Manual de Usuario
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
                                <a class="nav-link" href="#pos">Punto de Venta</a>
                                <a class="nav-link" href="#historial">Historial de Ventas</a>
                                <a class="nav-link" href="#citas">Calendario y Citas</a>
                                <a class="nav-link" href="#caja">Control de Caja</a>
                                <a class="nav-link" href="#perfil">Perfil de Usuario</a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <!-- Introducción -->
                    <div class="card mb-4" id="intro">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-info-circle text-primary"></i> Introducción</h3>
                            <p>Bienvenido al sistema de punto de venta. Como usuario, tienes acceso a las funciones esenciales para realizar ventas, consultar información y gestionar tu sesión de caja.</p>
                        </div>
                    </div>

                    <!-- Punto de Venta -->
                    <div class="card mb-4" id="pos">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-cart text-primary"></i> Punto de Venta (POS)</h3>
                            
                            <h5 class="fw-semibold mt-4">Realizar una Venta</h5>
                            <ol>
                                <li>Ve a <strong>Operación → Punto de Venta</strong></li>
                                <li>Busca productos usando la barra de búsqueda o navega por categorías</li>
                                <li>Haz clic en un producto para agregarlo al carrito</li>
                                <li>Ajusta las cantidades si es necesario</li>
                                <li>Selecciona el cliente (opcional)</li>
                                <li>Aplica cupones de descuento si corresponde</li>
                                <li>Selecciona el método de pago (Efectivo, Tarjeta, Transferencia)</li>
                                <li>Completa la venta</li>
                            </ol>

                            <div class="alert alert-info">
                                <strong><i class="bi bi-lightbulb"></i> Consejo:</strong> Usa el escáner de código de barras para agregar productos más rápido.
                            </div>

                            <h5 class="fw-semibold mt-4">Métodos de Pago</h5>
                            <ul>
                                <li><strong>Efectivo:</strong> Introduce el monto recibido, el sistema calcula el cambio</li>
                                <li><strong>Tarjeta:</strong> Registra el cargo a tarjeta</li>
                                <li><strong>Transferencia:</strong> Registra pagos por transferencia bancaria</li>
                            </ul>

                            <h5 class="fw-semibold mt-4">Cupones de Descuento</h5>
                            <p>Para aplicar un cupón:</p>
                            <ol>
                                <li>Ingresa el código del cupón en el campo correspondiente</li>
                                <li>Haz clic en "Aplicar"</li>
                                <li>El descuento se aplicará automáticamente al total</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Historial de Ventas -->
                    <div class="card mb-4" id="historial">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-clipboard text-primary"></i> Historial de Ventas</h3>
                            <p>Accede a <strong>Operación → Historial de Ventas</strong> para:</p>
                            <ul>
                                <li>Consultar todas tus ventas realizadas</li>
                                <li>Ver detalles de cada venta</li>
                                <li>Reimprimir tickets</li>
                                <li>Exportar reportes en PDF</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Calendario y Citas -->
                    <div class="card mb-4" id="citas">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-calendar-event text-primary"></i> Calendario y Citas</h3>
                            <p>Gestiona las citas de los clientes:</p>
                            <ol>
                                <li>Ve a <strong>Operación → Calendario y Citas</strong></li>
                                <li>Visualiza las citas programadas en el calendario</li>
                                <li>Crea nuevas citas seleccionando una fecha</li>
                                <li>Edita o cancela citas existentes</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Control de Caja -->
                    <div class="card mb-4" id="caja">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-cash-coin text-primary"></i> Control de Caja</h3>
                            
                            <h5 class="fw-semibold mt-4">Iniciar Sesión de Caja</h5>
                            <ol>
                                <li>Ve a <strong>Operación → Sesiones de Caja</strong></li>
                                <li>Haz clic en "Iniciar Sesión"</li>
                                <li>Introduce el monto inicial en efectivo</li>
                                <li>Ingresa el código de autorización</li>
                            </ol>

                            <div class="alert alert-warning">
                                <strong><i class="bi bi-exclamation-triangle"></i> Importante:</strong> Debes tener una sesión de caja activa para realizar ventas en efectivo.
                            </div>

                            <h5 class="fw-semibold mt-4">Realizar Arqueos</h5>
                            <p>Los arqueos permiten verificar el efectivo en caja durante el día:</p>
                            <ol>
                                <li>Ve a <strong>Operación → Control de Caja</strong></li>
                                <li>Haz clic en "Realizar Arqueo"</li>
                                <li>Cuenta el efectivo físico en caja</li>
                                <li>Registra el monto contado</li>
                                <li>El sistema mostrará la diferencia (si existe)</li>
                            </ol>

                            <h5 class="fw-semibold mt-4">Cerrar Sesión de Caja</h5>
                            <ol>
                                <li>Realiza un arqueo final</li>
                                <li>Ve a <strong>Operación → Sesiones de Caja</strong></li>
                                <li>Haz clic en "Cerrar Sesión"</li>
                                <li>Confirma el cierre</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Perfil de Usuario -->
                    <div class="card mb-4" id="perfil">
                        <div class="card-body">
                            <h3 class="h4 fw-semibold mb-3"><i class="bi bi-person text-primary"></i> Perfil de Usuario</h3>
                            <p>Actualiza tu información personal:</p>
                            <ol>
                                <li>Haz clic en tu foto de perfil en el sidebar</li>
                                <li>Selecciona "Editar Perfil"</li>
                                <li>Actualiza tu nombre, correo o foto</li>
                                <li>Cambia tu contraseña si es necesario</li>
                                <li>Guarda los cambios</li>
                            </ol>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/manuals/usuario.blade.php ENDPATH**/ ?>