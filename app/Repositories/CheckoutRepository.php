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

    public function create(array $data): Checkout
    {      

        $SafeencryptionObj = new Safeencryption;
        $bookingArr = unserialize($SafeencryptionObj->decode($data['bookingKey']));
      
        $UserArr = [
            'first_name'    => $data['firstname'],
            'last_name'    => $data['lastname'],
            'email'    => $data['email'],
            'password'    => Hash::make('123456'),
            'user_type'    => User::CUSTOMER            
        ];
        $user =  User::create($UserArr);     
         
        $dataSave = [
            'user_id'     => $user->id,
            'hotel_id'     => $bookingArr['hotel_id'],
            'room_id'     => $bookingArr['room_id'],
            'price_id'     => $bookingArr['price_id'],
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
            'coupon_code'     => '',
            'coupon_amount'     => 0,
            'tax'     => 0,
            'total_amount'     => 0,
        ];
        $CheckoutRepository =  Checkout::create($dataSave); 
        
        return $CheckoutRepository;
    }
}
