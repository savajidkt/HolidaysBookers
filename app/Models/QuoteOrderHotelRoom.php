<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteOrderHotelRoom extends Model
{
    use HasFactory;
    protected $table = "quote_hotel_rooms";
    protected $fillable = [
        'quote_id',
        'quote_hotel_id',
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
        'child_extra',
        'child_with_bed',
        'child_without_bed',
        'request_stay',
        'comments' 
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
