<?php

namespace App\Http\Controllers;

use App\Models\CashSession;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller as BaseController;

class CashSessionController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar formulario para iniciar sesión de caja
     */
    public function startForm()
    {
        // Verificar si ya hay una sesión activa
        $activeSession = CashSession::getActiveSession(Auth::id());

        if ($activeSession) {
            return redirect()->route('cash_sessions.show', $activeSession)->with('info', 'Ya tienes una sesión de caja activa');
        }

        return view('cash_sessions.start');
    }

    /**
     * Iniciar sesión de caja
     */
    public function start(Request $request): RedirectResponse
    {
        $request->validate([
            'initial_cash' => 'required|numeric|min:0.01',
            'password' => 'required|string',
        ]);

        // Verificar contraseña del usuario
        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->password])) {
            return back()->with('error', 'Contraseña incorrecta. No se puede iniciar la sesión de caja.');
        }

        // Verificar si ya hay una sesión activa
        $activeSession = CashSession::getActiveSession(Auth::id());
        if ($activeSession) {
            return back()->with('error', 'Ya tienes una sesión de caja activa');
        }

        try {
            $startFolio = Sale::generateNextFolio();

            CashSession::create([
                'user_id' => Auth::id(),
                'initial_cash' => $request->initial_cash,
                'start_folio' => $startFolio, // Asignar el folio inicial
                'start_time' => now(),
                'status' => 'active'
            ]);

            return redirect()->route('pos.index')->with('success', 'Sesión de caja iniciada exitosamente. Folio inicial: ' . $startFolio);

        } catch (\Exception $e) {
            return back()->with('error', 'Error al iniciar sesión de caja: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de la sesión de caja
     */
    public function show(CashSession $cashSession): View
    {
        // Admin y supervisor pueden ver todas las sesiones, otros usuarios solo las suyas
        if ($cashSession->user_id !== Auth::id() && !in_array(Auth::user()->role, ['admin', 'supervisor'])) {
            abort(403);
        }

        // Obtener ventas y movimientos de efectivo de la sesión
        $sales = $cashSession->sales()->with(['client', 'details'])->get();
        $cashMovements = $cashSession->cashMovements()->get();

        // Calcular totales
        $totalSales = $sales->sum('total_amount');
        $totalCash = $sales->where('payment_method', 'efectivo')->sum('cash_amount');
        $totalCard = $sales->where('payment_method', 'tarjeta')->sum('card_amount');
        $totalMixed = $sales->where('payment_method', 'mixto')->sum('total_amount');
        $voucherCount = $sales->sum('voucher_count');
        $voucherFolios = $sales->pluck('voucher_folios')->flatten()->filter()->unique()->values();

        // Calcular el total de efectivo, tarjeta y voucher en tiempo real para el reporte
        $totalCashSales = $sales->sum('cash_amount');
        $totalCardSales = $sales->sum('card_amount');
        $totalVoucherSales = $sales->sum('voucher_amount');

        // Calcular movimientos de efectivo (entradas y salidas)
        $cashIn = $cashMovements->where('type', 'deposit')->sum('amount');
        $cashOut = $cashMovements->where('type', 'withdrawal')->sum('amount');

        $currentCashBalance = $cashSession->initial_cash + $totalCashSales + $cashIn - $cashOut;
        $currentCardBalance = $totalCardSales;
        $currentVoucherBalance = $totalVoucherSales;

        return view('cash_sessions.show', compact(
            'cashSession',
            'sales',
            'totalSales',
            'totalCash',
            'totalCard',
            'totalMixed',
            'voucherCount',
            'voucherFolios',
            'cashMovements',
            'currentCashBalance',
            'currentCardBalance',
            'currentVoucherBalance'
        ));
    }

    /**
     * Cerrar sesión de caja
     */
    public function close(CashSession $cashSession): RedirectResponse
    {
        // Verificar que la sesión pertenece al usuario actual y está activa
        if ($cashSession->user_id !== Auth::id() || $cashSession->status !== 'active') {
            return back()->with('error', 'No puedes cerrar esta sesión de caja');
        }

        // Verificar si se ha realizado un corte de caja para esta sesión
        if (!$cashSession->hasCompletedCashCut()) {
            return back()->with('error', 'Debe realizar y cerrar el corte de caja antes de cerrar la sesión de venta.');
        }

        try {
            $cashSession->close();

            return redirect()->route('cash_sessions.show', $cashSession)->with('success', 'Sesión de caja cerrada exitosamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cerrar sesión de caja: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar historial de sesiones de caja (para todos los roles)
     */
    public function index(Request $request): View
    {
        $query = CashSession::with(['user', 'sales'])
            ->orderBy('start_time', 'desc');

        if (Auth::user()->role === 'admin') {
            // Admin puede ver todas las sesiones
            // No se aplica filtro por user_id a menos que se especifique
        } elseif (Auth::user()->role === 'supervisor') {
            // Supervisor puede ver todas las sesiones activas
            // Si no se filtra por status 'active', solo ve sus propias sesiones
            if (!($request->has('status') && $request->status === 'active')) {
                $query->where('user_id', Auth::id());
            }
        } else {
            // Otros usuarios solo pueden ver sus propias sesiones
            $query->where('user_id', Auth::id());
        }

        // Si es admin o supervisor y se filtra por usuario, aplicar filtro
        if ((Auth::user()->role === 'admin' || Auth::user()->role === 'supervisor') && $request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Filtros comunes
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('start_time', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('start_time', '<=', $request->date_to);
        }

        $sessions = $query->paginate(15);

        // Obtener lista de usuarios para el filtro (solo si es admin)
        $users = (Auth::user()->role === 'admin') ? \App\Models\User::whereIn('role', ['admin', 'supervisor', 'empleado'])->get() : collect();

        return view('cash_sessions.index', compact('sessions', 'users'));
    }

    /**
     * Mostrar reporte de sesión de caja
     */
    public function report(CashSession $cashSession): View
    {
        // Admin y supervisor pueden ver reportes de todas las sesiones, otros usuarios solo las suyas
        if ($cashSession->user_id !== Auth::id() && !in_array(Auth::user()->role, ['admin', 'supervisor'])) {
            abort(403);
        }

        // Obtener ventas y movimientos de efectivo de la sesión
        $sales = $cashSession->sales()->with(['client', 'details'])->get();
        $cashMovements = $cashSession->cashMovements()->get();

        // Calcular totales por método de pago
        $paymentSummary = [
            'efectivo' => $sales->where('payment_method', 'efectivo')->sum('total_amount'),
            'tarjeta' => $sales->where('payment_method', 'tarjeta')->sum('total_amount'),
            'transferencia' => $sales->where('payment_method', 'transferencia')->sum('total_amount'),
            'otro' => $sales->where('payment_method', 'otro')->sum('total_amount'),
            'mixto' => $sales->where('payment_method', 'mixto')->sum('total_amount'),
        ];

        // Obtener vouchers únicos
        $vouchers = $sales->pluck('voucher_folios')->flatten()->filter()->unique()->values();

        // Calcular el total de efectivo, tarjeta y voucher en tiempo real para el reporte
        $totalCashSales = $sales->sum('cash_amount');
        $totalCardSales = $sales->sum('card_amount');
        $totalVoucherSales = $sales->sum('voucher_amount');

        // Calcular movimientos de efectivo (entradas y salidas)
        $cashIn = $cashMovements->where('type', 'deposit')->sum('amount');
        $cashOut = $cashMovements->where('type', 'withdrawal')->sum('amount');

        $currentCashBalance = $cashSession->initial_cash + $totalCashSales + $cashIn - $cashOut;
        $currentCardBalance = $totalCardSales;
        $currentVoucherBalance = $totalVoucherSales;

        return view('cash_sessions.report', compact(
            'cashSession',
            'sales',
            'paymentSummary',
            'vouchers',
            'cashMovements',
            'currentCashBalance',
            'currentCardBalance',
            'currentVoucherBalance'
        ));
    }

    /**
     * Cerrar sesión de caja desde admin (para cualquier usuario)
     */
    public function adminClose(CashSession $cashSession): RedirectResponse
    {
        // Solo admin puede usar esta función
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Verificar que la sesión esté activa
        if ($cashSession->status !== 'active') {
            return back()->with('error', 'La sesión de caja ya está cerrada');
        }

        try {
            $cashSession->close();

            return redirect()->route('cash_sessions.show', $cashSession)->with('success', 'Sesión de caja cerrada exitosamente por administrador');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cerrar sesión de caja: ' . $e->getMessage());
        }
    }

    /**
     * Cerrar sesión de caja activa del usuario actual (AJAX)
     */
    public function closeActive(Request $request): JsonResponse
    {
        try {
            // Obtener la sesión activa del usuario actual (funciona para cualquier rol)
            $activeSession = CashSession::getActiveSession(Auth::id());

            if (!$activeSession) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay una sesión de caja activa para cerrar'
                ], 404);
            }

            // Verificar si se ha realizado un corte de caja para esta sesión
            if (!$activeSession->hasCompletedCashCut()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debe realizar y cerrar el corte de caja antes de cerrar la sesión de venta.'
                ], 400);
            }

            // Cerrar la sesión activa del usuario actual
            $activeSession->close();

            return response()->json([
                'success' => true,
                'message' => 'Sesión de caja cerrada exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión de caja: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Check if there's an active cash session for the current user via AJAX.
     */
    public function checkActiveSessionAjax(): JsonResponse
    {
        $activeSession = CashSession::getActiveSession(Auth::id());
        return response()->json(['has_active_session' => (bool)$activeSession]);
    }

    /**
     * Cerrar sesión de cualquier usuario (solo admin)
     */
    public function adminForceClose(CashSession $cashSession): RedirectResponse
    {
        // Admin y supervisor pueden usar esta función
        if (!in_array(Auth::user()->role, ['admin', 'supervisor'])) {
            abort(403);
        }

        // Verificar que la sesión esté activa
        if ($cashSession->status !== 'active') {
            return back()->with('error', 'La sesión de caja ya está cerrada');
        }

        try {
            $cashSession->close();

            return back()->with('success', 'Sesión de caja cerrada exitosamente por administrador');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al cerrar sesión de caja: ' . $e->getMessage());
        }
    }
}
