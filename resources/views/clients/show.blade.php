<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Detalles del Cliente') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">{{ __('Información del Cliente') }}</h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card bg-body-secondary">
                                <div class="card-body">
                                    <h6 class="mb-3">{{ __('Datos Personales') }}</h6>
                                    <p class="mb-2"><strong class="text-secondary">{{ __('Nombre') }}:</strong> {{ $client->name }}</p>
                                    <p class="mb-2"><strong class="text-secondary">{{ __('Apellido Paterno') }}:</strong> {{ $client->paternal_lastname }}</p>
                                    <p class="mb-0"><strong class="text-secondary">{{ __('Apellido Materno') }}:</strong> {{ $client->maternal_lastname }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-body-secondary">
                                <div class="card-body">
                                    <h6 class="mb-3">{{ __('Información de Contacto') }}</h6>
                                    <p class="mb-2"><strong class="text-secondary">{{ __('Teléfono') }}:</strong> {{ $client->phone }}</p>
                                    <p class="mb-2"><strong class="text-secondary">{{ __('Correo') }}:</strong> {{ $client->email }}</p>
                                    <p class="mb-0"><strong class="text-secondary">{{ __('Código de Barras') }}:</strong> <span class="font-monospace fs-5">{{ $client->eight_digit_barcode }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2 flex-wrap">
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil me-1"></i>{{ __('Editar') }}
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('¿Eliminar cliente?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-1"></i>{{ __('Eliminar') }}
                            </button>
                        </form>
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>{{ __('Volver a la Lista') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
