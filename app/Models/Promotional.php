<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Promotional extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;


    protected $table = "promotionals";
    protected $fillable = [
        'hotel_id',        
        'single_adult',
        'per_room',
        'extra_adult',
        'child_with_bed',
        'child_with_no_bed_0_4',
        'child_with_no_bed_5_12',
        'child_with_no_bed_13_18',
        'date_validity_start',
        'date_validity_end'
    ];  
}
