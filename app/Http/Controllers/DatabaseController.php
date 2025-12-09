<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use Illuminate\Routing\Controller as BaseController;

class DatabaseController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Método de prueba para verificar la funcionalidad de backups CSV
     */
    public function testCsvFunctionality(Request $request): RedirectResponse
    {
        try {
            // Verificar directorio de backups
            $backupDir = storage_path('backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Crear un backup de prueba
            $testBackupName = 'test_backup_' . date('Y-m-d_H-i-s');
            $testBackupPath = $backupDir . DIRECTORY_SEPARATOR . $testBackupName;

            if (!file_exists($testBackupPath)) {
                mkdir($testBackupPath, 0755, true);
            }

            // Obtener una tabla de prueba (users si existe)
            $testTables = ['users'];
            $availableTables = $this->getCurrentDatabaseTables();

            if (!empty($availableTables)) {
                $testTables = array_intersect($testTables, $availableTables);
                if (empty($testTables)) {
                    $testTables = [array_slice($availableTables, 0, 1)[0]];
                }
            }

            $exportedTables = [];
            $totalRecords = 0;

            foreach ($testTables as $tableName) {
                try {
                    $records = DB::table($tableName)->limit(10)->get(); // Solo 10 registros para prueba

                    if ($records->count() > 0) {
                        $filename = $testBackupPath . DIRECTORY_SEPARATOR . $tableName . '.csv';
                        $this->exportTableToCsv($tableName, $records, $filename);
                        $exportedTables[] = $tableName;
                        $totalRecords += $records->count();
                    }
                } catch (\Exception $e) {
                    Log::warning("Error exportando tabla de prueba {$tableName}: " . $e->getMessage());
                }
            }

            // Crear metadatos
            $metadata = [
                'backup_name' => $testBackupName,
                'created_at' => now()->toISOString(),
                'tables' => $exportedTables,
                'total_records' => $totalRecords,
                'format' => 'csv',
                'laravel_version' => app()->version(),
                'database_connection' => config('database.default'),
                'test_backup' => true
            ];

            file_put_contents($testBackupPath . '/metadata.json', json_encode($metadata, JSON_PRETTY_PRINT));

            $message = "✅ Prueba de funcionalidad CSV completada exitosamente.\n\n";
            $message .= "📁 Backup de prueba creado en: {$testBackupPath}\n";
            $message .= "📊 Tablas exportadas: " . count($exportedTables) . "\n";
            $message .= "📋 Registros de prueba: " . $totalRecords . "\n";
            $message .= "🔧 Funcionalidad CSV: OPERATIVA\n\n";
            $message .= "El sistema de backups CSV está funcionando correctamente.";

            return redirect()->route('database.index')->with('success', $message);

        } catch (\Exception $e) {
            Log::error("Error en prueba de funcionalidad CSV: " . $e->getMessage());
            return redirect()->route('database.index')->with('error', 'Error en prueba de funcionalidad CSV: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar el menú de gestión de base de datos
     */
    public function index(): View
    {
        try {
            $databaseConnection = config('database.default');
            $tableNames = [];

            switch ($databaseConnection) {
                case 'mysql':
                case 'mariadb':
                    $tables = DB::select('SHOW TABLES');
                    foreach ($tables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }
                    break;

                case 'sqlite':
                    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                    foreach ($tables as $table) {
                        $tableNames[] = $table->name;
                    }
                    break;

                case 'pgsql':
                    $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
                    foreach ($tables as $table) {
                        $tableNames[] = $table->tablename;
                    }
                    break;

                default:
                    $tables = DB::select('SHOW TABLES');
                    foreach ($tables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }
                    break;
            }

            // Información del sistema para debugging
            $systemInfo = [
                'database_connection' => $databaseConnection,
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,
                'backup_directory' => storage_path('backups'),
                'backup_directory_exists' => is_dir(storage_path('backups')),
                'backup_directory_writable' => is_writable(storage_path('backups'))
            ];

            return view('database.index', compact('tableNames', 'systemInfo'));

        } catch (\Exception $e) {
            Log::error('Error obteniendo lista de tablas: ' . $e->getMessage());
            return view('database.index', [
                'tableNames' => [],
                'systemInfo' => [
                    'error' => $e->getMessage(),
                    'database_connection' => config('database.default'),
                    'laravel_version' => app()->version()
                ]
            ]);
        }
    }

    /**
     * Mostrar formulario de backup
     */
    public function backupForm(): View
    {
        try {
            $databaseConnection = config('database.default');
            $tableNames = [];

            switch ($databaseConnection) {
                case 'mysql':
                case 'mariadb':
                    $tables = DB::select('SHOW TABLES');
                    foreach ($tables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }
                    break;

                case 'sqlite':
                    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                    foreach ($tables as $table) {
                        $tableNames[] = $table->name;
                    }
                    break;

                case 'pgsql':
                    $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
                    foreach ($tables as $table) {
                        $tableNames[] = $table->tablename;
                    }
                    break;

                default:
                    $tables = DB::select('SHOW TABLES');
                    foreach ($tables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }
                    break;
            }

            return view('database.backup', compact('tableNames'));

        } catch (\Exception $e) {
            Log::error('Error obteniendo lista de tablas para backup: ' . $e->getMessage());
            return view('database.backup', ['tableNames' => []]);
        }
    }

    /**
     * Crear backup de la base de datos (SQL o CSV)
     */
    public function createBackup(Request $request): RedirectResponse
    {
        $request->validate([
            'tables' => 'required|array',
            'tables.*' => 'string',
            'backup_name' => 'required|string|max:100',
            'backup_path' => 'required|string',
            'export_format' => 'required|in:sql,csv',
        ]);

        try {
            $selectedTables = $request->tables;
            $backupPath = $request->backup_path;
            $exportFormat = $request->export_format;

            // Crear directorio si no existe
            if (!file_exists($backupPath)) {
                if (!mkdir($backupPath, 0755, true)) {
                    throw new \Exception("No se pudo crear el directorio: {$backupPath}");
                }
            }

            $backupName = $request->backup_name;
            // Sanitizar el nombre del archivo
            $backupName = preg_replace('/[^A-Za-z0-9_-]/', '_', $backupName);

            if ($exportFormat === 'csv') {
                // Crear backup en formato CSV
                $backupDir = rtrim($backupPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $backupName;

                // Crear directorio para el backup
                if (!file_exists($backupDir)) {
                    if (!mkdir($backupDir, 0755, true)) {
                        throw new \Exception("No se pudo crear el directorio del backup: {$backupDir}");
                    }
                }

                Log::info("Creando backup CSV para tablas: " . implode(', ', $selectedTables));

                $exportedTables = [];
                $totalRecords = 0;

                foreach ($selectedTables as $tableName) {
                    try {
                        // Obtener todos los registros de la tabla
                        $records = DB::table($tableName)->get();

                        if ($records->count() > 0) {
                            $filename = $backupDir . DIRECTORY_SEPARATOR . $tableName . '.csv';
                            $this->exportTableToCsv($tableName, $records, $filename);
                            $exportedTables[] = $tableName;
                            $totalRecords += $records->count();

                            Log::info("Tabla {$tableName} exportada con {$records->count()} registros");
                        } else {
                            Log::info("Tabla {$tableName} está vacía, omitiendo");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error exportando tabla {$tableName}: " . $e->getMessage());
                        // Continuar con otras tablas
                    }
                }

                // Crear archivo de metadatos
                $metadataFile = $backupDir . DIRECTORY_SEPARATOR . 'metadata.json';
                $metadata = [
                    'backup_name' => $backupName,
                    'created_at' => now()->toISOString(),
                    'tables' => $exportedTables,
                    'total_records' => $totalRecords,
                    'format' => 'csv',
                    'laravel_version' => app()->version(),
                    'database_connection' => config('database.default')
                ];
                file_put_contents($metadataFile, json_encode($metadata, JSON_PRETTY_PRINT));

                $message = "Backup CSV creado exitosamente en: {$backupDir}\n";
                $message .= "Tablas exportadas: " . count($exportedTables) . "\n";
                $message .= "Total de registros: " . number_format($totalRecords) . "\n";
                $message .= "Formato: Archivos CSV separados por tabla";

                return redirect()->route('database.index')->with('success', $message);
            } else {
                // Crear backup en formato SQL (formato original)
                $filename = $backupName . '.sql';
                $fullPath = rtrim($backupPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

                // Intentar usar mysqldump primero
                $mysqldumpPath = exec('which mysqldump');
                if (!empty($mysqldumpPath)) {
                    // Usar mysqldump si está disponible
                    $command = "mysqldump --host=" . env('DB_HOST') .
                              " --user=" . env('DB_USERNAME') .
                              " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                              " --no-data=false --routines --triggers " . env('DB_DATABASE');

                    if (!empty($selectedTables)) {
                        $command .= " " . implode(' ', array_map('escapeshellarg', $selectedTables));
                    }

                    $command .= " > " . escapeshellarg($fullPath) . " 2>&1";

                    Log::info("Ejecutando comando de backup: {$command}");
                    exec($command, $output, $returnVar);

                    Log::info("Salida del comando: " . implode("\n", $output));
                    Log::info("Código de retorno: {$returnVar}");

                    if ($returnVar === 0) {
                        // Backup exitoso con mysqldump
                        $fileSize = filesize($fullPath);
                        if ($fileSize === 0) {
                            throw new \Exception("El archivo de backup se creó pero está vacío: {$fullPath}");
                        }
                        return redirect()->route('database.index')->with('success', "Backup SQL creado exitosamente en: {$fullPath} (Tamaño: " . number_format($fileSize / 1024, 2) . " KB)");
                    }
                }

                // Si mysqldump no está disponible o falló, usar método PHP
                Log::info("mysqldump no disponible o falló, usando método PHP");
                $this->createPhpBackup($selectedTables, $fullPath);

                // Verificar si el archivo se creó y tiene contenido
                if (!file_exists($fullPath)) {
                    throw new \Exception("El archivo de backup no se creó: {$fullPath}");
                }

                $fileSize = filesize($fullPath);
                if ($fileSize === 0) {
                    throw new \Exception("El archivo de backup se creó pero está vacío: {$fullPath}");
                }

                return redirect()->route('database.index')->with('success', "Backup SQL creado exitosamente en: {$fullPath} (Tamaño: " . number_format($fileSize / 1024, 2) . " KB)");
            }

        } catch (\Exception $e) {
            Log::error("Error en backup: " . $e->getMessage());
            return back()->with('error', 'Error al crear backup: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario de restauración
     */
    public function restoreForm(): View
    {
        // Buscar archivos SQL disponibles en el servidor
        $availableBackups = $this->findAvailableBackups();

        return view('database.restore', [
            'backupFile' => null,
            'backupTables' => [],
            'step' => 'upload',
            'availableBackups' => $availableBackups
        ]);
    }

    /**
     * Mostrar contenido del archivo de backup del servidor con comparación de migraciones
     */
    public function showServerBackupContent(Request $request)
    {
        try {
            $filePath = $request->query('server_backup_file');

            if (!$filePath) {
                return redirect()->route('database.restore_form')->with('error', 'No se especificó el archivo de backup.');
            }

            // Verificar que el archivo existe y es accesible
            if (!file_exists($filePath)) {
                return redirect()->route('database.restore_form')->with('error', 'El archivo de backup no existe o no es accesible.');
            }

            // Verificar que sea un archivo SQL
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if (!in_array($extension, ['sql', 'txt'])) {
                return redirect()->route('database.restore_form')->with('error', 'El archivo debe tener extensión .sql o .txt');
            }

            // Leer el contenido del archivo
            $sqlContent = file_get_contents($filePath);
            if ($sqlContent === false) {
                return redirect()->route('database.restore_form')->with('error', 'No se pudo leer el contenido del archivo.');
            }

            // Crear directorio temporal si no existe
            if (!Storage::exists('temp')) {
                Storage::makeDirectory('temp');
            }

            // Analizar el contenido del archivo SQL
            $tempPath = 'temp' . DIRECTORY_SEPARATOR . basename($filePath);
            if (!copy($filePath, storage_path('app' . DIRECTORY_SEPARATOR . $tempPath))) {
                return redirect()->route('database.restore_form')->with('error', 'No se pudo procesar el archivo para análisis.');
            }

            $analysis = $this->analyzeSqlFile($tempPath);
            Storage::delete($tempPath);

            // Obtener tablas actuales de la base de datos
            $currentTables = $this->getCurrentDatabaseTables();

            // Obtener tablas de las migraciones
            $migrationTables = $this->getMigrationTables();

            // Comparar tablas
            $comparison = $this->compareTables($analysis['tables'], $currentTables, $migrationTables);

            return view('database.backup_content', [
                'fileName' => basename($filePath),
                'filePath' => $filePath,
                'fileSize' => filesize($filePath),
                'modified' => date('Y-m-d H:i:s', filemtime($filePath)),
                'sqlContent' => $sqlContent,
                'backupTables' => $analysis['tables'],
                'backupInfo' => $analysis['info'],
                'currentTables' => $currentTables,
                'migrationTables' => $migrationTables,
                'tableComparison' => $comparison,
                'availableBackups' => $this->findAvailableBackups()
            ]);

        } catch (\Exception $e) {
            Log::error("Error mostrando contenido del archivo de backup: " . $e->getMessage());
            return redirect()->route('database.restore_form')->with('error', 'Error al procesar el archivo de backup: ' . $e->getMessage());
        }
    }

    /**
     * Procesar archivo de backup desde el servidor
     */
    public function processServerBackupFile(Request $request)
    {
        $request->validate([
            'server_backup_file' => 'required|string',
        ]);

        try {
            $filePath = $request->server_backup_file;

            // Verificar que el archivo existe y es accesible
            if (!file_exists($filePath)) {
                return back()->with('error', 'El archivo de backup no existe o no es accesible.');
            }

            // Verificar que sea un archivo SQL
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if (!in_array($extension, ['sql', 'txt'])) {
                return back()->with('error', 'El archivo debe tener extensión .sql o .txt');
            }

            // Crear directorio temporal si no existe
            if (!Storage::exists('temp')) {
                Storage::makeDirectory('temp');
            }

            // Copiar el archivo a storage temporal para análisis
            $tempPath = 'temp' . DIRECTORY_SEPARATOR . basename($filePath);
            if (!copy($filePath, storage_path('app' . DIRECTORY_SEPARATOR . $tempPath))) {
                return back()->with('error', 'No se pudo copiar el archivo para análisis.');
            }

            // Analizar el contenido del archivo SQL
            $analysis = $this->analyzeSqlFile($tempPath);

            if (empty($analysis['tables'])) {
                Storage::delete($tempPath);
                return back()->with('error', 'No se encontraron tablas válidas en el archivo de backup. Verifica que el archivo contenga sentencias SQL válidas.');
            }

            // Mostrar vista de selección de tablas
            return view('database.restore', [
                'backupFile' => new \Illuminate\Http\UploadedFile(
                    $filePath,
                    basename($filePath),
                    mime_content_type($filePath),
                    0,
                    true
                ),
                'backupTables' => $analysis['tables'],
                'backupInfo' => $analysis['info'],
                'step' => 'select_tables',
                'serverFilePath' => $filePath
            ]);

        } catch (\Exception $e) {
            Log::error("Error procesando archivo de backup del servidor: " . $e->getMessage());
            return back()->with('error', 'Error al procesar el archivo de backup: ' . $e->getMessage());
        }
    }

    /**
     * Procesar archivo de backup subido y mostrar análisis completo
     */
    public function processBackupFile(Request $request)
    {
        try {
            $file = $request->file('backup_file');

            if (!$file) {
                return back()->with('error', 'No se seleccionó ningún archivo.');
            }

            // Validar archivo manualmente
            if ($file->getSize() === 0) {
                return back()->with('error', 'El archivo no puede estar vacío.');
            }

            if ($file->getSize() > 10 * 1024 * 1024) {
                return back()->with('error', 'El archivo no puede ser mayor a 10MB.');
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['sql', 'txt'];

            if (!in_array($extension, $allowedExtensions)) {
                return back()->with('error', 'El archivo debe tener extensión .sql o .txt');
            }

            // Guardar archivo temporalmente
            $path = $file->store('temp');

            // Leer el contenido del archivo
            $sqlContent = file_get_contents(storage_path('app/' . $path));
            if ($sqlContent === false) {
                Storage::delete($path);
                return back()->with('error', 'No se pudo leer el contenido del archivo.');
            }

            // Analizar el contenido del archivo SQL
            $analysis = $this->analyzeSqlFile($path);

            if (empty($analysis['tables'])) {
                Storage::delete($path);
                return back()->with('error', 'No se encontraron tablas válidas en el archivo de backup. Verifica que el archivo contenga sentencias SQL válidas.');
            }

            // Obtener tablas actuales de la base de datos
            $currentTables = $this->getCurrentDatabaseTables();

            // Obtener tablas de las migraciones
            $migrationTables = $this->getMigrationTables();

            // Comparar tablas
            $comparison = $this->compareTables($analysis['tables'], $currentTables, $migrationTables);

            // Mostrar vista de análisis completo con comparación
            return view('database.backup_content', [
                'fileName' => $file->getClientOriginalName(),
                'filePath' => storage_path('app/' . $path),
                'fileSize' => $file->getSize(),
                'modified' => date('Y-m-d H:i:s', $file->getMTime()),
                'sqlContent' => $sqlContent,
                'backupTables' => $analysis['tables'],
                'backupInfo' => $analysis['info'],
                'currentTables' => $currentTables,
                'migrationTables' => $migrationTables,
                'tableComparison' => $comparison,
                'availableBackups' => $this->findAvailableBackups()
            ]);

        } catch (\Exception $e) {
            Log::error("Error procesando archivo de backup: " . $e->getMessage());
            return back()->with('error', 'Error al procesar el archivo de backup: ' . $e->getMessage());
        }
    }

    /**
     * Restaurar backup (completo o selectivo)
     */
    public function restoreBackup(Request $request): RedirectResponse
    {
        $request->validate([
            'backup_file' => [
                'nullable',
                'file',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Verificar que el archivo tenga extensión SQL o sea un archivo de texto
                        $allowedExtensions = ['sql', 'txt'];
                        $extension = strtolower($value->getClientOriginalExtension());

                        if (!in_array($extension, $allowedExtensions)) {
                            // Verificar por el tipo MIME
                            $mimeType = $value->getMimeType();
                            $allowedMimeTypes = ['application/sql', 'text/plain', 'text/sql', 'application/octet-stream'];

                            if (!in_array($mimeType, $allowedMimeTypes)) {
                                $fail('El archivo debe ser un archivo SQL válido (.sql) o archivo de texto (.txt).');
                            }
                        }

                        // Verificar que el archivo no esté vacío
                        if ($value->getSize() === 0) {
                            $fail('El archivo no puede estar vacío.');
                        }

                        // Verificar que el archivo no sea demasiado grande (10MB máximo)
                        if ($value->getSize() > 10 * 1024 * 1024) {
                            $fail('El archivo no puede ser mayor a 10MB.');
                        }
                    }
                }
            ],
            'server_file_path' => 'nullable|string',
            'tables' => 'nullable|array',
            'tables.*' => 'string',
        ]);

        try {
            $selectedTables = $request->tables;
            $serverFilePath = $request->server_file_path;

            // Si es un archivo del servidor, usarlo directamente
            if ($serverFilePath && file_exists($serverFilePath)) {
                $filePath = $serverFilePath;
                $isServerFile = true;
                Log::info("Restaurando desde archivo del servidor: {$filePath}");
            } else {
                // Si es un archivo subido, guardarlo temporalmente
                $file = $request->file('backup_file');

                if (!$file) {
                    return back()->with('error', 'Debe seleccionar un archivo de backup para restaurar o elegir uno del servidor.');
                }

                $tempPath = $file->store('temp');
                $filePath = storage_path('app/' . $tempPath);
                $isServerFile = false;
                Log::info("Restaurando desde archivo subido: {$filePath}");
            }

            $restoreAll = $request->has('restore_all');

            // Si no se especificaron tablas o si se marcó "restore_all", restaurar todo el archivo
            if ($restoreAll || empty($selectedTables)) {
                $selectedTables = []; // Asegurarse de que esté vacío para la restauración completa
                Log::info("No se especificaron tablas o se seleccionó restaurar todo, restaurando archivo completo");
            } else {
                Log::info("Tablas seleccionadas para restauración selectiva: " . implode(', ', $selectedTables));
            }

            // Usar método PHP para restauración (completa o selectiva)
            $restoreResults = $this->restorePhpBackupFromPath($filePath, $selectedTables);

            // Limpiar archivo temporal si no es del servidor
            if (!$isServerFile && isset($tempPath)) {
                Storage::delete($tempPath);
            }

            // Preparar mensaje de respuesta detallado
            $message = $this->generateSqlRestoreMessage($restoreResults, empty($selectedTables) ? 'Completa' : 'Selectiva');

            if ($restoreResults['executed_statements'] > 0 && $restoreResults['failed_statements'] > 0) {
                return redirect()->route('database.restore_form')->with('warning', $message);
            } elseif ($restoreResults['executed_statements'] > 0) {
                return redirect()->route('database.restore_form')->with('success', $message);
            } else {
                return back()->with('error', $message);
            }

        } catch (\Exception $e) {
            Log::error("Error en restauración: " . $e->getMessage());
            return back()->with('error', 'Error al restaurar backup: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario de limpieza de base de datos (solo registros)
     */
    public function deleteForm(): View
    {
        return view('database.delete');
    }

    /**
     * Limpiar base de datos (solo registros, no tablas)
     */
    public function deleteDatabase(Request $request): RedirectResponse
    {
        $request->validate([
            'master_code' => 'required|string',
        ]);

        if ($request->master_code !== 'EBCADMIN') {
            return back()->with('error', 'Código maestro incorrecto. No se puede eliminar la base de datos.');
        }

        try {
            $databaseConnection = config('database.default');
            Log::info("Iniciando eliminación de base de datos usando conexión: {$databaseConnection}");

            // Manejar diferentes tipos de base de datos
            if ($databaseConnection === 'mysql' || $databaseConnection === 'mariadb') {
                return $this->deleteMySQLDatabase();
            } elseif ($databaseConnection === 'sqlite') {
                return $this->deleteSQLiteDatabase();
            } elseif ($databaseConnection === 'pgsql') {
                return $this->deletePostgreSQLDatabase();
            } else {
                return back()->with('error', 'Tipo de base de datos no soportado: ' . $databaseConnection);
            }

        } catch (\Exception $e) {
            Log::error('Error general al eliminar base de datos: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar base de datos MySQL/MariaDB (solo registros, no tablas)
     */
    private function deleteMySQLDatabase(): RedirectResponse
    {
        try {
            // Desactivar verificación de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            // Obtener todas las tablas
            $tables = DB::select('SHOW TABLES');
            $tableNames = [];

            foreach ($tables as $table) {
                $tableNames[] = array_values((array) $table)[0];
            }

            // Tablas esenciales que NO se deben tocar (necesarias para login de admin)
            $essentialTables = ['migrations', 'cache', 'cache_locks', 'sessions'];

            Log::info('Tablas encontradas para limpiar (MySQL):', $tableNames);
            Log::info('Tablas esenciales que se preservarán completamente:', $essentialTables);

            $clearedTables = [];
            $preservedTables = [];
            $errors = [];

            // Limpiar todas las tablas excepto las esenciales
            foreach ($tableNames as $table) {
                if (in_array($table, $essentialTables)) {
                    $preservedTables[] = $table;
                    Log::info("Tabla MySQL preservada completamente (esencial): {$table}");
                    continue;
                }

                try {
                    // Si es la tabla users, solo eliminar usuarios no-admin
                    if ($table === 'users') {
                        // Preservar usuarios con email que contengan 'admin' o IDs específicos
                        DB::statement("DELETE FROM `$table` WHERE email NOT LIKE '%admin%' AND role != 'admin' AND id != 1");
                        Log::info("Usuarios no-admin eliminados de tabla: {$table}");
                    } else {
                        // Para otras tablas, eliminar todos los registros
                        DB::statement("DELETE FROM `$table`");
                        Log::info("Registros eliminados de tabla: {$table}");
                    }

                    $clearedTables[] = $table;
                } catch (\Exception $e) {
                    $errors[] = "Error limpiando tabla {$table}: " . $e->getMessage();
                    Log::error("Error limpiando tabla MySQL {$table}: " . $e->getMessage());
                }
            }

            // Reactivar verificación de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

            if (!empty($errors)) {
                return back()->with('error', 'Algunas tablas no se pudieron limpiar: ' . implode(', ', $errors));
            }

            $message = 'Base de datos limpiada exitosamente (solo registros eliminados). ';
            $message .= 'Tablas limpiadas: ' . count($clearedTables) . '. ';
            $message .= 'Tablas preservadas: ' . implode(', ', $preservedTables) . '. ';
            $message .= 'El usuario administrador se mantiene activo para que puedas restaurar datos.';

            return redirect()->route('database.index')->with('success', $message);

        } catch (\Exception $e) {
            // Asegurar que las claves foráneas se reactiven en caso de error
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            } catch (\Exception $fkError) {
                Log::error('Error reactivando foreign key checks en MySQL: ' . $fkError->getMessage());
            }

            throw $e;
        }
    }

    /**
     * Eliminar base de datos SQLite (solo registros, no tablas)
     */
    private function deleteSQLiteDatabase(): RedirectResponse
    {
        try {
            // Para SQLite, necesitamos manejar las restricciones de manera diferente
            DB::statement('PRAGMA foreign_keys = OFF');

            // Obtener todas las tablas
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $tableNames = [];

            foreach ($tables as $table) {
                $tableNames[] = $table->name;
            }

            // Tablas esenciales que NO se deben tocar (necesarias para login de admin)
            $essentialTables = ['migrations', 'cache', 'cache_locks', 'sessions'];

            Log::info('Tablas encontradas para limpiar (SQLite):', $tableNames);
            Log::info('Tablas esenciales que se preservarán completamente:', $essentialTables);

            $clearedTables = [];
            $preservedTables = [];
            $errors = [];

            // Limpiar todas las tablas excepto las esenciales
            foreach ($tableNames as $table) {
                if (in_array($table, $essentialTables)) {
                    $preservedTables[] = $table;
                    Log::info("Tabla SQLite preservada completamente (esencial): {$table}");
                    continue;
                }

                try {
                    // Si es la tabla users, solo eliminar usuarios no-admin
                    if ($table === 'users') {
                        // Preservar usuarios con email que contengan 'admin' o IDs específicos
                        DB::statement("DELETE FROM `{$table}` WHERE email NOT LIKE '%admin%' AND role != 'admin' AND id != 1");
                        Log::info("Usuarios no-admin eliminados de tabla: {$table}");
                    } else {
                        // Para otras tablas, eliminar todos los registros
                        DB::statement("DELETE FROM `{$table}`");
                        Log::info("Registros eliminados de tabla: {$table}");
                    }

                    $clearedTables[] = $table;
                } catch (\Exception $e) {
                    $errors[] = "Error limpiando tabla {$table}: " . $e->getMessage();
                    Log::error("Error limpiando tabla SQLite {$table}: " . $e->getMessage());
                }
            }

            // Reactivar verificación de claves foráneas
            DB::statement('PRAGMA foreign_keys = ON');

            if (!empty($errors)) {
                return back()->with('error', 'Algunas tablas no se pudieron limpiar: ' . implode(', ', $errors));
            }

            $message = 'Base de datos SQLite limpiada exitosamente (solo registros eliminados). ';
            $message .= 'Tablas limpiadas: ' . count($clearedTables) . '. ';
            $message .= 'Tablas preservadas: ' . implode(', ', $preservedTables) . '. ';
            $message .= 'El usuario administrador se mantiene activo para que puedas restaurar datos.';

            return redirect()->route('database.index')->with('success', $message);

        } catch (\Exception $e) {
            // Asegurar que las claves foráneas se reactiven en caso de error
            try {
                DB::statement('PRAGMA foreign_keys = ON');
            } catch (\Exception $fkError) {
                Log::error('Error reactivando foreign keys en SQLite: ' . $fkError->getMessage());
            }

            throw $e;
        }
    }

    /**
     * Eliminar base de datos PostgreSQL (solo registros, no tablas)
     */
    private function deletePostgreSQLDatabase(): RedirectResponse
    {
        try {
            // Obtener todas las tablas
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            $tableNames = [];

            foreach ($tables as $table) {
                $tableNames[] = $table->tablename;
            }

            // Tablas esenciales que NO se deben tocar (necesarias para login de admin)
            $essentialTables = ['migrations', 'cache', 'cache_locks', 'sessions'];

            Log::info('Tablas encontradas para limpiar (PostgreSQL):', $tableNames);
            Log::info('Tablas esenciales que se preservarán completamente:', $essentialTables);

            $clearedTables = [];
            $preservedTables = [];
            $errors = [];

            // Limpiar todas las tablas excepto las esenciales
            foreach ($tableNames as $table) {
                if (in_array($table, $essentialTables)) {
                    $preservedTables[] = $table;
                    Log::info("Tabla PostgreSQL preservada completamente (esencial): {$table}");
                    continue;
                }

                try {
                    // Si es la tabla users, solo eliminar usuarios no-admin
                    if ($table === 'users') {
                        // Preservar usuarios con email que contengan 'admin' o IDs específicos
                        DB::statement("DELETE FROM \"{$table}\" WHERE email NOT LIKE '%admin%' AND role != 'admin' AND id != 1");
                        Log::info("Usuarios no-admin eliminados de tabla: {$table}");
                    } else {
                        // Para otras tablas, eliminar todos los registros
                        DB::statement("DELETE FROM \"{$table}\"");
                        Log::info("Registros eliminados de tabla: {$table}");
                    }

                    $clearedTables[] = $table;
                } catch (\Exception $e) {
                    $errors[] = "Error limpiando tabla {$table}: " . $e->getMessage();
                    Log::error("Error limpiando tabla PostgreSQL {$table}: " . $e->getMessage());
                }
            }

            if (!empty($errors)) {
                return back()->with('error', 'Algunas tablas no se pudieron limpiar: ' . implode(', ', $errors));
            }

            $message = 'Base de datos PostgreSQL limpiada exitosamente (solo registros eliminados). ';
            $message .= 'Tablas limpiadas: ' . count($clearedTables) . '. ';
            $message .= 'Tablas preservadas: ' . implode(', ', $preservedTables) . '. ';
            $message .= 'El usuario administrador se mantiene activo para que puedas restaurar datos.';

            return redirect()->route('database.index')->with('success', $message);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Exportar tabla a formato CSV
     */
    private function exportTableToCsv(string $tableName, $records, string $filename): void
    {
        $handle = fopen($filename, 'w');

        if ($handle === false) {
            throw new \Exception("No se pudo crear el archivo CSV: {$filename}");
        }

        // Obtener nombres de columnas
        $columns = [];
        if ($records->count() > 0) {
            $firstRecord = $records->first();
            $columns = array_keys((array) $firstRecord);
        }

        // Escribir encabezados
        if (!empty($columns)) {
            fputcsv($handle, $columns);
        }

        // Escribir datos
        foreach ($records as $record) {
            $row = [];
            foreach ($columns as $column) {
                $value = $record->$column;

                // Convertir valores especiales para CSV
                if ($value === null) {
                    $row[] = '';
                } elseif (is_bool($value)) {
                    $row[] = $value ? '1' : '0';
                } else {
                    $row[] = $value;
                }
            }
            fputcsv($handle, $row);
        }

        fclose($handle);
    }

    /**
     * Crear backup usando PHP (método alternativo)
     */
    private function createPhpBackup(array $selectedTables, string $fullPath): void
    {
        $sql = "-- Backup creado por Laravel Database Manager\n";
        $sql .= "-- Fecha: " . now()->toDateTimeString() . "\n\n";

        foreach ($selectedTables as $tableName) {
            // Obtener estructura de la tabla
            $columns = DB::select("DESCRIBE `{$tableName}`");
            $columnNames = array_map(function($col) {
                return $col->Field;
            }, $columns);

            $sql .= "-- Estructura de la tabla `{$tableName}`\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";

            // Crear sentencia CREATE TABLE
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
            $sql .= $createTable->{'Create Table'} . ";\n\n";

            // Obtener datos de la tabla
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                $sql .= "-- Datos de la tabla `{$tableName}`\n";

                foreach ($rows as $row) {
                    $values = [];
                    foreach ($columnNames as $column) {
                        $value = $row->$column;
                        if (is_null($value)) {
                            $values[] = 'NULL';
                        } elseif (is_numeric($value)) {
                            $values[] = $value;
                        } else {
                            $values[] = "'" . addslashes($value) . "'";
                        }
                    }
                    $sql .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $columnNames) . "`) VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        // Escribir archivo
        if (file_put_contents($fullPath, $sql) === false) {
            throw new \Exception("No se pudo escribir el archivo de backup: {$fullPath}");
        }
    }

    /**
     * Restaurar backup usando PHP (método alternativo)
     */
    private function restorePhpBackup(string $filePath, array $selectedTables): array
    {
        $fullPath = storage_path('app/' . $filePath);
        $results = [
            'success' => true,
            'executed_statements' => 0,
            'failed_statements' => 0,
            'errors' => [],
            'warnings' => []
        ];

        if (!file_exists($fullPath)) {
            throw new \Exception("Archivo de backup no encontrado: {$fullPath}");
        }

        $sql = file_get_contents($fullPath);
        if ($sql === false) {
            throw new \Exception("No se pudo leer el archivo de backup: {$fullPath}");
        }

        Log::info("Iniciando restauración PHP del archivo: {$fullPath}");
        Log::info("Tamaño del archivo SQL: " . strlen($sql) . " caracteres");

        // Dividir el SQL en sentencias individuales
        $statements = [];
        $lines = explode("\n", $sql);
        $currentStatement = '';
        $inComment = false;
        $statementCount = 0;

        foreach ($lines as $lineNumber => $line) {
            $line = trim($line);

            // Manejar comentarios de línea
            if (strpos($line, '--') === 0) {
                continue; // Saltar comentarios de línea
            }

            // Manejar comentarios de bloque
            if (strpos($line, '/*') === 0) {
                $inComment = true;
                continue;
            }

            if ($inComment) {
                if (strpos($line, '*/') !== false) {
                    $inComment = false;
                }
                continue;
            }

            // Si la línea está vacía, continuar
            if (empty($line)) {
                continue;
            }

            $currentStatement .= $line . "\n";

            // Si la línea termina con punto y coma, es una sentencia completa
            if (substr($line, -1) === ';') {
                $statement = trim($currentStatement);
                if (!empty($statement)) {
                    $statements[] = $statement;
                    $statementCount++;
                }
                $currentStatement = '';
            }
        }

        Log::info("Sentencias SQL encontradas: " . count($statements));

        // Ejecutar sentencias
        foreach ($statements as $index => $statement) {
            if (empty($statement)) continue;

            try {
                // Determinar el tipo de sentencia
                $statementType = $this->getStatementType($statement);

                Log::info("Ejecutando sentencia {$index}: {$statementType}");

                switch ($statementType) {
                    case 'CREATE TABLE':
                        DB::statement($statement);
                        Log::info("Tabla creada exitosamente");
                        break;

                    case 'INSERT':
                        DB::statement($statement);
                        Log::info("Datos insertados exitosamente");
                        break;

                    case 'DROP TABLE':
                        DB::statement($statement);
                        Log::info("Tabla eliminada exitosamente");
                        break;

                    case 'UPDATE':
                        DB::statement($statement);
                        Log::info("Datos actualizados exitosamente");
                        break;

                    case 'DELETE':
                        DB::statement($statement);
                        Log::info("Datos eliminados exitosamente");
                        break;

                    case 'ALTER TABLE':
                        DB::statement($statement);
                        Log::info("Tabla modificada exitosamente");
                        break;

                    case 'TRUNCATE TABLE':
                        DB::statement($statement);
                        Log::info("Tabla truncada exitosamente");
                        break;

                    case 'REPLACE INTO':
                        DB::statement($statement);
                        Log::info("Datos reemplazados exitosamente");
                        break;

                    case 'SET':
                        DB::statement($statement);
                        Log::info("Configuración aplicada exitosamente");
                        break;

                    case 'LOCK TABLES':
                        DB::statement($statement);
                        Log::info("Tablas bloqueadas exitosamente");
                        break;

                    case 'UNLOCK TABLES':
                        DB::statement($statement);
                        Log::info("Tablas desbloqueadas exitosamente");
                        break;

                    default:
                        // Para otras sentencias, intentar ejecutar
                        DB::statement($statement);
                        Log::info("Sentencia ejecutada: " . substr($statementType, 0, 50) . "...");
                        break;
                }

                $results['executed_statements']++;

            } catch (\Exception $e) {
                $error = "Error en sentencia {$index}: " . $e->getMessage() . " | SQL: " . substr($statement, 0, 100) . "...";
                $results['errors'][] = $error;
                $results['failed_statements']++;
                Log::error($error);

                // Si es un error de tabla que ya existe, intentar con IF NOT EXISTS
                if (stripos($e->getMessage(), 'already exists') !== false && stripos($statement, 'CREATE TABLE') === 0) {
                    Log::warning("Intentando crear tabla con IF NOT EXISTS");
                    try {
                        $modifiedStatement = preg_replace('/^CREATE TABLE /i', 'CREATE TABLE IF NOT EXISTS ', $statement);
                        DB::statement($modifiedStatement);
                        $results['executed_statements']++;
                        $results['warnings'][] = "Tabla ya existía, se creó con IF NOT EXISTS";
                        Log::info("Tabla creada con IF NOT EXISTS");
                    } catch (\Exception $e2) {
                        $results['errors'][] = "Error incluso con IF NOT EXISTS: " . $e2->getMessage();
                        Log::error("Error con IF NOT EXISTS: " . $e2->getMessage());
                    }
                }
            }
        }

        // Si se especificaron tablas específicas, eliminar las que no están en la lista
        if (!empty($selectedTables)) {
            try {
                $allTables = DB::select('SHOW TABLES');
                $tableNames = [];
                foreach ($allTables as $table) {
                    $tableNames[] = array_values((array) $table)[0];
                }

                $removedTables = [];
                foreach ($tableNames as $table) {
                    if (!in_array($table, $selectedTables)) {
                        DB::statement("DROP TABLE IF EXISTS `$table`");
                        $removedTables[] = $table;
                    }
                }

                if (!empty($removedTables)) {
                    Log::info("Tablas removidas por restauración selectiva: " . implode(', ', $removedTables));
                }

            } catch (\Exception $e) {
                $results['warnings'][] = "Error en restauración selectiva: " . $e->getMessage();
                Log::warning("Error en restauración selectiva: " . $e->getMessage());
            }
        }

        Log::info("Restauración completada. Ejecutadas: {$results['executed_statements']}, Fallidas: {$results['failed_statements']}");

        return $results;
    }

    /**
     * Determinar el tipo de sentencia SQL
     */
    private function getStatementType(string $statement): string
    {
        $statement = trim(strtoupper($statement));

        if (stripos($statement, 'CREATE TABLE') === 0) {
            return 'CREATE TABLE';
        } elseif (stripos($statement, 'INSERT INTO') === 0 || stripos($statement, 'INSERT IGNORE INTO') === 0) {
            return 'INSERT';
        } elseif (stripos($statement, 'DROP TABLE') === 0) {
            return 'DROP TABLE';
        } elseif (stripos($statement, 'UPDATE') === 0) {
            return 'UPDATE';
        } elseif (stripos($statement, 'DELETE FROM') === 0) {
            return 'DELETE';
        } elseif (stripos($statement, 'ALTER TABLE') === 0) {
            return 'ALTER TABLE';
        } elseif (stripos($statement, 'TRUNCATE TABLE') === 0) {
            return 'TRUNCATE TABLE';
        } elseif (stripos($statement, 'REPLACE INTO') === 0) {
            return 'REPLACE INTO';
        } elseif (stripos($statement, 'SET ') === 0 && stripos($statement, 'SQL_MODE') !== false) {
            return 'SET';
        } elseif (stripos($statement, 'LOCK TABLES') === 0) {
            return 'LOCK TABLES';
        } elseif (stripos($statement, 'UNLOCK TABLES') === 0) {
            return 'UNLOCK TABLES';
        } else {
            return 'OTHER';
        }
    }

    /**
     * Restaurar backup usando comando MySQL
     */
    private function restoreWithMySQLCommand(string $filePath, array $selectedTables): bool
    {
        try {
            $mysqlPath = exec('which mysql');
            if (empty($mysqlPath)) {
                Log::info("Comando mysql no encontrado");
                return false;
            }

            // Si no se seleccionaron tablas, restaurar todas
            if (empty($selectedTables)) {
                $command = "mysql --host=" . env('DB_HOST') .
                          " --user=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " " . env('DB_DATABASE') .
                          " < " . storage_path('app/' . $filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración MySQL: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando MySQL: " . implode("\n", $output));
                Log::info("Código de retorno MySQL: {$returnVar}");

                return $returnVar === 0;
            } else {
                // Para restauración selectiva, necesitamos parsear el SQL
                // Por simplicidad, restauraremos todo y luego eliminaremos tablas no seleccionadas
                $command = "mysql --host=" . env('DB_HOST') .
                          " --user=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " " . env('DB_DATABASE') .
                          " < " . storage_path('app/' . $filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración MySQL selectiva: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando MySQL selectiva: " . implode("\n", $output));
                Log::info("Código de retorno MySQL selectiva: {$returnVar}");

                if ($returnVar === 0) {
                    // Eliminar tablas no seleccionadas
                    $allTables = DB::select('SHOW TABLES');
                    $tableNames = [];
                    foreach ($allTables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }

                    foreach ($tableNames as $table) {
                        if (!in_array($table, $selectedTables)) {
                            DB::statement("DROP TABLE IF EXISTS `$table`");
                        }
                    }
                    return true;
                }

                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error en restauración con comando MySQL: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Restaurar backup usando comando PostgreSQL
     */
    private function restoreWithPostgreSQLCommand(string $filePath, array $selectedTables): bool
    {
        try {
            $psqlPath = exec('which psql');
            if (empty($psqlPath)) {
                Log::info("Comando psql no encontrado");
                return false;
            }

            // Si no se seleccionaron tablas, restaurar todas
            if (empty($selectedTables)) {
                $command = "psql --host=" . env('DB_HOST') .
                          " --username=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " --dbname=" . env('DB_DATABASE') .
                          " < " . storage_path('app/' . $filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración PostgreSQL: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando PostgreSQL: " . implode("\n", $output));
                Log::info("Código de retorno PostgreSQL: {$returnVar}");

                return $returnVar === 0;
            } else {
                // Para restauración selectiva con PostgreSQL
                $command = "psql --host=" . env('DB_HOST') .
                          " --username=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " --dbname=" . env('DB_DATABASE') .
                          " < " . storage_path('app/' . $filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración PostgreSQL selectiva: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando PostgreSQL selectiva: " . implode("\n", $output));
                Log::info("Código de retorno PostgreSQL selectiva: {$returnVar}");

                if ($returnVar === 0) {
                    // Eliminar tablas no seleccionadas
                    $allTables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
                    $tableNames = [];
                    foreach ($allTables as $table) {
                        $tableNames[] = $table->tablename;
                    }

                    foreach ($tableNames as $table) {
                        if (!in_array($table, $selectedTables)) {
                            DB::statement("DROP TABLE IF EXISTS \"{$table}\" CASCADE");
                        }
                    }
                    return true;
                }

                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error en restauración con comando PostgreSQL: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Analizar archivo SQL y extraer información de tablas
     */
    private function analyzeSqlFile(string $filePath): array
    {
        $fullPath = storage_path('app/' . $filePath);

        if (!file_exists($fullPath)) {
            throw new \Exception("Archivo de backup no encontrado: {$fullPath}");
        }

        $sql = file_get_contents($fullPath);
        if ($sql === false) {
            throw new \Exception("No se pudo leer el archivo de backup: {$fullPath}");
        }

        $result = [
            'info' => [
                'file_size' => filesize($fullPath),
                'line_count' => substr_count($sql, "\n") + 1,
                'character_count' => strlen($sql)
            ],
            'tables' => [],
            'statements' => []
        ];

        Log::info("Analizando archivo SQL: {$fullPath}");
        Log::info("Tamaño del archivo: " . number_format($result['info']['file_size'] / 1024, 2) . " KB");

        // Dividir el SQL en sentencias individuales
        $statements = [];
        $lines = explode("\n", $sql);
        $currentStatement = '';
        $inComment = false;

        foreach ($lines as $lineNumber => $line) {
            $line = trim($line);

            // Manejar comentarios de línea
            if (strpos($line, '--') === 0) {
                continue; // Saltar comentarios de línea
            }

            // Manejar comentarios de bloque
            if (strpos($line, '/*') === 0) {
                $inComment = true;
                continue;
            }

            if ($inComment) {
                if (strpos($line, '*/') !== false) {
                    $inComment = false;
                }
                continue;
            }

            // Si la línea está vacía, continuar
            if (empty($line)) {
                continue;
            }

            $currentStatement .= $line . "\n";

            // Si la línea termina con punto y coma, es una sentencia completa
            if (substr($line, -1) === ';') {
                $statement = trim($currentStatement);
                if (!empty($statement)) {
                    $statements[] = $statement;
                }
                $currentStatement = '';
            }
        }

        Log::info("Sentencias encontradas: " . count($statements));

        // Analizar cada sentencia para extraer nombres de tablas
        $tableNames = [];
        $statementTypes = [
            'CREATE TABLE' => 0,
            'INSERT' => 0,
            'DROP TABLE' => 0,
            'UPDATE' => 0,
            'DELETE' => 0,
            'ALTER TABLE' => 0,
            'TRUNCATE TABLE' => 0,
            'REPLACE INTO' => 0,
            'SET' => 0,
            'LOCK TABLES' => 0,
            'UNLOCK TABLES' => 0,
            'OTHER' => 0
        ];

        foreach ($statements as $statement) {
            $statementType = $this->getStatementType($statement);
            $statementTypes[$statementType]++;

            // Extraer nombre de tabla según el tipo de sentencia
            $tableName = $this->extractTableName($statement, $statementType);
            if ($tableName && !in_array($tableName, $tableNames)) {
                $tableNames[] = $tableName;
            }
        }

        $result['statements'] = $statementTypes;
        $result['tables'] = array_unique($tableNames);

        sort($result['tables']); // Ordenar alfabéticamente

        Log::info("Tablas encontradas: " . implode(', ', $result['tables']));
        Log::info("Tipos de sentencias: " . json_encode($statementTypes));

        return $result;
    }

    /**
     * Extraer nombre de tabla de una sentencia SQL
     */
    private function extractTableName(string $statement, string $statementType): ?string
    {
        try {
            switch ($statementType) {
                case 'CREATE TABLE':
                    // CREATE TABLE `table_name` o CREATE TABLE table_name
                    // También maneja CREATE TABLE IF NOT EXISTS
                    if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'INSERT':
                    // INSERT INTO `table_name` o INSERT INTO table_name
                    // También maneja INSERT IGNORE INTO
                    if (preg_match('/INSERT\s+(?:IGNORE\s+)?INTO\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'DROP TABLE':
                    // DROP TABLE `table_name` o DROP TABLE table_name
                    // También maneja DROP TABLE IF EXISTS
                    if (preg_match('/DROP\s+TABLE\s+(?:IF\s+EXISTS\s+)?[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'UPDATE':
                    // UPDATE `table_name` o UPDATE table_name
                    if (preg_match('/UPDATE\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'DELETE':
                    // DELETE FROM `table_name` o DELETE FROM table_name
                    if (preg_match('/DELETE\s+FROM\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'ALTER TABLE':
                    // ALTER TABLE `table_name` o ALTER TABLE table_name
                    if (preg_match('/ALTER\s+TABLE\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'TRUNCATE TABLE':
                    // TRUNCATE TABLE `table_name` o TRUNCATE TABLE table_name
                    if (preg_match('/TRUNCATE\s+TABLE\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;

                case 'REPLACE INTO':
                    // REPLACE INTO `table_name` o REPLACE INTO table_name
                    if (preg_match('/REPLACE\s+INTO\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                        return $matches[1];
                    }
                    break;
            }
        } catch (\Exception $e) {
            Log::warning("Error extrayendo nombre de tabla: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Extraer nombre de tabla de cualquier sentencia SQL
     */
    private function extractTableNameFromStatement(string $statement): ?string
    {
        try {
            $statement = trim($statement);

            // CREATE TABLE `table_name` o CREATE TABLE table_name
            if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // INSERT INTO `table_name` o INSERT INTO table_name
            if (preg_match('/INSERT\s+(?:IGNORE\s+)?INTO\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // DROP TABLE `table_name` o DROP TABLE table_name
            if (preg_match('/DROP\s+TABLE\s+(?:IF\s+EXISTS\s+)?[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // UPDATE `table_name` o UPDATE table_name
            if (preg_match('/UPDATE\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // DELETE FROM `table_name` o DELETE FROM table_name
            if (preg_match('/DELETE\s+FROM\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // ALTER TABLE `table_name` o ALTER TABLE table_name
            if (preg_match('/ALTER\s+TABLE\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // TRUNCATE TABLE `table_name` o TRUNCATE TABLE table_name
            if (preg_match('/TRUNCATE\s+TABLE\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

            // REPLACE INTO `table_name` o REPLACE INTO table_name
            if (preg_match('/REPLACE\s+INTO\s+[`"]?([^`"\s;]+)/i', $statement, $matches)) {
                return $matches[1];
            }

        } catch (\Exception $e) {
            Log::warning("Error extrayendo nombre de tabla de sentencia: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Obtener tablas actuales de la base de datos
     */
    private function getCurrentDatabaseTables(): array
    {
        try {
            $databaseConnection = config('database.default');
            $tableNames = [];

            switch ($databaseConnection) {
                case 'mysql':
                case 'mariadb':
                    $tables = DB::select('SHOW TABLES');
                    foreach ($tables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }
                    break;

                case 'sqlite':
                    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
                    foreach ($tables as $table) {
                        $tableNames[] = $table->name;
                    }
                    break;

                case 'pgsql':
                    $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
                    foreach ($tables as $table) {
                        $tableNames[] = $table->tablename;
                    }
                    break;

                default:
                    $tables = DB::select('SHOW TABLES');
                    foreach ($tables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }
                    break;
            }

            return $tableNames;
        } catch (\Exception $e) {
            Log::error('Error obteniendo tablas actuales: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener tablas de las migraciones
     */
    private function getMigrationTables(): array
    {
        $migrationTables = [];

        try {
            $migrationFiles = glob(database_path('migrations') . '/*.php');

            foreach ($migrationFiles as $file) {
                $filename = basename($file, '.php');

                // Extraer el nombre de la tabla de la migración
                // Buscar patrones comunes en las migraciones de Laravel
                $content = file_get_contents($file);

                // Buscar Schema::create('table_name')
                if (preg_match("/Schema::create\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
                    $migrationTables[] = $matches[1];
                }

                // Buscar Schema::dropIfExists('table_name')
                if (preg_match("/Schema::dropIfExists\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
                    $migrationTables[] = $matches[1];
                }

                // Buscar Schema::table('table_name')
                if (preg_match("/Schema::table\(['\"]([^'\"]+)['\"]/", $content, $matches)) {
                    $migrationTables[] = $matches[1];
                }
            }

            // Remover duplicados y tablas del sistema
            $migrationTables = array_unique($migrationTables);
            $systemTables = ['migrations', 'cache', 'cache_locks', 'sessions', 'jobs', 'failed_jobs'];

            return array_diff($migrationTables, $systemTables);

        } catch (\Exception $e) {
            Log::error('Error obteniendo tablas de migraciones: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Comparar tablas del backup con las tablas actuales y de migraciones
     */
    private function compareTables(array $backupTables, array $currentTables, array $migrationTables): array
    {
        $comparison = [
            'missing_in_current' => [],      // Tablas del backup que no están en la BD actual
            'missing_in_migrations' => [],   // Tablas del backup que no están en migraciones
            'exist_in_current' => [],        // Tablas del backup que ya existen en la BD actual
            'exist_in_migrations' => [],     // Tablas del backup que están en migraciones
            'new_tables' => [],              // Tablas nuevas (no en migraciones pero en backup)
            'outdated_tables' => []          // Tablas que necesitan actualización
        ];

        foreach ($backupTables as $table) {
            if (!in_array($table, $currentTables)) {
                $comparison['missing_in_current'][] = $table;
            } else {
                $comparison['exist_in_current'][] = $table;
            }

            if (!in_array($table, $migrationTables)) {
                $comparison['missing_in_migrations'][] = $table;
                $comparison['new_tables'][] = $table;
            } else {
                $comparison['exist_in_migrations'][] = $table;
            }
        }

        // Identificar tablas que pueden necesitar actualización
        foreach ($comparison['exist_in_current'] as $table) {
            if (in_array($table, $migrationTables)) {
                $comparison['outdated_tables'][] = $table;
            }
        }

        return $comparison;
    }

    /**
     * Procesar backup CSV desde el servidor (método GET para evitar problemas CSRF)
     */
    public function processCsvBackup(Request $request)
    {
        try {
            $filePath = $request->query('file_path');

            if (!$filePath) {
                return back()->with('error', 'No se especificó el archivo de backup.');
            }

            // Verificar que el archivo existe y es accesible
            if (!file_exists($filePath)) {
                return back()->with('error', 'El archivo de backup no existe o no es accesible.');
            }

            // Verificar que sea un directorio CSV
            if (!is_dir($filePath)) {
                return back()->with('error', 'El archivo debe ser un directorio de backup CSV.');
            }

            // Verificar que existe el archivo de metadatos
            $metadataFile = $filePath . '/metadata.json';
            if (!file_exists($metadataFile)) {
                return back()->with('error', 'No se encontró el archivo de metadatos del backup CSV.');
            }

            $metadata = json_decode(file_get_contents($metadataFile), true);
            if (!$metadata) {
                return back()->with('error', 'No se pudo leer el archivo de metadatos del backup CSV.');
            }

            // Obtener archivos CSV disponibles
            $csvFiles = glob($filePath . '/*.csv');
            $tables = [];

            foreach ($csvFiles as $csvFile) {
                $tableName = basename($csvFile, '.csv');
                if ($tableName !== 'metadata') {
                    $tables[] = $tableName;
                }
            }

            if (empty($tables)) {
                return back()->with('error', 'No se encontraron archivos CSV válidos en el directorio de backup.');
            }

            // Obtener tablas actuales de la base de datos
            $currentTables = $this->getCurrentDatabaseTables();

            // Obtener tablas de las migraciones
            $migrationTables = $this->getMigrationTables();

            // Comparar tablas
            $comparison = $this->compareTables($tables, $currentTables, $migrationTables);

            // Mostrar vista de selección de tablas para CSV
            return view('database.restore_csv', [
                'backupPath' => $filePath,
                'backupName' => basename($filePath),
                'backupInfo' => $metadata,
                'backupTables' => $tables,
                'currentTables' => $currentTables,
                'migrationTables' => $migrationTables,
                'tableComparison' => $comparison,
                'availableBackups' => $this->findAvailableBackups()
            ]);

        } catch (\Exception $e) {
            Log::error("Error procesando backup CSV: " . $e->getMessage());
            return back()->with('error', 'Error al procesar el backup CSV: ' . $e->getMessage());
        }
    }

    /**
     * Procesar restauración CSV con método simplificado (sin CSRF)
     */
    public function restoreCsvSimple(Request $request)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $backupPath = $request->input('backup_path');
            $selectedTables = $request->input('tables', []);
            $truncateTables = $request->boolean('truncate_tables', true);

            if (!$backupPath || !file_exists($backupPath)) {
                return response()->json(['success' => false, 'error' => 'Directorio de backup no válido']);
            }

            $results = [
                'imported_tables' => 0,
                'total_records' => 0,
                'errors' => [],
                'processed_tables' => []
            ];

            // Si no hay tablas seleccionadas, procesar todas
            if (empty($selectedTables)) {
                $csvFiles = glob($backupPath . '/*.csv');
                foreach ($csvFiles as $csvFile) {
                    $tableName = basename($csvFile, '.csv');
                    if ($tableName !== 'metadata') {
                        $selectedTables[] = $tableName;
                    }
                }
            }

            foreach ($selectedTables as $tableName) {
                try {
                    $csvFile = $backupPath . '/' . $tableName . '.csv';

                    if (!file_exists($csvFile)) {
                        $results['errors'][] = "Archivo CSV no encontrado: {$tableName}";
                        continue;
                    }

                    // Verificar si la tabla existe
                    $tableExists = false;
                    try {
                        $columns = DB::select("DESCRIBE `{$tableName}`");
                        $tableExists = true;
                    } catch (\Exception $e) {
                        // La tabla no existe, se creará automáticamente
                    }

                    // Truncar tabla si existe y se pidió
                    if ($tableExists && $truncateTables) {
                        DB::statement("TRUNCATE TABLE `{$tableName}`");
                    }

                    // Importar datos CSV
                    $records = $this->importCsvData($csvFile, $tableName, !$tableExists);

                    $results['imported_tables']++;
                    $results['total_records'] += $records;
                    $results['processed_tables'][] = [
                        'name' => $tableName,
                        'records' => $records,
                        'status' => 'success'
                    ];

                } catch (\Exception $e) {
                    $results['errors'][] = "Error con tabla {$tableName}: " . $e->getMessage();
                    $results['processed_tables'][] = [
                        'name' => $tableName,
                        'records' => 0,
                        'status' => 'error',
                        'error' => $e->getMessage()
                    ];
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json([
                'success' => $results['imported_tables'] > 0,
                'message' => $this->generateSimpleRestoreMessage($results),
                'results' => $results
            ]);

        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json([
                'success' => false,
                'error' => 'Error en restauración: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Importar datos CSV de manera simplificada
     */
    private function importCsvData(string $csvFile, string $tableName, bool $createTable = false): int
    {
        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            throw new \Exception("No se pudo abrir el archivo CSV");
        }

        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);
            throw new \Exception("No se pudieron leer los encabezados");
        }

        // Crear tabla si no existe
        if ($createTable) {
            $this->createTableFromCsvHeaders($tableName, $headers);
        }

        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $data = [];
            foreach ($headers as $index => $header) {
                $data[$header] = $row[$index] ?? null;
            }

            DB::table($tableName)->insert($data);
            $count++;
        }

        fclose($handle);
        return $count;
    }

    /**
     * Generar mensaje simple de restauración
     */
    private function generateSimpleRestoreMessage(array $results): string
    {
        $message = "Restauración completada. ";

        if ($results['imported_tables'] > 0) {
            $message .= "✅ {$results['imported_tables']} tablas importadas con {$results['total_records']} registros totales. ";
        }

        if (!empty($results['errors'])) {
            $message .= "❌ " . count($results['errors']) . " errores encontrados. ";
        }

        return $message;
    }

    /**
     * Preview del contenido SQL
     */
    public function previewSqlContent(Request $request)
    {
        try {
            $request->validate([
                'file_path' => 'required|string',
            ]);

            $filePath = $request->file_path;

            // Verificar que el archivo existe y es accesible
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'error' => 'El archivo no existe o no es accesible.'
                ]);
            }

            // Verificar que sea un archivo SQL
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            if (!in_array($extension, ['sql', 'txt'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'El archivo debe tener extensión .sql o .txt'
                ]);
            }

            // Leer el contenido del archivo
            $content = file_get_contents($filePath);
            if ($content === false) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se pudo leer el contenido del archivo.'
                ]);
            }

            // Limitar el contenido a los primeros 5000 caracteres para el preview
            $previewContent = strlen($content) > 5000 ? substr($content, 0, 5000) . '...' : $content;

            return response()->json([
                'success' => true,
                'content' => $previewContent,
                'file_size' => strlen($content)
            ]);

        } catch (\Exception $e) {
            Log::error("Error en preview SQL: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al procesar el archivo: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Preview del contenido CSV
     */
    public function previewCsvContent(Request $request)
    {
        try {
            $request->validate([
                'file_path' => 'required|string',
            ]);

            $filePath = $request->file_path;

            // Verificar que el archivo existe y es accesible
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'error' => 'El directorio no existe o no es accesible.'
                ]);
            }

            // Verificar que sea un directorio
            if (!is_dir($filePath)) {
                return response()->json([
                    'success' => false,
                    'error' => 'La ruta debe ser un directorio de backup CSV.'
                ]);
            }

            // Verificar que existe el archivo de metadatos
            $metadataFile = $filePath . '/metadata.json';
            if (!file_exists($metadataFile)) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró el archivo de metadatos del backup CSV.'
                ]);
            }

            $metadata = json_decode(file_get_contents($metadataFile), true);
            if (!$metadata) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se pudo leer el archivo de metadatos.'
                ]);
            }

            // Obtener archivos CSV
            $csvFiles = glob($filePath . '/*.csv');
            $files = [];

            foreach ($csvFiles as $csvFile) {
                $tableName = basename($csvFile, '.csv');
                if ($tableName !== 'metadata') {
                    $records = $this->countCsvRecords($csvFile);
                    $preview = $this->getCsvPreview($csvFile, 5); // 5 primeras líneas

                    $files[] = [
                        'name' => $tableName . '.csv',
                        'records' => $records,
                        'preview' => $preview
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'metadata' => $metadata,
                'files' => $files
            ]);

        } catch (\Exception $e) {
            Log::error("Error en preview CSV: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al procesar el backup CSV: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Contar registros en un archivo CSV
     */
    private function countCsvRecords(string $filePath): int
    {
        $count = 0;
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (fgetcsv($handle) !== false) {
                $count++;
            }
            fclose($handle);
        }
        return $count - 1; // Restar 1 por el encabezado
    }

    /**
     * Obtener preview de un archivo CSV (primeras líneas)
     */
    private function getCsvPreview(string $filePath, int $lines = 5): string
    {
        $preview = '';
        $lineCount = 0;

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false && $lineCount < $lines) {
                $preview .= implode(',', $data) . "\n";
                $lineCount++;
            }
            fclose($handle);
        }

        return $preview;
    }

    /**
     * Buscar archivos de backup disponibles en el servidor (SQL y CSV)
     */
    private function findAvailableBackups(): array
    {
        $backups = [];

        // Buscar en la carpeta de backups del sistema
        $backupDirectory = storage_path('backups');

        if (is_dir($backupDirectory)) {
            // Buscar archivos SQL
            $sqlFiles = glob($backupDirectory . '/*.sql');
            foreach ($sqlFiles as $file) {
                if (is_readable($file)) {
                    $backups[] = [
                        'path' => $file,
                        'name' => basename($file),
                        'size' => filesize($file),
                        'modified' => date('Y-m-d H:i:s', filemtime($file)),
                        'type' => 'sql',
                        'directory' => 'backups'
                    ];
                }
            }

            // Buscar directorios de backup CSV
            $csvDirectories = glob($backupDirectory . '/*', GLOB_ONLYDIR);
            foreach ($csvDirectories as $dir) {
                if (is_readable($dir)) {
                    $metadataFile = $dir . '/metadata.json';
                    if (file_exists($metadataFile)) {
                        $metadata = json_decode(file_get_contents($metadataFile), true);
                        if ($metadata && isset($metadata['format']) && $metadata['format'] === 'csv') {
                            $totalSize = 0;
                            $csvFiles = glob($dir . '/*.csv');
                            foreach ($csvFiles as $csvFile) {
                                $totalSize += filesize($csvFile);
                            }

                            $backups[] = [
                                'path' => $dir,
                                'name' => basename($dir),
                                'size' => $totalSize,
                                'modified' => date('Y-m-d H:i:s', filemtime($dir)),
                                'type' => 'csv',
                                'tables' => $metadata['tables'] ?? [],
                                'total_records' => $metadata['total_records'] ?? 0,
                                'directory' => 'backups'
                            ];
                        }
                    }
                }
            }
        }

        // Ordenar por fecha de modificación (más reciente primero)
        usort($backups, function($a, $b) {
            return strtotime($b['modified']) - strtotime($a['modified']);
        });

        return $backups;
    }

    /**
     * Restaurar backup usando comando MySQL desde cualquier ruta
     */
    private function restoreWithMySQLCommandFromPath(string $filePath, array $selectedTables): bool
    {
        try {
            $mysqlPath = exec('which mysql');
            if (empty($mysqlPath)) {
                Log::info("Comando mysql no encontrado");
                return false;
            }

            // Si no se seleccionaron tablas, restaurar todas
            if (empty($selectedTables)) {
                $command = "mysql --host=" . env('DB_HOST') .
                          " --user=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " " . env('DB_DATABASE') .
                          " < " . escapeshellarg($filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración MySQL: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando MySQL: " . implode("\n", $output));
                Log::info("Código de retorno MySQL: {$returnVar}");

                return $returnVar === 0;
            } else {
                // Para restauración selectiva, necesitamos parsear el SQL
                // Por simplicidad, restauraremos todo y luego eliminaremos tablas no seleccionadas
                $command = "mysql --host=" . env('DB_HOST') .
                          " --user=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " " . env('DB_DATABASE') .
                          " < " . escapeshellarg($filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración MySQL selectiva: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando MySQL selectiva: " . implode("\n", $output));
                Log::info("Código de retorno MySQL selectiva: {$returnVar}");

                if ($returnVar === 0) {
                    // Eliminar tablas no seleccionadas
                    $allTables = DB::select('SHOW TABLES');
                    $tableNames = [];
                    foreach ($allTables as $table) {
                        $tableNames[] = array_values((array) $table)[0];
                    }

                    foreach ($tableNames as $table) {
                        if (!in_array($table, $selectedTables)) {
                            DB::statement("DROP TABLE IF EXISTS `$table`");
                        }
                    }
                    return true;
                }

                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error en restauración con comando MySQL: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Restaurar backup usando comando PostgreSQL desde cualquier ruta
     */
    private function restoreWithPostgreSQLCommandFromPath(string $filePath, array $selectedTables): bool
    {
        try {
            $psqlPath = exec('which psql');
            if (empty($psqlPath)) {
                Log::info("Comando psql no encontrado");
                return false;
            }

            // Si no se seleccionaron tablas, restaurar todas
            if (empty($selectedTables)) {
                $command = "psql --host=" . env('DB_HOST') .
                          " --username=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " --dbname=" . env('DB_DATABASE') .
                          " < " . escapeshellarg($filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración PostgreSQL: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando PostgreSQL: " . implode("\n", $output));
                Log::info("Código de retorno PostgreSQL: {$returnVar}");

                return $returnVar === 0;
            } else {
                // Para restauración selectiva con PostgreSQL
                $command = "psql --host=" . env('DB_HOST') .
                          " --username=" . env('DB_USERNAME') .
                          " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                          " --dbname=" . env('DB_DATABASE') .
                          " < " . escapeshellarg($filePath) . " 2>&1";

                Log::info("Ejecutando comando de restauración PostgreSQL selectiva: {$command}");
                exec($command, $output, $returnVar);

                Log::info("Salida del comando PostgreSQL selectiva: " . implode("\n", $output));
                Log::info("Código de retorno PostgreSQL selectiva: {$returnVar}");

                if ($returnVar === 0) {
                    // Eliminar tablas no seleccionadas
                    $allTables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
                    $tableNames = [];
                    foreach ($allTables as $table) {
                        $tableNames[] = $table->tablename;
                    }

                    foreach ($tableNames as $table) {
                        if (!in_array($table, $selectedTables)) {
                            DB::statement("DROP TABLE IF EXISTS \"{$table}\" CASCADE");
                        }
                    }
                    return true;
                }

                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error en restauración con comando PostgreSQL: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Restaurar backup usando PHP desde cualquier ruta (selectivo)
     */
    private function restorePhpBackupFromPath(string $filePath, array $selectedTables): array
    {
        $results = [
            'success' => true,
            'executed_statements' => 0,
            'failed_statements' => 0,
            'errors' => [],
            'warnings' => []
        ];

        if (!file_exists($filePath)) {
            throw new \Exception("Archivo de backup no encontrado: {$filePath}");
        }

        $sql = file_get_contents($filePath);
        if ($sql === false) {
            throw new \Exception("No se pudo leer el archivo de backup: {$filePath}");
        }

        Log::info("Iniciando restauración PHP selectiva del archivo: {$filePath}");
        Log::info("Tablas seleccionadas para restaurar: " . implode(', ', $selectedTables));
        Log::info("Tamaño del archivo SQL: " . strlen($sql) . " caracteres");

        // Dividir el SQL en sentencias individuales
        $allStatements = [];
        $lines = explode("\n", $sql);
        $currentStatement = '';
        $inComment = false;

        foreach ($lines as $lineNumber => $line) {
            $line = trim($line);

            // Manejar comentarios de línea
            if (strpos($line, '--') === 0) {
                continue; // Saltar comentarios de línea
            }

            // Manejar comentarios de bloque
            if (strpos($line, '/*') === 0) {
                $inComment = true;
                continue;
            }

            if ($inComment) {
                if (strpos($line, '*/') !== false) {
                    $inComment = false;
                }
                continue;
            }

            // Si la línea está vacía, continuar
            if (empty($line)) {
                continue;
            }

            $currentStatement .= $line . "\n";

            // Si la línea termina con punto y coma, es una sentencia completa
            if (substr($line, -1) === ';') {
                $statement = trim($currentStatement);
                if (!empty($statement)) {
                    $allStatements[] = $statement;
                }
                $currentStatement = '';
            }
        }

        Log::info("Total de sentencias SQL encontradas: " . count($allStatements));

        // Filtrar sentencias para solo incluir las tablas seleccionadas
        $filteredStatements = [];
        
        if (empty($selectedTables)) {
            // Si no hay tablas seleccionadas, restaurar todo
            $filteredStatements = $allStatements;
        } else {
            foreach ($allStatements as $statement) {
                $tableName = $this->extractTableNameFromStatement($statement);
                if ($tableName && in_array($tableName, $selectedTables)) {
                    $filteredStatements[] = $statement;
                }
            }
        }

        Log::info("Sentencias filtradas para restaurar: " . count($filteredStatements));
        
        // Desactivar verificación de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            // Ejecutar solo las sentencias filtradas
            foreach ($filteredStatements as $index => $statement) {
                if (empty($statement)) continue;

                try {
                    // Determinar el tipo de sentencia
                    $statementType = $this->getStatementType($statement);

                    Log::info("Ejecutando sentencia {$index} para tabla seleccionada: {$statementType}");

                    switch ($statementType) {
                        case 'CREATE TABLE':
                            DB::statement($statement);
                            Log::info("Tabla creada exitosamente");
                            break;

                        case 'INSERT':
                            DB::statement($statement);
                            Log::info("Datos insertados exitosamente");
                            break;

                        case 'DROP TABLE':
                            DB::statement($statement);
                            Log::info("Tabla eliminada exitosamente");
                            break;

                        case 'UPDATE':
                            DB::statement($statement);
                            Log::info("Datos actualizados exitosamente");
                            break;

                        case 'DELETE':
                            DB::statement($statement);
                            Log::info("Datos eliminados exitosamente");
                            break;

                        case 'ALTER TABLE':
                            DB::statement($statement);
                            Log::info("Tabla modificada exitosamente");
                            break;

                        case 'TRUNCATE TABLE':
                            DB::statement($statement);
                            Log::info("Tabla truncada exitosamente");
                            break;

                        case 'REPLACE INTO':
                            DB::statement($statement);
                            Log::info("Datos reemplazados exitosamente");
                            break;

                        case 'SET':
                            DB::statement($statement);
                            Log::info("Configuración aplicada exitosamente");
                            break;

                        case 'LOCK TABLES':
                            DB::statement($statement);
                            Log::info("Tablas bloqueadas exitosamente");
                            break;

                        case 'UNLOCK TABLES':
                            DB::statement($statement);
                            Log::info("Tablas desbloqueadas exitosamente");
                            break;

                        default:
                            // Para otras sentencias, intentar ejecutar
                            DB::statement($statement);
                            Log::info("Sentencia ejecutada: " . substr($statementType, 0, 50) . "...");
                            break;
                    }

                    $results['executed_statements']++;

                } catch (\Exception $e) {
                    $error = "Error en sentencia {$index}: " . $e->getMessage() . " | SQL: " . substr($statement, 0, 100) . "...";
                    $results['errors'][] = $error;
                    $results['failed_statements']++;
                    Log::error($error);

                    // Si es un error de tabla que ya existe, intentar con IF NOT EXISTS
                    if (stripos($e->getMessage(), 'already exists') !== false && stripos($statement, 'CREATE TABLE') === 0) {
                        Log::warning("Intentando crear tabla con IF NOT EXISTS");
                        try {
                            $modifiedStatement = preg_replace('/^CREATE TABLE /i', 'CREATE TABLE IF NOT EXISTS ', $statement);
                            DB::statement($modifiedStatement);
                            $results['executed_statements']++;
                            $results['warnings'][] = "Tabla ya existía, se creó con IF NOT EXISTS";
                            Log::info("Tabla creada con IF NOT EXISTS");
                        } catch (\Exception $e2) {
                            $results['errors'][] = "Error incluso con IF NOT EXISTS: " . $e2->getMessage();
                            Log::error("Error con IF NOT EXISTS: " . $e2->getMessage());
                        }
                    }
                }
            }
        } finally {
            // Reactivar verificación de claves foráneas
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        Log::info("Restauración selectiva completada. Ejecutadas: {$results['executed_statements']}, Fallidas: {$results['failed_statements']}");

        return $results;
    }

    /**
     * Restaurar backup desde archivos CSV
     */
    public function restoreCsvBackup(Request $request): RedirectResponse
    {
        $request->validate([
            'backup_path' => 'required|string',
            'tables' => 'nullable|array',
            'tables.*' => 'string',
            'truncate_tables' => 'nullable|boolean',
            'skip_errors' => 'nullable|boolean',
            'validate_data' => 'nullable|boolean',
        ]);

        try {
            $backupPath = $request->backup_path;
            $selectedTables = $request->tables;
            $truncateTables = $request->boolean('truncate_tables', true);
            $skipErrors = $request->boolean('skip_errors', false);
            $validateData = $request->boolean('validate_data', true);

            // Verificar que el directorio existe
            if (!file_exists($backupPath) || !is_dir($backupPath)) {
                return back()->with('error', 'El directorio de backup no existe o no es accesible.');
            }

            // Verificar que existe el archivo de metadatos
            $metadataFile = $backupPath . '/metadata.json';
            if (!file_exists($metadataFile)) {
                return back()->with('error', 'No se encontró el archivo de metadatos del backup CSV.');
            }

            $metadata = json_decode(file_get_contents($metadataFile), true);
            if (!$metadata) {
                return back()->with('error', 'No se pudo leer el archivo de metadatos del backup CSV.');
            }

            // Si no se especificaron tablas, restaurar todas
            if (empty($selectedTables)) {
                $csvFiles = glob($backupPath . '/*.csv');
                foreach ($csvFiles as $csvFile) {
                    $tableName = basename($csvFile, '.csv');
                    if ($tableName !== 'metadata') {
                        $selectedTables[] = $tableName;
                    }
                }
            }

            Log::info("Iniciando restauración CSV desde: {$backupPath}");
            Log::info("Tablas seleccionadas: " . implode(', ', $selectedTables));

            $results = [
                'success' => true,
                'imported_tables' => 0,
                'total_records' => 0,
                'errors' => [],
                'warnings' => [],
                'processed_tables' => [],
                'failed_tables' => []
            ];

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Procesar cada tabla seleccionada
            foreach ($selectedTables as $index => $tableName) {
                $csvFile = $backupPath . '/' . $tableName . '.csv';

                if (!file_exists($csvFile)) {
                    $error = "Archivo CSV no encontrado para la tabla: {$tableName}";
                    $results['errors'][] = $error;
                    $results['failed_tables'][] = $tableName;
                    Log::error($error);
                    if (!$skipErrors) {
                        return back()->with('error', $error);
                    }
                    continue;
                }

                try {
                    // Obtener estructura de la tabla si existe
                    $tableExists = false;
                    try {
                        $columns = DB::select("DESCRIBE `{$tableName}`");
                        $tableExists = true;
                        Log::info("Tabla {$tableName} existe, obteniendo estructura");
                    } catch (\Exception $e) {
                        Log::info("Tabla {$tableName} no existe, se creará automáticamente");
                    }

                    // Si la tabla existe y se pidió truncar, vaciarla
                    if ($tableExists && $truncateTables) {
                        DB::statement("TRUNCATE TABLE `{$tableName}`");
                        Log::info("Tabla {$tableName} truncada");
                    }

                    // Importar datos desde CSV
                    $importResult = $this->importCsvToTable($csvFile, $tableName, $tableExists, $validateData, $skipErrors);

                    $results['imported_tables']++;
                    $results['total_records'] += $importResult['records'];
                    $results['processed_tables'][] = [
                        'name' => $tableName,
                        'records' => $importResult['records'],
                        'status' => 'success'
                    ];

                    if (!empty($importResult['warnings'])) {
                        $results['warnings'] = array_merge($results['warnings'], $importResult['warnings']);
                    }

                    Log::info("Tabla {$tableName} importada con {$importResult['records']} registros");

                } catch (\Exception $e) {
                    $error = "Error importando tabla {$tableName}: " . $e->getMessage();
                    $results['errors'][] = $error;
                    $results['failed_tables'][] = $tableName;
                    $results['processed_tables'][] = [
                        'name' => $tableName,
                        'records' => 0,
                        'status' => 'error',
                        'error' => $e->getMessage()
                    ];
                    Log::error($error);
                    if (!$skipErrors) {
                        return back()->with('error', $error);
                    }
                }
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Preparar mensaje de respuesta detallado
            $message = $this->generateCsvRestoreMessage($results, $metadata);

            // Determinar el tipo de respuesta basado en los resultados
            if ($results['imported_tables'] > 0 && empty($results['errors'])) {
                // Éxito completo
                return redirect()->route('database.index')->with('success', $message);
            } elseif ($results['imported_tables'] > 0 && !empty($results['errors'])) {
                // Éxito parcial
                return redirect()->route('database.index')->with('warning', $message);
            } else {
                // Fallo completo
                return back()->with('error', $message);
            }

        } catch (\Exception $e) {
            // Asegurarse de reactivar los foreign key checks en caso de error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Log::error("Error en restauración CSV: " . $e->getMessage());
            return back()->with('error', 'Error al restaurar backup CSV: ' . $e->getMessage());
        }
    }

    /**
     * Generar mensaje detallado de restauración CSV
     */
    private function generateCsvRestoreMessage(array $results, array $metadata): string
    {
        $message = "";

        if ($results['imported_tables'] > 0) {
            $message .= "✅ Restauración CSV completada exitosamente.\n\n";
            $message .= "📊 Resumen de la restauración:\n";
            $message .= "• Tablas importadas: {$results['imported_tables']}\n";
            $message .= "• Total de registros: " . number_format($results['total_records']) . "\n";
            $message .= "• Backup: {$metadata['backup_name']}\n";
            $message .= "• Creado: " . date('d/m/Y H:i:s', strtotime($metadata['created_at'])) . "\n\n";

            $message .= "📋 Detalle por tabla:\n";
            foreach ($results['processed_tables'] as $table) {
                if ($table['status'] === 'success') {
                    $message .= "• ✅ {$table['name']}: " . number_format($table['records']) . " registros\n";
                } else {
                    $message .= "• ❌ {$table['name']}: Error - {$table['error']}\n";
                }
            }

            if (!empty($results['warnings'])) {
                $message .= "\n⚠️ Advertencias (" . count($results['warnings']) . "):\n";
                foreach (array_slice($results['warnings'], 0, 3) as $warning) {
                    $message .= "• {$warning}\n";
                }
                if (count($results['warnings']) > 3) {
                    $message .= "• ... y " . (count($results['warnings']) - 3) . " más\n";
                }
            }
        }

        if (!empty($results['errors'])) {
            $message .= "\n❌ Errores encontrados (" . count($results['errors']) . "):\n";
            foreach (array_slice($results['errors'], 0, 3) as $error) {
                $message .= "• {$error}\n";
            }
            if (count($results['errors']) > 3) {
                $message .= "• ... y " . (count($results['errors']) - 3) . " más\n";
            }
            $message .= "\nRevisa los logs del sistema para más detalles.";
        }

        return $message;
    }

    /**
     * Generar mensaje detallado de restauración SQL
     */
    private function generateSqlRestoreMessage(array $results, string $type = 'Completa'): string
    {
        $message = "";

        if ($results['executed_statements'] > 0) {
            $statusIcon = !empty($results['errors']) ? '⚠️' : '✅';
            $message .= "{$statusIcon} Restauración SQL {$type} finalizada.\n\n";
            $message .= "📊 Resumen de la restauración:\n";
            $message .= "• Sentencias ejecutadas: {$results['executed_statements']}\n";
            
            if ($results['failed_statements'] > 0) {
                $message .= "• Sentencias fallidas: {$results['failed_statements']}\n";
            }

            if (!empty($results['warnings'])) {
                $message .= "\n⚠️ Advertencias (" . count($results['warnings']) . "):\n";
                foreach (array_slice($results['warnings'], 0, 3) as $warning) {
                    $message .= "• {$warning}\n";
                }
                if (count($results['warnings']) > 3) {
                    $message .= "• ... y " . (count($results['warnings']) - 3) . " más\n";
                }
            }
        }

        if (!empty($results['errors'])) {
            $message .= "\n❌ Errores encontrados (" . count($results['errors']) . "):\n";
            foreach (array_slice($results['errors'], 0, 3) as $error) {
                $message .= "• {$error}\n";
            }
            if (count($results['errors']) > 3) {
                $message .= "• ... y " . (count($results['errors']) - 3) . " más\n";
            }
            $message .= "\nRevisa los logs del sistema para más detalles.";
        }

        if (empty($message)) {
            return "No se ejecutaron sentencias. El archivo podría estar vacío o no contener SQL válido.";
        }

        return $message;
    }

    /**
     * Importar datos desde archivo CSV a una tabla
     */
    private function importCsvToTable(string $csvFile, string $tableName, bool $tableExists, bool $validateData, bool $skipErrors = false): array
    {
        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            throw new \Exception("No se pudo abrir el archivo CSV: {$csvFile}");
        }

        $result = [
            'records' => 0,
            'warnings' => []
        ];

        // Leer encabezados
        $headers = fgetcsv($handle);
        if ($headers === false) {
            fclose($handle);
            throw new \Exception("No se pudieron leer los encabezados del archivo CSV");
        }

        // Limpiar encabezados (quitar espacios y caracteres especiales)
        $headers = array_map('trim', $headers);
        $headers = array_map(function($header) {
            return preg_replace('/[^A-Za-z0-9_]/', '', $header);
        }, $headers);

        // Si la tabla no existe, crearla automáticamente
        if (!$tableExists) {
            $this->createTableFromCsvHeaders($tableName, $headers);
            Log::info("Tabla {$tableName} creada automáticamente");
        }

        // Obtener información de columnas de la tabla
        $columnsInfo = [];
        try {
            $columns = DB::select("DESCRIBE `{$tableName}`");
            foreach ($columns as $col) {
                $columnsInfo[$col->Field] = [
                    'type' => $col->Type,
                    'null' => $col->Null,
                    'key' => $col->Key,
                    'default' => $col->Default,
                    'extra' => $col->Extra
                ];
            }
        } catch (\Exception $e) {
            throw new \Exception("No se pudo obtener la estructura de la tabla {$tableName}: " . $e->getMessage());
        }

        // Si la tabla existe y se pidió truncar, vaciarla
        if ($tableExists) {
            try {
                DB::statement("TRUNCATE TABLE `{$tableName}`");
                Log::info("Tabla {$tableName} truncada antes de importar");
            } catch (\Exception $e) {
                Log::warning("No se pudo truncar la tabla {$tableName}: " . $e->getMessage());
            }
        }

        // Procesar cada fila del CSV
        $lineNumber = 1;
        while (($row = fgetcsv($handle)) !== false) {
            $lineNumber++;

            try {
                // Preparar datos para insertar
                $data = [];
                foreach ($headers as $index => $header) {
                    $value = $row[$index] ?? '';

                    // Validar y convertir el valor según el tipo de columna
                    if (isset($columnsInfo[$header])) {
                        $value = $this->convertValueForColumn($value, $columnsInfo[$header], $validateData);
                    }

                    $data[$header] = $value;
                }

                // Insertar registro
                DB::table($tableName)->insert($data);
                $result['records']++;

            } catch (\Exception $e) {
                $warning = "Error en fila {$lineNumber} de {$tableName}: " . $e->getMessage();
                $result['warnings'][] = $warning;
                Log::warning($warning);

                if (!$skipErrors) {
                    throw $e;
                }
            }
        }

        fclose($handle);
        return $result;
    }

    /**
     * Crear tabla automáticamente desde encabezados CSV
     */
    private function createTableFromCsvHeaders(string $tableName, array $headers): void
    {
        $sql = "CREATE TABLE `{$tableName}` (";

        $columns = [];
        foreach ($headers as $header) {
            // Crear columnas como VARCHAR por defecto
            $columns[] = "`{$header}` VARCHAR(255) NULL";
        }

        $sql .= implode(', ', $columns);
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        DB::statement($sql);
    }

    /**
     * Convertir valor según el tipo de columna
     */
    private function convertValueForColumn($value, array $columnInfo, bool $validateData)
    {
        // Si el valor está vacío y la columna acepta NULL, devolver NULL
        if ($value === '' && strtoupper($columnInfo['null']) === 'YES') {
            return null;
        }

        // Convertir según el tipo de columna
        $type = strtoupper($columnInfo['type']);

        if (strpos($type, 'INT') !== false || strpos($type, 'TINYINT') !== false || strpos($type, 'SMALLINT') !== false || strpos($type, 'BIGINT') !== false) {
            return $value === '' ? 0 : (int) $value;
        } elseif (strpos($type, 'DECIMAL') !== false || strpos($type, 'FLOAT') !== false || strpos($type, 'DOUBLE') !== false) {
            return $value === '' ? 0.0 : (float) $value;
        } elseif (strpos($type, 'BOOLEAN') !== false || strpos($type, 'BOOL') !== false) {
            return $value === '' ? false : (bool) $value;
        } elseif (strpos($type, 'DATE') !== false) {
            return $value === '' ? null : date('Y-m-d', strtotime($value));
        } elseif (strpos($type, 'DATETIME') !== false || strpos($type, 'TIMESTAMP') !== false) {
            return $value === '' ? null : date('Y-m-d H:i:s', strtotime($value));
        } else {
            // Para VARCHAR, TEXT, etc., mantener como string
            return $value;
        }
    }
}
