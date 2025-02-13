<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'size',
        'price_per_hour',
        'facilities',
        'open_time',
        'close_time',
        'is_available'
    ];

    protected $casts = [
        'facilities' => 'array',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i'
    ];

    // Relasi ke FieldImages
    public function fieldImages()
    {
        return $this->hasMany(FieldImage::class);
    }

    // Relasi ke Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi ke Schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
