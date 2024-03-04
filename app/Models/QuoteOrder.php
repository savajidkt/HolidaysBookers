<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteOrder extends Model
{
    protected $table = "quote_masters";
    use HasFactory, Notifiable;
 
    //protected $table = "reachus";
    protected $fillable = [       
        'original_amount',
        'original_currency',
        'booking_amount',
        'booking_currency',
        'tax',
        'tax_amount',
        'agent_markup_type',
        'agent_markup_val',
        'total_price_markup',
        'quote_name',
        'agent_code',
        'agent_email',
        'total_adult',
        'total_child',
        'total_child_with_bed',
        'total_child_without_bed',
        'total_rooms',
        'total_nights',       
        'comments',        
        'passenger_type',
        'lead_passenger_name',
        'lead_passenger_id_proof',
        'lead_passenger_id_proof_no',
        'lead_passenger_phone_code',
        'lead_passenger_phone', 
        'agency_reference',     
        // 'extra_margin_type',      
        // 'extra_margin_amt',      
        // 'extra_quote_email',      
    ];

    public function quote_hotel()
    {
        return $this->hasMany(QuoteOrderHotel::class, 'quote_id', 'id');
    }

    public function quote_hotel_rooms()
    {
        return $this->hasMany(QuoteOrderHotelRoom::class, 'quote_id', 'id');
    }
}
