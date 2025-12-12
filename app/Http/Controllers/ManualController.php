<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualController extends Controller
{
    /**
     * Mostrar la página principal de manuales
     */
    public function index()
    {
        $user = auth()->user();
        $availableManuals = [];
        
        // Todos ven su propio manual
        $availableManuals[] = [
            'type' => 'usuario',
            'title' => 'Manual de Usuario',
            'description' => 'Guía básica para realizar ventas, gestionar caja y consultar información.',
            'icon' => 'bi-person-circle',
            'color' => 'primary'
        ];
        
        // Supervisores y admins ven manual de supervisor
        if (in_array($user->role, ['supervisor', 'admin'])) {
            $availableManuals[] = [
                'type' => 'supervisor',
                'title' => 'Manual de Supervisor',
                'description' => 'Gestión de inventario, clientes, proveedores y reportes.',
                'icon' => 'bi-clipboard-check',
                'color' => 'success'
            ];
        }
        
        // Solo admins ven manual de administrador
        if ($user->role === 'admin') {
            $availableManuals[] = [
                'type' => 'administrador',
                'title' => 'Manual de Administrador',
                'description' => 'Administración completa del sistema, usuarios, configuración y base de datos.',
                'icon' => 'bi-shield-lock',
                'color' => 'danger'
            ];
        }
        
        return view('manuals.index', compact('availableManuals'));
    }

    /**
     * Mostrar un manual específico
     */
    public function show($type)
    {
        $user = auth()->user();
        
        // Validar acceso según rol
        $allowedManuals = ['usuario'];
        
        if (in_array($user->role, ['supervisor', 'admin'])) {
            $allowedManuals[] = 'supervisor';
        }
        
        if ($user->role === 'admin') {
            $allowedManuals[] = 'administrador';
        }
        
        // Verificar si el usuario tiene permiso para ver este manual
        if (!in_array($type, $allowedManuals)) {
            abort(403, 'No tienes permiso para ver este manual.');
        }
        
        // Verificar que la vista existe
        if (!view()->exists("manuals.{$type}")) {
            abort(404, 'Manual no encontrado.');
        }
        
        return view("manuals.{$type}");
    }
}
