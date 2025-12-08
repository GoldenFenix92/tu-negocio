<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-file-earmark-code me-2"></i>{{ __('Analizar Contenido de Backup SQL') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    {{-- Información del backup --}}
                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                            <div>
                                <h6 class="mb-1">Backup SQL seleccionado: {{ $fileName }}</h6>
                                <p class="mb-0 small">Se encontró un backup SQL con {{ count($backupTables) }} tablas.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Formulario de restauración --}}
                    <form method="POST" action="{{ route('database.restore_backup') }}" id="sql-restore-form">
                        @csrf
                        <input type="hidden" name="server_file_path" value="{{ $filePath }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="alert alert-warning mb-4">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
                                <div>
                                    <h6 class="mb-1">Advertencia</h6>
                                    <p class="mb-0 small">La restauración desde SQL sobrescribirá los datos existentes en las tablas seleccionadas. Se recomienda hacer un backup antes de proceder.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" name="restore_all" id="restore_all_sql" class="form-check-input" onchange="toggleSqlTableSelection()">
                                <label class="form-check-label fw-semibold" for="restore_all_sql">Restaurar todas las tablas ({{ count($backupTables) }} tablas)</label>
                            </div>

                            <div id="sql_table_selection" style="display: none;">
                                <p class="small text-muted mb-3">O selecciona tablas específicas:</p>
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($backupTables as $table)
                                        <div class="col">
                                            <label class="card h-100" style="cursor: pointer;">
                                                <div class="card-body py-2">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="tables[]" value="{{ $table }}" class="form-check-input">
                                                        <label class="form-check-label font-monospace small">{{ $table }}</label>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('database.restore_form') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Volver a seleccionar archivo
                            </a>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres restaurar las tablas seleccionadas desde el backup SQL? Esta acción sobrescribirá los datos existentes.')">
                                <i class="bi bi-upload me-1"></i>Restaurar desde SQL
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSqlTableSelection() {
            const restoreAll = document.getElementById('restore_all_sql');
            const tableSelection = document.getElementById('sql_table_selection');
            const checkboxes = document.querySelectorAll('input[name="tables[]"]');

            if (restoreAll.checked) {
                tableSelection.style.display = 'none';
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    checkbox.disabled = true;
                });
            } else {
                tableSelection.style.display = 'block';
                checkboxes.forEach(checkbox => {
                    checkbox.disabled = false;
                    checkbox.checked = true;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('restore_all_sql').checked = true;
            toggleSqlTableSelection();

            document.querySelectorAll('input[name="tables[]"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const restoreAll = document.getElementById('restore_all_sql');
                    if (!this.checked) {
                        restoreAll.checked = false;
                    }
                });
            });
        });
    </script>
</x-app-layout>
