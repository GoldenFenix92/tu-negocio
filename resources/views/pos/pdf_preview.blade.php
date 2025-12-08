<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Vista Previa de Ticket de Venta #{{ $sale->folio }}
            </h2>
            <a href="{{ route('pos.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Volver al POS
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-end gap-2 mb-3">
                    <a href="{{ route('pos.generate_pdf', $sale->id) }}" class="btn btn-primary" target="_blank">
                        <i class="bi bi-file-pdf"></i> Abrir PDF
                    </a>
                    <button onclick="printPdf()" class="btn btn-secondary">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                    <a href="{{ route('pos.index') }}" class="btn btn-success">
                        <i class="bi bi-cart-plus"></i> Nueva Venta
                    </a>
                    @if($sale->client && $sale->client->phone)
                        @php
                            $phoneNumber = '52' . preg_replace('/[^0-9]/', '', $sale->client->phone);
                            $message = urlencode("¡Gracias por tu compra en EBC - Elise Beauty Center! Tu folio de compra es: " . $sale->folio . ".");
                            $whatsappLink = "https://wa.me/{$phoneNumber}?text={$message}";
                        @endphp
                        <a href="{{ $whatsappLink }}" target="_blank" class="btn btn-success" style="background-color: #25D366; border-color: #25D366;">
                            <i class="bi bi-whatsapp"></i> Enviar por WhatsApp
                        </a>
                    @endif
                </div>

                <div class="ratio ratio-1x1" style="height: 80vh;">
                    <iframe src="{{ route('pos.generate_pdf', $sale->id) }}" title="Vista previa del PDF" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printPdf() {
            const iframe = document.querySelector('iframe');
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.print();
            } else {
                alert('No se pudo cargar el contenido del PDF para imprimir.');
            }
        }
    </script>
</x-app-layout>
