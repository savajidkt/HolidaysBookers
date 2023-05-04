<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OfflineRoomCancelationPolicies extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;   

    protected $table = "offline_room_prices_cancelation_policies";

    protected $fillable = [
        'room_id',
        'price_id',
        'start_date',
        'end_date',
        'description'        
    ];
}
