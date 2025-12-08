<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Servicios</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('services.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Alta de Servicio
                    </a>
                </div>
            @endif

            @include('components.alerts')

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                @foreach($services as $service)
                    <div class="col">
                        <div class="card h-100 position-relative {{ $service->trashed() ? 'opacity-50' : '' }}">
                            @if (!$service->is_active)
                                <span class="position-absolute top-0 end-0 m-1 badge bg-danger" style="font-size: 0.6rem;">Inactivo</span>
                            @endif
                            @if ($service->trashed())
                                <span class="position-absolute top-0 start-0 m-1 badge bg-secondary" style="font-size: 0.6rem;">Eliminado</span>
                            @endif
                            <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}" class="card-img-top" style="height: 100px; object-fit: contain; background: rgba(255,255,255,0.05);">
                            <div class="card-body p-2 d-flex flex-column align-items-center text-center">
                                <h6 class="card-title fw-semibold text-body-emphasis mb-1 small">{{ Str::limit($service->name, 20) }}</h6>
                                <p class="text-body-secondary extra-small mb-0">{{ $service->service_id }}</p>
                                <p class="text-body-tertiary extra-small mb-0">{{ Str::limit($service->description, 25) }}</p>
                                <p class="fw-semibold text-body-secondary extra-small mb-0">{{ $service->duration_minutes }} min</p>
                                <p class="fw-bold text-body-emphasis small mb-0">${{ number_format($service->price, 2) }}</p>

                                <div class="mt-2 d-flex flex-wrap gap-1 justify-content-center">
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'supervisor')
                                        @if ($service->trashed())
                                            <form action="{{ route('services.restore', $service->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm py-0 px-1" title="Restaurar">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('services.edit', $service) }}" class="btn btn-success btn-sm py-0 px-1" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('services.toggleStatus', $service) }}" method="POST" onsubmit="return confirm('¿Cambiar estado?');" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn {{ $service->is_active ? 'btn-warning' : 'btn-primary' }} btn-sm py-0 px-1" title="{{ $service->is_active ? 'Inhabilitar' : 'Habilitar' }}">
                                                    <i class="bi {{ $service->is_active ? 'bi-pause' : 'bi-play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('services.destroy', $service) }}" method="POST" onsubmit="return confirm('¿Eliminar servicio?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm py-0 px-1" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
