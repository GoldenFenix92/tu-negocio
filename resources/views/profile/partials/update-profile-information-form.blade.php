<section>
    <header>
        <h5 class="fw-medium">Información del Perfil</h5>
        <p class="small text-secondary">Actualiza la información de perfil y correo electrónico de tu cuenta.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="profile_picture" class="form-label">Foto de Perfil</label>
            <div class="mb-2">
                <img src="{{ $user->imageUrl() }}" alt="Profile Picture" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
            <input id="profile_picture" name="profile_picture" type="file" class="form-control" />
            @error('profile_picture') <div class="text-danger small">{{ $message }}</div> @enderror

            @if ($user->profile_picture)
                <div class="form-check mt-2">
                    <input type="checkbox" name="remove_profile_picture" id="remove_profile_picture" class="form-check-input">
                    <label for="remove_profile_picture" class="form-check-label small text-danger">Eliminar Foto de Perfil</label>
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small">
                        Tu dirección de correo no está verificada.
                        <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-underline">
                            Haz clic aquí para reenviar el correo de verificación.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="small text-success">
                            Se ha enviado un nuevo enlace de verificación a tu correo.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>Guardar
            </button>

            @if (session('status') === 'profile-updated')
                <p class="small text-success mb-0">Guardado.</p>
            @endif
        </div>
    </form>
</section>
