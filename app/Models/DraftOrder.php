<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;



class DraftOrder extends Model

{

    protected $table = "draft_masters";

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
        'lead_nationality_text',
        'lead_nationality_id',

        'lead_passenger_id_proof',

        'lead_passenger_id_proof_no',

        'lead_passenger_phone_code',

        'lead_passenger_phone',     
        'agency_reference', 

    ];

    public function draft_hotel()
    {
        return $this->hasMany(DraftOrderHotel::class, 'draft_id', 'id');
    }

    public function draft_hotel_rooms()
    {
        return $this->hasMany(DraftOrderHotelRoom::class, 'draft_id', 'id');
    }



}