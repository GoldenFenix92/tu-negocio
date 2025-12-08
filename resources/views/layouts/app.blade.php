<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/pos-style.css') }}">
        <link rel="icon" href="{{ asset('images/brand-logo.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('images/brand-logo.png') }}">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-vh-100 bg-gray-700 d-flex">
            {{-- Sidebar Offcanvas (responsive) --}}
            <div class="offcanvas-lg offcanvas-start sidebar-offcanvas" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
                @include('layouts.sidebar')
            </div>

            {{-- Main content wrapper --}}
            <div class="flex-fill main-content-wrapper">
                {{-- Header --}}
                <header class="bg-gray-800 shadow sticky-top">
                    <div class="container-fluid py-3 px-3 px-sm-4 px-lg-5 d-flex align-items-center">
                        {{-- Hamburger menu button (solo móvil) --}}
                        <button class="btn btn-link text-white p-0 me-3 d-lg-none" 
                                type="button" 
                                data-bs-toggle="offcanvas" 
                                data-bs-target="#sidebarOffcanvas" 
                                aria-controls="sidebarOffcanvas">
                            <i class="bi bi-list fs-2"></i>
                        </button>
                        
                        <div class="flex-fill">
                            {{ $header }}
                        </div>
                    </div>
                </header>

                {{-- Contenido de la página --}}
                <main class="bg-gray-700">
                    <div class="main-content">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
