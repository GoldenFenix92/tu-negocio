<?php

// app/Models/Client.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'paternal_lastname',
        'maternal_lastname',
        'phone',
        'email',
        'eight_digit_barcode',
        'first_name',
        'image',
    ];

    // RELACIONES
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // ACCESSORS
    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->paternal_lastname . ' ' . $this->maternal_lastname);
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/cliente_comodin.webp');
    }
}
