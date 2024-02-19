<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Order_Adult;
use App\Models\Order_Child;
use App\Models\Order_Child_Bed;
use App\Models\Booking_payment_details;
use App\Models\OrderHotelRoomPassenger;
use Exception;

class OrderRepository
{


    public function update(array $data, Order $order): Order
    {
        $dataSave = [
            'status'    => $data['status'],
            'payment_status'    => $data['payment_status'],
            'status_comments'    => isset($data['status_comments']) ? $data['status_comments'] : '',
            'comments'    => $data['comments']
        ];
        if ($order->update($dataSave)) {
            return $order;
        }
        throw new Exception('Order update successfully!');
    }

    public function updatePassenger(array $data, Order $order): Order
    {


        if ($data['type'] == "lead") {

            $dataSave = [
                'lead_passenger_name'    => $data['lead_passenger_name'],
                'lead_passenger_id_proof'    => $data['lead_passenger_id_proof'],
                'lead_passenger_id_proof_no'    => $data['lead_passenger_id_proof_no'],
                'lead_passenger_phone_code'    => $data['lead_passenger_phone_code'],
                'lead_passenger_phone'    => $data['lead_passenger_phone']
                ];
            if ($order->update($dataSave)) {
                return $order;
        }
        } else {
            if (is_array($data['name']) && count($data['name'])  > 0) {
                foreach ($data['name'] as $key => $value) {

       
                $dataUpdate = [
                        'name'    => isset($value) ? $value : '',
                        'id_proof'    => isset($data['id_proof_type'][$key]) ? $data['id_proof_type'][$key] : '',
                        'id_proof_no'    => isset($data['id_proof_no'][$key]) ? $data['id_proof_no'][$key] : '',
                        'phone_code'     => isset($data['phone_code'][$key]) ? $data['phone_code'][$key] : '',
                        'phone'     => isset($data['phone'][$key]) ? $data['phone'][$key] : '',
                ];
                    OrderHotelRoomPassenger::where('id', $key)->update($dataUpdate);
                }
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