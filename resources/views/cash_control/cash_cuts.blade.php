<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">Historial de Cortes de Caja</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($cashCuts as $cashCut)
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-4 flex flex-col">
                        <!-- Color indicator for cash cuts (red) -->
                        <div class="w-full h-2 bg-red-500 rounded-t-lg mb-3"></div>

                        <div class="flex-1">
                            <div class="text-center font-semibold text-gray-800 dark:text-gray-100 mb-2">{{ $cashCut->folio }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-1">
                                <i class="fas fa-user mr-1"></i>{{ $cashCut->user->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <i class="fas fa-calendar mr-1"></i>{{ $cashCut->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-clock mr-1"></i>{{ $cashCut->cut_date->format('H:i') }}
                            </div>

                            <!-- Status badge -->
                            <div class="text-center mb-2">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full @if($cashCut->status === 'open') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                    {{ $cashCut->status === 'open' ? 'Abierto' : 'Cerrado' }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                                <div class="text-center">
                                    <div class="font-semibold text-gray-700 dark:text-gray-200">{{ $cashCut->total_sales }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">Ventas</div>
                                </div>
                                <div class="text-center">
                                    <div class="font-semibold text-green-600 dark:text-green-400">${{ number_format($cashCut->cash_amount, 2) }}</div>
                                    <div class="text-gray-500 dark:text-gray-400">Efectivo</div>
                                </div>
                            </div>

                            <div class="text-center mb-3">
                                <div class="text-sm font-bold @if($cashCut->difference > 0) text-green-600 dark:text-green-400 @elseif($cashCut->difference < 0) text-red-600 dark:text-red-400 @else text-blue-600 dark:text-blue-400 @endif">
                                    ${{ number_format($cashCut->difference, 2) }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($cashCut->difference > 0) Sobra
                                    @elseif($cashCut->difference < 0) Falta
                                    @else Exacto @endif
                                </div>
                            </div>

                            @if($cashCut->notes)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 italic">
                                    "{{ Str::limit($cashCut->notes, 50) }}"
                                </div>
                            @endif

                            @if($cashCut->status === 'closed' && $cashCut->closed_at)
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    <i class="fas fa-lock mr-1"></i>Cerrado: {{ $cashCut->closed_at->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('cash_control.cash_cut_pdf_preview', $cashCut) }}"
                               class="flex-1 px-3 py-2 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition-colors text-center">
                                <i class="fas fa-file-pdf mr-1"></i>Ver PDF
                            </a>
                            <a href="{{ route('cash_control.show_cash_cut', $cashCut) }}"
                               class="flex-1 px-3 py-2 bg-gray-500 text-white text-xs rounded hover:bg-gray-600 transition-colors text-center">
                                <i class="fas fa-eye mr-1"></i>Ver Detalles
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>No hay cortes de caja registrados</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $cashCuts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
