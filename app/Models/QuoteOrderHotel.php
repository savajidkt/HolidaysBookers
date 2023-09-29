<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteOrderHotel extends Model
{
    use HasFactory;
    protected $table = "quote_hotels";
    protected $fillable = [
        'quote_id',
        'hotel_id',
        'hotel_name',
        'type' // 0 = Offline, 1 = API	
    ];

    public function order_hotel_room()
    {
        return $this->hasMany(QuoteOrderHotelRoom::class, 'quote_hotel_id', 'id');
    }
}
