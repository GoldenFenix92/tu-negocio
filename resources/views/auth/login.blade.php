@section('head')
    <link rel="icon" href="{{ asset('images/brand-logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/brand-logo.png') }}">
@endsection

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <!-- Logo -->
    <div class="text-center mb-4">
        <a href="{{ url('/') }}" class="d-inline-block">
            <img src="{{ asset('images/brand-logo.png') }}" alt="{{ config('app.name') }}" class="auth-logo">
        </a>
    </div>

    <h4 class="auth-title">Iniciar Sesión</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Recuérdame -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-muted">
                {{ __('Recuérdame') }}
            </label>
        </div>

        <div class="d-grid gap-3">
            <x-primary-button class="btn-lg justify-content-center">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-3">
            @if (Route::has('password.request'))
                <a class="text-muted text-decoration-underline small" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
