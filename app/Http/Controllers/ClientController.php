<?php

namespace App\Http\Controllers;

use App\Models\Client; // Import the Client model
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect; // Import Redirect facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import Str for string manipulation
// DNS1D is no longer needed here as we are storing the barcode string, not generating an image on the fly in the controller.
// The view will handle displaying the barcode string.

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::withTrashed()->latest()->paginate(20); // Show all clients including soft deleted ones, like users
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'paternal_lastname' => 'required|string|max:255',
            'maternal_lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:clients,email',
            'eight_digit_barcode' => 'required|string|max:8|unique:clients,eight_digit_barcode',
            'image' => 'nullable|image|max:2048',
        ]);

        // Map the form fields to database fields
        $validatedData['first_name'] = $validatedData['name'];

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('clients', 'public');
        }

        $client = Client::create($validatedData);

        // Redirect to the show view for the newly created client
        return Redirect::route('clients.show', $client->id)->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Generate a unique 8-digit barcode.
     */
    protected function generateUniqueBarcode()
    {
        $barcode = null;
        do {
            // Generate a random 8-digit numeric string
            $potentialBarcode = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            // Check if this barcode already exists in the database
            $exists = Client::where('eight_digit_barcode', $potentialBarcode)->exists();
            if (!$exists) {
                $barcode = $potentialBarcode;
            }
        } while ($barcode === null); // Keep generating until a unique one is found

        return $barcode;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'paternal_lastname' => 'required|string|max:255',
            'maternal_lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:clients,email,' . $id, // Allow updating email if it's the same client
            'image' => 'nullable|image|max:2048',
        ]);

        // Map the form fields to database fields
        $validatedData['first_name'] = $validatedData['name'];

        if ($request->hasFile('image')) {
            if ($client->image) {
                Storage::disk('public')->delete($client->image);
            }
            $validatedData['image'] = $request->file('image')->store('clients', 'public');
        }

        // If the barcode is not being updated, ensure it remains unique if it was already set
        if ($request->filled('eight_digit_barcode')) {
            $validatedData['eight_digit_barcode'] = $request->input('eight_digit_barcode');
            // Add validation to ensure the new barcode is unique if it's different from the current one
            if ($client->eight_digit_barcode !== $validatedData['eight_digit_barcode']) {
                $request->validate([
                    'eight_digit_barcode' => 'required|string|max:8|unique:clients,eight_digit_barcode,' . $id,
                ]);
            }
        } else {
            // If barcode is not provided in the update request, and it's currently null,
            // we might want to generate one or leave it null.
            // For now, we'll assume it's either provided or remains null if not set.
            // If the requirement is to always have a barcode, we'd generate one here.
        }

        $client->update($validatedData);

        return Redirect::route('clients.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        if ($client->image) {
            Storage::disk('public')->delete($client->image);
        }
        $client->delete(); // Soft delete the client

        return Redirect::route('clients.index')->with('success', 'Cliente inhabilitado exitosamente.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Request $request, $id)
    {
        $client = Client::withTrashed()->find($id);
        if ($client) {
            $client->restore();
            return redirect()->route('clients.index')->with('success', 'Cliente reactivado exitosamente.');
        }
        return back()->with('error', 'Cliente no encontrado.');
    }

    public function destroyImage(Client $client): \Illuminate\Http\RedirectResponse
    {
        if ($client->image) {
            $imageName = basename($client->image);

            if ($imageName !== 'cliente_comodin.webp') {
                Storage::disk('public')->delete($client->image);
                $client->image = null;
                $client->save();
                return back()->with('success', 'Imagen del cliente eliminada correctamente.');
            }
        }
        return back()->with('info', 'El cliente no tiene una imagen personalizada para eliminar.');
    }

    /**
     * Get the discount for a specific client.
     */
    public function getDiscount(Client $client): JsonResponse
    {
        // If we get a client object, it means the client is registered.
        // Now, let's find the discount for frequent clients.
        $discountCoupon = Coupon::where('name', 'Descuento Cliente Frecuente')->first();

        // If the coupon doesn't exist, let's create it with a default value.
        if (!$discountCoupon) {
            $discountCoupon = Coupon::create([
                'name' => 'Descuento Cliente Frecuente',
                'discount_percentage' => 10.00, // Default value
                'is_active' => true,
            ]);
        }

        Log::info('Client discount coupon query result for client ' . $client->id, [$discountCoupon]);

        if ($discountCoupon && $discountCoupon->is_active) {
            return response()->json([
                'success' => true,
                'discount_percentage' => $discountCoupon->discount_percentage,
            ]);
        }

        return response()->json([
            'success' => false,
            'discount_percentage' => 0,
            'message' => 'El descuento para clientes frecuentes no está activo o no se encontró.'
        ]);
    }
}
