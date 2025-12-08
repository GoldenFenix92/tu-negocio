<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Vista Previa de Documento
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-end gap-2 mb-3">
                    <a href="{{ $pdfUrl }}" class="btn btn-primary" download>
                        <i class="bi bi-download"></i> Descargar PDF
                    </a>
                    <button onclick="printPdf()" class="btn btn-secondary">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="ratio ratio-1x1" style="height: 80vh;">
                    <iframe src="{{ $pdfUrl }}" title="Vista previa del PDF" allowfullscreen></iframe>
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
