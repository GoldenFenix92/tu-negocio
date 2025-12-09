<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        <link rel="icon" href="{{ $appSettings['favicon'] ?? asset('favicon.ico') }}" type="image/x-icon">
        <link rel="apple-touch-icon" href="{{ $appSettings['logo'] ?? asset('images/brand-logo.png') }}">
        @yield('head')
    </head>
    <body class="auth-page">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </body>
</html>
