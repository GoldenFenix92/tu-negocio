<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-white m-0">Gestión de Citas</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @include('components.alerts')

            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>Crear Cita
                        </a>
                    </div>

                    <div id="calendar"></div>

                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3">Próximas Citas</h5>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            @forelse($appointments as $appointment)
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title mb-2">{{ $appointment->client->name }}</h6>
                                            <p class="text-secondary small mb-2">{{ $appointment->appointment_datetime->format('d M Y, h:i A') }}</p>
                                            <span class="badge
                                                @switch($appointment->estatus)
                                                    @case('pending') bg-warning text-dark @break
                                                    @case('confirmed') bg-success @break
                                                    @case('completed') bg-primary @break
                                                    @case('cancelled') bg-danger @break
                                                @endswitch">
                                                {{ $appointment->estatus }}
                                            </span>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 d-flex justify-content-end gap-2">
                                            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta cita?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-secondary text-center">No hay citas próximas.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
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
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($events),
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
    @endpush
</x-app-layout>
