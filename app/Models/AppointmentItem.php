<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'itemable_id',
        'itemable_type',
        'quantity',
        'price',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
