<?php

namespace App\Repositories;

use Exception;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Checkout;
use App\Libraries\Safeencryption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckoutRepository
{

    public function createBooking(array $data): Checkout
    {      
        
        $SafeencryptionObj = new Safeencryption;
        $bookingArr = unserialize($SafeencryptionObj->decode($data['bookingKey']));
  
        $dataSave = [   
            'user_id'     => isset(auth()->user()->id) ?  auth()->user()->id : '',         
            'hotel_id'     => $bookingArr['hotel_id'],
            'room_id'     => 1,
            'price_id'     => 1,
            'adult'     => $bookingArr['adult'],
            'child'     => $bookingArr['child'],
            'room'     => $bookingArr['room'],
            'city_id'     => $bookingArr['city_id'],
            'search_from'     => $bookingArr['search_from'],
            'search_to'     => $bookingArr['search_to'],           
            'tax'     => $data['tax_amount'],
            'total_amount'     => $data['total_amount'],
            'bookingKey'     => $data['bookingKey'],
        ];
      
        $CheckoutRepository =  Checkout::create($dataSave);        
        return $CheckoutRepository;
    }

    public function update(array $data, Checkout $checkout): Checkout
    {                 
        $SafeencryptionObj = new Safeencryption;
        $bookingArr = unserialize($SafeencryptionObj->decode($data['bookingKey']));
        $dataSave = [            
            'hotel_id'     => $bookingArr['hotel_id'],
            'room_id'     => 1,
            'price_id'     => 1,
            'adult'     => $bookingArr['adult'],
            'child'     => $bookingArr['child'],
            'room'     => $bookingArr['room'],
            'city_id'     => $bookingArr['city_id'],
            'search_from'     => $bookingArr['search_from'],
            'search_to'     => $bookingArr['search_to'],
            'gst_enable'     => isset($data['gst_enable']) ? 1 : 0,
            'registration_number'     => $data['registration_number'],
            'registered_company_name'     => $data['registered_company_name'],
            'registered_company_address'     => $data['registered_company_address'],
            'coupon_code'     => $data['coupon_code'],
            'coupon_amount'     => $data['coupon_amount'],
            'tax'     => $data['tax'],
            'total_amount'     => $data['total_amount'],                
            'payment_method'     => $data['payment_method'],                
            'passenger'     => $data['passenger'],                
        ];
        
        $checkout->update($dataSave);                       
        return $checkout;
    }
}
