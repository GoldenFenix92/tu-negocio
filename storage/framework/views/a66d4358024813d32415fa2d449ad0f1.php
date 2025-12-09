<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="fw-semibold fs-4 text-white m-0">Gestión de Citas</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4">
        <div class="container">
            <?php echo $__env->make('components.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <a href="<?php echo e(route('appointments.create')); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>Crear Cita
                        </a>
                    </div>

                    <div id="calendar"></div>

                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3">Próximas Citas</h5>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title mb-2"><?php echo e($appointment->client->name); ?></h6>
                                            <p class="text-secondary small mb-2"><?php echo e($appointment->appointment_datetime->format('d M Y, h:i A')); ?></p>
                                            <span class="badge
                                                <?php switch($appointment->estatus):
                                                    case ('pending'): ?> bg-warning text-dark <?php break; ?>
                                                    <?php case ('confirmed'): ?> bg-success <?php break; ?>
                                                    <?php case ('completed'): ?> bg-primary <?php break; ?>
                                                    <?php case ('cancelled'): ?> bg-danger <?php break; ?>
                                                <?php endswitch; ?>">
                                                <?php echo e($appointment->estatus); ?>

                                            </span>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 d-flex justify-content-end gap-2">
                                            <a href="<?php echo e(route('appointments.edit', $appointment)); ?>" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('appointments.destroy', $appointment)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cita?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <p class="text-secondary text-center">No hay citas próximas.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
        .fc-daygrid-day-number, .fc-col-header-cell-cushion {
            color: #9ca3af;
        }
        .fc-day-today .fc-daygrid-day-number {
            color: #fff;
        }
        .fc-event {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .fc-toolbar-title {
            color: #e5e7eb;
        }
        .fc-button {
            background-color: #374151 !important;
            color: #e5e7eb !important;
            border: 1px solid #4b5563 !important;
        }
        .fc-button-primary:hover {
            background-color: #1f2937 !important;
        }
        .fc-button-active {
            background-color: #3b82f6 !important;
        }
        .fc-daygrid-day {
            background-color: #1f2937;
        }
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #374151;
        }
    </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($events, 15, 512) ?>,
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                }
            });
            calendar.render();
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH E:\Proyectos Eliel\EBC-PV\resources\views/appointments/index.blade.php ENDPATH**/ ?>