<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-database me-2"></i>{{ __('Gestión de Base de Datos') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            {{-- Información del sistema para debugging --}}
            @if(isset($systemInfo))
                @if(isset($systemInfo['error']))
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                            <div>
                                <h6 class="mb-1">Error de Conexión</h6>
                                <p class="mb-0 small">{{ $systemInfo['error'] }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-info-circle-fill text-info me-3 fs-5"></i>
                                <div>
                                    <h6 class="mb-2">Información del Sistema</h6>
                                    <div class="row g-2 small">
                                        <div class="col-md-6"><strong>Conexión:</strong> {{ $systemInfo['database_connection'] }}</div>
                                        <div class="col-md-6"><strong>Laravel:</strong> {{ $systemInfo['laravel_version'] }}</div>
                                        <div class="col-md-6"><strong>PHP:</strong> {{ $systemInfo['php_version'] }}</div>
                                        <div class="col-md-6"><strong>Directorio de backups:</strong> {{ $systemInfo['backup_directory'] }}</div>
                                        <div class="col-md-6">
                                            <strong>Directorio existe:</strong>
                                            @if($systemInfo['backup_directory_exists'])
                                                <i class="bi bi-check-circle-fill text-success"></i> Sí
                                            @else
                                                <i class="bi bi-x-circle-fill text-danger"></i> No
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Directorio escribible:</strong>
                                            @if($systemInfo['backup_directory_writable'])
                                                <i class="bi bi-check-circle-fill text-success"></i> Sí
                                            @else
                                                <i class="bi bi-x-circle-fill text-danger"></i> No
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-table me-2"></i>Contenido de la Base de Datos</h5>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        @forelse($tableNames as $table)
                            <div class="col">
                                <div class="card h-100 bg-body-secondary">
                                    <div class="card-body py-3">
                                        <h6 class="card-title mb-1"><i class="bi bi-grid me-2"></i>{{ $table }}</h6>
                                        <p class="card-text small text-secondary mb-0">Tabla de datos</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @if(!isset($systemInfo['error']))
                                <div class="col-12">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        No se encontraron tablas en la base de datos. Verifique la conexión y asegúrese de que la base de datos no esté vacía.
                                    </div>
                                </div>
                            @endif
                        @endforelse
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
                            <a href="{{ route('database.backup_form') }}" class="btn btn-primary w-100">
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
                            <a href="{{ route('database.restore_form') }}" class="btn btn-success w-100">
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
                            <a href="{{ route('database.delete_form') }}" class="btn btn-danger w-100">
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
                            <a href="{{ route('database.test_csv') }}" class="btn btn-purple w-100">
                                <i class="bi bi-play-fill me-1"></i>Probar CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mostrar backups recientes --}}
            @php
                $recentBackups = array_slice(array_filter($tableNames, function($table) {
                    return str_contains($table, 'backup') || str_contains($table, 'respaldo');
                }), 0, 5);
            @endphp

            @if(!empty($recentBackups))
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Backups recientes disponibles</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            @foreach($recentBackups as $backup)
                                <div class="col">
                                    <div class="card h-100 bg-body-secondary">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h6 class="card-title mb-0">{{ $backup }}</h6>
                                                <span class="badge bg-primary">
                                                    @if(str_contains($backup, 'csv'))
                                                        <i class="bi bi-file-earmark-spreadsheet me-1"></i>CSV
                                                    @else
                                                        <i class="bi bi-database me-1"></i>SQL
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="card-text small text-secondary mb-0">Backup de base de datos</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
