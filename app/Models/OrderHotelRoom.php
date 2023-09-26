<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHotelRoom extends Model
{
    use HasFactory;
    protected $table = "order_hotel_rooms";
    protected $fillable = [
        'order_id',
        'order_hotel_id',
        'hotel_id',
        'room_id',
        'room_price_id',
        'room_name',
        'check_in_date',
        'check_out_date',
        'origin_amount',
        'product_markup_amount',
        'agent_markup_amount',
        'agent_global_markup_amount',
        'price',
        'adult',
        'child',
        'child_with_bed',
        'child_without_bed'        
    ];

    public function order_hotel_room_passenger()
    {
        return $this->hasMany(OrderHotelRoomPassenger::class, 'order_hotel_room_id', 'id');
    }

    public function hotel_details()
    {
        return $this->belongsTo(OfflineHotel::class, 'hotel_id', 'id');
    }
}
