<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricalSale extends Model
{
    use SoftDeletes;

    protected $table = 'historical_sales';

    protected $fillable = [
        'folio',
        'client_id',
        'user_id',
        'subtotal',
        'discount_amount',
        'total_amount',
        'discount_coupon',
        'payment_method',
        'status',
        'sale_date',
        'details',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'sale_date' => 'date',
        'details' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
