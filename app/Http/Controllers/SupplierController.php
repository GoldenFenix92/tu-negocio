<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class SupplierController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $suppliers = Supplier::latest()->paginate(24);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('suppliers', 'public');
        }

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Proveedor creado exitosamente.');
    }



    public function edit(Supplier $supplier): View
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($supplier->image) {
                Storage::disk('public')->delete($supplier->image);
            }
            $data['image'] = $request->file('image')->store('suppliers', 'public');
        }

        $supplier->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        // Check if supplier has products
        if ($supplier->products()->count() > 0) {
            return redirect()->route('suppliers.index')->with('error', 'No se puede eliminar el proveedor porque tiene productos asociados.');
        }

        if ($supplier->image) {
            Storage::disk('public')->delete($supplier->image);
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado exitosamente.');
    }

    public function toggle(Supplier $supplier): RedirectResponse
    {
        $supplier->update(['is_active' => !$supplier->is_active]);

        $message = $supplier->is_active ? 'Proveedor habilitado.' : 'Proveedor deshabilitado.';

        return redirect()->route('suppliers.index')->with('success', $message);
    }

    public function destroyImage(Supplier $supplier): RedirectResponse
    {
        if ($supplier->image) {
            $imageName = basename($supplier->image);

            if ($imageName !== 'proveedor_comodin.webp') {
                Storage::disk('public')->delete($supplier->image);
                $supplier->image = null;
                $supplier->save();
                return back()->with('success', 'Imagen del proveedor eliminada correctamente.');
            }
        }
        return back()->with('info', 'El proveedor no tiene una imagen personalizada para eliminar.');
    }
}
