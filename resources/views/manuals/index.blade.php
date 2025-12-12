<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">
            <i class="bi bi-book"></i> Manuales de Usuario
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row g-4">
                @foreach($availableManuals as $manual)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('manual.show', $manual['type']) }}" class="text-decoration-none">
                            <div class="card h-100 hover-lift" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="bi {{ $manual['icon'] }} display-4" style="color: var(--color-primary);"></i>
                                    </div>
                                    <h3 class="h5 mb-3 fw-semibold">{{ $manual['title'] }}</h3>
                                    <p class="text-muted mb-3">{{ $manual['description'] }}</p>
                                    <span class="btn btn-sm btn-outline-primary">
                                        Ver Manual <i class="bi bi-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-info-circle fs-4" style="color: var(--color-primary);"></i>
                        <div>
                            <h5 class="fw-semibold mb-2">Información</h5>
                            <p class="mb-0 text-muted">
                                Los manuales están diseñados según tu rol en el sistema. 
                                Si tienes dudas sobre alguna función específica, consulta el manual correspondiente o contacta a tu supervisor.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
