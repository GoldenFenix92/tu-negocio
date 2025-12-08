<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Product;
use App\Models\Service;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('client', 'items')->latest()->get();
        $events = $appointments->map(function($appointment) {
            return [
                'title' => $appointment->client->name,
                'start' => $appointment->appointment_datetime->toIso8601String(),
                'url' => route('appointments.edit', $appointment)
            ];
        });
        return view('appointments.index', compact('appointments', 'events'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all()->map(function ($product) {
            $product->type = 'product';
            return $product;
        });
        $services = Service::all()->map(function ($service) {
            $service->type = 'service';
            return $service;
        });
        $items = $products->concat($services);

        $allClients = Client::all()->map(function ($client) {
            $client->display_name = $client->full_name;
            return $client;
        });
        $allProducts = Product::all()->map(function ($product) {
            $product->type = 'product';
            return $product;
        });
        $allServices = Service::all()->map(function ($service) {
            $service->type = 'service';
            return $service;
        });
        // Modificado para que allItems solo contenga servicios
        $allItems = $allServices;

        return view('appointments.form', compact('allClients', 'allItems'));
    }

    public function store(Request $request)
    {
        // Decodificar el JSON de items antes de validar
        $items = json_decode($request->input('items'), true);
        $request->merge(['items' => $items]);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'appointment_datetime' => 'required|date',
            'status' => 'required|string',
            'comments' => 'nullable|string', // Add validation for comments
            'items' => 'required|array|min:1',
            'deposit_type' => 'nullable|in:Efectivo,Transferencia',
            'deposit_amount' => 'nullable|numeric|min:0',
            'deposit_folio' => 'nullable|string|unique:appointments,deposit_folio',
        ], [
            'client_id.required' => 'Debes seleccionar un cliente.',
            'items.required' => 'Debes añadir al menos un producto o servicio.',
            'items.min' => 'Debes añadir al menos un producto o servicio.',
            'appointment_datetime.required' => 'La fecha y hora de la cita son obligatorias.',
            'deposit_type.in' => 'El tipo de anticipo debe ser Efectivo o Transferencia.',
            'deposit_amount.numeric' => 'El monto del anticipo debe ser un número.',
            'deposit_amount.min' => 'El monto del anticipo no puede ser negativo.',
            'deposit_folio.unique' => 'El folio de transferencia ya existe.',
        ]);

        $appointmentData = $request->only(['client_id', 'appointment_datetime', 'status', 'comments', 'deposit_type', 'deposit_amount', 'deposit_folio']);
        
        $total = 0;
        foreach ($request->items as $itemData) {
            $model = $itemData['type'] === 'product' ? Product::class : Service::class;
            $item = $model::find($itemData['id']);
            if ($item) {
                $total += $item->price;
            }
        }
        $appointmentData['total'] = $total;

        $appointment = Appointment::create($appointmentData);

        foreach ($request->items as $itemData) {
            $modelClass = $itemData['type'] === 'product' ? Product::class : Service::class;
            $item = $modelClass::find($itemData['id']);
            if ($item) {
                $appointment->items()->create([
                    'itemable_id' => $item->id,
                    'itemable_type' => $modelClass,
                    'price' => $item->price,
                    'quantity' => 1,
                ]);
            }
        }

        return redirect()->route('appointments.index')->with('success', 'Cita creada exitosamente.');
    }

    public function searchClients(Request $request)
    {
        $term = $request->get('term');
        $clients = Client::where(function ($query) use ($term) {
            $query->where('name', 'like', '%' . $term . '%')
                  ->orWhere('paternal_lastname', 'like', '%' . $term . '%')
                  ->orWhere('maternal_lastname', 'like', '%' . $term . '%');
        })->get()->map(function ($client) {
            $client->display_name = $client->full_name;
            return $client;
        });
        return response()->json($clients);
    }

    public function searchItems(Request $request)
    {
        $term = $request->get('term');
        $products = Product::where('name', 'like', '%' . $term . '%')->get()->map(function ($product) {
            $product->type = 'product';
            return $product;
        });
        $services = Service::where('name', 'like', '%' . $term . '%')->get()->map(function ($service) {
            $service->type = 'service';
            return $service;
        });
        $items = $products->concat($services);
        return response()->json($items);
    }

    public function edit(Appointment $appointment)
    {
        $clients = Client::all();
        $products = Product::all()->map(function ($product) {
            $product->type = 'product';
            return $product;
        });
        $services = Service::all()->map(function ($service) {
            $service->type = 'service';
            return $service;
        });
        $items = $products->concat($services);

        $selectedAppointmentItems = $appointment->items->map(function($item) {
            $model = $item->itemable_type === 'App\\Models\\Product' ? \App\Models\Product::find($item->itemable_id) : \App\Models\Service::find($item->itemable_id);
            if ($model) {
                $model->type = $item->itemable_type === 'App\\Models\\Product' ? 'product' : 'service';
                $model->display_name = $model->name; // Ensure display_name is set for consistency
                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'display_name' => $model->name,
                    'type' => $model->type,
                    'price' => $model->price,
                    'sell_price' => $model->sell_price ?? $model->price,
                    'stock' => $model->stock ?? null,
                    'duration_minutes' => $model->duration_minutes ?? null,
                    'quantity' => $item->quantity,
                ];
            }
            return null;
        })->filter()->values();

        $allClients = Client::all()->map(function ($client) {
            $client->display_name = $client->full_name;
            return $client;
        });
        $allProducts = Product::all()->map(function ($product) {
            $product->type = 'product';
            return $product;
        });
        $allServices = Service::all()->map(function ($service) {
            $service->type = 'service';
            return $service;
        });
        // Modificado para que allItems solo contenga servicios
        $allItems = $allServices;

        return view('appointments.form', compact('appointment', 'allClients', 'allItems', 'selectedAppointmentItems'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Decodificar el JSON de items antes de validar
        $items = json_decode($request->input('items'), true);
        $request->merge(['items' => $items]);

        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'appointment_datetime' => 'required|date',
            'status' => 'required|string',
            'comments' => 'nullable|string', // Add validation for comments
            'items' => 'required|array|min:1',
            'deposit_type' => 'nullable|in:Efectivo,Transferencia',
            'deposit_amount' => 'nullable|numeric|min:0',
            'deposit_folio' => 'nullable|string|unique:appointments,deposit_folio,' . $appointment->id,
        ], [
            'client_id.required' => 'Debes seleccionar un cliente.',
            'items.required' => 'Debes añadir al menos un producto o servicio.',
            'items.min' => 'Debes añadir al menos un producto o servicio.',
            'appointment_datetime.required' => 'La fecha y hora de la cita son obligatorias.',
            'deposit_type.in' => 'El tipo de anticipo debe ser Efectivo o Transferencia.',
            'deposit_amount.numeric' => 'El monto del anticipo debe ser un número.',
            'deposit_amount.min' => 'El monto del anticipo no puede ser negativo.',
            'deposit_folio.unique' => 'El folio de transferencia ya existe.',
        ]);

        $appointmentData = $request->only(['client_id', 'appointment_datetime', 'status', 'comments', 'deposit_type', 'deposit_amount', 'deposit_folio']);
        
        $total = 0;
        foreach ($request->items as $itemData) {
            $model = $itemData['type'] === 'product' ? Product::class : Service::class;
            $item = $model::find($itemData['id']);
            if ($item) {
                $total += $item->price;
            }
        }
        $appointmentData['total'] = $total;

        $appointment->update($appointmentData);
        $appointment->items()->delete();

        foreach ($request->items as $itemData) {
            $modelClass = $itemData['type'] === 'product' ? Product::class : Service::class;
            $item = $modelClass::find($itemData['id']);
            if ($item) {
                $appointment->items()->create([
                    'itemable_id' => $item->id,
                    'itemable_type' => $modelClass,
                    'price' => $item->price,
                    'quantity' => 1,
                ]);
            }
        }

        return redirect()->route('appointments.index')->with('success', 'Cita actualizada exitosamente.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
