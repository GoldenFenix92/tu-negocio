<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Service;
use App\Models\Client;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; // Import Mail facade
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;
use App\Mail\SaleTicketMail; // Import Mailable class

class PosController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la interfaz del punto de venta
     */
    public function index(): View
    {
        $products = Product::where('stock', '>', 0)->get();
        $services = Service::where('is_active', true)->get(); // Fetch active services
        $clients = Client::all();
        $nextFolio = Sale::generateNextFolio();

        return view('pos.index', compact('products', 'services', 'clients', 'nextFolio'));
    }

    /**
     * Buscar productos por nombre o SKU
     */
    public function searchProducts(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        $products = Product::where('stock', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'sku', 'sell_price', 'stock'])
            ->map(function ($product) {
                $product->type = 'product';
                return $product;
            });

        $services = Service::where('is_active', true)
            ->where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'price', 'duration_minutes'])
            ->map(function ($service) {
                $service->type = 'service';
                $service->sell_price = $service->price; // Align field names for frontend
                $service->stock = null; // Services don't have stock in this context
                return $service;
            });

        $results = $products->merge($services)->sortBy('name')->take(10);

        return response()->json($results);
    }

    /**
     * Completar la venta - Lógica reconstruida
     */
    public function completeSale(Request $request): JsonResponse
    {
        Log::info('Inicio de reconstrucción de venta', ['user_id' => Auth::id(), 'data' => $request->all()]);

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'client_id' => 'nullable|exists:clients,id',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer', // ID can be product or service
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.type' => 'required|in:product,service', // New: type of item
                'payment_method' => 'required|in:efectivo,tarjeta,mixto',
                'card_type' => 'required_if:payment_method,tarjeta,mixto|nullable|in:debito,credito',
                'voucher_folio' => 'required_if:payment_method,tarjeta,mixto|nullable|string|max:100|unique:sales,voucher_folio',
                'voucher_amount' => 'required_if:payment_method,mixto|nullable|numeric|min:0.01',
                'cash_tendered' => 'required_if:payment_method,efectivo,mixto|nullable|numeric|min:0', // Nuevo: efectivo entregado por el cliente
                'discount_coupon' => 'nullable|string|max:50', // Add validation for discount coupon
            ], [
                'voucher_folio.unique' => 'El folio de voucher ya existe. Por favor, ingrese uno diferente.',
                'items.*.id.required' => 'El ID del item es requerido.',
                'items.*.id.integer' => 'El ID del item debe ser un número entero.',
                'items.*.quantity.required' => 'La cantidad del item es requerida.',
                'items.*.quantity.integer' => 'La cantidad del item debe ser un número entero.',
                'items.*.quantity.min' => 'La cantidad del item debe ser al menos 1.',
                'items.*.type.required' => 'El tipo de item es requerido.',
                'items.*.type.in' => 'El tipo de item debe ser "product" o "service".',
                'cash_tendered.required_if' => 'El efectivo entregado es requerido para pagos en efectivo o mixtos.',
                'cash_tendered.numeric' => 'El efectivo entregado debe ser un número.',
                'cash_tendered.min' => 'El efectivo entregado debe ser al menos 0.',
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Datos inválidos.', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        try {
            DB::beginTransaction();

            // 1. Recalcular todo en el servidor para máxima seguridad
            $processedItems = $this->processSaleItems($validatedData['items']);
            $subtotal = $processedItems['subtotal'];
            $saleItemsDetails = $processedItems['saleItemsDetails'];

            // 2. Calcular descuentos en el servidor
            $clientDiscountAmount = 0;
            if (!empty($validatedData['client_id'])) {
                $clientDiscountCoupon = Coupon::where('name', 'Descuento Cliente Frecuente')->where('is_active', true)->first();
                if ($clientDiscountCoupon) {
                    $clientDiscountAmount = $subtotal * ($clientDiscountCoupon->discount_percentage / 100);
                }
            }

            // Apply coupon discount
            $couponDiscountAmount = 0;
            $appliedCoupon = null;
            if (!empty($validatedData['discount_coupon'])) {
                $appliedCoupon = Coupon::where('name', $validatedData['discount_coupon'])
                                      ->where('is_active', true)
                                      ->whereNull('deleted_at')
                                      ->first();

                if ($appliedCoupon) {
                    $couponDiscountAmount = $subtotal * ($appliedCoupon->discount_percentage / 100);
                } else {
                    throw new \Exception("El cupón de descuento ingresado no es válido o está inactivo.");
                }
            }
            
            $totalDiscount = $clientDiscountAmount + $couponDiscountAmount;
            $total = $subtotal - $totalDiscount;
            if ($total < 0) $total = 0; // Ensure total doesn't go negative

            // 3. Calcular y validar montos de pago en el servidor
            $cashAmount = 0; // Efectivo recibido del cliente
            $cardAmount = 0; // Monto pagado con tarjeta
            $change = 0;     // Cambio a devolver

            switch ($validatedData['payment_method']) {
                case 'efectivo':
                    $cashAmount = $validatedData['cash_tendered'];
                    if ($cashAmount < $total) {
                        throw new \Exception("El efectivo entregado es insuficiente. Faltan: $" . number_format($total - $cashAmount, 2));
                    }
                    $change = $cashAmount - $total;
                    break;
                case 'tarjeta':
                    $cardAmount = $total;
                    break;
                case 'mixto':
                    $cardAmount = $validatedData['voucher_amount'] ?? 0;
                    $cashNeeded = $total - $cardAmount;

                    if ($cashNeeded < 0) {
                        throw new \Exception("El monto de tarjeta excede el total de la venta.");
                    }

                    $cashAmount = $validatedData['cash_tendered'];
                    if ($cashAmount < $cashNeeded) {
                        throw new \Exception("El efectivo entregado es insuficiente para cubrir la parte en efectivo. Faltan: $" . number_format($cashNeeded - $cashAmount, 2));
                    }
                    $change = $cashAmount - $cashNeeded;
                    break;
            }
            
            // Verificación final de consistencia (total pagado vs total de venta)
            // Para efectivo y mixto, el total pagado es el total de la venta (después de cambio)
            // Para tarjeta, el total pagado es el total de la venta
            $totalPaid = ($validatedData['payment_method'] === 'efectivo' || $validatedData['payment_method'] === 'mixto')
                         ? ($cashAmount - $change) + $cardAmount
                         : $cardAmount;

            if (abs($totalPaid - $total) > 0.01) {
                throw new \Exception("El desglose de pago no coincide con el total de la venta. Total: {$total}, Pagado: " . $totalPaid);
            }

            // 4. Obtener sesión de caja
            $cashSession = \App\Models\CashSession::getActiveSession(Auth::id());
            if (!$cashSession) {
                throw new \Exception("No hay una sesión de caja activa para el usuario.");
            }

            // 5. Crear la venta
            $saleVoucherFolio = $validatedData['voucher_folio'] ?? null;
            $saleVoucherCount = 0;
            $saleVoucherFoliosArray = [];

            if (($validatedData['payment_method'] === 'tarjeta' || $validatedData['payment_method'] === 'mixto') && $saleVoucherFolio) {
                $saleVoucherCount = 1;
                $saleVoucherFoliosArray = [$saleVoucherFolio];
            }

            $sale = Sale::create([
                'folio' => Sale::generateNextFolio(),
                'client_id' => $validatedData['client_id'] ?? null,
                'user_id' => Auth::id(),
                'cash_session_id' => $cashSession ? $cashSession->id : null,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'total_amount' => $total,
                'discount_coupon' => $validatedData['discount_coupon'] ?? null, // Store the applied coupon
                'payment_method' => $validatedData['payment_method'],
                'card_type' => $validatedData['card_type'] ?? null,
                'voucher_folio' => $saleVoucherFolio,
                'voucher_amount' => $validatedData['payment_method'] === 'mixto' ? $cardAmount : 0,
                'card_amount' => $cardAmount,
                'cash_amount' => $cashAmount - $change, // Almacenar el efectivo neto que queda en caja
                'status' => 'completada',
                'voucher_count' => $saleVoucherCount,
                'voucher_folios' => $saleVoucherFoliosArray,
            ]);

            // 6. Guardar detalles y actualizar stock
            foreach ($saleItemsDetails as $detail) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'item_type' => $detail['type'],
                    'item_id' => $detail['item']->id,
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                ]);

                if ($detail['type'] === 'product') {
                    $detail['item']->decrement('stock', $detail['quantity']);
                } elseif ($detail['type'] === 'service') {
                    // For services, decrement stock of associated products
                    foreach ($detail['associated_products'] as $associatedProduct) {
                        // Assuming 1 unit of associated product per service unit
                        $associatedProduct->decrement('stock', $detail['quantity']);
                    }
                }
            }

            if ($cashSession) {
                $cashSession->addSale($sale);
            }

            DB::commit();

            // Send email with purchase ticket if client is registered and has an email
            if ($sale->client_id) {
                $client = Client::find($sale->client_id);
                if ($client && $client->email) {
                    try {
                        $sale->load(['client', 'user', 'details.item']);
                        $logoBase64 = $this->getLogoBase64(); // Reuse existing method for logo if needed in PDF
                        $amountPaid = $sale->cash_amount + $sale->card_amount;
                        $change = $amountPaid - $sale->total_amount;
                        if ($change < 0) {
                            $change = 0;
                        }

                        $pdf = Pdf::loadView('pos.pdf', compact('sale', 'logoBase64', 'change'))->setPaper('a4', 'portrait');
                        $pdfContent = $pdf->output();

                        Mail::to($client->email)->send(new SaleTicketMail($sale, $pdfContent));
                        Log::info('Ticket de compra enviado al cliente', ['sale_id' => $sale->id, 'client_email' => $client->email]);
                    } catch (\Exception $mailException) {
                        Log::error('Error al enviar ticket de compra por correo', [
                            'sale_id' => $sale->id,
                            'client_id' => $sale->client_id,
                            'error' => $mailException->getMessage(),
                            'trace' => $mailException->getTraceAsString()
                        ]);
                        // Continue with the sale completion even if email fails
                    }
                }
            }

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'folio' => $sale->folio,
                'message' => 'Venta completada exitosamente con lógica reconstruida.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en lógica de venta reconstruida', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Error al procesar la venta: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generar PDF de la venta
     */
    public function generatePdf(Sale $sale): \Illuminate\Http\Response
    {
        $sale->load(['client', 'user', 'details.item']);
        $logoBase64 = $this->getLogoBase64();

        // Calcular el cambio
        $change = 0;
        if ($sale->payment_method === 'efectivo' || $sale->payment_method === 'mixto') {
            // cash_amount ahora representa el efectivo entregado
            $change = $sale->cash_amount - ($sale->total_amount - $sale->card_amount);
            if ($change < 0) $change = 0; // Salvaguarda
        }

        $pdf = Pdf::loadView('pos.pdf', compact('sale', 'logoBase64', 'change'))->setPaper('a4', 'portrait');
        return $pdf->stream("venta-{$sale->folio}.pdf");
    }

    /**
     * Mostrar vista previa del PDF de la venta
     */
    public function pdfPreview(Sale $sale): View
    {
        return view('pos.pdf_preview', compact('sale'));
    }

    /**
     * Mostrar historial de ventas
     */
    public function salesHistory(Request $request): View
    {
        $query = Sale::with(['client', 'user'])->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('folio') && !empty($request->folio)) {
            $query->where('folio', 'like', '%' . $request->folio . '%');
        }

        if ($request->has('client_name') && !empty($request->client_name)) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->client_name . '%')
                  ->orWhere('paternal_lastname', 'like', '%' . $request->client_name . '%')
                  ->orWhere('maternal_lastname', 'like', '%' . $request->client_name . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $paymentMethod = $request->payment_method;
            if ($paymentMethod === 'efectivo') {
                $query->where(function ($q) {
                    $q->where('payment_method', 'efectivo')
                      ->orWhere(function ($q2) {
                          $q2->where('payment_method', 'mixto')
                             ->where('cash_amount', '>', 0);
                      });
                });
            } elseif ($paymentMethod === 'tarjeta') {
                $query->where(function ($q) {
                    $q->where('payment_method', 'tarjeta')
                      ->orWhere(function ($q2) {
                          $q2->where('payment_method', 'mixto')
                             ->where('card_amount', '>', 0);
                      });
                });
            } else {
                $query->where('payment_method', $paymentMethod);
            }
        }

        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->paginate(15);
        return view('pos.history', compact('sales'));
    }

    /**
     * Mostrar detalles de una venta
     */
    public function showSale(Sale $sale): View
    {
        $sale->load(['client', 'user', 'details.item']);
        return view('pos.show', compact('sale'));
    }

    /**
     * Cancelar venta
     */
    public function cancelSale(Sale $sale): RedirectResponse
    {
        if ($sale->status === 'cancelada') {
            return back()->with('error', 'La venta ya está cancelada');
        }

        try {
            DB::beginTransaction();
            foreach ($sale->details as $detail) {
                if ($detail->item_type === 'product' && $detail->item) {
                    $detail->item->increment('stock', $detail->quantity);
                }
            }
            $sale->update(['status' => 'cancelada']);
            DB::commit();
            return back()->with('success', 'Venta cancelada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al cancelar la venta: ' . $e->getMessage());
        }
    }
    
    private function getLogoBase64(): ?string
    {
        if (extension_loaded('gd')) {
            $logoPath = public_path('images/brand-logo.png');
            if (file_exists($logoPath)) {
                return 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
            }
        }
        return null;
    }

    /**
     * Check if voucher folio is unique via AJAX.
     */
    public function checkVoucherFolio(Request $request): JsonResponse
    {
        $request->validate([
            'voucher_folio' => 'required|string|max:100',
        ]);

        $isUnique = Sale::where('voucher_folio', $request->voucher_folio)->doesntExist();

        return response()->json(['is_unique' => $isUnique]);
    }

    /**
     * Export all sales to PDF.
     */
    public function exportAllPdf(Request $request): \Illuminate\Http\Response
    {
        $query = Sale::with(['client', 'user'])->orderBy('created_at', 'desc');

        // Apply filters (same as salesHistory)
        if ($request->has('folio') && !empty($request->folio)) {
            $query->where('folio', 'like', '%' . $request->folio . '%');
        }

        if ($request->has('client_name') && !empty($request->client_name)) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->client_name . '%')
                  ->orWhere('paternal_lastname', 'like', '%' . $request->client_name . '%')
                  ->orWhere('maternal_lastname', 'like', '%' . $request->client_name . '%');
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->get();

        $logoBase64 = null;
        if (extension_loaded('gd')) {
            $logoPath = public_path('images/brand-logo.png');
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $pdf = Pdf::loadView('pos.history_pdf', compact('sales', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream('historial-ventas-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Show PDF preview for all sales history.
     */
    public function exportAllPdfPreview(Request $request): View
    {
        $pdfUrl = route('pos.export_all_pdf', $request->query());
        return view('components.pdf-viewer', compact('pdfUrl'));
    }

    // Other methods (create, edit, update, destroy, restore, export) can be added here if needed.
    // For simplicity, they are omitted from this rebuild unless requested.

    public function validateCoupon($couponName)
    {
        $coupon = Coupon::where('name', $couponName)
                        ->where('is_active', true)
                        ->whereNull('deleted_at')
                        ->first();

        if ($coupon) {
            return response()->json(['success' => true, 'coupon' => $coupon]);
        }

        return response()->json(['success' => false, 'message' => 'Cupón no válido o inactivo.']);
    }

    /**
     * Process sale items (products and services) and calculate subtotal.
     * 
     * @param array $items
     * @return array
     * @throws \Exception
     */
    private function processSaleItems(array $items): array
    {
        $subtotal = 0;
        $saleItemsDetails = [];

        foreach ($items as $itemData) {
            if ($itemData['type'] === 'product') {
                $product = Product::find($itemData['id']);
                if (!$product) {
                    throw new \Exception("Producto con ID {$itemData['id']} no encontrado.");
                }
                if ($product->stock < $itemData['quantity']) {
                    throw new \Exception("Stock insuficiente para {$product->name}. Disponible: {$product->stock}");
                }
                $lineSubtotal = $product->sell_price * $itemData['quantity'];
                $subtotal += $lineSubtotal;
                $saleItemsDetails[] = [
                    'type' => 'product',
                    'item' => $product,
                    'quantity' => $itemData['quantity'],
                    'price' => $product->sell_price
                ];
            } elseif ($itemData['type'] === 'service') {
                $service = Service::with('products')->find($itemData['id']);
                if (!$service) {
                    throw new \Exception("Servicio con ID {$itemData['id']} no encontrado.");
                }
                // Check stock for each product associated with the service
                foreach ($service->products as $associatedProduct) {
                    $requiredStock = $itemData['quantity']; // Assuming 1 unit of associated product per service unit
                    if ($associatedProduct->stock < $requiredStock) {
                        throw new \Exception("Stock insuficiente para el producto '{$associatedProduct->name}' asociado al servicio '{$service->name}'. Disponible: {$associatedProduct->stock}, Requerido: {$requiredStock}");
                    }
                }
                $lineSubtotal = $service->price * $itemData['quantity'];
                $subtotal += $lineSubtotal;
                $saleItemsDetails[] = [
                    'type' => 'service',
                    'item' => $service,
                    'quantity' => $itemData['quantity'],
                    'price' => $service->price,
                    'associated_products' => $service->products // Store associated products for later stock deduction
                ];
            }
        }

        return [
            'subtotal' => $subtotal,
            'saleItemsDetails' => $saleItemsDetails
        ];
    }
}
