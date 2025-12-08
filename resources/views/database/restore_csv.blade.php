<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-file-earmark-spreadsheet me-2"></i>{{ __('Restaurar Backup CSV de Base de Datos') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            {{-- Mostrar mensajes de éxito o error de la sesión --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <div class="d-flex">
                        <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Restauración Exitosa</h6>
                            <div class="small">{{ session('success') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mb-4">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Restauración Parcial</h6>
                            <div class="small">{{ session('warning') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <div class="d-flex">
                        <i class="bi bi-x-circle-fill me-3 fs-5"></i>
                        <div>
                            <h6 class="mb-1">Error en la Restauración</h6>
                            <div class="small">{{ session('error') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    {{-- Información del backup CSV --}}
                    <div class="alert alert-success mb-4">
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                            <div>
                                <h6 class="mb-1">Backup CSV seleccionado: {{ $backupName }}</h6>
                                <p class="mb-0 small">Se encontró un backup CSV con {{ count($backupTables) }} tablas y {{ number_format($backupInfo['total_records'] ?? 0) }} registros totales.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Información del backup --}}
                    @if(isset($backupInfo))
                        <div class="card bg-body-secondary mb-4">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="bi bi-bar-chart me-1"></i>Información del backup CSV</h6>
                                <div class="row g-2 small">
                                    <div class="col-md-4"><strong>Nombre del backup:</strong> {{ $backupInfo['backup_name'] ?? $backupName }}</div>
                                    <div class="col-md-4"><strong>Creado:</strong> {{ isset($backupInfo['created_at']) ? date('Y-m-d H:i:s', strtotime($backupInfo['created_at'])) : 'N/A' }}</div>
                                    <div class="col-md-4"><strong>Total de registros:</strong> {{ number_format($backupInfo['total_records'] ?? 0) }}</div>
                                    <div class="col-md-4"><strong>Tablas:</strong> {{ count($backupTables) }}</div>
                                    <div class="col-md-4"><strong>Formato:</strong> CSV (Archivos separados por tabla)</div>
                                    <div class="col-md-4"><strong>Versión de Laravel:</strong> {{ $backupInfo['laravel_version'] ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Comparación de tablas --}}
                    @if(isset($tableComparison))
                        <div class="card bg-body-secondary mb-4">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="bi bi-search me-1"></i>Análisis de tablas</h6>
                                <div class="row g-3">
                                    @if(count($tableComparison['exist_in_current']) > 0)
                                        <div class="col-md-3">
                                            <div class="card bg-success bg-opacity-25 border-success h-100">
                                                <div class="card-body text-center">
                                                    <div class="fw-semibold text-success"><i class="bi bi-check-circle-fill"></i> Tablas existentes</div>
                                                    <div class="fs-4 fw-bold text-success">{{ count($tableComparison['exist_in_current']) }}</div>
                                                    <div class="extra-small text-muted">Se sobrescribirán</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(count($tableComparison['missing_in_current']) > 0)
                                        <div class="col-md-3">
                                            <div class="card bg-primary bg-opacity-25 border-primary h-100">
                                                <div class="card-body text-center">
                                                    <div class="fw-semibold text-primary">🆕 Tablas nuevas</div>
                                                    <div class="fs-4 fw-bold text-primary">{{ count($tableComparison['missing_in_current']) }}</div>
                                                    <div class="extra-small text-muted">Se crearán</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(count($tableComparison['exist_in_migrations']) > 0)
                                        <div class="col-md-3">
                                            <div class="card bg-warning bg-opacity-25 border-warning h-100">
                                                <div class="card-body text-center">
                                                    <div class="fw-semibold text-warning"><i class="bi bi-clipboard"></i> En migraciones</div>
                                                    <div class="fs-4 fw-bold text-warning">{{ count($tableComparison['exist_in_migrations']) }}</div>
                                                    <div class="extra-small text-muted">Tablas estándar</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(count($tableComparison['missing_in_migrations']) > 0)
                                        <div class="col-md-3">
                                            <div class="card border-purple h-100" style="background-color: rgba(139, 92, 246, 0.15); border-color: #8b5cf6 !important;">
                                                <div class="card-body text-center">
                                                    <div class="fw-semibold" style="color: #a78bfa;"><i class="bi bi-tools me-1"></i> Tablas personalizadas</div>
                                                    <div class="fs-4 fw-bold" style="color: #a78bfa;">{{ count($tableComparison['missing_in_migrations']) }}</div>
                                                    <div class="extra-small text-muted">No en migraciones</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Formulario de restauración --}}
                    <form method="POST" action="{{ route('database.restore_csv_backup') }}" id="csv-restore-form">
                        @csrf
                        <input type="hidden" name="backup_path" value="{{ $backupPath }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {{-- Indicador de progreso --}}
                        <div id="restore-progress" class="mb-4 d-none">
                            <div class="card bg-body-secondary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="spinner-border spinner-border-sm text-primary me-3" role="status"></div>
                                        <div>
                                            <h6 class="mb-0"><i class="bi bi-arrow-repeat me-1"></i> Restaurando datos...</h6>
                                            <div class="small text-muted" id="progress-text">Iniciando restauración...</div>
                                        </div>
                                    </div>
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div class="extra-small text-muted">
                                        <span id="progress-counter">0</span> de <span id="progress-total">{{ count($backupTables) }}</span> tablas procesadas
                                    </div>
                                    <div id="progress-log" class="mt-3 bg-dark rounded p-2 small font-monospace text-light" style="max-height: 120px; overflow-y: auto;">
                                        <div id="log-content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mb-4">
                            <h6><i class="bi bi-info-circle me-1"></i>Información importante</h6>
                            <p class="mb-0 small">Estas son las tablas que se encontraron en el backup CSV. La restauración importará los datos desde los archivos CSV correspondientes.</p>
                        </div>

                        <h5 class="mb-3">Tablas disponibles en el backup CSV</h5>

                        @if(count($backupTables) > 0)
                            <div class="alert alert-warning mb-4">
                                <h6><i class="bi bi-exclamation-triangle me-1"></i>Advertencia</h6>
                                <p class="mb-0 small">La restauración desde CSV sobrescribirá los datos existentes en las tablas seleccionadas. Se recomienda hacer un backup antes de proceder.</p>
                            </div>

                            <div class="mb-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="restore_all" id="restore_all_csv" class="form-check-input" checked onchange="toggleCsvTableSelection()">
                                    <label class="form-check-label fw-semibold" for="restore_all_csv">Restaurar todas las tablas ({{ count($backupTables) }} tablas)</label>
                                </div>

                                <div id="csv_table_selection">
                                    <p class="small text-muted mb-3">O selecciona tablas específicas:</p>
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" style="max-height: 400px; overflow-y: auto;">
                                        @foreach($backupTables as $table)
                                            @php
                                                $isNew = in_array($table, $tableComparison['missing_in_current'] ?? []);
                                                $exists = in_array($table, $tableComparison['exist_in_current'] ?? []);
                                                $inMigrations = in_array($table, $tableComparison['exist_in_migrations'] ?? []);
                                            @endphp
                                            <div class="col">
                                                <label class="card h-100 {{ $isNew ? 'border-primary bg-primary bg-opacity-10' : ($exists ? 'border-success bg-success bg-opacity-10' : '') }}" style="cursor: pointer;">
                                                    <div class="card-body py-2">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="tables[]" value="{{ $table }}" class="form-check-input" checked>
                                                            <label class="form-check-label">
                                                                <span class="font-monospace small">{{ $table }}</span>
                                                                <div class="mt-1">
                                                                    @if($isNew)
                                                                        <span class="badge bg-primary-subtle text-primary-emphasis">🆕 Nueva</span>
                                                                    @elseif($exists)
                                                                        <span class="badge bg-success-subtle text-success-emphasis"><i class="bi bi-check-circle-fill"></i> Existe</span>
                                                                    @endif
                                                                    @if($inMigrations)
                                                                        <span class="badge bg-warning-subtle text-warning-emphasis"><i class="bi bi-clipboard"></i> Migración</span>
                                                                    @endif
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h6><i class="bi bi-x-circle me-1"></i>No se encontraron tablas</h6>
                                <p class="mb-0 small">No se detectaron tablas válidas en el backup CSV. Verifica que el directorio contenga archivos CSV válidos.</p>
                            </div>
                        @endif

                        {{-- Opciones de restauración --}}
                        @if(count($backupTables) > 0)
                            <div class="card bg-body-secondary mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><i class="bi bi-gear me-1"></i>Opciones de restauración</h6>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="truncate_tables" value="1" class="form-check-input" id="truncate_tables" checked>
                                        <label class="form-check-label" for="truncate_tables">Vaciar tablas antes de importar (TRUNCATE)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="skip_errors" value="1" class="form-check-input" id="skip_errors">
                                        <label class="form-check-label" for="skip_errors">Continuar en caso de errores (no detener la importación)</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="validate_data" value="1" class="form-check-input" id="validate_data" checked>
                                        <label class="form-check-label" for="validate_data">Validar datos antes de importar</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('database.restore_form') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Volver a seleccionar archivo
                            </a>
                            @if(count($backupTables) > 0)
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres restaurar las tablas seleccionadas desde el backup CSV? Esta acción sobrescribirá los datos existentes.')">
                                    <i class="bi bi-upload me-1"></i>Restaurar desde CSV
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleCsvTableSelection() {
            const restoreAll = document.getElementById('restore_all_csv');
            const tableSelection = document.getElementById('csv_table_selection');

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

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="tables[]"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const restoreAll = document.getElementById('restore_all_csv');
                    if (!this.checked) {
                        restoreAll.checked = false;
                    }
                });
            });
        });

        document.getElementById('csv-restore-form')?.addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="tables[]"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Por favor selecciona al menos una tabla para restaurar.');
                return false;
            }

            if (!confirm('¿Estás seguro de que quieres restaurar las ' + checkboxes.length + ' tablas seleccionadas desde el backup CSV? Esta acción sobrescribirá los datos existentes.')) {
                e.preventDefault();
                return false;
            }

            showRestoreProgress();
            return true;
        });

        function showRestoreProgress() {
            const progressDiv = document.getElementById('restore-progress');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            const progressCounter = document.getElementById('progress-counter');
            const progressTotal = document.getElementById('progress-total');
            const logContent = document.getElementById('log-content');

            document.getElementById('csv-restore-form').style.display = 'none';
            progressDiv.classList.remove('d-none');

            const totalTables = document.querySelectorAll('input[name="tables[]"]:checked').length;
            progressTotal.textContent = totalTables;
            progressCounter.textContent = '0';
            progressBar.style.width = '0%';
            progressText.textContent = 'Iniciando restauración...';
            logContent.innerHTML = '<div class="text-info"><i class="bi bi-rocket-takeoff me-1"></i> Iniciando proceso de restauración...</div>';

            let currentProgress = 0;
            const progressInterval = setInterval(() => {
                currentProgress += Math.random() * 15;
                if (currentProgress > 90) currentProgress = 90;

                const progressPercent = Math.round(currentProgress);
                progressBar.style.width = progressPercent + '%';
                progressCounter.textContent = Math.round((progressPercent / 100) * totalTables);

                if (progressPercent < 30) {
                    progressText.textContent = 'Analizando archivos CSV...';
                } else if (progressPercent < 60) {
                    progressText.textContent = 'Importando datos...';
                } else {
                    progressText.textContent = 'Finalizando restauración...';
                }
            }, 500);
        }
    </script>
</x-app-layout>
