<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHotelRoomPassenger extends Model
{
    use HasFactory;
    protected $table = "order_passengers";
    protected $fillable = [
        'order_id',
        'order_hotel_id',
        'hotel_id',        
        'order_hotel_room_id',
        'room_id',
        'room_price_id',
        'passenger_type',
        'name',
        'id_proof',
        'id_proof_no',
        'phone',
        'is_adult',
        'child_age',
        'child_with_bed'    
    ];

    
}
