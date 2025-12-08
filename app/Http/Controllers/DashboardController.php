<?php

namespace App\Http\Controllers;

use App\Models\CashSession;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeSessions = collect(); // Initialize as empty collection

        // Fetch active sessions only for admin and supervisor roles
        if (in_array(Auth::user()->role, ['admin', 'supervisor'])) {
            $activeSessions = CashSession::with(['user', 'sales', 'cashMovements'])
                ->where('status', 'active')
                ->orderBy('start_time', 'desc')
                ->get()
                ->map(function ($session) {
                    // Calculate the total of cash, card, and voucher in real-time
                    $totalCashSales = $session->sales->where('payment_method', 'efectivo')->sum('cash_amount');
                    $totalCardSales = $session->sales->where('payment_method', 'tarjeta')->sum('card_amount');
                    $totalVoucherSales = $session->sales->sum('voucher_amount');

                    // Calculate cash movements (inflows and outflows)
                    $cashIn = $session->cashMovements->where('type', 'deposit')->sum('amount');
                    $cashOut = $session->cashMovements->where('type', 'withdrawal')->sum('amount');

                    $session->current_cash_balance = $session->initial_cash + $totalCashSales + $cashIn - $cashOut;
                    $session->current_card_balance = $totalCardSales;
                    $session->current_voucher_balance = $totalVoucherSales;

                    return $session;
                });
        }

        return view('dashboard', compact('activeSessions'));
    }
}
