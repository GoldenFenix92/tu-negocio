<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class ServiceController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $services = Service::withTrashed()->with('products')->latest()->paginate(24);
        return view('services.index', compact('services'));
    }

    public function create(): View
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('services.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Decode products JSON string to array before validation
        if ($request->has('products') && is_string($request->input('products'))) {
            $request->merge(['products' => json_decode($request->input('products'), true)]);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'is_active' => 'boolean', // Add validation for is_active
        ]);

        // Generar service_id EBC-SERV-###
        $last = Service::where('service_id', 'like', 'EBC-SERV-%')->orderByDesc('id')->first();
        $seq = 1;
        if ($last && preg_match('/(\d{3})$/', $last->service_id, $m)) {
            $seq = intval($m[1]) + 1;
        }
        $validatedData['service_id'] = 'EBC-SERV-' . str_pad($seq, 3, '0', STR_PAD_LEFT);
        $validatedData['is_active'] = $request->boolean('is_active', true); // Default to true

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $request->file('image')->store('services', 'public');
        } else {
            $validatedData['image_path'] = 'images/servicio_comodin.webp'; // Default placeholder image
        }
        unset($validatedData['image']); // Remove the 'image' file object from validated data

        $service = Service::create(collect($validatedData)->except('products')->toArray());
        $service->products()->attach($request->input('products'));

        return redirect()->route('services.index')->with('success', 'Servicio creado.');
    }

    public function edit(Service $service): View
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        $selectedProducts = $service->products->pluck('id')->toArray();
        return view('services.edit', compact('service', 'products', 'selectedProducts'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        // Decode products JSON string to array before validation
        if ($request->has('products') && is_string($request->input('products'))) {
            $request->merge(['products' => json_decode($request->input('products'), true)]);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'is_active' => 'boolean', // Add validation for is_active
        ]);

        $validatedData['is_active'] = $request->boolean('is_active'); // Get is_active status

        if ($request->hasFile('image')) {
            if ($service->image_path && $service->image_path !== 'images/servicio_comodin.webp') {
                Storage::disk('public')->delete($service->image_path);
            }
            $validatedData['image_path'] = $request->file('image')->store('services', 'public');
        } elseif ($request->boolean('remove_image')) { // Option to remove image
            if ($service->image_path && $service->image_path !== 'images/servicio_comodin.webp') { // Revert default image path
                Storage::disk('public')->delete($service->image_path);
            }
            $validatedData['image_path'] = 'images/servicio_comodin.webp'; // Revert default image path
        } else {
            // If no new image and not explicitly removed, keep existing image_path
            unset($validatedData['image_path']);
        }
        unset($validatedData['image']); // Remove the 'image' file object from validated data

        $service->update(collect($validatedData)->except('products')->toArray());
        $service->products()->sync($request->input('products'));

        return redirect()->route('services.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->image_path && $service->image_path !== 'images/servicio_comodin.webp') {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Servicio eliminado.');
    }

    public function restore(Request $request, $id): RedirectResponse
    {
        $service = Service::withTrashed()->find($id);
        if ($service) {
            $service->restore();

            if ($request->hasFile('image')) {
                if ($service->image_path && $service->image_path !== 'images/servicio_comodin.webp') {
                    Storage::disk('public')->delete($service->image_path);
                }
                $service->image_path = $request->file('image')->store('services', 'public');
                $service->save();
            }

            return redirect()->route('services.index')->with('success', 'Servicio reactivado.');
        }
        return back()->with('error', 'Servicio no encontrado.');
    }

    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->is_active = !$service->is_active;
        $service->save();

        return back()->with('success', 'Estado del servicio actualizado.');
    }
}
