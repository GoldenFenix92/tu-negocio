<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.scss', 'resources/js/app.js']); ?>
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/brand-logo.png')); ?>">
</head>

<body class="auth-page">
    <div class="auth-card" style="max-width: 32rem;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="<?php echo e(asset('images/brand-logo.png')); ?>" alt="<?php echo e(config('app.name')); ?>" class="auth-logo"
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