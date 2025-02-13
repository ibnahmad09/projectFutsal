<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_method',
        'amount',
        'status',
        'transaction_id',
        'midtrans_response',
        'payment_date'
    ];

    protected $casts = ['payment_date' => 'datetime'];

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
