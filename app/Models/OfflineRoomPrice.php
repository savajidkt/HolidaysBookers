<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OfflineRoomPrice extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const NORMAL = 1;
    const BLACKOUTSALE = 2;
    const STOPSALE = 0;

    const PRICE_TYPE = [
        self::NORMAL => 'NORMAL',
        self::BLACKOUTSALE => 'BLACKOUTSALE',
        self::STOPSALE => 'STOPSALE',
    ];

    protected $fillable = [
        'room_id',
        'from_date',
        'to_date',
        'single_adult_price',
        'adult_price',
        'extra_bed_price',
        'price_type'        
    ];
}
