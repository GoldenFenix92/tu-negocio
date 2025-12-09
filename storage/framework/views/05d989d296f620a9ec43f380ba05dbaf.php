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
            <i class="bi bi-download me-2"></i><?php echo e(__('Crear Backup de Base de Datos')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('database.create_backup')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <h5 class="mb-3">Selecciona las tablas a respaldar</h5>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                                <?php
                                    $databaseConnection = config('database.default');
                                    $currentTableNames = [];

                                    switch ($databaseConnection) {
                                        case 'mysql':
                                        case 'mariadb':
                                            $tables = DB::select('SHOW TABLES');
                                            foreach ($tables as $table) {
                                                $currentTableNames[] = array_values((array) $table)[0];
                                            }
                                            break;
                                        case 'sqlite':
                                            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                                            foreach ($tables as $table) {
                                                $currentTableNames[] = $table->name;
                                            }
                                            break;
                                        case 'pgsql':
                                            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
                                            foreach ($tables as $table) {
                                                $currentTableNames[] = $table->tablename;
                                            }
                                            break;
                                        default:
                                            $tables = DB::select('SHOW TABLES');
                                            foreach ($tables as $table) {
                                                $currentTableNames[] = array_values((array) $table)[0];
                                            }
                                            break;
                                    }
                                ?>
                                <?php $__currentLoopData = $currentTableNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" name="tables[]" value="<?php echo e($table); ?>" class="form-check-input" id="table_<?php echo e($table); ?>" checked>
                                            <label class="form-check-label" for="table_<?php echo e($table); ?>"><?php echo e($table); ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="backup_name" class="form-label"><?php echo e(__('Nombre del archivo de backup')); ?></label>
                            <input type="text" id="backup_name" name="backup_name" class="form-control" value="<?php echo e(old('backup_name', 'backup_manual')); ?>" required>
                            <?php $__errorArgs = ['backup_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">El archivo se guardará con extensión .sql o .csv según el formato seleccionado</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><?php echo e(__('Formato de exportación')); ?></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" name="export_format" value="sql" class="form-check-input" id="format_sql" checked>
                                    <label class="form-check-label" for="format_sql">SQL (Estructura y datos completos)</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="export_format" value="csv" class="form-check-input" id="format_csv">
                                    <label class="form-check-label" for="format_csv">CSV (Solo datos en archivos separados)</label>
                                </div>
                            </div>
                            <?php $__errorArgs = ['export_format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text mt-2">
                                <p class="mb-1"><strong>SQL:</strong> Exporta la estructura completa de las tablas y todos los datos. Ideal para respaldos completos.</p>
                                <p class="mb-0"><strong>CSV:</strong> Exporta solo los datos en archivos CSV separados por tabla. Ideal para análisis de datos y migraciones simples.</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="backup_path" class="form-label"><?php echo e(__('Ruta completa donde guardar el backup')); ?></label>
                            <div class="input-group">
                                <input type="text" id="backup_path" name="backup_path" class="form-control" value="<?php echo e(old('backup_path', storage_path('backups'))); ?>" required>
                                <button type="button" onclick="browseDirectory()" class="btn btn-secondary">
                                    <i class="bi bi-folder2-open me-1"></i>Explorar
                                </button>
                            </div>
                            <?php $__errorArgs = ['backup_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">
                                <p class="mb-1">Ejemplo: <?php echo e(PHP_OS_FAMILY === 'Windows' ? 'C:\\backups' : '/home/user/backups'); ?> o <?php echo e(storage_path('backups')); ?></p>
                                <p class="mb-0">Asegúrate de que el directorio exista y el servidor web tenga permisos de escritura.</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('database.index')); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-download me-1"></i><?php echo e(__('Crear Backup')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function browseDirectory() {
            const input = document.createElement('input');
            input.type = 'file';
            input.webkitdirectory = true;
            input.directory = true;

            input.onchange = function(e) {
                if (e.target.files.length > 0) {
                    const path = e.target.files[0].path || e.target.files[0].webkitRelativePath;
                    if (path) {
                        const dirPath = path.substring(0, path.lastIndexOf('/') || path.lastIndexOf('\\'));
                        document.getElementById('backup_path').value = dirPath;
                    }
                }
            };

            input.click();
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
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/database/backup.blade.php ENDPATH**/ ?>