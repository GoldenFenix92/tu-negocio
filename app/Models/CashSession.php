<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'initial_cash',
        'total_sales',
        'total_cash',
        'total_card',
        'voucher_count',
        'voucher_folios',
        'start_folio',
        'end_folio',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'initial_cash' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'total_cash' => 'decimal:2',
        'total_card' => 'decimal:2',
        'voucher_folios' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // RELACIONES
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function cashMovements()
    {
        return $this->hasMany(CashMovement::class);
    }

    /**
     * Obtener la sesión de caja activa para un usuario
     */
    public static function getActiveSession($userId)
    {
        return self::where('user_id', $userId)
                  ->where('status', 'active')
                  ->first();
    }

    /**
     * Agregar una venta a la sesión de caja
     */
    public function addSale(Sale $sale)
    {
        $this->increment('total_sales', $sale->total_amount);

        if ($sale->payment_method === 'efectivo') {
            $this->increment('total_cash', $sale->cash_amount);
        } elseif ($sale->payment_method === 'tarjeta') {
            $this->increment('total_card', $sale->card_amount);
        }

        // Actualizar el end_folio con el folio de la última venta
        $this->end_folio = $sale->folio;

        // Si hay vouchers, actualizar el conteo y la lista
        if ($sale->voucher_count > 0) {
            $this->increment('voucher_count', $sale->voucher_count);

            if ($sale->voucher_folios) {
                $currentFolios = $this->voucher_folios ?? [];
                $newFolios = array_merge($currentFolios, $sale->voucher_folios);
                $this->update(['voucher_folios' => $newFolios]);
            }
        }

        $this->save();
    }

    /**
     * Verificar si se ha realizado un corte de caja para esta sesión.
     */
    public function hasCompletedCashCut(): bool
    {
        return $this->hasMany(CashCut::class)->where('status', 'closed')->exists();
    }

    /**
     * Cerrar la sesión de caja
     */
    public function close()
    {
        // Solo marcar las ventas como transferidas, no transferir a tabla histórica
        $this->sales()
            ->where('status', '!=', 'transferida')
            ->where('status', 'completada')
            ->update(['status' => 'transferida']);

        $this->update([
            'status' => 'closed',
            'end_time' => now()
        ]);
    }

    /**
     * Transfer sales to historical table and clear current sales
     */
    public function transferSalesToHistorical()
    {
        $sales = $this->sales()->where('status', '!=', 'transferida')->get();

        foreach ($sales as $sale) {
            // Get details
            $details = $sale->details->map(function($detail) {
                return [
                    'item_type' => $detail->item_type,
                    'item_id' => $detail->item_id,
                    'item_name' => $detail->item ? $detail->item->name : 'N/A',
                    'item_sku' => $detail->item ? $detail->item->sku : 'N/A',
                    'price' => $detail->price,
                    'quantity' => $detail->quantity,
                    'subtotal' => $detail->price * $detail->quantity,
                ];
            })->toArray();

            \App\Models\HistoricalSale::create([
                'folio' => $sale->folio,
                'client_id' => $sale->client_id,
                'user_id' => $sale->user_id,
                'subtotal' => $sale->subtotal,
                'discount_amount' => $sale->discount_amount,
                'total_amount' => $sale->total_amount,
                'discount_coupon' => $sale->discount_coupon,
                'payment_method' => $sale->payment_method,
                'status' => $sale->status,
                'sale_date' => $sale->created_at->toDateString(),
                'details' => $details,
            ]);

            // Delete sale from current table after successful transfer
            $sale->delete();
        }
    }
}
