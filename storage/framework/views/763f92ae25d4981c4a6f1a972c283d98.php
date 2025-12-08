<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.scss', 'resources/js/app.js']); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/pos-style.css')); ?>">
        <link rel="icon" href="<?php echo e(asset('images/brand-logo.png')); ?>" type="image/png">
        <link rel="apple-touch-icon" href="<?php echo e(asset('images/brand-logo.png')); ?>">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
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