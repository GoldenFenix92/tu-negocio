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
            <i class="bi bi-upload me-2"></i><?php echo e(__('Restaurar Backup de Base de Datos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success mb-4">
                    <div class="d-flex">
                        <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Restauración Exitosa</h6>
                            <div class="small"><?php echo e(session('success')); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('warning')): ?>
                <div class="alert alert-warning mb-4">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Restauración Parcial</h6>
                            <div class="small"><?php echo e(session('warning')); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger mb-4">
                    <div class="d-flex">
                        <i class="bi bi-x-circle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Error en la Restauración</h6>
                            <div class="small"><?php echo e(session('error')); ?></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    
                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                            <div>
                                <h6 class="mb-1">Paso 1: Seleccionar archivo de backup</h6>
                                <p class="mb-0 small">Sube tu archivo de backup SQL o selecciona uno existente en el servidor para analizar su contenido y ver qué tablas contiene.</p>
                            </div>
                        </div>
                    </div>

                    
                    <?php if(!empty($availableBackups)): ?>
                        <div class="mb-4">
                            <h5 class="mb-3">Archivos de backup disponibles</h5>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                                <?php $__currentLoopData = $availableBackups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col">
                                        <div class="card h-100 bg-body-secondary border-secondary backup-card" style="cursor: pointer;" onclick="openBackupModal('<?php echo e(addslashes($backup['name'])); ?>', '<?php echo e($backup['type']); ?>', '<?php echo e($backup['path']); ?>', '<?php echo e(number_format($backup['size'] / 1024, 2)); ?>', '<?php echo e($backup['modified']); ?>', '<?php echo e(isset($backup['tables']) ? count($backup['tables']) : 0); ?>', '<?php echo e(isset($backup['total_records']) ? number_format($backup['total_records']) : 0); ?>')">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <?php if($backup['type'] === 'csv'): ?>
                                                            <div class="rounded bg-success bg-opacity-25 p-2">
                                                                <i class="bi bi-file-earmark-spreadsheet text-success"></i>
                                                            </div>
                                                            <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">CSV</span>
                                                        <?php else: ?>
                                                            <div class="rounded bg-primary bg-opacity-25 p-2">
                                                                <i class="bi bi-file-earmark-code text-primary"></i>
                                                            </div>
                                                            <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">SQL</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <i class="bi bi-eye text-secondary"></i>
                                                </div>

                                                <h6 class="card-title text-truncate mb-2"><?php echo e($backup['name']); ?></h6>

                                                <div class="small text-secondary mb-3">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-hdd me-1"></i>
                                                        <?php echo e(number_format($backup['size'] / 1024, 2)); ?> KB
                                                    </div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-clock me-1"></i>
                                                        <?php echo e($backup['modified']); ?>

                                                    </div>
                                                    <?php if($backup['type'] === 'csv' && isset($backup['tables'])): ?>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <i class="bi bi-table me-1"></i>
                                                            <?php echo e(count($backup['tables'])); ?> tablas
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-list-ol me-1"></i>
                                                            <?php echo e(number_format($backup['total_records'])); ?> registros
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <?php if($backup['type'] === 'csv'): ?>
                                                        <button type="button" onclick="event.stopPropagation(); previewCsvContent('<?php echo e(addslashes($backup['path'])); ?>')" class="btn btn-success btn-sm flex-fill">
                                                            Ver CSV
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" onclick="event.stopPropagation(); previewSqlContent('<?php echo e(addslashes($backup['path'])); ?>')" class="btn btn-primary btn-sm flex-fill">
                                                            Ver SQL
                                                        </button>
                                                    <?php endif; ?>
                                                    <button type="button" onclick="event.stopPropagation(); selectBackup('<?php echo e(addslashes($backup['path'])); ?>', '<?php echo e($backup['type']); ?>')" class="btn btn-outline-primary btn-sm flex-fill">
                                                        Seleccionar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mb-4">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                                <div>
                                    <h6 class="mb-1">No hay archivos de backup</h6>
                                    <p class="mb-0 small">No se encontraron archivos SQL en la carpeta <code>storage/backups/</code>. Puedes crear un backup primero o subir un archivo manualmente.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <div class="border-top pt-4 mt-4">
                        <h5 class="mb-3">O subir un archivo SQL manualmente</h5>

                        <form method="POST" action="<?php echo e(route('database.restore_process')); ?>" enctype="multipart/form-data" id="upload-form">
                            <?php echo csrf_field(); ?>

                            <div class="mb-4">
                                <label for="backup_file" class="form-label">Seleccionar archivo de backup</label>
                                <input id="backup_file" class="form-control" type="file" name="backup_file" accept=".sql,.txt,text/plain" required />
                                <div class="form-text">
                                    <p class="mb-1">Selecciona un archivo .sql o .txt para restaurar</p>
                                    <p class="mb-0">Formatos aceptados: .sql, .txt | Tamaño máximo: 10MB</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('database.index')); ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Cancelar
                                </a>
                                <div class="d-flex gap-2">
                                    <button type="submit" formaction="<?php echo e(route('database.restore_backup')); ?>" class="btn btn-success">
                                        <i class="bi bi-upload me-1"></i>Restaurar Todo
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search me-1"></i>Analizar y Seleccionar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="backupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Información del Backup</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Contenido del modal se cargará dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="proceedWithBackup()" id="modalProceedBtn">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewTitle">Preview del Contenido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewContent" style="max-height: 60vh; overflow-y: auto;">
                    <!-- Contenido del preview se cargará dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .backup-card:hover {
            border-color: var(--bs-primary) !important;
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>

    <script>
        let selectedBackupPath = null;
        let selectedBackupType = null;
        let backupModalInstance = null;
        let previewModalInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            backupModalInstance = new bootstrap.Modal(document.getElementById('backupModal'));
            previewModalInstance = new bootstrap.Modal(document.getElementById('previewModal'));
        });

        function openBackupModal(name, type, path, size, modified, tablesCount, recordsCount) {
            selectedBackupPath = path;
            selectedBackupType = type;

            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const modalProceedBtn = document.getElementById('modalProceedBtn');

            modalTitle.textContent = `Información: ${name}`;

            let content = `
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card bg-body-secondary">
                            <div class="card-body">
                                <h6 class="card-title">Información del Archivo</h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Nombre:</strong> ${name}</p>
                                    <p class="mb-1"><strong>Tipo:</strong> ${type.toUpperCase()}</p>
                                    <p class="mb-1"><strong>Tamaño:</strong> ${size} KB</p>
                                    <p class="mb-0"><strong>Modificado:</strong> ${modified}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-body-secondary">
                            <div class="card-body">
                                <h6 class="card-title">Contenido</h6>
                                <div class="small">
            `;

            if (type === 'csv') {
                content += `
                                    <p class="mb-1"><strong>Tablas:</strong> ${tablesCount}</p>
                                    <p class="mb-1"><strong>Total de registros:</strong> ${recordsCount}</p>
                                    <p class="mb-0"><strong>Formato:</strong> Archivos CSV separados por tabla</p>
                `;
            } else {
                content += `
                                    <p class="mb-1"><strong>Formato:</strong> Archivo SQL completo</p>
                                    <p class="mb-0"><strong>Contenido:</strong> Sentencias SQL con estructura y datos</p>
                `;
            }

            content += `
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mb-0">
                    <h6><i class="bi bi-question-circle me-1"></i>¿Qué deseas hacer?</h6>
                    <p class="small mb-2">Selecciona cómo quieres proceder con este archivo de backup:</p>
                    <ul class="small mb-0">
                        <li><strong>Analizar y Seleccionar:</strong> Ver el contenido detallado y elegir qué tablas restaurar</li>
                        <li><strong>Restaurar Todo:</strong> Restaurar todo el contenido del backup sin selección</li>
                    </ul>
                </div>
            `;

            modalContent.innerHTML = content;

            // Configurar el botón de proceder
            modalProceedBtn.textContent = 'Analizar y Seleccionar';
            if (type === 'csv') {
                modalProceedBtn.onclick = () => analyzeCsvBackup(path);
            } else {
                modalProceedBtn.onclick = () => analyzeSqlBackup(path);
            }

            backupModalInstance.show();
        }

        function closeBackupModal() {
            backupModalInstance.hide();
            selectedBackupPath = null;
            selectedBackupType = null;
        }

        function proceedWithBackup() {
            if (selectedBackupType === 'csv') {
                analyzeCsvBackup(selectedBackupPath);
            } else {
                analyzeSqlBackup(selectedBackupPath);
            }
        }

        function analyzeSqlBackup(path) {
            closeBackupModal();
            window.location.href = `<?php echo e(route('database.restore_show_content')); ?>?server_backup_file=${encodeURIComponent(path)}`;
        }

        function analyzeCsvBackup(path) {
            closeBackupModal();
            window.location.href = `<?php echo e(route('database.restore_process_csv_get')); ?>?file_path=${encodeURIComponent(path)}`;
        }

        function selectBackup(path, type) {
            if (type === 'csv') {
                analyzeCsvBackup(path);
            } else {
                analyzeSqlBackup(path);
            }
        }

        function previewSqlContent(path) {
            const modalTitle = document.getElementById('previewTitle');
            const modalContent = document.getElementById('previewContent');

            modalTitle.textContent = 'Preview del Contenido SQL';

            // Mostrar loading
            modalContent.innerHTML = `
                <div class="d-flex justify-content-center align-items-center py-5">
                    <div class="spinner-border text-primary me-2" role="status"></div>
                    <span>Cargando contenido...</span>
                </div>
            `;

            previewModalInstance.show();

            // Hacer petición AJAX
            fetch(`<?php echo e(route('database.preview_sql_content')); ?>`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ file_path: path })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalContent.innerHTML = `
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Contenido del archivo SQL</span>
                                <span class="badge bg-secondary">${data.file_size} caracteres</span>
                            </div>
                            <pre class="card-body bg-dark text-success mb-0" style="max-height: 400px; overflow: auto;"><code>${data.content}</code></pre>
                        </div>
                    `;
                } else {
                    modalContent.innerHTML = `
                        <div class="alert alert-danger mb-0">
                            <h6><i class="bi bi-x-circle me-1"></i>Error al cargar el contenido</h6>
                            <p class="mb-0 small">${data.error || 'No se pudo cargar el contenido del archivo.'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        <h6><i class="bi bi-x-circle me-1"></i>Error de conexión</h6>
                        <p class="mb-0 small">No se pudo conectar con el servidor para obtener el contenido.</p>
                    </div>
                `;
            });
        }

        function previewCsvContent(path) {
            const modalTitle = document.getElementById('previewTitle');
            const modalContent = document.getElementById('previewContent');

            modalTitle.textContent = 'Preview del Contenido CSV';

            // Mostrar loading
            modalContent.innerHTML = `
                <div class="d-flex justify-content-center align-items-center py-5">
                    <div class="spinner-border text-success me-2" role="status"></div>
                    <span>Cargando contenido...</span>
                </div>
            `;

            previewModalInstance.show();

            // Hacer petición AJAX
            fetch(`<?php echo e(route('database.preview_csv_content')); ?>`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ file_path: path })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let content = '';

                    if (data.metadata) {
                        content += `
                            <div class="alert alert-info mb-3">
                                <h6 class="mb-2">Información del Backup CSV</h6>
                                <div class="row small">
                                    <div class="col-md-6"><strong>Nombre:</strong> ${data.metadata.backup_name}</div>
                                    <div class="col-md-6"><strong>Creado:</strong> ${data.metadata.created_at}</div>
                                    <div class="col-md-6"><strong>Tablas:</strong> ${data.metadata.tables.length}</div>
                                    <div class="col-md-6"><strong>Total registros:</strong> ${data.metadata.total_records}</div>
                                </div>
                            </div>
                        `;
                    }

                    content += '<div class="card"><div class="card-header d-flex justify-content-between">';
                    content += '<span>Archivos CSV disponibles</span>';
                    content += `<span class="badge bg-secondary">${data.files.length} archivos</span>`;
                    content += '</div><div class="card-body">';

                    if (data.files.length > 0) {
                        data.files.forEach(file => {
                            content += `
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>${file.name}</strong>
                                        <span class="badge bg-secondary">${file.records} registros</span>
                                    </div>
                                    <pre class="bg-dark text-success p-3 rounded small mb-0" style="max-height: 120px; overflow: auto;"><code>${file.preview}</code></pre>
                                </div>
                            `;
                        });
                    } else {
                        content += '<p class="text-muted text-center mb-0">No se encontraron archivos CSV en el directorio.</p>';
                    }

                    content += '</div></div>';
                    modalContent.innerHTML = content;
                } else {
                    modalContent.innerHTML = `
                        <div class="alert alert-danger mb-0">
                            <h6><i class="bi bi-x-circle me-1"></i>Error al cargar el contenido</h6>
                            <p class="mb-0 small">${data.error || 'No se pudo cargar el contenido del archivo CSV.'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        <h6><i class="bi bi-x-circle me-1"></i>Error de conexión</h6>
                        <p class="mb-0 small">No se pudo conectar con el servidor para obtener el contenido.</p>
                    </div>
                `;
            });
        }

        function closePreviewModal() {
            previewModalInstance.hide();
        }

        function toggleTableSelection() {
            const restoreAll = document.getElementById('restore_all');
            const tableSelection = document.getElementById('table_selection');

            if (restoreAll.checked) {
                tableSelection.style.display = 'none';
                document.querySelectorAll('input[name="tables[]"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            } else {
                tableSelection.style.display = 'block';
                document.querySelectorAll('input[name="tables[]"]').forEach(function(checkbox) {
                    checkbox.checked = true;
                });
            }
        }

        // Si se desmarca "restore_all", marcar todas las individuales
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="tables[]"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const restoreAll = document.getElementById('restore_all');
                    if (!this.checked) {
                        restoreAll.checked = false;
                    }
                });
            });
        });

        // Validación para el formulario de restauración selectiva
        document.getElementById('selective-restore-form')?.addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="tables[]"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Por favor selecciona al menos una tabla para restaurar.');
                return false;
            }

            if (!confirm('¿Estás seguro de que quieres restaurar las ' + checkboxes.length + ' tablas seleccionadas? Esta acción puede sobrescribir datos existentes.')) {
                e.preventDefault();
                return false;
            }
        });

        // Cerrar modales con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBackupModal();
                closePreviewModal();
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/database/restore.blade.php ENDPATH**/ ?>