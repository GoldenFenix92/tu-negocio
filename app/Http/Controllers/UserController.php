<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $users = User::withTrashed()->latest()->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = [
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_SUPERVISOR => 'Supervisor',
            User::ROLE_EMPLEADO => 'Empleado'
        ];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_SUPERVISOR . ',' . User::ROLE_EMPLEADO,
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'commission_percentage' => $request->commission_percentage ?? 0,
            'permissions' => User::getDefaultPermissionsForRole($request->role),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user): View
    {
        $roles = [
            User::ROLE_ADMIN => 'Administrador',
            User::ROLE_SUPERVISOR => 'Supervisor',
            User::ROLE_EMPLEADO => 'Empleado'
        ];

        $permissions = [];
        $auth_user = auth()->user();

        if ($auth_user->isAdmin()) {
            $permissions = User::PERMISSIONS;
        } elseif ($auth_user->role === 'supervisor') {
            $permissions = $auth_user->permissions ?? [];
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:' . User::ROLE_ADMIN . ',' . User::ROLE_SUPERVISOR . ',' . User::ROLE_EMPLEADO,
            'commission_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'commission_percentage' => $request->commission_percentage ?? 0,
        ];

        $auth_user = auth()->user();
        $requested_permissions = $request->input('permissions', []);

        // If the role is being changed, reset the permissions to the default for the new role
        if ($user->role !== $request->role) {
            $data['permissions'] = User::getDefaultPermissionsForRole($request->role);
        } else {
            if ($auth_user->role === 'supervisor') {
                $supervisor_permissions = $auth_user->permissions ?? [];
                // Filter out permissions that the supervisor doesn't have
                $data['permissions'] = array_intersect($requested_permissions, $supervisor_permissions);
            } elseif($auth_user->isAdmin()) {
                // Admin can grant any permission
                $data['permissions'] = $requested_permissions;
            }
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        // Soft delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario inhabilitado exitosamente.');
    }

    public function restore(Request $request, $id): RedirectResponse
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            return redirect()->route('users.index')->with('success', 'Usuario reactivado exitosamente.');
        }
        return back()->with('error', 'Usuario no encontrado.');
    }
}
