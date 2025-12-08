<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.scss', 'resources/js/app.js']); ?>
        <link rel="icon" href="<?php echo e(asset('images/brand-logo.png')); ?>" type="image/png">
        <link rel="apple-touch-icon" href="<?php echo e(asset('images/brand-logo.png')); ?>">
        <?php echo $__env->yieldContent('head'); ?>
    </head>
    <body class="auth-page">
        <div class="auth-card">
            <?php echo e($slot); ?>

        </div>
    </body>
</html>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/layouts/guest.blade.php ENDPATH**/ ?>