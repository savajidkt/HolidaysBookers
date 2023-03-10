<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OfflineRoomGallery extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'room_id',
        'images'
    ];
}
