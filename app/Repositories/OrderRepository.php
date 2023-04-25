<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Order_Adult;
use App\Models\Order_Child;
use App\Models\Order_Child_Bed;
use App\Models\Booking_payment_details;
use Exception;

class OrderRepository
{


    public function update(array $data, Order $order): Order
    {
        $dataSave = [
            'status'    => $data['status'],
            'payment'    => $data['payment'],
            'comments'    => $data['comments']
        ];
        if ($order->update($dataSave)) {
            return $order;
        }
        throw new Exception('Order update successfully!');
    }

    public function updatePassenger(array $data, Order $order): Order
    {
        if (count($data['adult']) > 0) {
            foreach ($data['adult'] as $key => $value) {
                $dataUpdate = [
                    'first_name'    => $value['adult_first_name'],
                    'last_name'    => $value['adult_last_name'],
                    'id_proof_type'    => $value['adult_id_proof_type'],
                    'id_proof_no'     => $value['adult_id_proof_no'],
                ];
                Order_Adult::where('id', $value['id'])->where('order_id', $value['order_id'])->update($dataUpdate);
            }
        }

        if (count($data['child']) > 0) {
            foreach ($data['child'] as $key => $value) {
                $dataUpdate = [
                    'child_first_name'    => $value['child_first_name'],
                    'child_last_name'    => $value['child_last_name'],
                    'child_id_proof_type'    => $value['child_id_proof_type'],
                    'child_id_proof_no'     => $value['child_id_proof_no'],
                    'child_age'     => $value['child_age'],
                ];
                Order_Child::where('id', $value['id'])->where('order_id', $value['order_id'])->update($dataUpdate);

                // if (isset($value['order_child_id']) && strlen($value['order_child_id']) > 0) {
                //     $dataUpdate = [
                //         'order_child_id'    => $value['order_child_id'],                        
                //     ];
                //     Order_Child_Bed::where('id', $value['id'])->where('order_id', $value['order_id'])->where('order_child_id', $value['order_child_id'])->update($dataUpdate);
                // }
            }
        }

        return $order;
        throw new Exception('Order update successfully!');
    }


    public function updatePayment(array $data, Order $order): Order
    {

        if (Booking_payment_details::where('order_id', '=', $data['order_id'])->count() > 0) {            
            $booking_payment_details = Booking_payment_details::where('order_id', '=', $data['order_id'])->get();           
            $dataUpdate = [
                'paid_amount'    => ($booking_payment_details[0]->paid_amount + $data['paid_amount']),
                'remaining_amount'     => ($booking_payment_details[0]->remaining_amount - $data['paid_amount'])
            ];
            Booking_payment_details::where('order_id', $data['order_id'])->update($dataUpdate);

        } else {
            // insert
            $dataCreate = [
                'order_id'    => $data['order_id'],
                'total_amount'    => $data['total_amount'],
                'paid_amount'    => $data['paid_amount'],
                'remaining_amount'     => ($data['remaining_amount'] - $data['paid_amount'])
            ];
            Booking_payment_details::create($dataCreate);
        }

        return $order;
        throw new Exception('Order update successfully!');
    }

    /**
     * Method delete
     *
     * @param Order $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Order $order): bool
    {
        if ($order->forceDelete()) {
            return true;
        }

        throw new Exception('Order us delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Order $order): bool
    {
        $order->status = !$input['status'];
        return $order->save();
    }
}
