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
            <i class="bi bi-database me-2"></i><?php echo e(__('Gestión de Base de Datos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            
            <?php if(isset($systemInfo)): ?>
                <?php if(isset($systemInfo['error'])): ?>
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                            <div>
                                <h6 class="mb-1">Error de Conexión</h6>
                                <p class="mb-0 small"><?php echo e($systemInfo['error']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-info-circle-fill text-info me-3 fs-5"></i>
                                <div>
                                    <h6 class="mb-2">Información del Sistema</h6>
                                    <div class="row g-2 small">
                                        <div class="col-md-6"><strong>Conexión:</strong> <?php echo e($systemInfo['database_connection']); ?></div>
                                        <div class="col-md-6"><strong>Laravel:</strong> <?php echo e($systemInfo['laravel_version']); ?></div>
                                        <div class="col-md-6"><strong>PHP:</strong> <?php echo e($systemInfo['php_version']); ?></div>
                                        <div class="col-md-6"><strong>Directorio de backups:</strong> <?php echo e($systemInfo['backup_directory']); ?></div>
                                        <div class="col-md-6">
                                            <strong>Directorio existe:</strong>
                                            <?php if($systemInfo['backup_directory_exists']): ?>
                                                <i class="bi bi-check-circle-fill text-success"></i> Sí
                                            <?php else: ?>
                                                <i class="bi bi-x-circle-fill text-danger"></i> No
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Directorio escribible:</strong>
                                            <?php if($systemInfo['backup_directory_writable']): ?>
                                                <i class="bi bi-check-circle-fill text-success"></i> Sí
                                            <?php else: ?>
                                                <i class="bi bi-x-circle-fill text-danger"></i> No
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-table me-2"></i>Contenido de la Base de Datos</h5>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        <?php $__empty_1 = true; $__currentLoopData = $tableNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col">
                                <div class="card h-100 bg-body-secondary">
                                    <div class="card-body py-3">
                                        <h6 class="card-title mb-1"><i class="bi bi-grid me-2"></i><?php echo e($table); ?></h6>
                                        <p class="card-text small text-secondary mb-0">Tabla de datos</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php if(!isset($systemInfo['error'])): ?>
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        No se encontraron tablas en la base de datos. Verifique la conexión y asegúrese de que la base de datos no esté vacía.
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Acciones principales -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
                <!-- Backup Section -->
                <div class="col">
                    <div class="card h-100 border-primary">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded bg-primary text-white p-2 me-3">
                                    <i class="bi bi-download fs-5"></i>
                                </div>
                                <h5 class="card-title mb-0">Crear Backup</h5>
                            </div>
                            <p class="card-text small text-secondary flex-grow-1">Realiza una copia de seguridad de tu base de datos en formato SQL o CSV.</p>
                            <a href="<?php echo e(route('database.backup_form')); ?>" class="btn btn-primary w-100">
                                <i class="bi bi-download me-1"></i>Crear Backup
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Restore Section -->
                <div class="col">
                    <div class="card h-100 border-success">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded bg-success text-white p-2 me-3">
                                    <i class="bi bi-upload fs-5"></i>
                                </div>
                                <h5 class="card-title mb-0">Restaurar Backup</h5>
                            </div>
                            <p class="card-text small text-secondary flex-grow-1">Restaura una copia de seguridad existente con análisis completo y selección de tablas.</p>
                            <a href="<?php echo e(route('database.restore_form')); ?>" class="btn btn-success w-100">
                                <i class="bi bi-upload me-1"></i>Restaurar Backup
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Delete Section -->
                <div class="col">
                    <div class="card h-100 border-danger">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded bg-danger text-white p-2 me-3">
                                    <i class="bi bi-trash fs-5"></i>
                                </div>
                                <h5 class="card-title mb-0">Limpiar Base</h5>
                            </div>
                            <p class="card-text small text-secondary flex-grow-1">Elimina solo los registros de las tablas de negocio (requiere código maestro).</p>
                            <a href="<?php echo e(route('database.delete_form')); ?>" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-1"></i>Limpiar BD
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Test Section -->
                <div class="col">
                    <div class="card h-100 border-purple" style="border-color: #8b5cf6 !important;">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded text-white p-2 me-3" style="background-color: #8b5cf6;">
                                    <i class="bi bi-file-earmark-spreadsheet fs-5"></i>
                                </div>
                                <h5 class="card-title mb-0">Probar CSV</h5>
                            </div>
                            <p class="card-text small text-secondary flex-grow-1">Ejecuta una prueba automática para verificar que la funcionalidad de backups CSV esté operando correctamente.</p>
                            <a href="<?php echo e(route('database.test_csv')); ?>" class="btn btn-purple w-100">
                                <i class="bi bi-play-fill me-1"></i>Probar CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php
                $recentBackups = array_slice(array_filter($tableNames, function($table) {
                    return str_contains($table, 'backup') || str_contains($table, 'respaldo');
                }), 0, 5);
            ?>

            <?php if(!empty($recentBackups)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Backups recientes disponibles</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <?php $__currentLoopData = $recentBackups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col">
                                    <div class="card h-100 bg-body-secondary">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="card-title mb-0"><?php echo e($backup); ?></h6>
                                                <span class="badge bg-primary">
                                                    <?php if(str_contains($backup, 'csv')): ?>
                                                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV
                                                    <?php else: ?>
                                                        <i class="bi bi-database me-1"></i>SQL
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                            <p class="card-text small text-secondary mb-0">Backup de base de datos</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/database/index.blade.php ENDPATH**/ ?>