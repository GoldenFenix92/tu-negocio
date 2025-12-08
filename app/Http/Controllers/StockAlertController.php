<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\DomPDF\Facade\Pdf;

class StockAlertController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $lowStockProducts = Product::where('stock', '<', 10)
            ->with('category')
            ->orderBy('stock', 'asc')
            ->paginate(20);

        return view('stock_alerts.index', compact('lowStockProducts'));
    }

    public function exportPdf()
    {
        $lowStockProducts = Product::where('stock', '<', 10)
            ->with('category')
            ->orderBy('stock', 'asc')
            ->get();

        // Convert logo to base64 if it exists and GD is available
        $logoBase64 = null;
        if (extension_loaded('gd')) {
            $logoPath = public_path('images/brand-logo.png');
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $data = [
            'title' => 'Reporte de Alertas de Stock',
            'date' => now()->format('d/m/Y H:i'),
            'lowStockProducts' => $lowStockProducts,
            'totalProducts' => $lowStockProducts->count(),
            'logoBase64' => $logoBase64
        ];

        $pdf = Pdf::loadView('stock_alerts.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream('alertas-stock-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Show PDF preview for stock alerts.
     */
    public function pdfPreview(): View
    {
        $pdfUrl = route('stock_alerts.export_pdf');
        return view('components.pdf-viewer', compact('pdfUrl'));
    }
}
