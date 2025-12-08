<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $movements = StockMovement::with(['product', 'user' => function($query) {
            $query->withTrashed();
        }])->latest()->paginate(20);
        return view('stock_movements.index', compact('movements'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();
        $types = ['in' => 'Entrada', 'out' => 'Salida', 'adjustment' => 'Ajuste'];
        return view('stock_movements.create', compact('products', 'types'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        $product = Product::find($request->product_id);
        $quantity = $request->quantity;

        if ($request->type === 'out' && $product->stock < $quantity) {
            return back()->withErrors(['quantity' => 'No hay suficiente stock disponible.']);
        }

        // Update stock
        if ($request->type === 'in') {
            $product->increment('stock', $quantity);
        } elseif ($request->type === 'out') {
            $product->decrement('stock', $quantity);
        } elseif ($request->type === 'adjustment') {
            $product->update(['stock' => $quantity]);
        }

        // Create movement record
        StockMovement::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $quantity,
            'reason' => $request->reason,
            'user_id' => Auth::id(),
            'reference' => null,
        ]);

        return redirect()->route('stock_movements.index')->with('success', 'Movimiento de stock registrado.');
    }
}
