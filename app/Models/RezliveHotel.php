<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RezliveHotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_country',
        'hotel_city',      
        'hotel_code',
        'hotel_name',      
        'hotel_address',      
        'hotel_review',
        'City',
        'CityId',
        'CountryId'
      
    ];
}
