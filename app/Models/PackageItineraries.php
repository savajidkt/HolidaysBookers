<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PackageItineraries extends Authenticatable
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;
    protected $fillable = [
        'package_id',
        'heading',
        'display_order',
        'description'
    ];
}