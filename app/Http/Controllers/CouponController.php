<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // Find the specific client discount coupon
        $clientDiscountCoupon = Coupon::where('name', 'Descuento Cliente Frecuente')->first();

        // If it doesn't exist, create it
        if (!$clientDiscountCoupon) {
            $clientDiscountCoupon = Coupon::create([
                'name' => 'Descuento Cliente Frecuente',
                'discount_percentage' => 10.00, // Default value
                'is_active' => true,
            ]);
        }

        $coupons = Coupon::withTrashed()
            ->where('name', '!=', 'Descuento Cliente Frecuente') // Exclude the special coupon from the main list
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('discount_percentage', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('coupons.index', compact('coupons', 'search', 'clientDiscountCoupon'));
    }

    public function create()
    {
        return view('coupons.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:coupons,name',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupons.index')->with('success', 'Cupón creado exitosamente.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupons.form', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coupons')->ignore($coupon->id),
            ],
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        // Ensure 'is_active' is set correctly when the checkbox is unchecked
        $data['is_active'] = $request->has('is_active');

        $coupon->update($data);

        return redirect()->route('coupons.index')->with('success', 'Cupón actualizado exitosamente.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Cupón inhabilitado exitosamente.');
    }

    public function restore($id)
    {
        $coupon = Coupon::withTrashed()->findOrFail($id);
        $coupon->restore();
        return redirect()->route('coupons.index')->with('success', 'Cupón restaurado exitosamente.');
    }

    public function updateClientDiscount(Request $request)
    {
        $request->validate([
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $clientDiscountCoupon = Coupon::where('name', 'Descuento Cliente Frecuente')->firstOrFail();
        $clientDiscountCoupon->update([
            'discount_percentage' => $request->discount_percentage,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Descuento de cliente frecuente actualizado exitosamente.');
    }

    public function getClientDiscount()
    {
        $clientDiscountCoupon = Coupon::where('name', 'Descuento Cliente Frecuente')->first();

        if (!$clientDiscountCoupon) {
            $clientDiscountCoupon = Coupon::create([
                'name' => 'Descuento Cliente Frecuente',
                'discount_percentage' => 10.00, // Default value
                'is_active' => true,
            ]);
        }

        return response()->json([
            'discount_percentage' => $clientDiscountCoupon && $clientDiscountCoupon->is_active ? $clientDiscountCoupon->discount_percentage : 0,
        ]);
    }
}
