<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'guest_name',
        'appointment_datetime',
        'status',
        'comments',
        'total',
        'deposit_type',
        'deposit_amount',
        'deposit_folio',
    ];

    protected $casts = [
        'appointment_datetime' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(AppointmentItem::class);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'itemable', 'appointment_items')->withPivot('quantity', 'price');
    }

    public function services()
    {
        return $this->morphedByMany(Service::class, 'itemable', 'appointment_items')->withPivot('quantity', 'price');
    }
}
