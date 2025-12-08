<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Category extends Model
{
    protected $fillable = ['name', 'is_active', 'image'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/categoria_comodin.webp');
    }
}
