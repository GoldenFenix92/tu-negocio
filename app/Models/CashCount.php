<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashCount extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Relación con la sesión de caja
     */
    public function cashSession(): BelongsTo
    {
        return $this->belongsTo(CashSession::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'cash_amount' => 'decimal:2',
        'card_amount' => 'decimal:2',
        'transfer_amount' => 'decimal:2',
        'expected_cash' => 'decimal:2',
        'actual_cash' => 'decimal:2',
        'difference' => 'decimal:2',
    ];

    /**
     * Relación con el usuario que realizó el arqueo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para arqueos completados
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope para arqueos del día actual
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Obtener el estado con color para la UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'completed' => 'green',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Obtener el estado con texto para la UI
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'completed' => 'Completado',
            'pending' => 'Pendiente',
            'cancelled' => 'Cancelado',
            default => 'Desconocido',
        };
    }

    /**
     * Verificar si hay diferencia en el arqueo
     */
    public function hasDifference(): bool
    {
        return abs($this->difference) > 0.01; // Considerar diferencia si es mayor a 1 centavo
    }

    /**
     * Obtener el tipo de diferencia (falta o sobra)
     */
    public function getDifferenceTypeAttribute(): string
    {
        if ($this->difference > 0) {
            return 'sobra';
        } elseif ($this->difference < 0) {
            return 'falta';
        }
        return 'exacto';
    }
}
