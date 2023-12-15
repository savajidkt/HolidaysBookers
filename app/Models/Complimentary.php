<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Complimentary extends Model
{    
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;


    protected $table = "complimentaries";
    protected $fillable = [
        'hotel_id',        
        'room_id',
        'complimentary_name',
        'complimentary_price'
    ];  
}
