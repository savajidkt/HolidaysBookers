<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surcharge extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;


    protected $table = "offline_rooms_surcharge";
    protected $fillable = [
        'hotel_id',        
        'room_id',        
        'surcharge_name',
        'surcharge_price',
        'surcharge_date_start',
        'surcharge_date_end',
        'apply_for',
    ];  
}
