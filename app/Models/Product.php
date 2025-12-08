<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\StockMovement;
use App\Models\Service; // Import the Service model

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'category_id',
        'supplier_id',
        'presentation',
        'cost_price',
        'sell_price',
        'image',
        'stock',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function imageUrl(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/producto_comodin.webp');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * The services that belong to the product.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_product', 'product_id', 'service_id');
    }

    public function appointments()
    {
        return $this->morphToMany(Appointment::class, 'itemable', 'appointment_items')->withPivot('quantity', 'price');
    }
}
