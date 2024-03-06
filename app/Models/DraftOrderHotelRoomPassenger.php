<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftOrderHotelRoomPassenger extends Model
{
    use HasFactory;
    protected $table = "draft_passengers";
    protected $fillable = [
        'draft_id',
        'draft_hotel_id',
        'hotel_id',        
        'draft_hotel_room_id',
        'room_id',
        'room_price_id',
        'passenger_type',
        'name',
        'id_proof',
        'id_proof_no',
        'phone_code',
        'phone',
        'is_adult',
        'child_age',
        'child_with_bed',
        'nationality_text',    
        'nationality_id'     
    ];

    
}
