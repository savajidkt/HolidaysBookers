<?php

namespace App\Repositories;

use Exception;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Checkout;
use App\Models\Order_Adult;
use App\Models\Order_Child;
use App\Libraries\Safeencryption;
use App\Models\Booking_payment_details;
use App\Models\Order_Form;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckoutRepository
{

    public function createBooking(array $data): Checkout
    {

        $passenger = [];
        $passenger['adult'] = $data['adult'];
        $passenger['child'] = $data['child'];
        $extra_data = [];
        $extra_data['cartData'] = getBookingCart('bookingCart');
        $extra_data['searchRoomData'] = getSearchCookies('searchGuestArr');
        $extra_data['searchLocation'] = getSearchCookies('location');
        $extra_data['searchCity_id'] = getSearchCookies('hidden_city_id');
        $extra_data['searchCountry_id'] = getSearchCookies('country_id');
        $extra_data['searchFrom'] = getSearchCookies('search_from');
        $extra_data['searchTo'] = getSearchCookies('search_to');
        $dataSave = [
            'user_id'     => auth()->user()->id,
            'adult'     => getSearchCookies('searchGuestAdultCount'),
            'child'     => getSearchCookies('searchGuestChildCount'),
            'room'     => getSearchCookies('searchGuestRoomCount'),
            'city_id'     => getSearchCookies('hidden_city_id'),
            'search_from'     => getSearchCookies('search_from'),
            'search_to'     => getSearchCookies('search_to'),
            'gst_enable'     => isset($data['gst_enable']) ? 1 : 0,
            'registration_number'     => $data['registration_number'],
            'registered_company_name'     => $data['registered_company_name'],
            'registered_company_address'     => $data['registered_company_address'],
            // 'coupon_code'     => $data['coupon_code'],
            // 'coupon_amount'     => $data['coupon_amount'],            
            'total_amount'     => getFinalAmountChackOut(),
            'currency'     => globalCurrency(),
            'payment_method'     => $data['payment_method'],
            'passenger'     => serialize($passenger),
            'extra_data'     => serialize($extra_data),
        ];
        $CheckoutRepository =  Checkout::create($dataSave);
        return $CheckoutRepository;
    }

    public function createOrderBooking(Checkout $checkout): Order
    {
        $user = User::find($checkout->user_id);
        $extra_data = unserialize($checkout->extra_data);
        $passenger = unserialize($checkout->passenger);

        $hotelListingRepository = new HotelListingRepository;
        $hotelsDetails = $hotelListingRepository->hotelDetails(getHotelID($extra_data));
        $passengerLead = getGuestLeadDetails($passenger);
        $OrderData = [];
        $OrderData['hotel_country_id'] = ($hotelsDetails['hotel']['hotel_country']) ? $hotelsDetails['hotel']['hotel_country'] : '';
        $OrderData['hotel_city_id'] = ($hotelsDetails['hotel']['hotel_city']) ? $hotelsDetails['hotel']['hotel_city'] : '';
        $OrderData['hotel_id'] = ($hotelsDetails['hotel']['id']) ? $hotelsDetails['hotel']['id'] : '';
        $OrderData['booking_id'] = '';
        $OrderData['booking_code'] = '';
        $OrderData['confirmation_no'] = '';
        $OrderData['status'] = 1;
        $OrderData['voucher'] = 0;
        $OrderData['original_amount'] = getOriginAmountChackOut($extra_data);
        $OrderData['original_currency'] = globalCurrency();
        $OrderData['booking_amount'] = ($checkout->total_amount) ? $checkout->total_amount : '';
        $OrderData['booking_currency'] = ($checkout->currency) ? $checkout->currency : '';
        $OrderData['agent_code'] = ($user->agents->agent_code) ? $user->agents->agent_code : '';
        $OrderData['agent_email'] = ($user->email) ? $user->email : '';
        $OrderData['hotel_name'] = ($hotelsDetails['hotel']['hotel_name']) ? $hotelsDetails['hotel']['hotel_name'] : '';
        $OrderData['check_in_date'] = ($checkout->search_from) ? $checkout->search_from : '';
        $OrderData['check_out_date'] = ($checkout->search_to) ? $checkout->search_to : '';
        $OrderData['cancelled_date'] = '';
        $OrderData['type'] = 0; //0 = Offline, 1 = API 
        $OrderData['total_rooms'] = getSearchCookies('searchGuestRoomCount');
        $OrderData['total_nights'] = (int) dateDiffInDays($checkout->search_from, $checkout->search_to);
        $OrderData['rating'] = ($hotelsDetails['hotel']['category']) ? $hotelsDetails['hotel']['category'] : 0;
        $OrderData['payment'] = 1;
        $OrderData['comments'] = '';
        $OrderData['guest_lead'] = ($passengerLead['name']) ? $passengerLead['name'] : '';
        $OrderData['guest_phone'] = ($passengerLead['phone']) ? $passengerLead['phone'] : '';
        $OrderData['mail_sent'] = 0;
        $OrderData['booked_by'] = 1;
        $OrderData['prebook_response'] = '';
        $OrderData['booking_response'] = '';
        $OrderData['deadline_date'] = '';
        $OrderData['agent_markup_type'] = $user->agents->agent_global_markups_type;
        $OrderData['agent_markup_val'] = $user->agents->agent_global_markup;
        $OrderData['total_price_markup'] = '';
        $OrderData['is_pay_using'] = $checkout->payment_method;
        $OrderData =  Order::create($OrderData);
        $this->addAdultData($passenger, $OrderData->id);
        $this->addChildData($passenger, $OrderData->id);      
        $this->addFormData($OrderData->id, $checkout->extra_data);      
        $this->addPaymentDetails($OrderData);      
        return $OrderData;
    }

    public function addAdultData($passenger, $OrderID)
    {

        if (is_array($passenger['adult']) && count($passenger['adult']) > 0) {
            foreach ($passenger['adult'] as $key => $value) {
                if (is_array($value) && count($value) > 0) {
                    foreach ($value as $key1 => $value1) {
                        $OrderAdult = [];
                        $OrderAdult['order_id'] = $OrderID;
                        $OrderAdult['first_name'] = isset($passenger['adult']['firstname'][$key1]) ? $passenger['adult']['title'][$key1] . ' ' . $passenger['adult']['firstname'][$key1] : '';
                        $OrderAdult['last_name'] = isset($passenger['adult']['lastname'][$key1]) ? $passenger['adult']['lastname'][$key1] : '';
                        //0 = None, 1 = Aadhaar Card, 2 = Passport, 3 = Driving Licence, 4 = Voters ID Card, 5 = PAN Card, 6 = Other
                        if (isset($passenger['adult']['id_proof'][$key1])) {
                            if ($passenger['adult']['id_proof'][$key1] == "Aadhaar") {
                                $OrderAdult['id_proof_type'] = 1;
                            } else if ($passenger['adult']['id_proof'][$key1] == "Passport") {
                                $OrderAdult['id_proof_type'] = 2;
                            } else if ($passenger['adult']['id_proof'][$key1] == "Driving Licence") {
                                $OrderAdult['id_proof_type'] = 3;
                            } else if ($passenger['adult']['id_proof'][$key1] == "Voters ID Card") {
                                $OrderAdult['id_proof_type'] = 4;
                            } else if ($passenger['adult']['id_proof'][$key1] == "PAN card") {
                                $OrderAdult['id_proof_type'] = 5;
                            } else {
                                $OrderAdult['id_proof_type'] = 0;
                            }
                        }
                        $OrderAdult['id_proof_no'] = isset($passenger['adult']['id_proof_no'][$key1]) ? $passenger['adult']['id_proof_no'][$key1] : '';
                        $OrderAdult['phone'] = isset($passenger['adult']['phonenumber'][$key1]) ? $passenger['adult']['phonenumber'][$key1] : '';
                        Order_Adult::create($OrderAdult);
                    }
                }
                return true;
            }
        }
        return true;
    }

    public function addChildData($passenger, $OrderID)
    {

        if (is_array($passenger['child']) && count($passenger['child']) > 0) {
            foreach ($passenger['child'] as $key => $value) {
                if (is_array($value) && count($value) > 0) {
                    foreach ($value as $key1 => $value1) {
                        $OrderChild = [];
                        $OrderChild['order_id'] = $OrderID;
                        $OrderChild['child_first_name'] = isset($passenger['child']['firstname'][$key1]) ? $passenger['child']['title'][$key1] . ' ' . $passenger['child']['firstname'][$key1] : '';
                        $OrderChild['child_last_name'] = isset($passenger['child']['lastname'][$key1]) ? $passenger['child']['lastname'][$key1] : '';
                        //0 = None, 1 = Aadhaar Card, 2 = Passport, 3 = Driving Licence, 4 = Voters ID Card, 5 = PAN Card, 6 = Other
                        if (isset($passenger['child']['id_proof'][$key1])) {
                            if ($passenger['child']['id_proof'][$key1] == "Aadhaar") {
                                $OrderChild['child_id_proof_type'] = 1;
                            } else if ($passenger['child']['id_proof'][$key1] == "Passport") {
                                $OrderChild['child_id_proof_type'] = 2;
                            } else if ($passenger['child']['id_proof'][$key1] == "Driving Licence") {
                                $OrderChild['child_id_proof_type'] = 3;
                            } else if ($passenger['child']['id_proof'][$key1] == "Voters ID Card") {
                                $OrderChild['child_id_proof_type'] = 4;
                            } else if ($passenger['child']['id_proof'][$key1] == "PAN card") {
                                $OrderChild['child_id_proof_type'] = 5;
                            } else {
                                $OrderChild['child_id_proof_type'] = 0;
                            }
                        }
                        $OrderChild['child_id_proof_no'] = isset($passenger['child']['id_proof_no'][$key1]) ? $passenger['child']['id_proof_no'][$key1] : '';
                        //$OrderChild['child_age'] = isset($passenger['child']['id_proof_no'][$key1]) ? $passenger['child']['id_proof_no'][$key1] : '';                       
                        Order_Child::create($OrderChild);
                    }
                }
                return true;
            }
        }
        return true;
    }

    public function addFormData($OrderID,$extra_data)
    {
        $OrderForm = [];
        $OrderForm['order_id'] = $OrderID;
        $OrderForm['form_data_serialize'] = $extra_data;
        return Order_Form::create($OrderForm);        
    }

    public function addPaymentDetails($order)
    {
        $OrderForm = [];
        $OrderForm['order_id'] = $order->id;
        $OrderForm['total_amount'] = $order->booking_amount;
        $OrderForm['paid_amount'] = $order->booking_amount;
        $OrderForm['remaining_amount'] = 0;
        return Booking_payment_details::create($OrderForm);        
    }

    public function update(array $data, Checkout $checkout): Checkout
    {
        $SafeencryptionObj = new Safeencryption;
        $bookingArr = unserialize($SafeencryptionObj->decode($data['bookingKey']));
        $dataSave = [
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

    public function updateCredit(array $data)
    {
        return WalletTransaction::create($data);        
    }
}
