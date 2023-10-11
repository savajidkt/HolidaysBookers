<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftOrderHotel extends Model
{
    use HasFactory;
    protected $table = "draft_hotels";
    protected $fillable = [
        'draft_id',
        'hotel_id',
        'hotel_name',
        'type' // 0 = Offline, 1 = API	
    ];

    public function order_hotel_room()
    {
<<<<<<< HEAD
        return $this->hasMany(DraftOrderHotelRoom::class, 'order_hotel_id', 'id');
=======
        return $this->hasMany(DraftOrderHotelRoom::class, 'draft_hotel_id', 'id');
>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
    }
}
