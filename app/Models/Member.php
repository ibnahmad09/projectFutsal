<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_date',
        'weeks_completed',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
