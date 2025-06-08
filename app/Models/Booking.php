<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'field_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration',
        'total_price',
        'status',
        'payment_method',
        'customer_name',
        'customer_phone',
        'is_manual_booking'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_manual_booking' => 'boolean'
    ];

    // Tambahkan accessor untuk mendapatkan nama customer
    public function getCustomerNameAttribute()
    {
        if ($this->is_manual_booking) {
            return $this->attributes['customer_name'];
        }
        return $this->user ? $this->user->name : 'User tidak tersedia';
    }

    // Tambahkan accessor untuk mendapatkan nomor telepon
    public function getCustomerPhoneAttribute()
    {
        if ($this->is_manual_booking) {
            return $this->attributes['customer_phone'];
        }
        return $this->user ? $this->user->phone : 'Tidak tersedia';
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Field
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    // Relasi ke Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi ke Review
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public static function isTimeValid($fieldId, $bookingDate, $startTime, $endTime)
    {
        return !Booking::where('field_id', $fieldId)
            ->where('booking_date', $bookingDate)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q) use ($startTime, $endTime) {
                          $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                      });
            })
            ->where('status', '!=', 'canceled') // Hanya abaikan booking yang cancelled
            ->exists();
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($booking) {
            if ($booking->status === 'confirmed') {
                throw new \Exception('Tidak dapat menghapus booking yang sudah dikonfirmasi');
            }
        });
    }
}
