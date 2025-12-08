<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\CashCount;
use App\Models\CashCut;
use App\Models\CashMovement; // Import the new CashMovement model
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CashControlController extends \Illuminate\Routing\Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la interfaz de control de caja
     */
    public function index(): View
    {
        $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

        $salesQuery = Sale::where('status', '!=', 'transferida')
            ->where('status', 'completada')
            ->with(['client', 'user'])
            ->orderBy('created_at', 'desc');

        if ($activeSession) {
            $salesQuery->where('cash_session_id', $activeSession->id);
        } else {
            // Si no hay sesión activa, mostrar ventas del día actual sin sesión
            $salesQuery->whereDate('created_at', Carbon::today());
        }

        $sales = $salesQuery->get();

        // Obtener efectivo inicial de la sesión de caja activa
        $initialCash = $activeSession ? $activeSession->initial_cash : 0;

        // Obtener movimientos de efectivo (retiros y depósitos) para la sesión o el día
        $cashMovementsQuery = CashMovement::where('user_id', Auth::id());
        if ($activeSession) {
            $cashMovementsQuery->where('cash_session_id', $activeSession->id);
        } else {
            $cashMovementsQuery->whereDate('created_at', Carbon::today());
        }
        $cashMovements = $cashMovementsQuery->get();

        $totalWithdrawals = $cashMovements->where('type', 'withdrawal')->sum('amount');
        $totalDeposits = $cashMovements->where('type', 'deposit')->sum('amount');

        // Calcular totales de la sesión o del día sin sesión
        $dailyTotals = [
            'total_sales' => $sales->count(),
            'total_amount' => $sales->sum('total_amount'),
            'cash_amount' => $sales->where('payment_method', 'efectivo')->sum('total_amount') +
                             $sales->where('payment_method', 'mixto')->sum('cash_amount'), // Incluir efectivo de pagos mixtos
            'card_amount' => $sales->where('payment_method', 'tarjeta')->sum('total_amount') +
                             $sales->where('payment_method', 'mixto')->sum('card_amount'), // Incluir tarjeta de pagos mixtos
            'transfer_amount' => $sales->where('payment_method', 'transferencia')->sum('total_amount'),
        ];

        // Calcular efectivo esperado en caja (efectivo inicial + ventas en efectivo + depósitos - retiros)
        $expectedCashInRegister = $initialCash + $dailyTotals['cash_amount'] + $totalDeposits - $totalWithdrawals;

        // Obtener último arqueo y corte para la sesión activa o del día sin sesión
        $lastCashCountQuery = CashCount::where('user_id', Auth::id())->latest();
        $lastCashCutQuery = CashCut::latest();

        if ($activeSession) {
            $lastCashCountQuery->where('cash_session_id', $activeSession->id);
            $lastCashCutQuery->where('cash_session_id', $activeSession->id);
        } else {
            $lastCashCountQuery->whereDate('created_at', Carbon::today());
            $lastCashCutQuery->whereDate('created_at', Carbon::today());
        }

        $lastCashCount = $lastCashCountQuery->first();
        $lastCashCut = $lastCashCutQuery->first();

        // Generar próximo folio para arqueo
        $nextCashCountFolio = $this->generateNextCashCountFolio();

        // Variable para verificar si hay sesión activa (para JavaScript)
        $hasActiveSession = $activeSession !== null;

        return view('cash_control.index', compact(
            'sales',
            'dailyTotals',
            'lastCashCount',
            'lastCashCut',
            'nextCashCountFolio',
            'initialCash',
            'expectedCashInRegister',
            'totalWithdrawals',
            'totalDeposits',
            'cashMovements',
            'hasActiveSession'
        ));
    }

    /**
     * Realizar arqueo de caja (temporal)
     */
    public function cashCount(Request $request): JsonResponse
    {
        $request->validate([
            'secret_code' => 'required|string',
            'cash_in_register' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // Verificar código secreto - empleados necesitan EBCADMIN, admin/supervisor pueden usar cualquier código
        $validCodes = ['EBCADMIN'];
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'supervisor') {
            $validCodes[] = 'EBCFCADMIN';
        }

        // Normalizar código ingresado a mayúsculas y eliminar espacios
        $inputCode = strtoupper(trim($request->secret_code));

        if (!in_array($inputCode, $validCodes)) {
            return response()->json([
                'success' => false,
                'message' => 'Código secreto incorrecto. No se puede realizar el arqueo.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

            // Verificar que no haya un corte de caja activo para esta sesión
            $activeCashCutQuery = CashCut::where('status', 'open');
            if ($activeSession) {
                $activeCashCutQuery->where('cash_session_id', $activeSession->id);
            } else {
                $activeCashCutQuery->whereDate('created_at', Carbon::today());
            }
            $activeCashCut = $activeCashCutQuery->first();

            if ($activeCashCut) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede realizar arqueo con un corte de caja activo para esta sesión. Primero debe cerrar el corte.'
                ], 400);
            }

            // Obtener ventas de la sesión activa o del día actual si no hay sesión
            $salesQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada')
                ->with(['client', 'user']);

            if ($activeSession) {
                $salesQuery->where('cash_session_id', $activeSession->id);
            } else {
                $salesQuery->whereDate('created_at', Carbon::today());
            }
            $sales = $salesQuery->get();

            // Calcular totales del día
            $totals = [
                'total_sales' => $sales->count(),
                'total_amount' => $sales->sum('total_amount'),
                'cash_amount' => $sales->where('payment_method', 'efectivo')->sum('total_amount') +
                                 $sales->where('payment_method', 'mixto')->sum('cash_amount'), // Incluir efectivo de pagos mixtos
                'card_amount' => $sales->where('payment_method', 'tarjeta')->sum('total_amount') +
                                 $sales->where('payment_method', 'mixto')->sum('card_amount'), // Incluir tarjeta de pagos mixtos
                'transfer_amount' => $sales->where('payment_method', 'transferencia')->sum('total_amount'),
            ];

            // Obtener efectivo inicial de la sesión de caja activa
            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());
            $initialCash = $activeSession ? $activeSession->initial_cash : 0;

            // Obtener movimientos de efectivo (retiros y depósitos) para la sesión o el día
            $cashMovementsQuery = CashMovement::where('user_id', Auth::id());
            if ($activeSession) {
                $cashMovementsQuery->where('cash_session_id', $activeSession->id);
            } else {
                $cashMovementsQuery->whereDate('created_at', Carbon::today());
            }
            $cashMovements = $cashMovementsQuery->get();

            $totalWithdrawals = $cashMovements->where('type', 'withdrawal')->sum('amount');
            $totalDeposits = $cashMovements->where('type', 'deposit')->sum('amount');

            // Calcular diferencia: efectivo inicial + ventas en efectivo + depósitos - retiros vs efectivo actual en caja
            $expected_cash = $initialCash + $totals['cash_amount'] + $totalDeposits - $totalWithdrawals;
            $actual_cash = $request->cash_in_register;
            $difference = $actual_cash - $expected_cash;

            // Contar vouchers de la sesión o del día sin sesión
            $voucherCountQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada')
                ->whereNotNull('voucher_folio');
            if ($activeSession) {
                $voucherCountQuery->where('cash_session_id', $activeSession->id);
            } else {
                $voucherCountQuery->whereDate('created_at', Carbon::today());
            }
            $voucherCount = $voucherCountQuery->count();

            // Agregar información de vouchers al response
            $vouchersQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada')
                ->whereNotNull('voucher_folio');
            if ($activeSession) {
                $vouchersQuery->where('cash_session_id', $activeSession->id);
            } else {
                $vouchersQuery->whereDate('created_at', Carbon::today());
            }
            $vouchers = $vouchersQuery->pluck('voucher_folio')->toArray();

            // Crear arqueo
            $cashCount = CashCount::create([
                'folio' => $this->generateNextCashCountFolio(),
                'user_id' => Auth::id(),
                'cash_session_id' => $activeSession ? $activeSession->id : null, // Asociar con la sesión activa
                'start_date' => now(),
                'end_date' => now(),
                'total_sales' => $totals['total_sales'],
                'total_amount' => $totals['total_amount'],
                'cash_amount' => $totals['cash_amount'],
                'card_amount' => $totals['card_amount'],
                'transfer_amount' => $totals['transfer_amount'],
                'expected_cash' => $expected_cash,
                'actual_cash' => $actual_cash,
                'difference' => $difference,
                'notes' => $request->notes,
                'status' => 'completed',
            ]);

            // Verificar si hay una sesión activa para ofrecer cierre
            $shouldAskForSessionClose = $activeSession ? true : false;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Arqueo de caja realizado exitosamente',
                'cash_count' => $cashCount,
                'totals' => $totals,
                'difference' => $difference,
                'voucher_count' => $voucherCount,
                'vouchers' => $vouchers,
                'ask_for_session_close' => $shouldAskForSessionClose,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar el arqueo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Realizar corte de caja (final del día)
     */
    public function cashCut(Request $request): JsonResponse
    {
        $request->validate([
            'secret_code' => 'required|string',
            'cash_in_register' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // Verificar código secreto - empleados necesitan EBCADMIN, admin/supervisor pueden usar cualquier código
        $validCodes = ['EBCADMIN'];
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'supervisor') {
            $validCodes[] = 'EBCFCADMIN';
        }

        // Normalizar código ingresado a mayúsculas y eliminar espacios
        $inputCode = strtoupper(trim($request->secret_code));

        if (!in_array($inputCode, $validCodes)) {
            return response()->json([
                'success' => false,
                'message' => 'Código secreto incorrecto. No se puede realizar el corte de caja.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

            // Verificar que no haya un corte activo para esta sesión
            $activeCashCutQuery = CashCut::where('status', 'open');
            if ($activeSession) {
                $activeCashCutQuery->where('cash_session_id', $activeSession->id);
            } else {
                $activeCashCutQuery->whereDate('created_at', Carbon::today());
            }
            $activeCashCut = $activeCashCutQuery->first();

            if ($activeCashCut) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un corte de caja activo para esta sesión.'
                ], 400);
            }

            // Obtener todas las ventas de la sesión activa o del día actual si no hay sesión
            $salesQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada')
                ->with(['client', 'user']);

            if ($activeSession) {
                $salesQuery->where('cash_session_id', $activeSession->id);
            } else {
                $salesQuery->whereDate('created_at', Carbon::today());
            }
            $sales = $salesQuery->get();

            // Calcular totales del día
            $totals = [
                'total_sales' => $sales->count(),
                'total_amount' => $sales->sum('total_amount'),
                'cash_amount' => $sales->where('payment_method', 'efectivo')->sum('total_amount') +
                                 $sales->where('payment_method', 'mixto')->sum('cash_amount'), // Incluir efectivo de pagos mixtos
                'card_amount' => $sales->where('payment_method', 'tarjeta')->sum('total_amount') +
                                 $sales->where('payment_method', 'mixto')->sum('card_amount'), // Incluir tarjeta de pagos mixtos
                'transfer_amount' => $sales->where('payment_method', 'transferencia')->sum('total_amount'),
            ];

            // Obtener efectivo inicial de la sesión de caja activa
            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());
            $initialCash = $activeSession ? $activeSession->initial_cash : 0;

            // Obtener movimientos de efectivo (retiros y depósitos) para la sesión o el día
            $cashMovementsQuery = CashMovement::where('user_id', Auth::id());
            if ($activeSession) {
                $cashMovementsQuery->where('cash_session_id', $activeSession->id);
            } else {
                $cashMovementsQuery->whereDate('created_at', Carbon::today());
            }
            $cashMovements = $cashMovementsQuery->get();

            $totalWithdrawals = $cashMovements->where('type', 'withdrawal')->sum('amount');
            $totalDeposits = $cashMovements->where('type', 'deposit')->sum('amount');

            // Calcular diferencia: efectivo inicial + ventas en efectivo + depósitos - retiros vs efectivo actual en caja
            $expected_cash = $initialCash + $totals['cash_amount'] + $totalDeposits - $totalWithdrawals;
            $actual_cash = $request->cash_in_register;
            $difference = $actual_cash - $expected_cash;

            // Contar vouchers de la sesión o del día sin sesión
            $voucherCountQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada')
                ->whereNotNull('voucher_folio');
            if ($activeSession) {
                $voucherCountQuery->where('cash_session_id', $activeSession->id);
            } else {
                $voucherCountQuery->whereDate('created_at', Carbon::today());
            }
            $voucherCount = $voucherCountQuery->count();

            // Agregar información de vouchers al response
            $vouchersQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada')
                ->whereNotNull('voucher_folio');
            if ($activeSession) {
                $vouchersQuery->where('cash_session_id', $activeSession->id);
            } else {
                $vouchersQuery->whereDate('created_at', Carbon::today());
            }
            $vouchers = $vouchersQuery->pluck('voucher_folio')->toArray();

            // Crear corte de caja
            $cashCut = CashCut::create([
                'folio' => $this->generateNextCashCutFolio(),
                'user_id' => Auth::id(),
                'cash_session_id' => $activeSession ? $activeSession->id : null, // Asociar con la sesión activa
                'cut_date' => now(),
                'total_sales' => $totals['total_sales'],
                'total_amount' => $totals['total_amount'],
                'cash_amount' => $totals['cash_amount'],
                'card_amount' => $totals['card_amount'],
                'transfer_amount' => $totals['transfer_amount'],
                'expected_cash' => $expected_cash,
                'actual_cash' => $actual_cash,
                'difference' => $difference,
                'notes' => $request->notes,
                'status' => 'open',
                'secret_code' => $request->secret_code,
            ]);

            // Las ventas ya mantienen sus detalles en sale_details, no necesitamos transferir a tabla histórica
            // Solo marcamos las ventas como transferidas para mantener el historial
            $salesToTransferQuery = Sale::where('status', '!=', 'transferida')
                ->where('status', 'completada');
            if ($activeSession) {
                $salesToTransferQuery->where('cash_session_id', $activeSession->id);
            } else {
                $salesToTransferQuery->whereDate('created_at', Carbon::today());
            }
            $salesToTransferQuery->update(['status' => 'transferida']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Corte de caja realizado exitosamente.',
                'cash_cut' => $cashCut,
                'totals' => $totals,
                'difference' => $difference,
                'voucher_count' => $voucherCount,
                'vouchers' => $vouchers,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar el corte de caja: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar reportes de control de caja
     */
    public function reports(Request $request): View
    {
        $query = Sale::where('status', '!=', 'transferida')->where('status', 'completada')->with(['client', 'user']);

        // Filtros por fecha
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filtro por usuario
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Filtro por método de pago
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        // Calcular totales antes de paginar
        $totalsQuery = clone $query;
        $totals = [
            'total_sales' => $totalsQuery->count(),
            'total_amount' => $totalsQuery->sum('total_amount'),
            'cash_amount' => (clone $totalsQuery)->where('payment_method', 'efectivo')->sum('total_amount'),
            'card_amount' => (clone $totalsQuery)->where('payment_method', 'tarjeta')->sum('total_amount'),
            'transfer_amount' => (clone $totalsQuery)->where('payment_method', 'transferencia')->sum('total_amount'),
        ];

        $sales = $query->orderBy('created_at', 'desc')->paginate(20);

        // Obtener arqueos y cortes
        $cashCounts = CashCount::with('user')
            ->when($request->start_date, function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            })
            ->when($request->user_id, function($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $cashCuts = CashCut::with('user')
            ->when($request->start_date, function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            })
            ->when($request->user_id, function($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cash_control.reports', compact(
            'sales',
            'totals',
            'cashCounts',
            'cashCuts'
        ));
    }

    /**
     * Cerrar corte de caja
     */
    public function closeCashCut(Request $request, CashCut $cashCut): RedirectResponse
    {
        // Verificar que el corte esté abierto
        if ($cashCut->status !== 'open') {
            return back()->with('error', 'El corte de caja ya está cerrado o no se puede cerrar.');
        }

        // Verificar que el usuario sea el mismo que abrió el corte o sea admin
        if ($cashCut->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return back()->with('error', 'Solo el usuario que abrió el corte o un administrador puede cerrarlo.');
        }

        try {
            DB::beginTransaction();

            // Actualizar el corte como cerrado
            $cashCut->update([
                'status' => 'closed',
                'closed_at' => now(),
                'closed_by' => Auth::id(),
            ]);

            DB::commit();

            // Cerrar la sesión de caja asociada si existe
            if ($cashCut->cashSession) {
                $cashCut->cashSession->close();
            }

            // Cerrar sesión del usuario y redirigir al login
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();

            return redirect()->route('login')->with('success', 'Corte de caja cerrado y sesión de venta finalizada. Por favor, inicia sesión de nuevo.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al cerrar el corte de caja: ' . $e->getMessage());
        }
    }

    /**
     * Exportar reportes a PDF
     */
    public function exportReportsPdf(Request $request): \Illuminate\Http\Response
    {
        $query = Sale::where('status', '!=', 'transferida')->where('status', 'completada')->with(['client', 'user']);

        // Aplicar filtros
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }

        // Calcular totales antes de obtener los resultados
        $totalsQuery = clone $query;
        $totals = [
            'total_sales' => $totalsQuery->count(),
            'total_amount' => $totalsQuery->sum('total_amount'),
            'cash_amount' => (clone $totalsQuery)->where('payment_method', 'efectivo')->sum('total_amount'),
            'card_amount' => (clone $totalsQuery)->where('payment_method', 'tarjeta')->sum('total_amount'),
            'transfer_amount' => (clone $totalsQuery)->where('payment_method', 'transferencia')->sum('total_amount'),
            'mixed_amount' => (clone $totalsQuery)->where('payment_method', 'mixto')->sum('total_amount'),
        ];

        $sales = $query->orderBy('created_at', 'desc')->get();

        // Obtener arqueos y cortes
        $cashCounts = CashCount::with('user')
            ->when($request->start_date, function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            })
            ->when($request->user_id, function($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $cashCuts = CashCut::with('user')
            ->when($request->start_date, function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            })
            ->when($request->user_id, function($q) use ($request) {
                $q->where('user_id', $request->user_id);
            })
            ->orderBy('created_at', 'desc')
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

        $pdf = Pdf::loadView('cash_control.reports_pdf', compact(
            'sales',
            'totals',
            'cashCounts',
            'cashCuts',
            'logoBase64'
        ))
        ->setPaper('a4', 'portrait')
        ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream('reportes-control-caja-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Show PDF preview for cash control reports.
     */
    public function reportsPdfPreview(Request $request): View
    {
        $pdfUrl = route('cash_control.export_reports_pdf', $request->query());
        return view('components.pdf-viewer', compact('pdfUrl'));
    }

    /**
     * Generar próximo folio para arqueo
     */
    private function generateNextCashCountFolio()
    {
        $today = Carbon::today()->format('Y-m-d');
        $prefix = 'EBC-ARQ-' . $today . '-';

        $lastCount = CashCount::where('folio', 'like', $prefix . '%')
            ->orderBy('folio', 'desc')
            ->first();

        if ($lastCount) {
            $lastNumber = intval(substr($lastCount->folio, -3));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Generar próximo folio para corte
     */
    private function generateNextCashCutFolio()
    {
        $today = Carbon::today()->format('Y-m-d');
        $prefix = 'EBC-CRTE-' . $today . '-';

        $lastCut = CashCut::where('folio', 'like', $prefix . '%')
            ->orderBy('folio', 'desc')
            ->first();

        if ($lastCut) {
            $lastNumber = intval(substr($lastCut->folio, -3));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Mostrar detalles de un arqueo de caja
     */
    public function showCashCount(CashCount $cashCount): View
    {
        $cashCount->load(['user', 'cashSession']);

        $salesQuery = Sale::where('status', 'completada')
            ->with(['client', 'user'])
            ->orderBy('created_at', 'desc');

        if ($cashCount->cash_session_id) {
            $salesQuery->where('cash_session_id', $cashCount->cash_session_id);
        } else {
            $salesQuery->whereDate('created_at', $cashCount->created_at->toDateString());
        }
        $sales = $salesQuery->get();

        // Contar vouchers de la sesión o del día
        $voucherCountQuery = Sale::where('status', 'completada')
            ->whereNotNull('voucher_folio');
        if ($cashCount->cash_session_id) {
            $voucherCountQuery->where('cash_session_id', $cashCount->cash_session_id);
        } else {
            $voucherCountQuery->whereDate('created_at', $cashCount->created_at->toDateString());
        }
        $voucherCount = $voucherCountQuery->count();
        $vouchers = $voucherCountQuery->pluck('voucher_folio')->filter()->unique()->values();

        return view('cash_control.show_cash_count', compact('cashCount', 'sales', 'voucherCount', 'vouchers'));
    }

    /**
     * Mostrar detalles de un corte de caja
     */
    public function showCashCut(CashCut $cashCut): View
    {
        $cashCut->load(['user', 'cashSession']);

        $salesQuery = Sale::where('status', 'completada')
            ->with(['client', 'user'])
            ->orderBy('created_at', 'desc');

        if ($cashCut->cash_session_id) {
            $salesQuery->where('cash_session_id', $cashCut->cash_session_id);
        } else {
            $salesQuery->whereDate('created_at', $cashCut->created_at->toDateString());
        }
        $sales = $salesQuery->get();

        // Contar vouchers de la sesión o del día
        $voucherCountQuery = Sale::where('status', 'completada')
            ->whereNotNull('voucher_folio');
        if ($cashCut->cash_session_id) {
            $voucherCountQuery->where('cash_session_id', $cashCut->cash_session_id);
        } else {
            $voucherCountQuery->whereDate('created_at', $cashCut->created_at->toDateString());
        }
        $voucherCount = $voucherCountQuery->count();
        $vouchers = $voucherCountQuery->pluck('voucher_folio')->filter()->unique()->values();

        return view('cash_control.show_cash_cut', compact('cashCut', 'sales', 'voucherCount', 'vouchers'));
    }

    /**
     * Mostrar historial de arqueos de caja
     */
    public function cashCountsHistory(Request $request): View
    {
        $query = CashCount::with('user')->orderBy('created_at', 'desc');

        // Filtros
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $cashCounts = $query->paginate(20);

        return view('cash_control.cash_counts', compact('cashCounts'));
    }

    /**
     * Mostrar historial de cortes de caja
     */
    public function cashCutsHistory(Request $request): View
    {
        $query = CashCut::with('user')->orderBy('created_at', 'desc');

        // Filtros
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $cashCuts = $query->paginate(20);

        return view('cash_control.cash_cuts', compact('cashCuts'));
    }

    /**
     * Generar PDF de arqueo de caja
     */
    public function generateCashCountPdf(CashCount $cashCount): \Illuminate\Http\Response
    {
        $cashCount->load(['user', 'cashSession']);

        $salesQuery = Sale::where('status', 'completada')
            ->with(['client', 'user'])
            ->orderBy('created_at', 'desc');

        if ($cashCount->cash_session_id) {
            $salesQuery->where('cash_session_id', $cashCount->cash_session_id);
        } else {
            $salesQuery->whereDate('created_at', $cashCount->created_at->toDateString());
        }
        $sales = $salesQuery->get();

        // Contar vouchers de la sesión o del día
        $voucherCountQuery = Sale::where('status', 'completada')
            ->whereNotNull('voucher_folio');
        if ($cashCount->cash_session_id) {
            $voucherCountQuery->where('cash_session_id', $cashCount->cash_session_id);
        } else {
            $voucherCountQuery->whereDate('created_at', $cashCount->created_at->toDateString());
        }
        $voucherCount = $voucherCountQuery->count();
        $vouchers = $voucherCountQuery->pluck('voucher_folio')->filter()->unique()->values();

        // Convert logo to base64 if it exists and GD is available
        $logoBase64 = null;
        if (extension_loaded('gd')) {
            $logoPath = public_path('images/brand-logo.png');
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $pdf = Pdf::loadView('cash_control.cash_count_pdf', compact('cashCount', 'sales', 'voucherCount', 'vouchers', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream("arqueo-{$cashCount->folio}.pdf");
    }

    /**
     * Show PDF preview for a cash count.
     */
    public function cashCountPdfPreview(CashCount $cashCount): View
    {
        $pdfUrl = route('cash_control.generate_cash_count_pdf', $cashCount);
        return view('components.pdf-viewer', compact('pdfUrl'));
    }

    /**
     * Generar PDF de corte de caja
     */
    public function generateCashCutPdf(CashCut $cashCut): \Illuminate\Http\Response
    {
        $cashCut->load(['user', 'cashSession']);

        $salesQuery = Sale::where('status', 'completada')
            ->with(['client', 'user'])
            ->orderBy('created_at', 'desc');

        if ($cashCut->cash_session_id) {
            $salesQuery->where('cash_session_id', $cashCut->cash_session_id);
        } else {
            $salesQuery->whereDate('created_at', $cashCut->created_at->toDateString());
        }
        $sales = $salesQuery->get();

        // Contar vouchers de la sesión o del día
        $voucherCountQuery = Sale::where('status', 'completada')
            ->whereNotNull('voucher_folio');
        if ($cashCut->cash_session_id) {
            $voucherCountQuery->where('cash_session_id', $cashCut->cash_session_id);
        } else {
            $voucherCountQuery->whereDate('created_at', $cashCut->created_at->toDateString());
        }
        $voucherCount = $voucherCountQuery->count();
        $vouchers = $voucherCountQuery->pluck('voucher_folio')->filter()->unique()->values();

        // Convert logo to base64 if it exists and GD is available
        $logoBase64 = null;
        if (extension_loaded('gd')) {
            $logoPath = public_path('images/brand-logo.png');
            if (file_exists($logoPath)) {
                $logoData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
            }
        }

        $pdf = Pdf::loadView('cash_control.cash_cut_pdf', compact('cashCut', 'sales', 'voucherCount', 'vouchers', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream("corte-{$cashCut->folio}.pdf");
    }

    /**
     * Show PDF preview for a cash cut.
     */
    public function cashCutPdfPreview(CashCut $cashCut): View
    {
        $pdfUrl = route('cash_control.generate_cash_cut_pdf', $cashCut);
        return view('components.pdf-viewer', compact('pdfUrl'));
    }

    /**
     * Muestra el formulario para realizar movimientos de efectivo (retiro/depósito).
     */
    public function showCashMovementForm(): View|RedirectResponse
    {
        $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

        if (!$activeSession || $activeSession->initial_cash <= 0) {
            return redirect()->route('cash_control.index')->with('error', 'Debe tener una sesión de caja activa con efectivo inicial para realizar movimientos de efectivo.');
        }

        return view('cash_control.cash_movement_form', compact('activeSession'));
    }

    /**
     * Procesa un retiro de efectivo de caja.
     */
    public function processCashWithdrawal(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
            'secret_code' => 'required|string',
        ]);

        // Verificar código secreto - empleados necesitan EBCADMIN, admin/supervisor pueden usar cualquier código
        $validCodes = ['EBCADMIN'];
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'supervisor') {
            $validCodes[] = 'EBCFCADMIN';
        }

        if (!in_array($request->secret_code, $validCodes)) {
            return response()->json([
                'success' => false,
                'message' => 'Código secreto incorrecto. No se puede realizar el retiro de efectivo.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

            // Registrar el movimiento de efectivo
            CashMovement::create([
                'cash_session_id' => $activeSession ? $activeSession->id : null,
                'user_id' => Auth::id(),
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'reason' => $request->reason,
                'secret_code' => $request->secret_code,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Retiro de efectivo registrado exitosamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el retiro de efectivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Procesa un ingreso de efectivo a caja.
     */
    public function processCashDeposit(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

            // Registrar el movimiento de efectivo
            CashMovement::create([
                'cash_session_id' => $activeSession ? $activeSession->id : null,
                'user_id' => Auth::id(),
                'type' => 'deposit',
                'amount' => $request->amount,
                'reason' => $request->reason,
                'secret_code' => null, // No se requiere código secreto para depósitos
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ingreso de efectivo registrado exitosamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el ingreso de efectivo: ' . $e->getMessage()
            ], 500);
        }
    }
}
