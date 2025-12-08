<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->permissions === null) {
            $user->permissions = \App\Models\User::getDefaultPermissionsForRole($user->role);
            $user->save();
        }

        // Siempre redirigir al dashboard
        // Si el usuario es un empleado, verificar si necesita iniciar sesión de caja
        if ($user->role === 'empleado') {
            $activeSession = \App\Models\CashSession::getActiveSession(Auth::id());

            if (!$activeSession) {
                return redirect()->route('cash_sessions.start_form');
            }
        }

        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
