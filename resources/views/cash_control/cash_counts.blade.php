<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Historial de Arqueos de Caja</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($cashCounts as $cashCount)
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col">
                        <!-- Color indicator for cash counts (blue) -->
                        <div class="w-full h-2 bg-blue-500 rounded-t-lg mb-3"></div>

                        <div class="flex-1">
                            <div class="text-center font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $cashCount->folio }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                                <i class="fas fa-user mr-1"></i>{{ $cashCount->user->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <i class="fas fa-calendar mr-1"></i>{{ $cashCount->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-clock mr-1"></i>{{ $cashCount->start_date->format('H:i') }} - {{ $cashCount->end_date->format('H:i') }}
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                                <div class="text-center">
                                    <div class="font-semibold text-gray-700 dark:text-gray-200">{{ $cashCount->total_sales }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">Ventas</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold text-green-600 dark:text-green-400">${{ number_format($cashCount->cash_amount, 2) }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">Efectivo</div>
                                </div>
                            </div>

                            <div class="text-center mb-3">
                                <div class="text-sm font-bold @if($cashCount->difference > 0) text-green-600 dark:text-green-400 @elseif($cashCount->difference < 0) text-red-600 dark:text-red-400 @else text-blue-600 dark:text-blue-400 @endif">
                                    ${{ number_format($cashCount->difference, 2) }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($cashCount->difference > 0) Sobra
                                    @elseif($cashCount->difference < 0) Falta
                                    @else Exacto @endif
                                </div>
                            </div>

                            @if($cashCount->notes)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 italic">
                                    "{{ Str::limit($cashCount->notes, 50) }}"
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('cash_control.cash_count_pdf_preview', $cashCount) }}"
                               class="flex-1 px-3 py-2 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition-colors text-center">
                                <i class="fas fa-file-pdf mr-1"></i>Ver PDF
                            </a>
                            <a href="{{ route('cash_control.show_cash_count', $cashCount) }}"
                               class="flex-1 px-3 py-2 bg-gray-500 text-white text-xs rounded hover:bg-gray-600 transition-colors text-center">
                                <i class="fas fa-eye mr-1"></i>Ver Detalles
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>No hay arqueos de caja registrados</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $cashCounts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
