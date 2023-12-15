<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class StopSale extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;


    protected $table = "stopsale";
    protected $fillable = [
        'hotel_id',        
        'stop_sale_date'
    ];  
}
