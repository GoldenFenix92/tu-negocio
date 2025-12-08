{{-- Componente de alertas Bootstrap reutilizable --}}
{{-- Uso: @include('components.alerts') o <x-alerts /> --}}

{{-- Contenedor de alertas dinámicas (JavaScript) --}}
<div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1100; max-width: 450px;"></div>

{{-- Alertas de sesión Laravel --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-check-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Éxito!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-x-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Error!</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Atención!</strong> {{ session('warning') }}
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                {{ session('info') }}
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

{{-- Errores de validación --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-x-circle-fill me-2 mt-1"></i>
            <div class="flex-grow-1">
                <strong>¡Error de validación!</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
