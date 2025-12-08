<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashCut extends Model
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
        'cut_date' => 'datetime',
        'closed_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'cash_amount' => 'decimal:2',
        'card_amount' => 'decimal:2',
        'transfer_amount' => 'decimal:2',
        'expected_cash' => 'decimal:2',
        'actual_cash' => 'decimal:2',
        'difference' => 'decimal:2',
    ];

    /**
     * Relación con el usuario que realizó el corte
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el usuario que cerró el corte
     */
    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    /**
     * Scope para cortes abiertos
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope para cortes cerrados
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Scope para cortes del día actual
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
            'open' => 'green',
            'closed' => 'red',
            'pending' => 'yellow',
            default => 'gray',
        };
    }

    /**
     * Obtener el estado con texto para la UI
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'open' => 'Abierto',
            'closed' => 'Cerrado',
            'pending' => 'Pendiente',
            default => 'Desconocido',
        };
    }

    /**
     * Verificar si hay diferencia en el corte
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

    /**
     * Verificar si el corte está activo (abierto)
     */
    public function isActive(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Cerrar el corte de caja
     */
    public function close(): bool
    {
        return $this->update(['status' => 'closed']);
    }

    /**
     * Verificar si el corte puede ser modificado
     */
    public function canBeModified(): bool
    {
        return $this->status === 'open';
    }
}
