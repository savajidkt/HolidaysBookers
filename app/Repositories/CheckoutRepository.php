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
use App\Models\DraftOrder;
use App\Models\DraftOrderHotel;
use App\Models\DraftOrderHotelRoom;
use App\Models\DraftOrderHotelRoomPassenger;
use App\Models\OfflineHotel;
use App\Models\OfflineRoom;
use App\Models\Order_Child_Bed;
use App\Models\Order_Form;
use App\Models\Order_Room;
use App\Models\OrderHotel;
use App\Models\OrderHotelRoom;
use App\Models\OrderHotelRoomPassenger;
use App\Models\QuoteOrder;
use App\Models\QuoteOrderHotel;
use App\Models\QuoteOrderHotelRoom;
use App\Models\QuoteOrderHotelRoomPassenger;
use App\Models\RoomType;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckoutRepository
{

    protected $order_Rooms;
    public function createBooking(array $data): Checkout
    {
        
        $extra_data = [];
        $extra_data['cartData'] = getBookingCart('bookingCart');
        $extra_data['searchRoomData'] = getSearchCookies('searchGuestArr');
        $extra_data['searchLocation'] = getSearchCookies('location');
        $extra_data['searchCity_id'] = getSearchCookies('hidden_city_id');
        $extra_data['searchCountry_id'] = getSearchCookies('country_id');
        $extra_data['searchFrom'] = getSearchCookies('search_from');
        $extra_data['searchTo'] = getSearchCookies('search_to');
        $extra_data['passenger_type'] = $data['passengers'];
        $extra_data['taxes_and_fees'] = $data['Taxes_and_fees'];
        $extra_data['taxes_and_fees_amt'] = $data['Taxes_and_fees_amt'];
        $extra_data['button_name'] = $data['button_name'];
        $extra_data['lead_passengers_country_code'] = $data['lead_passengers_country_code'];
        $extra_data['all_passengers_country_code'] = $data['all_passengers_country_code'];
        $adultCount = 0;
        $childCount = 0;
        $roomCount = count($extra_data['cartData']);

        if (count($extra_data['cartData']) > 0) {
            $i = 1;           
            foreach ($data['hotel'] as $key => $value) {
                $adultCount = $adultCount + (int) $value['room_no_' . $i]['adults'];
                $childCount = $childCount + (int) $value['room_no_' . $i]['childs'];
                $i++;
            }
        }

        if( $data['passengers'] == "lead" ){
            $learArr=[];
            $learArr['name'] = $data['lead_title'] . ' ' . $data['lead_firstname'] . ' ' . $data['lead_lastname'];
            $learArr['id_proof']= $data['lead_id_proof'];
            $learArr['id_proof_no']= $data['lead_id_proof_no'];
            $learArr['phone']= $data['lead_phonenumber'];           
            $extra_data['lead_passenger'] = $learArr;      
        } else {
            if (count($extra_data['cartData']) > 0) {
                $i = 1;
                foreach ($data['hotel'] as $key => $value) {
                    $learArr = [];
                    $extra_data['passenger'][] = $value['room_no_' . $i];
                    $i++;
                }
            }
        }

        $dataSave = [
            'user_id'     => auth()->user()->id,
            'adult'     => $adultCount,
            'child'     => $childCount,
            'room'     => $roomCount,
            'city_id'     => getSearchCookies('hidden_city_id'),
            'search_from'     => getSearchCookies('search_from'),
            'search_to'     => getSearchCookies('search_to'),
            'gst_enable'     => isset($data['gst_enable']) ? 1 : 0,
            'registration_number'     => $data['registration_number'],
            'registered_company_name'     => $data['registered_company_name'],
            'registered_company_address'     => $data['registered_company_address'],
            'agency_reference'     => $data['agency_reference'],
            // 'coupon_amount'     => $data['coupon_amount'],            
            'total_amount'     => getFinalAmountChackOut(),
            'currency'     => globalCurrency(),
            'payment_method'     => isset($data['payment_method']) ? $data['payment_method'] : 0,
            'passenger'     => serialize($this->roomPassenger($data)),
            'extra_data'     => serialize($extra_data),
            'unique_number'     => generateUniqueNumber('order', $langth=4),
        ];
        $CheckoutRepository =  Checkout::create($dataSave);
        return $CheckoutRepository;
    }

    public function roomPassenger($data)
    {
        $passenger = [];
        $roomCount = getSearchCookies('searchGuestRoomCount');
        if ($roomCount > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {
                if ($i <= $roomCount) {
                    $passenger['room_' . $i] = $value['room_no_' . $i];
                    $i++;
                }
            }
        }
        return $passenger;
    }

    public function createOrderBooking(Checkout $checkout, $paymentResponce = '', $WalletTransaction_id = ''): Order
    {
        $user = User::find($checkout->user_id);
        $extra_data = unserialize($checkout->extra_data);

        $phone_code = "";
        $this->order_Rooms = $extra_data['cartData'];
        $passenger = unserialize($checkout->passenger);
        $passengerLead = [];
        $passenger_type = 0;
        if( $extra_data['passenger_type'] == "all" ){
            $passengerLead = $extra_data['passenger'];
            $passenger_type = 1;
            $phone_code = $extra_data['all_passengers_country_code'];
        } else {
            $passenger_type = 0;
            $passengerLead = $extra_data['lead_passenger'];
            $phone_code = $extra_data['lead_passengers_country_code'];
        }

        

        $OrderData = [];
        $OrderData['prn_number'] = InvoiceNumberGenerator('PRN');
        $OrderData['booking_id'] = '';
        $OrderData['booking_code'] = InvoiceNumberGenerator();
        $OrderData['invoice_no'] = InvoiceNumberGenerator('HB');
        $OrderData['confirmation_no'] = '';
        $OrderData['voucher'] = 0;

        $OrderData['order_amount'] = getOriginAmountChackOut($extra_data);
        $OrderData['order_currency'] = trim($checkout->currency);

        $taxAmt = isset($extra_data['taxes_and_fees_amt']) ? $extra_data['taxes_and_fees_amt'] : 0;
        $OrderData['booking_amount'] = ($checkout->total_amount) ? $checkout->total_amount + $taxAmt : '';
        $OrderData['booking_currency'] = ($checkout->currency) ? $checkout->currency : '';

        $OrderData['tax'] = ($extra_data['taxes_and_fees']) ? $extra_data['taxes_and_fees'] : 0;
        $OrderData['tax_amount'] = ($extra_data['taxes_and_fees_amt']) ? $extra_data['taxes_and_fees_amt'] : 0;

        $OrderData['agent_markup_type'] = $user->agents->agent_global_markups_type ?? '';
        $OrderData['agent_markup_val'] = $user->agents->agent_global_markup ?? '';
        $OrderData['total_price_markup'] = 0;
        $OrderData['agent_code'] = ($user->agents->agent_code) ? $user->agents->agent_code : '';
        $OrderData['agent_email'] = ($user->email) ? $user->email : '';
        $OrderData['total_adult'] = $checkout->adult;
        $OrderData['total_child'] = $checkout->child;
        $OrderData['total_child_with_bed'] = 0;
        $OrderData['total_child_without_bed'] = 0;
        $OrderData['total_rooms'] = $checkout->room;
        $OrderData['total_nights'] = (int) dateDiffInDays($checkout->search_from, $checkout->search_to);
        $OrderData['payment_status'] = 1;
        if ($extra_data['button_name'] == "Draft") {
            $OrderData['payment_status'] = 0;
        } else {
            $OrderData['payment_status'] = 1; //0 = No, 1 = Yes
        }
        $OrderData['comments'] = '';       
        $OrderData['mail_sent'] = 0;
        $OrderData['booked_by'] = 1;
        $OrderData['prebook_response'] = '';
        $OrderData['booking_response'] = '';
        $OrderData['razorpay_responce'] = serialize($paymentResponce);        
        $OrderData['is_pay_using'] = ($checkout->payment_method) ? $checkout->payment_method : 0;
        $OrderData['passenger_type'] = $passenger_type;
        $OrderData['lead_passenger_name'] = isset($extra_data['lead_passenger']['name']) ? $extra_data['lead_passenger']['name'] : '';
        $OrderData['lead_passenger_id_proof'] = isset($extra_data['lead_passenger']['id_proof']) ? $extra_data['lead_passenger']['id_proof'] : '';
        $OrderData['lead_passenger_id_proof_no'] = isset($extra_data['lead_passenger']['id_proof_no']) ? $extra_data['lead_passenger']['id_proof_no'] : '';
        $OrderData['lead_passenger_phone_code'] = isset($phone_code) ? $phone_code : '';
        $OrderData['lead_passenger_phone'] = isset($extra_data['lead_passenger']['phone']) ? $extra_data['lead_passenger']['phone'] : '';
        if ($extra_data['button_name'] == "Draft") {
            $OrderData['order_type'] = 0;
        } else {
        $OrderData['order_type'] = 1; //0 = Draft, 1 = Order 
        }

        $OrderData['status'] = 1; //1 = Processed, 2 = Confirmed, 3 = Cancelled, 4 = Vouchered     
        $OrderData =  Order::create($OrderData);

        if (strlen($WalletTransaction_id) > 0 && $WalletTransaction_id > 0) {
            WalletTransaction::where('id', $WalletTransaction_id)->update(['pnr' => $OrderData->prn_number]);
        }

        $dataSave = [
            'order_id'        => $OrderData->id,
            'total_amount'        => $OrderData->booking_amount,
            'paid_amount'     => $OrderData->booking_amount,                        
        ];
        Booking_payment_details::create($dataSave);

        $this->addOrderHotels($extra_data, $OrderData->id, $passengerLead);

        // Below code implement is pendding

        //$this->addOrderPackage($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderTransfere($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderSightseeing($extra_data, $OrderData->id, $passengerLead);       

        return $OrderData;
    }

    public function addOrderPackage($cartHotel, $OrderID, $passengerLead)
    {
    }
    public function addOrderTransfere($cartHotel, $OrderID, $passengerLead)
    {
    }
    public function addOrderSightseeing($cartHotel, $OrderID, $passengerLead)
    {
    }

    public function addOrderHotels($cartHotel, $OrderID, $passengerLead)
    {
        if ($cartHotel['cartData'] > 0) {
            $addHotel = [];
            $addHotel['order_id'] = $OrderID;
            foreach ($cartHotel['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                $hotelsDetails =  OfflineHotel::find($value['hotel_id']);
                $addHotel['hotel_id'] = $hotelsDetails->id;
                $addHotel['hotel_name'] = $hotelsDetails->hotel_name;
                $addHotel['type'] = $hotelsDetails->hotel_type;
                $hotelData = OrderHotel::create($addHotel);
                $this->addOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead);
            }
        }
            }
        }
        return true;
    }

    public function addOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead)
    {
        if (count($value) > 0) {
            $roomType = OfflineRoom::find($value['room_id']);
            $addHotelRoom = [];
            $addHotelRoom['order_id'] = $OrderID;
            $addHotelRoom['order_hotel_id'] = $hotelData->id;
            $addHotelRoom['hotel_id'] = $value['hotel_id'];
            $addHotelRoom['room_id'] = $value['room_id'];
            $addHotelRoom['room_price_id'] = $value['price_id'];
            $addHotelRoom['room_name'] = $roomType->roomtype->room_type;
            $addHotelRoom['check_in_date'] = $value['search_from'];
            $addHotelRoom['check_out_date'] = $value['search_to'];
            $addHotelRoom['origin_amount'] = $value['originAmount'];
            $addHotelRoom['product_markup_amount'] = $value['productMarkupAmount'];
            $addHotelRoom['agent_markup_amount'] = $value['agentMarkupAmount'];
            $addHotelRoom['agent_global_markup_amount'] = $value['agentGlobalMarkupAmount'];
            $addHotelRoom['price'] = $value['finalAmount'];
            $addHotelRoom['adult'] = $value['adult'];
            $addHotelRoom['child'] = $value['child'];
            $addHotelRoom['child_with_bed'] = 0;
            $addHotelRoom['child_without_bed'] = 0;
            $hotelRoomData = OrderHotelRoom::create($addHotelRoom);
            $this->addOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead);
        }
        return true;
    }

    public function addOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead)
    {
        

        if (count($value) > 0) {

            if (isset($cartHotel['passenger']) && count($cartHotel['passenger']) > 0) {
                foreach ($cartHotel['passenger'] as $key => $value1) {

                    if ($value1['hotel_id'] == $value['hotel_id'] && $value1['room_id'] == $value['room_id']) {

                        if ($value1['adults'] > 0) {
                            $i = 0;
                            for ($i = 0; $i < $value1['adults']; $i++) {
                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['order_id'] = $OrderID;
                                $addHotelRoomPassengers['order_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['order_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $value1['adult']['title'][$i] . ' ' . $value1['adult']['firstname'][$i] . ' ' . $value1['adult']['lastname'][$i];
                                $addHotelRoomPassengers['id_proof'] = $value1['adult']['id_proof'][$i];
                                $addHotelRoomPassengers['id_proof_no'] = $value1['adult']['id_proof_no'][$i];
                                $addHotelRoomPassengers['phone_code'] = isset($cartHotel['all_passengers_country_code']) ? $cartHotel['all_passengers_country_code'] : '';
                                $addHotelRoomPassengers['phone'] = isset($value1['adult']['phonenumber'][$i]) ? $value1['adult']['phonenumber'][$i] : '';
                                $addHotelRoomPassengers['is_adult'] = 0;

                                OrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                        }

                        if ($value1['childs'] > 0) {
                            $i = 0;
                            for ($i = 0; $i < $value1['childs']; $i++) {

                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['order_id'] = $OrderID;
                                $addHotelRoomPassengers['order_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['order_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $value1['child']['title'][$i] . ' ' . $value1['child']['firstname'][$i] . ' ' . $value1['adult']['lastname'][$i];
                                $addHotelRoomPassengers['id_proof'] = $value1['child']['id_proof'][$i];
                                $addHotelRoomPassengers['id_proof_no'] = $value1['child']['id_proof_no'][$i];
                                $addHotelRoomPassengers['phone_code'] = isset($cartHotel['all_passengers_country_code']) ? $cartHotel['all_passengers_country_code'] : '';
                                $addHotelRoomPassengers['phone'] = isset($value1['child']['phonenumber'][$i]) ? $value1['child']['phonenumber'][$i] : '';
                                $addHotelRoomPassengers['is_adult'] = 1;

                                OrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                        }
                    }
                }
            }
        }
        
        return true;
    }

    public function addAdultData($passenger, $OrderID)
    {      

        $roomCount = getSearchCookies('searchGuestRoomCount');
        if ($roomCount > 0) {
            $RoomData = $this->order_Rooms;
            for ($i = 1; $i <= $roomCount; $i++) {
                $j = 0;
                if ( isset($passenger['room_' . $i]['adult']) &&  is_array($passenger['room_' . $i]['adult']) && count($passenger['room_' . $i]['adult']) > 0) {
                    foreach ($passenger['room_' . $i]['adult']['title'] as $key1 => $value) {
                        $OrderAdult = [];
                        $OrderAdult['order_id'] = $OrderID;
                        $OrderAdult['first_name'] = isset($passenger['room_' . $i]['adult']['firstname'][$key1]) ? $passenger['room_' . $i]['adult']['title'][$key1] . ' ' . $passenger['room_' . $i]['adult']['firstname'][$key1] : '';
                        $OrderAdult['last_name'] = isset($passenger['room_' . $i]['adult']['lastname'][$key1]) ? $passenger['room_' . $i]['adult']['lastname'][$key1] : '';
                        //0 = None, 1 = Aadhaar Card, 2 = Passport, 3 = Driving Licence, 4 = Voters ID Card, 5 = PAN Card, 6 = Other
                        if (isset($passenger['room_' . $i]['adult']['id_proof'][$key1])) {
                            if ($passenger['room_' . $i]['adult']['id_proof'][$key1] == "Aadhaar") {
                                $OrderAdult['id_proof_type'] = 1;
                            } else if ($passenger['room_' . $i]['adult']['id_proof'][$key1] == "Passport") {
                                $OrderAdult['id_proof_type'] = 2;
                            } else if ($passenger['room_' . $i]['adult']['id_proof'][$key1] == "Driving Licence") {
                                $OrderAdult['id_proof_type'] = 3;
                            } else if ($passenger['room_' . $i]['adult']['id_proof'][$key1] == "Voters ID Card") {
                                $OrderAdult['id_proof_type'] = 4;
                            } else if ($passenger['room_' . $i]['adult']['id_proof'][$key1] == "PAN card") {
                                $OrderAdult['id_proof_type'] = 5;
                            } else {
                                $OrderAdult['id_proof_type'] = 0;
                            }
                        }
                        $OrderAdult['id_proof_no'] = isset($passenger['room_' . $i]['adult']['id_proof_no'][$key1]) ? $passenger['room_' . $i]['adult']['id_proof_no'][$key1] : '';
                        $OrderAdult['phone'] = isset($passenger['room_' . $i]['adult']['phonenumber'][$key1]) ? $passenger['room_' . $i]['adult']['phonenumber'][$key1] : '';
                        $adult = Order_Adult::create($OrderAdult);
                        $this->addOrderRoom($OrderID, $adult, 'adult', $RoomData);
                    }
                }
                unset($RoomData[0]);
            }
        }
        return true;
    }

    public function addChildData($passenger, $OrderID)
    {

        $roomCount = getSearchCookies('searchGuestRoomCount');
        if ($roomCount > 0) {
            $RoomData = $this->order_Rooms;
            for ($i = 1; $i <= $roomCount; $i++) {
                $j = 0;
                if ( isset($passenger['room_' . $i]['child']) && is_array($passenger['room_' . $i]['child']) && count($passenger['room_' . $i]['child']) > 0) {
                    foreach ($passenger['room_' . $i]['child']['title'] as $key1 => $value) {
                        $OrderChild = [];
                        $OrderChild['order_id'] = $OrderID;
                        $OrderChild['child_first_name'] = isset($passenger['room_' . $i]['child']['firstname'][$key1]) ? $passenger['room_' . $i]['child']['title'][$key1] . ' ' . $passenger['room_' . $i]['child']['firstname'][$key1] : '';
                        $OrderChild['child_last_name'] = isset($passenger['room_' . $i]['child']['lastname'][$key1]) ? $passenger['room_' . $i]['child']['lastname'][$key1] : '';
                        //0 = None, 1 = Aadhaar Card, 2 = Passport, 3 = Driving Licence, 4 = Voters ID Card, 5 = PAN Card, 6 = Other
                        if (isset($passenger['room_' . $i]['child']['id_proof'][$key1])) {
                            if ($passenger['room_' . $i]['child']['id_proof'][$key1] == "Aadhaar") {
                                $OrderChild['child_id_proof_type'] = 1;
                            } else if ($passenger['room_' . $i]['child']['id_proof'][$key1] == "Passport") {
                                $OrderChild['child_id_proof_type'] = 2;
                            } else if ($passenger['room_' . $i]['child']['id_proof'][$key1] == "Driving Licence") {
                                $OrderChild['child_id_proof_type'] = 3;
                            } else if ($passenger['room_' . $i]['child']['id_proof'][$key1] == "Voters ID Card") {
                                $OrderChild['child_id_proof_type'] = 4;
                            } else if ($passenger['room_' . $i]['child']['id_proof'][$key1] == "PAN card") {
                                $OrderChild['child_id_proof_type'] = 5;
                            } else {
                                $OrderChild['child_id_proof_type'] = 0;
                            }
                        }
                        $OrderChild['child_id_proof_no'] = isset($passenger['room_' . $i]['child']['id_proof_no'][$key1]) ? $passenger['room_' . $i]['child']['id_proof_no'][$key1] : '';
                        $OrderChild['child_age'] = isset($passenger['room_' . $i]['child']['age'][$key1]) ? $passenger['room_' . $i]['child']['age'][$key1] : '';
                        $Order_Child = Order_Child::create($OrderChild);
                        $this->addOrderRoom($OrderID, $Order_Child, 'child', $RoomData);

                        if (isset($passenger['room_' . $i]['child']['cwb'][$key1]) && $passenger['room_' . $i]['child']['cwb'][$key1] == "yes") {
                            $OrderChildBed = [];
                            $OrderChildBed['order_id'] = $OrderID;
                            $OrderChildBed['order_child_id'] = $Order_Child->id;
                            $aa = Order_Child_Bed::create($OrderChildBed);
                          
                        }
                    }
                }
                unset($RoomData[0]);
            }
        }
        return true;
    }

    public function addOrderRoom($OrderID, $data, $type, $RoomData)
    {
        $OrderForm = [];
        $OrderForm['order_id'] = $OrderID;
        if ($type == "adult") {
            $OrderForm['adult_id'] = $data->id;
        } else if ($type == "child") {
            $OrderForm['child_id'] =  $data->id;
        }
        if (is_array($RoomData) && count($RoomData) > 0) {
            foreach ($RoomData as $key => $value) {
                $OrderForm['room_id'] = $value['room_id'];
                $OrderForm['price_id'] = $value['price_id'];
                break;
            }
        }
        $OrderForm['type'] = $type;
        return Order_Room::create($OrderForm);
    }

    public function addFormData($OrderID, $extra_data)
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


    /**
     * Draft Insert Data
     */

    public function createBookingDraft(array $data): Checkout
    {

        $extra_data = [];
        $extra_data['cartData'] = getBookingCart('bookingCart');
        $extra_data['searchRoomData'] = getSearchCookies('searchGuestArr');
        $extra_data['searchLocation'] = getSearchCookies('location');
        $extra_data['searchCity_id'] = getSearchCookies('hidden_city_id');
        $extra_data['searchCountry_id'] = getSearchCookies('country_id');
        $extra_data['searchFrom'] = getSearchCookies('search_from');
        $extra_data['searchTo'] = getSearchCookies('search_to');
        $extra_data['passenger_type'] = $data['passengers'];
        $extra_data['taxes_and_fees'] = $data['Taxes_and_fees'];
        $extra_data['taxes_and_fees_amt'] = $data['Taxes_and_fees_amt'];
        $extra_data['button_name'] = $data['button_name'];
        $extra_data['lead_passengers_country_code'] = $data['lead_passengers_country_code'];
        $extra_data['all_passengers_country_code'] = $data['all_passengers_country_code'];
        $adultCount = 0;
        $childCount = 0;
        $roomCount = count($extra_data['cartData']);

        if (count($extra_data['cartData']) > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {

                $adultCount = $adultCount + (int) $value['room_no_' . $i]['adults'];
                $childCount = $childCount + (int) $value['room_no_' . $i]['childs'];
                $i++;
            }
        }

        if ($data['passengers'] == "lead") {
            $learArr = [];
            $learArr['name'] = $data['lead_title'] . ' ' . $data['lead_firstname'] . ' ' . $data['lead_lastname'];
            $learArr['id_proof'] = $data['lead_id_proof'];
            $learArr['id_proof_no'] = $data['lead_id_proof_no'];
            $learArr['phone'] = $data['lead_phonenumber'];
            $extra_data['lead_passenger'] = $learArr;
        } else {
            if (count($extra_data['cartData']) > 0) {

                $i = 1;
                foreach ($data['hotel'] as $key => $value) {
                    $learArr = [];
                    $extra_data['passenger'][] = $value['room_no_' . $i];
                    $i++;
                }
            }
        }
        $dataSave = [
            'user_id'     => auth()->user()->id,
            'adult'     => $adultCount,
            'child'     => $childCount,
            'room'     => $roomCount,
            'city_id'     => getSearchCookies('hidden_city_id'),
            'search_from'     => getSearchCookies('search_from'),
            'search_to'     => getSearchCookies('search_to'),
            'gst_enable'     => isset($data['gst_enable']) ? 1 : 0,
            'registration_number'     => $data['registration_number'],
            'registered_company_name'     => $data['registered_company_name'],
            'registered_company_address'     => $data['registered_company_address'],
            'total_amount'     => getFinalAmountChackOut(),
            'currency'     => globalCurrency(),
            'payment_method'     => isset($data['payment_method']) ? $data['payment_method'] : 0,
            'passenger'     => serialize($this->roomPassenger($data)),
            'extra_data'     => serialize($extra_data),
            'unique_number'     => generateUniqueNumber('order', $langth = 4),
        ];

        $CheckoutRepository =  Checkout::create($dataSave);

        return $CheckoutRepository;
    }

    public function createOrderBookingDraft(Checkout $checkout, $paymentResponce = ''): DraftOrder
    {
        $user = User::find($checkout->user_id);
        $extra_data = unserialize($checkout->extra_data);

        $phone_code = "";
        $this->order_Rooms = $extra_data['cartData'];
        $passenger = unserialize($checkout->passenger);
        $passengerLead = [];
        $passenger_type = 0;
        if ($extra_data['passenger_type'] == "all") {
            $passengerLead = $extra_data['passenger'];
            $passenger_type = 1;
            $phone_code = $extra_data['all_passengers_country_code'];
        } else {
            $passenger_type = 0;
            $passengerLead = $extra_data['lead_passenger'];
            $phone_code = $extra_data['lead_passengers_country_code'];
        }

        $OrderData = [];
        $OrderData['original_amount'] = getOriginAmountChackOut($extra_data);
        $OrderData['original_currency'] = trim($checkout->currency);

        $taxAmt = isset($extra_data['taxes_and_fees_amt']) ? $extra_data['taxes_and_fees_amt'] : 0;
        $OrderData['booking_amount'] = ($checkout->total_amount) ? $checkout->total_amount + $taxAmt : '';
        $OrderData['booking_currency'] = ($checkout->currency) ? $checkout->currency : '';

        $OrderData['tax'] = ($extra_data['taxes_and_fees']) ? $extra_data['taxes_and_fees'] : 0;
        $OrderData['tax_amount'] = ($extra_data['taxes_and_fees_amt']) ? $extra_data['taxes_and_fees_amt'] : 0;

        $OrderData['agent_markup_type'] = $user->agents->agent_global_markups_type ?? '';
        $OrderData['agent_markup_val'] = $user->agents->agent_global_markup ?? '';
        $OrderData['total_price_markup'] = 0;
        $OrderData['agent_code'] = ($user->agents->agent_code) ? $user->agents->agent_code : '';
        $OrderData['agent_email'] = ($user->email) ? $user->email : '';
        $OrderData['total_adult'] = $checkout->adult;
        $OrderData['total_child'] = $checkout->child;
        $OrderData['total_child_with_bed'] = 0;
        $OrderData['total_child_without_bed'] = 0;
        $OrderData['total_rooms'] = $checkout->room;
        $OrderData['total_nights'] = (int) dateDiffInDays($checkout->search_from, $checkout->search_to);
        $OrderData['comments'] = '';
        $OrderData['passenger_type'] = $passenger_type;
        $OrderData['lead_passenger_name'] = isset($extra_data['lead_passenger']['name']) ? $extra_data['lead_passenger']['name'] : '';
        $OrderData['lead_passenger_id_proof'] = isset($extra_data['lead_passenger']['id_proof']) ? $extra_data['lead_passenger']['id_proof'] : '';
        $OrderData['lead_passenger_id_proof_no'] = isset($extra_data['lead_passenger']['id_proof_no']) ? $extra_data['lead_passenger']['id_proof_no'] : '';
        $OrderData['lead_passenger_phone_code'] = isset($phone_code) ? $phone_code : '';
        $OrderData['lead_passenger_phone'] = isset($extra_data['lead_passenger']['phone']) ? $extra_data['lead_passenger']['phone'] : '';

        $OrderData =  DraftOrder::create($OrderData);

        $this->addDraftOrderHotels($extra_data, $OrderData->id, $passengerLead);

        // Below code implement is pendding

        //$this->addOrderPackage($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderTransfere($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderSightseeing($extra_data, $OrderData->id, $passengerLead);       

        return $OrderData;
    }

    public function addDraftOrderHotels($cartHotel, $OrderID, $passengerLead)
    {
        if ($cartHotel['cartData'] > 0) {
            $addHotel = [];
            $addHotel['draft_id'] = $OrderID;

            foreach ($cartHotel['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                        $hotelsDetails =  OfflineHotel::find($value['hotel_id']);
                        $addHotel['hotel_id'] = $hotelsDetails->id;
                        $addHotel['hotel_name'] = $hotelsDetails->hotel_name;
                        $addHotel['type'] = $hotelsDetails->hotel_type;
                        $hotelData = DraftOrderHotel::create($addHotel);
                        $this->addDraftOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead);
                    }
                }
            }
        }
        return true;
    }

    public function addDraftOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead)
    {
        if (count($value) > 0) {
            $roomType = OfflineRoom::find($value['room_id']);
            $addHotelRoom = [];
            $addHotelRoom['draft_id'] = $OrderID;
            $addHotelRoom['draft_hotel_id'] = $hotelData->id;
            $addHotelRoom['hotel_id'] = $value['hotel_id'];
            $addHotelRoom['room_id'] = $value['room_id'];
            $addHotelRoom['room_price_id'] = $value['price_id'];
            $addHotelRoom['room_name'] = $roomType->roomtype->room_type;
            $addHotelRoom['check_in_date'] = $value['search_from'];
            $addHotelRoom['check_out_date'] = $value['search_to'];
            $addHotelRoom['origin_amount'] = $value['originAmount'];
            $addHotelRoom['product_markup_amount'] = $value['productMarkupAmount'];
            $addHotelRoom['agent_markup_amount'] = $value['agentMarkupAmount'];
            $addHotelRoom['agent_global_markup_amount'] = $value['agentGlobalMarkupAmount'];
            $addHotelRoom['price'] = $value['finalAmount'];
            $addHotelRoom['adult'] = $value['adult'];
            $addHotelRoom['child'] = $value['child'];
            $addHotelRoom['child_with_bed'] = 0;
            $addHotelRoom['child_without_bed'] = 0;
            $hotelRoomData = DraftOrderHotelRoom::create($addHotelRoom);
            $this->addDraftOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead);
        }
        return true;
    }

    public function addDraftOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead)
    {

        if (count($value) > 0) {

            if (isset($cartHotel['passenger']) && count($cartHotel['passenger']) > 0) {
                foreach ($cartHotel['passenger'] as $key => $value1) {
                    if ($value1['hotel_id'] == $value['hotel_id'] && $value1['room_id'] == $value['room_id']) {
                        if ($value1['adults'] > 0) {
                            $i = 0;
                            for ($i = 0; $i < $value1['adults']; $i++) {
                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['draft_id'] = $OrderID;
                                $addHotelRoomPassengers['draft_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['draft_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $value1['adult']['title'][$i] . ' ' . $value1['adult']['firstname'][$i] . ' ' . $value1['adult']['lastname'][$i];
                                $addHotelRoomPassengers['id_proof'] = $value1['adult']['id_proof'][$i];
                                $addHotelRoomPassengers['id_proof_no'] = $value1['adult']['id_proof_no'][$i];
                                $addHotelRoomPassengers['phone_code'] = isset($cartHotel['all_passengers_country_code']) ? $cartHotel['all_passengers_country_code'] : '';
                                $addHotelRoomPassengers['phone'] = isset($value1['adult']['phonenumber'][$i]) ? $value1['adult']['phonenumber'][$i] : '';
                                $addHotelRoomPassengers['is_adult'] = 0;

                                DraftOrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                        }

                        if ($value1['childs'] > 0) {
                            $i = 0;
                            for ($i = 0; $i < $value1['childs']; $i++) {

                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['draft_id'] = $OrderID;
                                $addHotelRoomPassengers['draft_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['draft_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $value1['child']['title'][$i] . ' ' . $value1['child']['firstname'][$i] . ' ' . $value1['adult']['lastname'][$i];
                                $addHotelRoomPassengers['id_proof'] = $value1['child']['id_proof'][$i];
                                $addHotelRoomPassengers['id_proof_no'] = $value1['child']['id_proof_no'][$i];
                                $addHotelRoomPassengers['phone_code'] = isset($cartHotel['all_passengers_country_code']) ? $cartHotel['all_passengers_country_code'] : '';
                                $addHotelRoomPassengers['phone'] = isset($value1['child']['phonenumber'][$i]) ? $value1['child']['phonenumber'][$i] : '';
                                $addHotelRoomPassengers['is_adult'] = 1;

                                DraftOrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * Quote Insert Data
     */

    public function createBookingQuote(array $data): Checkout
    {
        $extra_data = [];
        $extra_data['cartData'] = getBookingCart('bookingCart');
        $extra_data['searchRoomData'] = getSearchCookies('searchGuestArr');
        $extra_data['searchLocation'] = getSearchCookies('location');
        $extra_data['searchCity_id'] = getSearchCookies('hidden_city_id');
        $extra_data['searchCountry_id'] = getSearchCookies('country_id');
        $extra_data['searchFrom'] = getSearchCookies('search_from');
        $extra_data['searchTo'] = getSearchCookies('search_to');
        $extra_data['passenger_type'] = $data['passengers'];
        $extra_data['taxes_and_fees'] = $data['Taxes_and_fees'];
        $extra_data['taxes_and_fees_amt'] = $data['Taxes_and_fees_amt'];
        $extra_data['button_name'] = $data['button_name'];
        $extra_data['lead_passengers_country_code'] = $data['lead_passengers_country_code'];
        $extra_data['all_passengers_country_code'] = $data['all_passengers_country_code'];
        $extra_data['quote_name'] = $data['quote_name'];
        // $extra_data['extra_margin_type'] = $data['popup_margin_type'];
        // $extra_data['extra_margin_amt'] = $data['margin_amt'];
        // $extra_data['extra_quote_email'] = $data['quote_email'];

        // $adultCount = 0;
        // $childCount = 0;
        // $roomCount = count($extra_data['cartData']);

        // if (count($extra_data['cartData']) > 0) {
        //     $i = 1;
        //     foreach ($data['hotel'] as $key => $value) {
        //         $adultCount = $adultCount + $value['room_no_' . $i]['adults'];
        //         $childCount = $childCount + $value['room_no_' . $i]['childs'];
        //         $i++;
        //     }
        // }

        $adultCount = 0;
        $childCount = 0;
        $roomCount = count($extra_data['cartData']);

        if ($roomCount > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {
                if (isset($value['room_no_' . $i]['adults']) && is_numeric($value['room_no_' . $i]['adults'])) {
                    $adultCount = $adultCount + (int) $value['room_no_' . $i]['adults'];
                }

                if (isset($value['room_no_' . $i]['childs']) && is_numeric($value['room_no_' . $i]['childs'])) {
                    $childCount = $childCount + (int) $value['room_no_' . $i]['childs'];
                }

                $i++;
            }
        }


        if ($data['passengers'] == "lead") {
            $learArr = [];
            $learArr['name'] = $data['lead_title'] . ' ' . $data['lead_firstname'] . ' ' . $data['lead_lastname'];
            $learArr['id_proof'] = $data['lead_id_proof'];
            $learArr['id_proof_no'] = $data['lead_id_proof_no'];
            $learArr['phone'] = $data['lead_phonenumber'];
            $extra_data['lead_passenger'] = $learArr;
        } else {
            if (count($extra_data['cartData']) > 0) {
                $i = 1;
                foreach ($data['hotel'] as $key => $value) {
                    $learArr = [];
                    $extra_data['passenger'][] = $value['room_no_' . $i];
                    $i++;
                }
            }
        }
        $dataSave = [
            'user_id'     => auth()->user()->id,
            'adult'     => $adultCount,
            'child'     => $childCount,
            'room'     => $roomCount,
            'city_id'     => getSearchCookies('hidden_city_id'),
            'search_from'     => getSearchCookies('search_from'),
            'search_to'     => getSearchCookies('search_to'),
            'gst_enable'     => isset($data['gst_enable']) ? 1 : 0,
            'registration_number'     => $data['registration_number'],
            'registered_company_name'     => $data['registered_company_name'],
            'registered_company_address'     => $data['registered_company_address'],
            'total_amount'     => getFinalAmountChackOut(),
            'currency'     => globalCurrency(),
            'payment_method'     => isset($data['payment_method']) ? $data['payment_method'] : 0,
            'passenger'     => serialize($this->roomPassenger($data)),
            'extra_data'     => serialize($extra_data),
            'unique_number'     => generateUniqueNumber('order', $langth = 4),
        ];

        $CheckoutRepository =  Checkout::create($dataSave);

        return $CheckoutRepository;
    }

    public function createOrderBookingQuote(Checkout $checkout, $paymentResponce = ''): QuoteOrder
    {
        $user = User::find($checkout->user_id);
        $extra_data = unserialize($checkout->extra_data);

        $phone_code = "";
        $this->order_Rooms = $extra_data['cartData'];
        $passenger = unserialize($checkout->passenger);
        $passengerLead = [];
        $passenger_type = 0;
        if ($extra_data['passenger_type'] == "all") {
            $passengerLead = $extra_data['passenger'];
            $passenger_type = 1;
            $phone_code = $extra_data['all_passengers_country_code'];
        } else {
            $passenger_type = 0;
            $passengerLead = $extra_data['lead_passenger'];
            $phone_code = $extra_data['lead_passengers_country_code'];
        }

        $OrderData = [];
        $OrderData['original_amount'] = getOriginAmountChackOut($extra_data);
        $OrderData['original_currency'] = trim($checkout->currency);

        $taxAmt = isset($extra_data['taxes_and_fees_amt']) ? $extra_data['taxes_and_fees_amt'] : 0;
        $OrderData['booking_amount'] = ($checkout->total_amount) ? $checkout->total_amount + $taxAmt : '';
        $OrderData['booking_currency'] = ($checkout->currency) ? $checkout->currency : '';

        $OrderData['tax'] = ($extra_data['taxes_and_fees']) ? $extra_data['taxes_and_fees'] : 0;
        $OrderData['tax_amount'] = ($extra_data['taxes_and_fees_amt']) ? $extra_data['taxes_and_fees_amt'] : 0;

        $OrderData['agent_markup_type'] = $user->agents->agent_global_markups_type ?? '';
        $OrderData['agent_markup_val'] = $user->agents->agent_global_markup ?? '';
        $OrderData['total_price_markup'] = 0;
        $OrderData['quote_name'] = ($extra_data['quote_name']) ? $extra_data['quote_name'] : 0;
        $OrderData['agent_code'] = ($user->agents->agent_code) ? $user->agents->agent_code : '';
        $OrderData['agent_email'] = ($user->email) ? $user->email : '';
        $OrderData['total_adult'] = $checkout->adult;
        $OrderData['total_child'] = $checkout->child;
        $OrderData['total_child_with_bed'] = 0;
        $OrderData['total_child_without_bed'] = 0;
        $OrderData['total_rooms'] = $checkout->room;
        $OrderData['total_nights'] = (int) dateDiffInDays($checkout->search_from, $checkout->search_to);
        $OrderData['comments'] = '';
        $OrderData['passenger_type'] = $passenger_type;
        $OrderData['lead_passenger_name'] = isset($extra_data['lead_passenger']['name']) ? $extra_data['lead_passenger']['name'] : '';
        $OrderData['lead_passenger_id_proof'] = isset($extra_data['lead_passenger']['id_proof']) ? $extra_data['lead_passenger']['id_proof'] : '';
        $OrderData['lead_passenger_id_proof_no'] = isset($extra_data['lead_passenger']['id_proof_no']) ? $extra_data['lead_passenger']['id_proof_no'] : '';
        $OrderData['lead_passenger_phone_code'] = isset($phone_code) ? $phone_code : '';
        $OrderData['lead_passenger_phone'] = isset($extra_data['lead_passenger']['phone']) ? $extra_data['lead_passenger']['phone'] : '';

        // $OrderData['extra_margin_type'] = $extra_data['extra_margin_type'];
        // $OrderData['extra_margin_amt'] = $extra_data['extra_margin_amt'];
        // $OrderData['extra_quote_email'] = $extra_data['extra_quote_email'];

        $OrderData =  QuoteOrder::create($OrderData);
        $this->addQuoteOrderHotels($extra_data, $OrderData->id, $passengerLead);

        // Below code implement is pendding

        //$this->addOrderPackage($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderTransfere($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderSightseeing($extra_data, $OrderData->id, $passengerLead);       

        return $OrderData;
    }

    public function addQuoteOrderHotels($cartHotel, $OrderID, $passengerLead)
    {
        if ($cartHotel['cartData'] > 0) {
            $addHotel = [];
            $addHotel['quote_id'] = $OrderID;
            foreach ($cartHotel['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                        $hotelsDetails =  OfflineHotel::find($value['hotel_id']);
                        $addHotel['hotel_id'] = $hotelsDetails->id;
                        $addHotel['hotel_name'] = $hotelsDetails->hotel_name;
                        $addHotel['type'] = $hotelsDetails->hotel_type;

                        $hotelData = QuoteOrderHotel::create($addHotel);
                        $this->addQuoteOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead);
                    }
                }
            }
        }
        return true;
    }

    public function addQuoteOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead)
    {
        if (count($value) > 0) {
            $roomType = OfflineRoom::find($value['room_id']);
            $addHotelRoom = [];
            $addHotelRoom['quote_id'] = $OrderID;
            $addHotelRoom['quote_hotel_id'] = $hotelData->id;
            $addHotelRoom['hotel_id'] = $value['hotel_id'];
            $addHotelRoom['room_id'] = $value['room_id'];
            $addHotelRoom['room_price_id'] = $value['price_id'];
            $addHotelRoom['room_name'] = $roomType->roomtype->room_type;
            $addHotelRoom['check_in_date'] = $value['search_from'];
            $addHotelRoom['check_out_date'] = $value['search_to'];
            $addHotelRoom['origin_amount'] = $value['originAmount'];
            $addHotelRoom['product_markup_amount'] = $value['productMarkupAmount'];
            $addHotelRoom['agent_markup_amount'] = $value['agentMarkupAmount'];
            $addHotelRoom['agent_global_markup_amount'] = $value['agentGlobalMarkupAmount'];
            $addHotelRoom['price'] = $value['finalAmount'];
            $addHotelRoom['adult'] = $value['adult'];
            $addHotelRoom['child'] = $value['child'];
            $addHotelRoom['child_with_bed'] = 0;
            $addHotelRoom['child_without_bed'] = 0;
            $hotelRoomData = QuoteOrderHotelRoom::create($addHotelRoom);
            $this->addQuoteOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead);
        }
        return true;
    }

    public function addQuoteOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead)
    {
        if (count($value) > 0) {
            if (isset($cartHotel['passenger']) && count($cartHotel['passenger']) > 0) {
                foreach ($cartHotel['passenger'] as $key => $value1) {
                    if ($value1['hotel_id'] == $value['hotel_id'] && $value1['room_id'] == $value['room_id']) {
                        if ($value1['adults'] > 0) {
                            $i = 0;
                            for ($i = 0; $i < $value1['adults']; $i++) {
                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['quote_id'] = $OrderID;
                                $addHotelRoomPassengers['quote_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['quote_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $value1['adult']['title'][$i] . ' ' . $value1['adult']['firstname'][$i] . ' ' . $value1['adult']['lastname'][$i];
                                $addHotelRoomPassengers['id_proof'] = $value1['adult']['id_proof'][$i];
                                $addHotelRoomPassengers['id_proof_no'] = $value1['adult']['id_proof_no'][$i];
                                $addHotelRoomPassengers['phone_code'] = isset($cartHotel['all_passengers_country_code']) ? $cartHotel['all_passengers_country_code'] : '';
                                $addHotelRoomPassengers['phone'] = isset($value1['adult']['phonenumber'][$i]) ? $value1['adult']['phonenumber'][$i] : '';
                                $addHotelRoomPassengers['is_adult'] = 0;

                                QuoteOrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                        }

                        if ($value1['childs'] > 0) {
                            $i = 0;
                            for ($i = 0; $i < $value1['childs']; $i++) {

                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['quote_id'] = $OrderID;
                                $addHotelRoomPassengers['quote_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['quote_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $value1['child']['title'][$i] . ' ' . $value1['child']['firstname'][$i] . ' ' . $value1['adult']['lastname'][$i];
                                $addHotelRoomPassengers['id_proof'] = $value1['child']['id_proof'][$i];
                                $addHotelRoomPassengers['id_proof_no'] = $value1['child']['id_proof_no'][$i];
                                $addHotelRoomPassengers['phone_code'] = isset($cartHotel['all_passengers_country_code']) ? $cartHotel['all_passengers_country_code'] : '';
                                $addHotelRoomPassengers['phone'] = isset($value1['child']['phonenumber'][$i]) ? $value1['child']['phonenumber'][$i] : '';
                                $addHotelRoomPassengers['is_adult'] = 1;

                                QuoteOrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                        }
                    }
                }
            }
        }

        return true;
    }
}