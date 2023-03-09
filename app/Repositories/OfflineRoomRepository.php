<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\Customer;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Hash;

class OfflineRoomRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Customer
     */
    public function create(array $data): Customer
    {
        if( is_array($data['rooms']) && count($data['rooms']) > 0 ){
            $hotel_id = $data['hotel_id'];
            foreach ($$data['rooms'] as $key => $value) {                

                // Insert Room code here...
                //$user =  User::create($UserArr);
            }
        }
               
        return $customer;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Customer $customer [explicite description]
     *
     * @return Customer
     * @throws Exception
     */
    public function update(array $data, Customer $customer): Customer
    {

        $password = $data['password'];
        $UserArr = [
            'first_name'    => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'    => $data['email_address'],
            'status'    => $data['status'],
        ];
        if (isset($password)) {
            $UserArr['password'] = Hash::make($password);
        }
        if ($customer->user->update($UserArr)) {
            $dataSave = [
                'dob'     => $data['dob'],
                'country'     => $data['country'],
                'state'     => $data['state'],
                'city'     => $data['city'],
                'zipcode'     => $data['zipcode'],
                'telephone'     => $data['telephone'],
                'mobile_number'     => $data['mobile_number']
            ];
            $customer->update($dataSave);
        }

        return $customer;
        throw new Exception('Customer update failed.');
    }

    /**
     * Method delete
     *
     * @param Customer $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Customer $customer): bool
    {
        if ($customer->user->forceDelete()) {
            return true;
        }

        throw new Exception('Customer delete failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, User $user): bool
    {
        $user->status = !$input['status'];
        return $user->save();
    }   
}
