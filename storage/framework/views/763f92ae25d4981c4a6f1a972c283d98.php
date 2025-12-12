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
                    
                    // Detect if background is dark or light
                    $bg = $appSettings['background_color'] ?? '#111827';
                    $bgR = hexdec(substr($bg, 1, 2));
                    $bgG = hexdec(substr($bg, 3, 2));
                    $bgB = hexdec(substr($bg, 5, 2));
                    $brightness = ($bgR * 299 + $bgG * 587 + $bgB * 114) / 1000;
                    $isDark = $brightness < 128;
                    
                    // Shadow configuration (from settings or defaults)
                    $shadowIntensity = $appSettings['shadow_intensity'] ?? 1.0;
                    $shadowBlur = $appSettings['shadow_blur'] ?? 10;
                    $shadowOpacityInput = $appSettings['shadow_opacity'] ?? 0;
                    
                    // Shadow color based on theme
                    $shadowColor = $isDark ? '0, 0, 0' : '0, 0, 0';
                    $shadowOpacity = $shadowOpacityInput == 0 ? ($isDark ? 0.5 : 0.15) : $shadowOpacityInput;
                    
                    // Calculate shadow values with multipliers
                    $sm1 = round(1 * $shadowIntensity);
                    $sm2 = round(2 * $shadowIntensity);
                    $sm4 = round(4 * $shadowIntensity);
                    $sm10 = round(10 * $shadowIntensity);
                    $blur1 = round($shadowBlur * 0.3);
                    $blur2 = round($shadowBlur * 0.5);
                    $blur3 = round($shadowBlur * 1.0);
                ?>
                --color-primary-rgb: <?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>;
                
                /* Shadow Variables - Adapt to theme and user settings */
                --shadow-color-rgb: <?php echo e($shadowColor); ?>;
                --shadow-opacity: <?php echo e($shadowOpacity); ?>;
                --shadow-intensity: <?php echo e($shadowIntensity); ?>;
                --shadow-blur-base: <?php echo e($shadowBlur); ?>px;
                --shadow-sm: 0 <?php echo e($sm1); ?>px <?php echo e($blur1); ?>px 0 rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.3)),
                             0 <?php echo e($sm1); ?>px <?php echo e($blur2); ?>px 0 rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.2));
                --shadow-md: 0 <?php echo e($sm4); ?>px <?php echo e($blur2); ?>px -1px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.5)),
                             0 <?php echo e($sm2); ?>px <?php echo e($blur1); ?>px -2px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.3));
                --shadow-lg: 0 <?php echo e($sm10); ?>px <?php echo e($blur3); ?>px -3px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.6)),
                             0 <?php echo e($sm4); ?>px <?php echo e($blur2); ?>px -4px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.4));
                --shadow-xl: 0 <?php echo e(round(20 * $shadowIntensity)); ?>px <?php echo e(round($shadowBlur * 1.5)); ?>px -5px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.7)),
                             0 <?php echo e(round(8 * $shadowIntensity)); ?>px <?php echo e($blur3); ?>px -6px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.5));
                
                /* Glow effects with primary color */
                --glow-primary-sm: 0 0 0 1px rgba(var(--color-primary-rgb), 0.1),
                                   0 0 <?php echo e($blur1); ?>px 0 rgba(var(--color-primary-rgb), 0.1);
                --glow-primary-md: 0 0 0 1px rgba(var(--color-primary-rgb), 0.3),
                                   0 0 <?php echo e($blur3); ?>px 0 rgba(var(--color-primary-rgb), 0.2);
                --glow-primary-lg: 0 0 0 2px rgba(var(--color-primary-rgb), 0.4),
                                   0 0 <?php echo e(round($shadowBlur * 1.2)); ?>px 0 rgba(var(--color-primary-rgb), 0.3);
                
                /* Border with subtle glow */
                --border-color: color-mix(in srgb, var(--text-primary), transparent 70%);

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
                box-shadow: var(--shadow-sm), var(--glow-primary-sm);
                transition: all 0.3s ease-in-out;
            }
            .btn-primary:hover {
                box-shadow: var(--shadow-md), var(--glow-primary-md);
                transform: translateY(-2px);
            }
            .btn-primary:active {
                box-shadow: var(--shadow-sm);
                transform: translateY(0);
            }
            
            /* Badge Styles - Preserve Bootstrap Colors */
            .badge.bg-danger-subtle,
            .badge.bg-danger {
                background-color: #f8d7da !important;
                color: #842029 !important;
                border-color: #f5c2c7 !important;
            }
            
            .badge.text-danger-emphasis {
                color: #842029 !important;
            }
            
            .badge.bg-success-subtle,
            .badge.bg-success {
                background-color: #d1e7dd !important;
                color: #0a3622 !important;
                border-color: #badbcc !important;
            }
            
            .badge.text-success-emphasis {
                color: #0a3622 !important;
            }
            
            .badge.bg-warning-subtle,
            .badge.bg-warning {
                background-color: #fff3cd !important;
                color: #664d03 !important;
                border-color: #ffe69c !important;
            }
            
            .badge.text-warning-emphasis {
                color: #664d03 !important;
            }
            
            .badge.bg-info-subtle,
            .badge.bg-info {
                background-color: #cfe2ff !important;
                color: #055160 !important;
                border-color: #9ec5fe !important;
            }
            
            .badge.text-info-emphasis {
                color: #055160 !important;
            }
            
            .badge.bg-primary-subtle {
                background-color: #cfe2ff !important;
                color: #084298 !important;
                border-color: #9ec5fe !important;
            }
            
            .badge.text-primary-emphasis {
                color: #084298 !important;
            }
            
            .badge.bg-secondary-subtle {
                background-color: #e2e3e5 !important;
                color: #41464b !important;
                border-color: #c4c8cc !important;
            }
            
            .badge.text-secondary-emphasis {
                color: #41464b !important;
            }
            
            /* Dashboard badges - Bold text */
            .card-body .badge {
                font-weight: 700 !important;
                box-shadow: var(--shadow-sm);
            }
            
            /* ===================================== */
            /* GLOBAL ALERT STYLES - Soft Backgrounds */
            /* ===================================== */
            
            .alert {
                border-width: 1px;
                border-style: solid;
                border-radius: 0.5rem;
                padding: 1rem 1.25rem;
                position: relative;
                box-shadow: var(--shadow-sm);
            }
            
            /* Success Alerts */
            .alert-success {
                background-color: rgba(25, 135, 84, 0.15) !important;
                border-color: rgba(25, 135, 84, 0.4) !important;
                color: #0f5132 !important;
            }
            
            .alert-success .alert-link {
                color: #0a3622 !important;
                font-weight: 600;
            }
            
            .alert-success hr {
                border-color: rgba(25, 135, 84, 0.3) !important;
            }
            
            /* Danger Alerts */
            .alert-danger {
                background-color: rgba(220, 53, 69, 0.15) !important;
                border-color: rgba(220, 53, 69, 0.4) !important;
                color: #842029 !important;
            }
            
            .alert-danger .alert-link {
                color: #6c1621 !important;
                font-weight: 600;
            }
            
            .alert-danger hr {
                border-color: rgba(220, 53, 69, 0.3) !important;
            }
            
            /* Warning Alerts */
            .alert-warning {
                background-color: rgba(255, 193, 7, 0.15) !important;
                border-color: rgba(255, 193, 7, 0.5) !important;
                color: #664d03 !important;
            }
            
            .alert-warning .alert-link {
                color: #523c02 !important;
                font-weight: 600;
            }
            
            .alert-warning hr {
                border-color: rgba(255, 193, 7, 0.4) !important;
            }
            
            /* Info Alerts */
            .alert-info {
                background-color: rgba(13, 202, 240, 0.15) !important;
                border-color: rgba(13, 202, 240, 0.4) !important;
                color: #055160 !important;
            }
            
            .alert-info .alert-link {
                color: #033d47 !important;
                font-weight: 600;
            }
            
            .alert-info hr {
                border-color: rgba(13, 202, 240, 0.3) !important;
            }
            
            /* Primary Alerts */
            .alert-primary {
                background-color: color-mix(in srgb, var(--color-primary), transparent 85%) !important;
                border-color: color-mix(in srgb, var(--color-primary), transparent 60%) !important;
                color: color-mix(in srgb, var(--color-primary), black 30%) !important;
            }
            
            .alert-primary .alert-link {
                color: color-mix(in srgb, var(--color-primary), black 50%) !important;
                font-weight: 600;
            }
            
            .alert-primary hr {
                border-color: color-mix(in srgb, var(--color-primary), transparent 70%) !important;
            }
            
            /* Secondary Alerts */
            .alert-secondary {
                background-color: rgba(108, 117, 125, 0.15) !important;
                border-color: rgba(108, 117, 125, 0.4) !important;
                color: #41464b !important;
            }
            
            .alert-secondary .alert-link {
                color: #2e3338 !important;
                font-weight: 600;
            }
            
            .alert-secondary hr {
                border-color: rgba(108, 117, 125, 0.3) !important;
            }
            
            /* Dark Alerts */
            .alert-dark {
                background-color: rgba(33, 37, 41, 0.15) !important;
                border-color: rgba(33, 37, 41, 0.4) !important;
                color: #141619 !important;
            }
            
            .alert-dark .alert-link {
                color: #0a0c0d !important;
                font-weight: 600;
            }
            
            /* Light Alerts */
            .alert-light {
                background-color: rgba(248, 249, 250, 0.8) !important;
                border-color: rgba(222, 226, 230, 0.6) !important;
                color: #636464 !important;
            }
            
            .alert-light .alert-link {
                color: #4f5050 !important;
                font-weight: 600;
            }
            
            /* Alert Icons and Content */
            .alert i.bi {
                margin-right: 0.5rem;
                font-size: 1.1em;
            }
            
            /* Alert Headings */
            .alert h4,
            .alert h5,
            .alert h6,
            .alert .alert-heading {
                margin-top: 0;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }
            
            /* Dismissible Alerts */
            .alert-dismissible .btn-close {
                position: absolute;
                top: 0.75rem;
                right: 0.75rem;
                padding: 0.5rem;
                opacity: 0.5;
            }
            
            .alert-dismissible .btn-close:hover {
                opacity: 1;
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
                border-color: var(--border-color) !important;
                opacity: 0.9;
                box-shadow: var(--shadow-sm);
                transition: all 0.2s ease-in-out;
            }
            .form-control:focus, .form-select:focus {
                background-color: var(--color-secondary) !important;
                color: var(--text-primary) !important;
                border-color: var(--color-primary) !important;
                box-shadow: var(--glow-primary-md), var(--shadow-md);
                transform: translateY(-1px);
            }
            .form-control:hover:not(:focus), .form-select:hover:not(:focus) {
                border-color: var(--text-primary) !important;
                box-shadow: var(--shadow-md);
            }
            .form-label {
                color: var(--text-primary) !important;
            }

            /* Tables */
            .table {
                --bs-table-color: var(--text-primary);
                --bs-table-bg: transparent;
                --bs-table-border-color: var(--border-color);
                color: var(--text-primary) !important;
                border-color: var(--border-color) !important;
            }
            .table thead th {
                background-color: var(--color-secondary) !important;
                color: var(--text-primary) !important;
                border-bottom-color: var(--border-color) !important;
                box-shadow: 0 1px 0 0 rgba(var(--shadow-color-rgb), 0.1);
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
                border-color: var(--border-color) !important;
                color: var(--text-primary) !important;
                box-shadow: var(--shadow-md);
                transition: all 0.3s ease-in-out;
            }
            .card:hover {
                box-shadow: var(--shadow-lg);
                transform: translateY(-2px);
            }
            .card-header {
                background-color: rgba(0, 0, 0, 0.1) !important;
                border-bottom-color: var(--border-color) !important;
            }
            .card-footer {
                background-color: rgba(0, 0, 0, 0.1) !important;
                border-top-color: var(--border-color) !important;
            }
            
            /* Modals */
            .modal-content {
                background-color: var(--bg-primary) !important;
                color: var(--text-primary) !important;
                border-color: var(--border-color) !important;
                box-shadow: var(--shadow-xl), var(--glow-primary-sm);
            }
            .modal-header, .modal-footer {
                border-color: var(--border-color) !important;
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