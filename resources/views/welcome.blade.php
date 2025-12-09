<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <link rel="icon" href="{{ $appSettings['favicon'] ?? asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ $appSettings['logo'] ?? asset('images/brand-logo.png') }}">
</head>

<body class="auth-page">
    <div class="auth-card" style="max-width: 32rem;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ $appSettings['logo'] ?? asset('images/brand-logo.png') }}" alt="{{ config('app.name') }}" class="auth-logo"
                style="max-height: 180px;">
        </div>

        @if (Route::has('login'))
            <!-- Título de bienvenida -->
            <h4 class="auth-title">Bienvenido</h4>
            
            <div class="d-grid gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-house-door fs-5"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-in-right fs-5"></i>
                        <span>Iniciar Sesión</span>
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-person-plus fs-5"></i>
                            <span>Registrarse</span>
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Información adicional -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0 small">
                    {{ config('app.name') }} - Sistema de Punto de Venta
                </p>
            </div>
        @endif
    </div>
</body>

</html>