<?php

// app/Models/SaleDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
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
        'price' => 'decimal:2',
        'commission_paid' => 'decimal:2',
    ];

    // RELACIONES
    public function sale()
    {
        return $this->belongsTo(Sale::class); // Detalle pertenece a una venta
    }

    public function stylist()
    {
        // Estilista que realizó el servicio (si item_type es 'service')
        return $this->belongsTo(User::class, 'stylist_id');
    }

    // Método para obtener el item específico (producto o servicio)
    public function item()
    {
        return $this->morphTo('item');
    }

    // Método helper para obtener el nombre del item
    public function getItemNameAttribute()
    {
        $item = $this->item;
        return $item ? $item->name : 'Producto no encontrado';
    }

    // Método helper para obtener el SKU del item
    public function getItemSkuAttribute()
    {
        $item = $this->item;
        return $item ? $item->sku : 'N/A';
    }
}
