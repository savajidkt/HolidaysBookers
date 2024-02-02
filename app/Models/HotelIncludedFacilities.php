<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelIncludedFacilities extends Model
{
    use HasFactory;
    protected $table = "hotel_included_facilities";   


    protected $fillable = [
        'hotel_id',
        'facility_id',
        'facilities_id',
    ];


    public function hotelfacilities()
    {
        return $this->belongsToMany(HotelFacilities::class, 'hotel_included_facilities', 'id', 'facilities_id');
    }

    public function hotelfacilitiy()
    {
        return $this->belongsToMany(HotelFacility::class, 'hotel_included_facilities', 'id', 'facility_id');
    }
    public function hotelfacilitiyOne()
    {
        return $this->hasOne(HotelFacility::class, 'id', 'facility_id');
    }

    public function facilitiesone()
    {
        return $this->hasOne(HotelFacilities::class, 'id', 'facilities_id');
    }

    
}
