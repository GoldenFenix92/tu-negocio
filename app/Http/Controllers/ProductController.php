<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $products = Product::with(['category', 'supplier'])->latest()->paginate(24);
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = \App\Models\Supplier::orderBy('name')->get();
        $presentations = ['piezas', 'cajas', 'pares'];
        return view('products.create', compact('categories', 'suppliers', 'presentations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'presentation' => 'required|string|max:50',
            'cost_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'stock' => 'nullable|integer|min:0',
        ]);

        $existingProduct = Product::withTrashed()
            ->where('sku', $request->sku)
            ->orWhere('name', $request->name)
            ->first();

        if ($existingProduct && $existingProduct->trashed()) {
            return back()
                ->with('info', 'El producto ya existe pero está inactivo.')
                ->with('product_id', $existingProduct->id);
        }

        $data = $request->all();

        // Generar product_id EBC-PRDTO-###
        $last = Product::where('product_id', 'like', 'EBC-PRDTO-%')->orderByDesc('id')->first();
        $seq = 1;
        if ($last && preg_match('/(\d{3})$/', $last->product_id, $m)) {
            $seq = intval($m[1]) + 1;
        }
        $data['product_id'] = 'EBC-PRDTO-' . str_pad($seq, 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Producto creado.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = \App\Models\Supplier::orderBy('name')->get();
        $presentations = ['piezas', 'cajas', 'pares'];
        return view('products.edit', compact('product', 'categories', 'suppliers', 'presentations'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'presentation' => 'required|string|max:50',
            'cost_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048', // La imagen es opcional al actualizar
            'stock' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }

    public function restore(Request $request, $id): RedirectResponse
    {
        $product = Product::withTrashed()->find($id);
        if ($product) {
            $product->restore();

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $request->file('image')->store('products', 'public');
                $product->save();
            }

            return redirect()->route('products.index')->with('success', 'Producto reactivado.');
        }
        return back()->with('error', 'Producto no encontrado.');
    }

    public function destroyImage(Product $product): RedirectResponse
    {
        if ($product->image) {
            // Extraer el nombre del archivo de la ruta
            $imageName = basename($product->image);

            // Verificar si la imagen no es la predeterminada
            if ($imageName !== 'producto_comodin.webp') {
                Storage::disk('public')->delete($product->image);
                $product->image = null; // Opcional: establecer a null o a la ruta de la imagen por defecto
                $product->save();
                return back()->with('success', 'Imagen del producto eliminada correctamente.');
            }
        }
        return back()->with('info', 'El producto no tiene una imagen personalizada para eliminar.');
    }
}
