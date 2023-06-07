<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkout extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

   

    protected $table = 'temp_bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',        
        'unique_number',        
        'adult',
        'child',
        'room',
        'city_id',
        'search_from',
        'search_to',
        'gst_enable',
        'registration_number',
        'registered_company_name',
        'registered_company_address',
        'coupon_code',
        'coupon_amount',        
        'total_amount',        
        'currency',        
        'payment_method',
        'passenger',
        'extra_data',
    ];   

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
