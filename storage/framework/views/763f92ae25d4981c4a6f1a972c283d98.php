<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e($appSettings['app_name'] ?? config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Dynamic Fonts -->
        <?php if(isset($appSettings['font_family'])): ?>
            <link href="https://fonts.googleapis.com/css2?family=<?php echo e(str_replace(' ', '+', $appSettings['font_family'])); ?>:wght@400;500;600;700&display=swap" rel="stylesheet">
        <?php endif; ?>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.scss', 'resources/js/app.js']); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/pos-style.css')); ?>">
        <link rel="icon" href="<?php echo e($appSettings['logo'] ?? asset('images/brand-logo.png')); ?>" type="image/png">
        <link rel="apple-touch-icon" href="<?php echo e($appSettings['logo'] ?? asset('images/brand-logo.png')); ?>">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        
        <style>
            :root {
                --bg-primary: <?php echo e($appSettings['background_color'] ?? '#111827'); ?>;
                --text-primary: <?php echo e($appSettings['text_color'] ?? '#d1d5db'); ?>;
                --color-primary: <?php echo e($appSettings['primary_color'] ?? '#3b82f6'); ?>;
                --color-secondary: <?php echo e($appSettings['secondary_color'] ?? '#1f2937'); ?>;
                --font-family: '<?php echo e($appSettings['font_family'] ?? 'Inter'); ?>', sans-serif;
                
                <?php
                    $primary = $appSettings['primary_color'] ?? '#3b82f6';
                    $r = hexdec(substr($primary, 1, 2));
                    $g = hexdec(substr($primary, 3, 2));
                    $b = hexdec(substr($primary, 5, 2));
                ?>
                --color-primary-rgb: <?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>;

                /* Derived Text Colors for Hierarchy */
                /* Using opacity to ensure they work on any background */
                --text-secondary: color-mix(in srgb, var(--text-primary), transparent 30%);
                --text-muted: color-mix(in srgb, var(--text-primary), transparent 50%);
            }
            body {
                background-color: var(--bg-primary) !important;
                color: var(--text-primary) !important;
                font-family: var(--font-family) !important;
            }
            .bg-gray-700 {
                background-color: var(--bg-primary) !important;
            }
            .bg-gray-800 {
                background-color: var(--color-secondary) !important;
            }
            .btn-primary {
                background-color: var(--color-primary) !important;
                border-color: var(--color-primary) !important;
            }
            .text-primary {
                color: var(--color-primary) !important;
            }
            .border-secondary {
                border-color: var(--text-muted) !important;
                opacity: 0.5;
            }
            .text-secondary {
                color: var(--text-secondary) !important;
                opacity: 1 !important; /* Reset opacity as color-mix handles it */
            }
            .text-white {
                color: var(--text-primary) !important;
            }
            .text-muted {
                color: var(--text-muted) !important;
                opacity: 1 !important; /* Reset opacity as color-mix handles it */
            }
            
            /* Forms */
            .form-control, .form-select, .input-group-text {
                background-color: var(--color-secondary) !important;
                color: var(--text-primary) !important;
                border-color: var(--text-primary) !important;
                opacity: 0.9;
            }
            .form-control:focus, .form-select:focus {
                background-color: var(--color-secondary) !important;
                color: var(--text-primary) !important;
                border-color: var(--color-primary) !important;
                box-shadow: 0 0 0 0.25rem rgba(var(--color-primary-rgb), 0.25);
            }
            .form-label {
                color: var(--text-primary) !important;
            }

            /* Tables */
            .table {
                --bs-table-color: var(--text-primary);
                --bs-table-bg: transparent;
                --bs-table-border-color: var(--text-primary);
                color: var(--text-primary) !important;
                border-color: var(--text-primary) !important;
            }
            .table thead th {
                background-color: var(--color-secondary) !important;
                color: var(--text-primary) !important;
                border-bottom-color: var(--text-primary) !important;
            }
            .table td, .table th {
                background-color: transparent !important;
                color: var(--text-primary) !important;
                opacity: 0.9;
            }
            .table-hover tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.05) !important;
            }

            /* Cards */
            .card {
                background-color: var(--color-secondary) !important;
                border-color: var(--text-primary) !important;
                color: var(--text-primary) !important;
            }
            .card-header {
                background-color: rgba(0, 0, 0, 0.1) !important;
                border-bottom-color: var(--text-primary) !important;
            }
            .card-footer {
                background-color: rgba(0, 0, 0, 0.1) !important;
                border-top-color: var(--text-primary) !important;
            }
            
            /* Modals */
            .modal-content {
                background-color: var(--bg-primary) !important;
                color: var(--text-primary) !important;
                border-color: var(--text-primary) !important;
            }
            .modal-header, .modal-footer {
                border-color: var(--text-primary) !important;
            }
            .btn-close {
                filter: invert(1) grayscale(100%) brightness(200%);
            }
        </style>
        <?php echo $__env->yieldPushContent('styles'); ?>
    </head>
    <body class="font-sans antialiased">
        <div class="min-vh-100 bg-gray-700 d-flex">
            
            <div class="offcanvas-lg offcanvas-start sidebar-offcanvas" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
                <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div class="flex-fill main-content-wrapper">
                
                <header class="bg-gray-800 shadow sticky-top">
                    <div class="container-fluid py-3 px-3 px-sm-4 px-lg-5 d-flex align-items-center">
                        
                        <button class="btn btn-link text-white p-0 me-3 d-lg-none" 
                                type="button" 
                                data-bs-toggle="offcanvas" 
                                data-bs-target="#sidebarOffcanvas" 
                                aria-controls="sidebarOffcanvas">
                            <i class="bi bi-list fs-2"></i>
                        </button>
                        
                        <div class="flex-fill">
                            <?php echo e($header); ?>

                        </div>
                    </div>
                </header>

                
                <main class="bg-gray-700">
                    <div class="main-content">
                        <?php echo e($slot); ?>

                    </div>
                </main>
            </div>
        </div>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/layouts/app.blade.php ENDPATH**/ ?>