<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerRepository
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

        $UserArr = [
            'first_name'    => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'    => $data['email_address'],
            'password'    => Hash::make($data['password']),
            'user_type'    => User::CUSTOMER,
            'status'    => User::ACTIVE,
        ];

        $user =  User::create($UserArr);

        $dataSave = [
            'user_id'     => $user->id,
            'dob'     => $data['dob'],
            'country'     => $data['country'],
            'state'     => $data['state'],
            'city'     => $data['city'],
            'zipcode'     => $data['zipcode'],
            'telephone'     => $data['telephone'],
            'mobile_number'     => $data['mobile_number']
        ];
        $customer =  Customer::create($dataSave);
        //$user->notify(new RegisterdEmailNotification($password,$user));
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
