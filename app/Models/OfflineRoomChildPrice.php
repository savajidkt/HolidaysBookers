<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OfflineRoomChildPrice extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    const NORMAL = 1;
    const BLACKOUTSALE = 2;
    const STOPSALE = 0;

    const STATUS = [
        self::NORMAL => 'NORMAL',
        self::BLACKOUTSALE => 'BLACKOUTSALE',
        self::STOPSALE => 'STOPSALE',
    ];

    protected $fillable = [
        'room_id',
        'price_id',
        'from_date',
        'to_date',
        'min_age',
        'max_age',
        'cwb_price',
        'cnb_price'
    ];

    public function facilities()
    {
        return $this->hasMany(OfflineRoomFacilitiesPrice::class, 'price_id', 'id');
    }
}
