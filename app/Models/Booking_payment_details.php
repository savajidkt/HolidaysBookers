<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_payment_details extends Model
{
    use HasFactory;
    protected $table = "booking_payment_details";
    protected $fillable = [
        'order_id',
        'total_amount',
        'paid_amount',
        'remaining_amount'
    ];
}
