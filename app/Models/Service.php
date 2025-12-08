<?php

// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The products that belong to the service.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'service_product', 'service_id', 'product_id');
    }

    /**
     * Get the URL for the service's image.
     */
    public function imageUrl(): string
    {
        if ($this->image_path === 'images/servicio_comodin.webp') {
            return asset('images/servicio_comodin.webp');
        }
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/servicio_comodin.webp');
    }

    // NOTA: Los servicios se relacionan con las ventas a través de SaleDetail.

    public function appointments()
    {
        return $this->morphToMany(Appointment::class, 'itemable', 'appointment_items')->withPivot('quantity', 'price');
    }
}
