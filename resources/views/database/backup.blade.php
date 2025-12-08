<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-download me-2"></i>{{ __('Crear Backup de Base de Datos') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('database.create_backup') }}">
                        @csrf

                        <div class="mb-4">
                            <h5 class="mb-3">Selecciona las tablas a respaldar</h5>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                                @php
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
                                @endphp
                                @foreach($currentTableNames as $table)
                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" name="tables[]" value="{{ $table }}" class="form-check-input" id="table_{{ $table }}" checked>
                                            <label class="form-check-label" for="table_{{ $table }}">{{ $table }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="backup_name" class="form-label">{{ __('Nombre del archivo de backup') }}</label>
                            <input type="text" id="backup_name" name="backup_name" class="form-control" value="{{ old('backup_name', 'backup_manual') }}" required>
                            @error('backup_name') <div class="text-danger small">{{ $message }}</div> @enderror
                            <div class="form-text">El archivo se guardará con extensión .sql o .csv según el formato seleccionado</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">{{ __('Formato de exportación') }}</label>
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
                            @error('export_format') <div class="text-danger small">{{ $message }}</div> @enderror
                            <div class="form-text mt-2">
                                <p class="mb-1"><strong>SQL:</strong> Exporta la estructura completa de las tablas y todos los datos. Ideal para respaldos completos.</p>
                                <p class="mb-0"><strong>CSV:</strong> Exporta solo los datos en archivos CSV separados por tabla. Ideal para análisis de datos y migraciones simples.</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="backup_path" class="form-label">{{ __('Ruta completa donde guardar el backup') }}</label>
                            <div class="input-group">
                                <input type="text" id="backup_path" name="backup_path" class="form-control" value="{{ old('backup_path', storage_path('backups')) }}" required>
                                <button type="button" onclick="browseDirectory()" class="btn btn-secondary">
                                    <i class="bi bi-folder2-open me-1"></i>Explorar
                                </button>
                            </div>
                            @error('backup_path') <div class="text-danger small">{{ $message }}</div> @enderror
                            <div class="form-text">
                                <p class="mb-1">Ejemplo: {{ PHP_OS_FAMILY === 'Windows' ? 'C:\\backups' : '/home/user/backups' }} o {{ storage_path('backups') }}</p>
                                <p class="mb-0">Asegúrate de que el directorio exista y el servidor web tenga permisos de escritura.</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('database.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-download me-1"></i>{{ __('Crear Backup') }}
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
</x-app-layout>
