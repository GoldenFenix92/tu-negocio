<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">{{ __('Editar Cliente') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">{{ __('Información del Cliente') }}</h5>

                    <form method="POST" action="{{ route('clients.update', $client->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $client->name) }}" required autofocus class="form-control" />
                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="paternal_lastname" class="form-label">{{ __('Apellido Paterno') }}</label>
                                <input id="paternal_lastname" type="text" name="paternal_lastname" value="{{ old('paternal_lastname', $client->paternal_lastname) }}" required class="form-control" />
                                @error('paternal_lastname') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="maternal_lastname" class="form-label">{{ __('Apellido Materno') }}</label>
                                <input id="maternal_lastname" type="text" name="maternal_lastname" value="{{ old('maternal_lastname', $client->maternal_lastname) }}" required class="form-control" />
                                @error('maternal_lastname') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $client->phone) }}" required class="form-control" />
                                @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">{{ __('Correo') }}</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $client->email) }}" required class="form-control" />
                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="eight_digit_barcode" class="form-label">{{ __('Código de Barras') }}</label>
                                <div class="input-group">
                                    <input id="eight_digit_barcode" type="text" name="eight_digit_barcode" value="{{ old('eight_digit_barcode', $client->eight_digit_barcode) }}" required class="form-control" />
                                    <button type="button" class="btn btn-secondary" onclick="generateBarcode()">
                                        <i class="bi bi-shuffle me-1"></i>{{ __('Generar') }}
                                    </button>
                                </div>
                                @error('eight_digit_barcode') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label">{{ __('Imagen (opcional)') }}</label>
                                <input type="file" name="image" id="image" accept="image/*" class="form-control" />
                                @if($client->image)
                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <img src="{{ $client->imageUrl() }}" class="rounded" style="width: 96px; height: 96px; object-fit: cover;" alt="">
                                        @if($client->image !== 'clients/cliente_comodin.webp')
                                            <form action="{{ route('clients.destroyImage', $client) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la imagen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash me-1"></i>{{ __('Eliminar Imagen') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>{{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i>{{ __('Actualizar Cliente') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateBarcode() {
            let barcode = '';
            for (let i = 0; i < 8; i++) {
                barcode += Math.floor(Math.random() * 10);
            }
            document.getElementById('eight_digit_barcode').value = barcode;
        }
    </script>
</x-app-layout>
