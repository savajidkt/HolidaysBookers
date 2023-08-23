<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHotel extends Model
{
    use HasFactory;
    protected $table = "order_hotels";
    protected $fillable = [
        'order_id',
        'hotel_id',
        'hotel_name',
        'type' // 0 = Offline, 1 = API	
    ];

    public function order_hotel_room()
    {
        return $this->hasMany(OrderHotelRoom::class, 'order_hotel_id', 'id');
    }
}
