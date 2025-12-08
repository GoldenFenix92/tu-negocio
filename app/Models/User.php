<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    
    // Define las constantes de Rol para un mejor manejo
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERVISOR = 'supervisor'; // Cambio aplicado
    const ROLE_EMPLEADO = 'empleado';

    const PERMISSIONS = [
        'products.view', 'products.create', 'products.edit', 'products.delete',
        'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
        'suppliers.view', 'suppliers.create', 'suppliers.edit', 'suppliers.delete',
        'pos.access',
        'sales_history.view', 'sales_history.edit', 'sales_history.cancel', 'sales_history.delete',
        'cash_control.access',
        'stock_management.access',
        'user_management.view', 'user_management.create', 'user_management.edit', 'user_management.delete',
        'database.access',
        'clients.view', 'clients.create', 'clients.edit', 'clients.delete',
        'services.view', 'services.create', 'services.edit', 'services.delete',
        'coupons.view', 'coupons.create', 'coupons.edit', 'coupons.delete',
    ];

    public static function getDefaultPermissionsForRole($role)
    {
        switch ($role) {
            case self::ROLE_ADMIN:
                return self::PERMISSIONS; // Admin has all permissions
            case self::ROLE_SUPERVISOR:
                return [
                    'products.view', 'products.create', 'products.edit', 'products.delete',
                    'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
                    'suppliers.view', 'suppliers.create', 'suppliers.edit', 'suppliers.delete',
                    'pos.access',
                    'sales_history.view', 'sales_history.edit', 'sales_history.cancel',
                    'cash_control.access',
                    'stock_management.access',
                    'user_management.view', 'user_management.edit',
                    'clients.view', 'clients.create', 'clients.edit',
                    'services.view', 'services.create', 'services.edit', 'services.delete',
                    'coupons.view', 'coupons.create', 'coupons.edit', 'coupons.delete',
                ];
            case self::ROLE_EMPLEADO:
                return [
                    'products.view', 'products.create',
                    'categories.view', 'categories.create',
                    'suppliers.view', 'suppliers.create',
                    'pos.access',
                    'user_management.view',
                    'clients.view',
                    'services.view',
                    'cash_control.access',
                ];
            default:
                return [];
        }
    }

    public function hasPermissionTo($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }

    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'commission_percentage',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    public function imageUrl(): string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        switch ($this->role) {
            case self::ROLE_ADMIN:
                return asset('images/administrador.webp');
            case self::ROLE_SUPERVISOR:
                return asset('images/supervisor.webp');
            case self::ROLE_EMPLEADO:
                return asset('images/empleado.webp');
            default:
                return asset('images/empleado.webp'); // Fallback to employee image
        }
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
}
