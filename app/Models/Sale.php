<?php

// app/Models/Sale.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'card_amount' => 'decimal:2',
        'cash_amount' => 'decimal:2',
        'voucher_amount' => 'decimal:2',
        'voucher_folios' => 'array',
        'deleted_at' => 'datetime',
    ];

    // RELACIONES
    public function client()
    {
        return $this->belongsTo(Client::class); // Venta pertenece a un cliente (opcional)
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Venta pertenece al cajero que la registró
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class); // Venta tiene muchos detalles
    }

    public function cashSession()
    {
        return $this->belongsTo(CashSession::class); // Venta pertenece a una sesión de caja
    }

    /**
     * Generar el siguiente folio de venta
     */
    public static function generateNextFolio()
    {
        try {
            // Buscar el último número de folio usado en ambas tablas
            $lastNumber = 0;

            // Buscar en tabla de ventas actuales
            $currentFolios = self::where('folio', 'like', 'EBC-VNTA-%')->pluck('folio');
            foreach ($currentFolios as $folio) {
                if (preg_match('/EBC-VNTA-(\d{3})$/', $folio, $matches)) {
                    $number = intval($matches[1]);
                    if ($number > $lastNumber) {
                        $lastNumber = $number;
                    }
                }
            }

            // No buscar en tabla histórica ya que fue eliminada

            $nextNumber = $lastNumber + 1;

            // Asegurar que el folio no existe ya (evitar duplicados)
            $newFolio = 'EBC-VNTA-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            while (self::where('folio', $newFolio)->exists()) {
                $nextNumber++;
                $newFolio = 'EBC-VNTA-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            return $newFolio;

        } catch (\Exception $e) {
            // Si hay error, generar un folio único con timestamp
            return 'EBC-VNTA-' . date('YmdHis');
        }
    }
}
