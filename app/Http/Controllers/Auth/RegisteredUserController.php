<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDACIÓN
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Regla de Rol: Ahora incluye 'supervisor'
            'role' => ['required', 'in:admin,supervisor,empleado'],
            'registration_token' => ['required', 'string'],
        ]);

        // 2. VERIFICACIÓN DE LA CLAVE DE REGISTRO
        // Obtenemos la clave del archivo config/app.php
        $secretKey = config('app.registration_secret');

        if ($request->registration_token !== $secretKey) {
            // Si la clave es incorrecta, devuelve un error específico
            throw ValidationException::withMessages([
                'registration_token' => __('La Clave de Registro proporcionada es incorrecta.'),
            ]);
        }

        // 3. CREACIÓN DEL USUARIO CON EL ROL Y COMISIÓN
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Guardamos el rol
            'commission_percentage' => 0.0000, // Comisión por defecto
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
