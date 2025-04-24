<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory ;

    protected $fillable = [
        'name',
        'description',
        'price_per_hour',
        'open_time',
        'close_time',
        'is_available',
    ];

    protected $casts = [
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i'
    ];

    // Relasi ke FieldImages
    public function images()
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
