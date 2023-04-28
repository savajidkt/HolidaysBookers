<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OfflineRoomFacilitiesPrice extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;   

    protected $table = "offline_room_prices_facilities";

    protected $fillable = [
        'room_id',
        'price_id',
        'title',
        'description',
        'status'
    ];
}
