<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    
    <!-- Dynamic Font Loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?php echo e(str_replace(' ', '+', $appSettings['font_family'] ?? 'Inter')); ?>:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.scss', 'resources/js/app.js']); ?>
    <link rel="icon" href="<?php echo e($appSettings['favicon'] ?? asset('favicon.ico')); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo e($appSettings['logo'] ?? asset('images/brand-logo.png')); ?>">
    
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
                
                $bg = $appSettings['background_color'] ?? '#111827';
                $bgR = hexdec(substr($bg, 1, 2));
                $bgG = hexdec(substr($bg, 3, 2));
                $bgB = hexdec(substr($bg, 5, 2));
                $brightness = ($bgR * 299 + $bgG * 587 + $bgB * 114) / 1000;
                $isDark = $brightness < 128;
                
                $shadowIntensity = $appSettings['shadow_intensity'] ?? 1.0;
                $shadowBlur = $appSettings['shadow_blur'] ?? 10;
                $shadowOpacityInput = $appSettings['shadow_opacity'] ?? 0;
                
                $shadowColor = $isDark ? '0, 0, 0' : '0, 0, 0';
                $shadowOpacity = $shadowOpacityInput == 0 ? ($isDark ? 0.5 : 0.15) : $shadowOpacityInput;
                
                $sm1 = round(1 * $shadowIntensity);
                $sm2 = round(2 * $shadowIntensity);
                $sm4 = round(4 * $shadowIntensity);
                $blur1 = round($shadowBlur * 0.3);
                $blur2 = round($shadowBlur * 0.5);
                $blur3 = round($shadowBlur * 1.0);
            ?>
            --color-primary-rgb: <?php echo e($r); ?>, <?php echo e($g); ?>, <?php echo e($b); ?>;
            --shadow-color-rgb: <?php echo e($shadowColor); ?>;
            --shadow-opacity: <?php echo e($shadowOpacity); ?>;
            --shadow-sm: 0 <?php echo e($sm1); ?>px <?php echo e($blur1); ?>px 0 rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.3)),
                         0 <?php echo e($sm1); ?>px <?php echo e($blur2); ?>px 0 rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.2));
            --shadow-md: 0 <?php echo e($sm4); ?>px <?php echo e($blur2); ?>px -1px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.5)),
                         0 <?php echo e($sm2); ?>px <?php echo e($blur1); ?>px -2px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.3));
            --shadow-xl: 0 <?php echo e(round(20 * $shadowIntensity)); ?>px <?php echo e(round($shadowBlur * 1.5)); ?>px -5px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.7)),
                         0 <?php echo e(round(8 * $shadowIntensity)); ?>px <?php echo e($blur3); ?>px -6px rgba(var(--shadow-color-rgb), calc(var(--shadow-opacity) * 0.5));
            --glow-primary-sm: 0 0 0 1px rgba(var(--color-primary-rgb), 0.1),
                               0 0 <?php echo e($blur1); ?>px 0 rgba(var(--color-primary-rgb), 0.1);
            --glow-primary-md: 0 0 0 1px rgba(var(--color-primary-rgb), 0.3),
                               0 0 <?php echo e($blur3); ?>px 0 rgba(var(--color-primary-rgb), 0.2);
            --border-color: color-mix(in srgb, var(--text-primary), transparent 70%);
        }
        
        .auth-page {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--color-secondary) 50%, var(--bg-primary) 100%);
            font-family: var(--font-family);
        }
        
        .auth-card {
            background: color-mix(in srgb, var(--color-secondary), transparent 5%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-xl), var(--glow-primary-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .auth-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl), var(--glow-primary-md);
        }
        
        .auth-title {
            color: var(--text-primary);
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
        
        .btn-secondary {
            background-color: var(--color-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-secondary:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .text-muted {
            color: color-mix(in srgb, var(--text-primary), transparent 50%) !important;
        }
    </style>
</head>

<body class="auth-page">
    <div class="auth-card" style="max-width: 32rem;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="<?php echo e($appSettings['logo'] ?? asset('images/brand-logo.png')); ?>" alt="<?php echo e(config('app.name')); ?>" class="auth-logo"
                style="max-height: 180px;">
        </div>

        <?php if(Route::has('login')): ?>
            <!-- Título de bienvenida -->
            <h4 class="auth-title">Bienvenido</h4>
            
            <div class="d-grid gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>"
                        class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-house-door fs-5"></i>
                        <span>Dashboard</span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                        class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-in-right fs-5"></i>
                        <span>Iniciar Sesión</span>
                    </a>

                    <?php if(Route::has('register')): ?>
                        <a href="<?php echo e(route('register')); ?>"
                            class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-person-plus fs-5"></i>
                            <span>Registrarse</span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Información adicional -->
            <div class="text-center mt-4">
                <p class="text-muted mb-0 small">
                    <?php echo e(config('app.name')); ?> - Sistema de Punto de Venta
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html><?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/welcome.blade.php ENDPATH**/ ?>