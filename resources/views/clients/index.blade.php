<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Clientes</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Alta de Cliente
                </a>
            </div>

            @include('components.alerts')

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($clients as $client)
                    <div class="col">
                        <div class="card h-100 {{ $client->trashed() ? 'opacity-50' : '' }}">
                            <img src="{{ $client->imageUrl() }}" alt="{{ $client->name }}" class="card-img-top" style="height: 160px; object-fit: cover;">
                            <div class="card-body d-flex flex-column align-items-center text-center">
                                <h5 class="card-title fw-semibold text-body-emphasis mb-1">{{ $client->name }} {{ $client->paternal_lastname }} {{ $client->maternal_lastname }}</h5>
                                <p class="text-body-secondary small mb-1">{{ $client->phone }}</p>
                                <p class="text-body-tertiary extra-small mb-1">{{ $client->email }}</p>
                                <p class="text-body-tertiary extra-small font-monospace mb-1">{{ $client->eight_digit_barcode }}</p>
                                <p class="text-body-tertiary extra-small mb-1">ID: {{ $client->id }}</p>
                                <div class="mt-2">
                                    @if($client->trashed())
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">Inhabilitado</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Activo</span>
                                    @endif
                                </div>

                                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                                    @if(!$client->trashed())
                                        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('¿Inhabilitar cliente?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle me-1"></i>Inhabilitar
                                            </button>
                                        </form>
                                        @if($client->image && $client->image !== 'clients/cliente_comodin.webp')
                                            <form action="{{ route('clients.destroyImage', $client) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-image me-1"></i>Borrar Imagen
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('clients.restore', $client->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
