<x-guest-layout>
    <!-- Logo -->
    <div class="text-center mb-4">
        <a href="{{ url('/') }}" class="d-inline-block">
            <img src="{{ asset('images/brand-logo.png') }}" alt="{{ config('app.name') }}" class="auth-logo">
        </a>
    </div>

    <h4 class="auth-title">Registrarse</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div class="mb-3">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Correo -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Rol -->
        <div class="mb-3">
            <x-input-label for="role" :value="__('Rol')" />
            <select id="role" name="role" class="form-select" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="empleado" {{ old('role') == 'empleado' ? 'selected' : '' }}>Empleado</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </div>

        <!-- Clave de Registro -->
        <div class="mb-4">
            <x-input-label for="registration_token" :value="__('Clave de Registro')" />
            <x-text-input id="registration_token" type="password" name="registration_token" required />
            <x-input-error :messages="$errors->get('registration_token')" class="mt-1" />
        </div>

        <div class="d-grid gap-3">
            <x-primary-button class="btn-lg justify-content-center">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-muted text-decoration-underline small">
                {{ __('¿Ya tienes cuenta?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
