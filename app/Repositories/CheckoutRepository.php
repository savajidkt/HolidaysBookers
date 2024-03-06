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
use App\Models\Setting;
use App\Models\WalletTransaction;
use App\Notifications\BookingNotification;
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
        $extra_data['taxes_and_fees'] = $data['Taxes_and_fees'];
        $extra_data['taxes_and_fees_amt'] = $data['Taxes_and_fees_amt'];
        $extra_data['button_name'] = $data['button_name'];       
        
        $adultCount = 0;
        $childCount = 0;
        $roomCount = count($extra_data['cartData']);
        $room_child_age = [];

        if ($roomCount > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {
                
                if (isset($value['room_no_' . $i]['adults']) && is_numeric($value['room_no_' . $i]['adults'])) {
                    $adultCount = $adultCount + (int) $value['room_no_' . $i]['adults'];
                }

                if (isset($value['room_no_' . $i]['childs']) && is_numeric($value['room_no_' . $i]['childs'])) {
                    $childCount = $childCount + (int) $value['room_no_' . $i]['childs'];
                }
               
               
                   
                if( isset($value['room_no_' . $i]['room_child_age']) && is_array($value['room_no_' . $i]['room_child_age']) && count($value['room_no_' . $i]['room_child_age']) > 0 ){                   
                    foreach ($value['room_no_' . $i]['room_child_age'] as $child_key => $child_value) {                            
                        if( is_array( $child_value) && count( $child_value) > 0 ){
                            foreach ($child_value as $s_child_key => $s_child_value) {
                                $tempArr = [];
                                $tempArr['cwb'] = $value['room_no_' . $i]['room_child_age']["cwd"][$s_child_key];
                                $tempArr['age'] = $s_child_value;
                               
                                $room_child_age[$i][] = $tempArr;
                               
                            }
                        }
                        break;                            
                    }
               }              

                $i++;
            }
        }
        $room_child_age = json_decode(json_encode($room_child_age), FALSE);       
        $extra_data['child_extra'] = $room_child_age;        
        $extra_data['lead_passenger'] = $data['lead_name'] . ' ' . $data['lead_surname'];
        $extra_data['lead_nationality_text'] = $data['lead_nationality_text'];
        $extra_data['lead_nationality_id'] = $data['lead_nationality_id'];
        if (count($extra_data['cartData']) > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {                
                $extra_data['passenger'][] = $value['room_no_' . $i];
                $i++;
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
            'registration_number'     => isset($data['registration_number']) ? $data['registration_number'] : '',
            'registered_company_name'     => isset($data['registered_company_name'])?$data['registered_company_name'] : '',
            'registered_company_address'     => isset($data['registered_company_address'])? $data['registered_company_address']: '',
            'agency_reference'     => $data['agency_reference'],            
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
              
       
        $this->order_Rooms = $extra_data['cartData'];
        $passengerLead =  $extra_data['passenger'];             
       
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
        $OrderData['passenger_type'] = '';
        $OrderData['lead_passenger_name'] = isset($extra_data['lead_passenger']) ? $extra_data['lead_passenger'] : '';
        $OrderData['lead_nationality_text'] = isset($extra_data['lead_nationality_text']) ? $extra_data['lead_nationality_text'] : '';
        $OrderData['lead_nationality_id'] = isset($extra_data['lead_nationality_id']) ? $extra_data['lead_nationality_id'] : '';
        $OrderData['lead_passenger_id_proof'] = '';
        $OrderData['lead_passenger_id_proof_no'] = '';
        $OrderData['lead_passenger_phone_code'] = '';
        $OrderData['agency_reference'] = $checkout->agency_reference;
        $OrderData['lead_passenger_phone'] = '';
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
        // Send Email Booking email
        
        $settingsArr = Setting::where('type','0')->first();  

        if( $settingsArr  ){
            $savedArr = unserialize($settingsArr->settings_data);
            if( $savedArr ){
                if( isset($savedArr['send_email_hb']) && $savedArr['send_email_hb'] =="yes" ){
                    $this->SendEmailAdmin($OrderData); 
                }
                if( isset($savedArr['send_email_agent']) && $savedArr['send_email_agent'] =="yes" ){
                    $this->SendEmailAgent($OrderData);
                }
                if( isset($savedArr['send_email_hotel']) && $savedArr['send_email_hotel'] =="yes" ){
                    $this->SendEmailHotel($OrderData);
                }
                if( isset($savedArr['send_email_hotel_account']) && $savedArr['send_email_hotel_account'] =="yes" ){
                    $this->SendEmailAccount($OrderData);
                }
                if( isset($savedArr['send_email_hotel_sales']) && $savedArr['send_email_hotel_sales'] =="yes" ){
                    $this->SendEmailSales($OrderData);
                }
                if( isset($savedArr['send_email_hotel_front_office']) && $savedArr['send_email_hotel_front_office'] =="yes" ){
                    $this->SendEmailFrontOffice($OrderData);
                }
                if( isset($savedArr['send_email_hotel_registration']) && $savedArr['send_email_hotel_registration'] =="yes" ){
                    $this->SendEmailReservation($OrderData);
                }

            }
        }
        // Below code implement is pendding
        //$this->addOrderPackage($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderTransfere($extra_data, $OrderData->id, $passengerLead);
        //$this->addOrderSightseeing($extra_data, $OrderData->id, $passengerLead);       

        return $OrderData;
    }
    public function SendEmailAdmin($order){
        $order->notify(new BookingNotification($order,'admin'));
    }
    public function SendEmailAgent($order){
        $order->notify(new BookingNotification($order,'agent'));
    }

    public function SendEmailHotel($order){
        $order->notify(new BookingNotification($order,'hotel'));
    }

    public function SendEmailAccount($order){
        $order->notify(new BookingNotification($order,'account'));
    }

    public function SendEmailSales($order){
        $order->notify(new BookingNotification($order,'sales'));
    }

    public function SendEmailFrontOffice($order){
        $order->notify(new BookingNotification($order,'front_office'));
    }

    public function SendEmailReservation($order){
        $order->notify(new BookingNotification($order,'reservation'));
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
            $i = 1;
           
            foreach ($cartHotel['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) { 
                        
                        $hotelsDetails =  OfflineHotel::find($value['hotel_id']);
                        $addHotel['hotel_id'] = $hotelsDetails->id;
                        $addHotel['hotel_name'] = $hotelsDetails->hotel_name;
                        $addHotel['type'] = $hotelsDetails->hotel_type;
                        $hotelData = OrderHotel::create($addHotel);
                        $passengerLeadData = [];

                        if( isset($value['status']) && $value['status'] =="Quote" ){
                            if( isset($value['quote_id']) && $value['quote_id'] !="" && $value['quote_id'] > 0){
                               
                                QuoteOrder::where('id',$value['quote_id'])->update(['status'=>'1']);                               
                            }
                        }
                        if( isset($passengerLead[$key]) && is_array($passengerLead[$key]) && count($passengerLead[$key]) > 0 ){
                            $passengerLeadData = $passengerLead[$key];
                        }                       
                       
                        $i++;
                        $this->addOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLeadData);
                    }
                }
            }
        }
        return true;
    }

    public function addOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead)
    {
        
        if (count($value) > 0) {

            $CWBCount = 0;
            $CNBCount = 0;
            if(is_array($value['room_child_age']) && count($value['room_child_age']) > 0){
                foreach($value['room_child_age'] as $room_child_age){
                    if( $room_child_age->cwb == "yes" ){
                        $CWBCount = $CWBCount + 1;
                    } else if( $room_child_age->cwb == "no" ){
                        $CNBCount = $CNBCount + 1;
                    }
                }
            }
            
            $roomType = OfflineRoom::find($value['room_id']);
            $addHotelRoom = [];
            $addHotelRoom['order_id'] = $OrderID;
            $addHotelRoom['order_hotel_id'] = $hotelData->id;
            $addHotelRoom['hotel_id'] = $value['hotel_id'];
            $addHotelRoom['room_id'] = $value['room_id'];
            $addHotelRoom['room_price_id'] = $value['price_id'];
            $addHotelRoom['room_name'] = $roomType->roomtype->room_type;
            $addHotelRoom['check_in_date'] = dateFormat( str_replace('/', '-', $value['search_from']),'Y-m-d');            
            $addHotelRoom['check_out_date'] = dateFormat( str_replace('/', '-', $value['search_to']),'Y-m-d');
            
            $addHotelRoom['origin_amount'] = $value['originAmount'];
            $addHotelRoom['product_markup_amount'] = $value['productMarkupAmount'];
            $addHotelRoom['agent_markup_amount'] = $value['agentMarkupAmount'];
            $addHotelRoom['agent_global_markup_amount'] = $value['agentGlobalMarkupAmount'];
            $addHotelRoom['price'] = $value['finalAmount'];
            $addHotelRoom['adult'] = $value['adult'];
            $addHotelRoom['child'] = $value['child'];
            $addHotelRoom['child_extra'] = serialize($value['room_child_age']);            
            $addHotelRoom['child_with_bed'] = $CWBCount;
            $addHotelRoom['child_without_bed'] =$CNBCount;
            $addHotelRoom['request_stay'] = isset($passengerLead['request_stay']) ? implode(',',$passengerLead['request_stay']):'';
            $addHotelRoom['comments'] = ( $passengerLead['request_comment'][0]) ?  $passengerLead['request_comment'][0] : '';            
            $hotelRoomData = OrderHotelRoom::create($addHotelRoom);            
            $this->addOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead);
        }
        return true;
    }

    public function addOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead)
    {
        

        if (count($value) > 0) {
            if (isset($passengerLead) && count($passengerLead) > 0) {               
                $totalAdult =  (int) $passengerLead['adults'] + (int) $passengerLead['childs'];
                for ($i = 0; $i < $totalAdult; $i++) {                                            
                    $addHotelRoomPassengers = [];
                    $addHotelRoomPassengers['order_id'] = $OrderID;
                    $addHotelRoomPassengers['order_hotel_id'] = $hotelData->id;
                    $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                    $addHotelRoomPassengers['order_hotel_room_id'] = $hotelRoomData->id;
                    $addHotelRoomPassengers['room_id'] = $value['room_id'];
                    $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                    $addHotelRoomPassengers['name'] = $passengerLead['name'][$i] . ' ' . $passengerLead['surname'][$i];                               
                    $addHotelRoomPassengers['nationality_text'] = $passengerLead['nationality_text'][$i];                               
                    $addHotelRoomPassengers['nationality_id'] = $passengerLead['nationality_id'][$i];                               
                    OrderHotelRoomPassenger::create($addHotelRoomPassengers);
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
            'registration_number'     => isset($data['registration_number']) ? $data['registration_number'] : '',
            'registered_company_name'     => isset($data['registered_company_name'])?$data['registered_company_name'] : '',
            'registered_company_address'     => isset($data['registered_company_address'])? $data['registered_company_address']: '',
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
        $extra_data['taxes_and_fees'] = $data['Taxes_and_fees'];
        $extra_data['taxes_and_fees_amt'] = $data['Taxes_and_fees_amt'];
        $extra_data['button_name'] = $data['button_name'];       
        $extra_data['quote_name'] = isset($data['quote_name']) ? $data['quote_name']:'';

        $adultCount = 0;
        $childCount = 0;
        $roomCount = count($extra_data['cartData']);
        $room_child_age = [];

        if ($roomCount > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {
                
                if (isset($value['room_no_' . $i]['adults']) && is_numeric($value['room_no_' . $i]['adults'])) {
                    $adultCount = $adultCount + (int) $value['room_no_' . $i]['adults'];
                }

                if (isset($value['room_no_' . $i]['childs']) && is_numeric($value['room_no_' . $i]['childs'])) {
                    $childCount = $childCount + (int) $value['room_no_' . $i]['childs'];
                }
               
               
                   
                   if( isset($value['room_no_' . $i]['room_child_age']) && is_array($value['room_no_' . $i]['room_child_age']) && count($value['room_no_' . $i]['room_child_age']) > 0 ){                   
                        foreach ($value['room_no_' . $i]['room_child_age'] as $child_key => $child_value) {                            
                            if( is_array( $child_value) && count( $child_value) > 0 ){
                                foreach ($child_value as $s_child_key => $s_child_value) {
                                    $tempArr = [];
                                    $tempArr['cwb'] = $value['room_no_' . $i]['room_child_age']["cwd"][$s_child_key];
                                    $tempArr['age'] = $s_child_value;
                                   
                                    $room_child_age[$i][] = $tempArr;
                                   
                                }
                            }
                            break;                            
                        }
                   }                

                $i++;
            }
        }

        $room_child_age = json_decode(json_encode($room_child_age), FALSE);       
        $extra_data['child_extra'] = $room_child_age;
        $extra_data['lead_passenger'] = $data['lead_name'] . ' ' . $data['lead_surname'];
        $extra_data['lead_nationality_text'] = $data['lead_nationality_text'];
        $extra_data['lead_nationality_id'] = $data['lead_nationality_id'];
        if (count($extra_data['cartData']) > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {                
                $extra_data['passenger'][] = $value['room_no_' . $i];
                $i++;
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
            'registration_number'     => isset($data['registration_number']) ? $data['registration_number'] : '',
            'registered_company_name'     => isset($data['registered_company_name'])?$data['registered_company_name'] : '',
            'registered_company_address'     => isset($data['registered_company_address'])? $data['registered_company_address']: '',
            'total_amount'     => getFinalAmountChackOut(),
            'currency'     => globalCurrency(),
            'payment_method'     => isset($data['payment_method']) ? $data['payment_method'] : 0,
            'passenger'     => serialize($this->roomPassenger($data)),
            'extra_data'     => serialize($extra_data),
            'agency_reference'     => $data['agency_reference'],
            'unique_number'     => generateUniqueNumber('order', $langth = 4),
        ];

        $CheckoutRepository =  Checkout::create($dataSave);

        return $CheckoutRepository;
    }

    public function createOrderBookingDraft(Checkout $checkout, $paymentResponce = ''): DraftOrder
    {
        $user = User::find($checkout->user_id);
        $extra_data = unserialize($checkout->extra_data);
        $this->order_Rooms = $extra_data['cartData'];
        $passengerLead = unserialize($checkout->passenger);

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
        $OrderData['passenger_type'] = '';
        $OrderData['lead_passenger_name'] = isset($extra_data['lead_passenger']) ? $extra_data['lead_passenger'] : '';
        $OrderData['lead_nationality_text'] = isset($extra_data['lead_nationality_text']) ? $extra_data['lead_nationality_text'] : '';
        $OrderData['lead_nationality_id'] = isset($extra_data['lead_nationality_id']) ? $extra_data['lead_nationality_id'] : '';
        $OrderData['lead_passenger_id_proof'] = '';
        $OrderData['lead_passenger_id_proof_no'] = '';
        $OrderData['lead_passenger_phone_code'] = '';
        $OrderData['lead_passenger_phone'] = '';
        $OrderData['agency_reference'] = $checkout->agency_reference;
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
            $i = 1;
            foreach ($cartHotel['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                        $hotelsDetails =  OfflineHotel::find($value['hotel_id']);
                        $addHotel['hotel_id'] = $hotelsDetails->id;
                        $addHotel['hotel_name'] = $hotelsDetails->hotel_name;
                        $addHotel['type'] = $hotelsDetails->hotel_type;                                               
                        $hotelData = DraftOrderHotel::create($addHotel);
                        $passengerLeadData = [];
                        if( isset($passengerLead['room_'.$i]) && is_array($passengerLead['room_'.$i]) && count($passengerLead['room_'.$i]) > 0 ){
                            $passengerLeadData = $passengerLead['room_'.$i];
                        }
                        $i++;                       
                        $this->addDraftOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLeadData);
                    }
                }
            }
        }
        return true;
    }

    public function addDraftOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead)
    {
        
        if (count($value) > 0) {

            $CWBCount = 0;
            $CNBCount = 0;
            if(is_array($value['room_child_age']) && count($value['room_child_age']) > 0){
                foreach($value['room_child_age'] as $room_child_age){
                    if( $room_child_age->cwb == "yes" ){
                        $CWBCount = $CWBCount + 1;
                    } else if( $room_child_age->cwb == "no" ){
                        $CNBCount = $CNBCount + 1;
                    }
                }
            }

            $roomType = OfflineRoom::find($value['room_id']);
            $addHotelRoom = [];
            $addHotelRoom['draft_id'] = $OrderID;
            $addHotelRoom['draft_hotel_id'] = $hotelData->id;
            $addHotelRoom['hotel_id'] = $value['hotel_id'];
            $addHotelRoom['room_id'] = $value['room_id'];
            $addHotelRoom['room_price_id'] = $value['price_id'];
            $addHotelRoom['room_name'] = $roomType->roomtype->room_type;            
            $addHotelRoom['check_in_date'] = dateFormat( str_replace('/', '-', $value['search_from']),'Y-m-d');
            $addHotelRoom['check_out_date'] = dateFormat(str_replace('/', '-', $value['search_to']), 'Y-m-d');
            $addHotelRoom['origin_amount'] = $value['originAmount'];
            $addHotelRoom['product_markup_amount'] = $value['productMarkupAmount'];
            $addHotelRoom['agent_markup_amount'] = $value['agentMarkupAmount'];
            $addHotelRoom['agent_global_markup_amount'] = $value['agentGlobalMarkupAmount'];
            $addHotelRoom['price'] = $value['finalAmount'];
            $addHotelRoom['adult'] = $value['adult'];
            $addHotelRoom['child'] = $value['child'];
            $addHotelRoom['child_extra'] = serialize($value['room_child_age']);
            $addHotelRoom['child_with_bed'] = $CWBCount;
            $addHotelRoom['child_without_bed'] = $CNBCount;
            $addHotelRoom['request_stay'] = isset($passengerLead['request_stay']) ? implode(',',$passengerLead['request_stay']):'';
            $addHotelRoom['comments'] = isset( $passengerLead['request_comment'][0]) ?  $passengerLead['request_comment'][0] : '';
           
            $hotelRoomData = DraftOrderHotelRoom::create($addHotelRoom);
            
            $this->addDraftOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead);
        }
        return true;
    }

    public function addDraftOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead)
    {

        if (count($value) > 0) {

            if (isset($passengerLead) && count($passengerLead) > 0) {
                $totalAdult =  (int) $passengerLead['adults'] + (int) $passengerLead['childs']; 
                for ($i = 0; $i < $totalAdult; $i++) { 
                    
                    $addHotelRoomPassengers = [];
                    $addHotelRoomPassengers['draft_id'] = $OrderID;
                    $addHotelRoomPassengers['draft_hotel_id'] = $hotelData->id;
                    $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                    $addHotelRoomPassengers['draft_hotel_room_id'] = $hotelRoomData->id;
                    $addHotelRoomPassengers['room_id'] = $value['room_id'];
                    $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                    $addHotelRoomPassengers['name'] = $passengerLead['name'][$i] . ' ' . $passengerLead['surname'][$i];   
                    $addHotelRoomPassengers['nationality_text'] = $passengerLead['nationality_text'][$i];                               
                    $addHotelRoomPassengers['nationality_id'] = $passengerLead['nationality_id'][$i];  
                    
                    DraftOrderHotelRoomPassenger::create($addHotelRoomPassengers);
                    
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
        $extra_data['taxes_and_fees'] = $data['Taxes_and_fees'];
        $extra_data['taxes_and_fees_amt'] = $data['Taxes_and_fees_amt'];
        $extra_data['button_name'] = $data['button_name'];       
        $extra_data['quote_name'] = isset($data['quote_name']) ? $data['quote_name']:'';      

        $adultCount = 0;
        $childCount = 0;
        $roomCount = count($extra_data['cartData']);
        $room_child_age = [];

        if ($roomCount > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {
                
                if (isset($value['room_no_' . $i]['adults']) && is_numeric($value['room_no_' . $i]['adults'])) {
                    $adultCount = $adultCount + (int) $value['room_no_' . $i]['adults'];
                }

                if (isset($value['room_no_' . $i]['childs']) && is_numeric($value['room_no_' . $i]['childs'])) {
                    $childCount = $childCount + (int) $value['room_no_' . $i]['childs'];
                }
               
               
                   
                   if( isset($value['room_no_' . $i]['room_child_age']) && is_array($value['room_no_' . $i]['room_child_age']) && count($value['room_no_' . $i]['room_child_age']) > 0 ){                   
                        foreach ($value['room_no_' . $i]['room_child_age'] as $child_key => $child_value) {                            
                            if( is_array( $child_value) && count( $child_value) > 0 ){
                                foreach ($child_value as $s_child_key => $s_child_value) {
                                    $tempArr = [];
                                    $tempArr['cwb'] = $value['room_no_' . $i]['room_child_age']["cwd"][$s_child_key];
                                    $tempArr['age'] = $s_child_value;
                                   
                                    $room_child_age[$i][] = $tempArr;
                                   
                                }
                            }
                            break;                            
                        }
                   }                

                $i++;
            }
        }
        
        $room_child_age = json_decode(json_encode($room_child_age), FALSE);       
        $extra_data['child_extra'] = $room_child_age;
        $extra_data['lead_passenger'] = $data['lead_name'] . ' ' . $data['lead_surname'];
        $extra_data['lead_nationality_text'] = $data['lead_nationality_text'];
        $extra_data['lead_nationality_id'] = $data['lead_nationality_id'];
        if (count($extra_data['cartData']) > 0) {
            $i = 1;
            foreach ($data['hotel'] as $key => $value) {                
                $extra_data['passenger'][] = $value['room_no_' . $i];
                $i++;
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
            'registration_number'     => isset($data['registration_number']) ? $data['registration_number'] : '',
            'registered_company_name'     => isset($data['registered_company_name'])?$data['registered_company_name'] : '',
            'registered_company_address'     => isset($data['registered_company_address'])? $data['registered_company_address']: '',
            'total_amount'     => getFinalAmountChackOut(),
            'currency'     => globalCurrency(),
            'payment_method'     => isset($data['payment_method']) ? $data['payment_method'] : 0,
            'passenger'     => serialize($this->roomPassenger($data)),
            'extra_data'     => serialize($extra_data),
            'agency_reference'     => $data['agency_reference'],
            'unique_number'     => generateUniqueNumber('order', $langth = 4),
        ];

        $CheckoutRepository =  Checkout::create($dataSave);

        return $CheckoutRepository;
    }

    public function createOrderBookingQuote(Checkout $checkout, $paymentResponce = ''): QuoteOrder
    {      
        
        $user = User::find($checkout->user_id);
        $extra_data = unserialize($checkout->extra_data);
        $this->order_Rooms = $extra_data['cartData'];
        $passengerLead = unserialize($checkout->passenger);
       
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
        $OrderData['passenger_type'] = '';
        $OrderData['lead_passenger_name'] = isset($extra_data['lead_passenger']) ? $extra_data['lead_passenger'] : '';
        $OrderData['lead_nationality_text'] = isset($extra_data['lead_nationality_text']) ? $extra_data['lead_nationality_text'] : '';
        $OrderData['lead_nationality_id'] = isset($extra_data['lead_nationality_id']) ? $extra_data['lead_nationality_id'] : '';
        $OrderData['lead_passenger_id_proof'] = '';
        $OrderData['lead_passenger_id_proof_no'] = '';
        $OrderData['lead_passenger_phone_code'] = '';
        $OrderData['lead_passenger_phone'] = '';
        $OrderData['agency_reference'] = $checkout->agency_reference;

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
            $i = 1;
            foreach ($cartHotel['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                        $hotelsDetails =  OfflineHotel::find($value['hotel_id']);
                        $addHotel['hotel_id'] = $hotelsDetails->id;
                        $addHotel['hotel_name'] = $hotelsDetails->hotel_name;
                        $addHotel['type'] = $hotelsDetails->hotel_type;                       
                        $hotelData = QuoteOrderHotel::create($addHotel);
                        $passengerLeadData = [];
                        if( isset($passengerLead['room_'.$i]) && is_array($passengerLead['room_'.$i]) && count($passengerLead['room_'.$i]) > 0 ){
                            $passengerLeadData = $passengerLead['room_'.$i];
                        }
                        $i++;
                        
                        $this->addQuoteOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLeadData);
                    }
                }
            }
        }
        return true;
    }

    public function addQuoteOrderHotelRooms($cartHotel, $value, $OrderID, $hotelData, $passengerLead)
    {   
        
        if (count($value) > 0) {

            $CWBCount = 0;
            $CNBCount = 0;
            if(is_array($value['room_child_age']) && count($value['room_child_age']) > 0){
                foreach($value['room_child_age'] as $room_child_age){
                    if( $room_child_age->cwb == "yes" ){
                        $CWBCount = $CWBCount + 1;
                    } else if( $room_child_age->cwb == "no" ){
                        $CNBCount = $CNBCount + 1;
                    }
                }
            }

            $roomType = OfflineRoom::find($value['room_id']);
            $addHotelRoom = [];
            $addHotelRoom['quote_id'] = $OrderID;
            $addHotelRoom['quote_hotel_id'] = $hotelData->id;
            $addHotelRoom['hotel_id'] = $value['hotel_id'];
            $addHotelRoom['room_id'] = $value['room_id'];
            $addHotelRoom['room_price_id'] = $value['price_id'];
            $addHotelRoom['room_name'] = $roomType->roomtype->room_type;
            $addHotelRoom['check_in_date'] = dateFormat( str_replace('/', '-', $value['search_from']),'Y-m-d');
            $addHotelRoom['check_out_date'] = dateFormat(str_replace('/', '-', $value['search_to']), 'Y-m-d');
            $addHotelRoom['origin_amount'] = $value['originAmount'];
            $addHotelRoom['product_markup_amount'] = $value['productMarkupAmount'];
            $addHotelRoom['agent_markup_amount'] = $value['agentMarkupAmount'];
            $addHotelRoom['agent_global_markup_amount'] = $value['agentGlobalMarkupAmount'];
            $addHotelRoom['price'] = $value['finalAmount'];
            $addHotelRoom['adult'] = $value['adult'];
            $addHotelRoom['child'] = $value['child'];
            $addHotelRoom['child_extra'] = serialize($value['room_child_age']);
            $addHotelRoom['child_with_bed'] = $CWBCount;
            $addHotelRoom['child_without_bed'] = $CNBCount;
            $addHotelRoom['request_stay'] = isset($passengerLead['request_stay']) ? implode(',',$passengerLead['request_stay']):'';
            $addHotelRoom['comments'] = isset( $passengerLead['request_comment'][0]) ?  $passengerLead['request_comment'][0] : '';
            
            $hotelRoomData = QuoteOrderHotelRoom::create($addHotelRoom);
            $this->addQuoteOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead);
        }
        return true;
    }

    public function addQuoteOrderHotelRoomPassengers($cartHotel, $value, $OrderID, $hotelData, $hotelRoomData, $passengerLead)
    {
      
        if (count($value) > 0) {
            if (isset($passengerLead) && count($passengerLead) > 0) {
                            $totalAdult =  (int) $passengerLead['adults'] + (int) $passengerLead['childs'];                         
                                                    
                            for ($i = 0; $i < $totalAdult; $i++) {                              
                                $addHotelRoomPassengers = [];
                                $addHotelRoomPassengers['quote_id'] = $OrderID;
                                $addHotelRoomPassengers['quote_hotel_id'] = $hotelData->id;
                                $addHotelRoomPassengers['hotel_id'] = $value['hotel_id'];
                                $addHotelRoomPassengers['quote_hotel_room_id'] = $hotelRoomData->id;
                                $addHotelRoomPassengers['room_id'] = $value['room_id'];
                                $addHotelRoomPassengers['room_price_id'] = $value['price_id'];
                                $addHotelRoomPassengers['name'] = $passengerLead['name'][$i] . ' ' . $passengerLead['surname'][$i];   
                                $addHotelRoomPassengers['nationality_text'] = $passengerLead['nationality_text'][$i];                               
                                $addHotelRoomPassengers['nationality_id'] = $passengerLead['nationality_id'][$i];                            
                                QuoteOrderHotelRoomPassenger::create($addHotelRoomPassengers);
                            }
                           
                
            }
        }   
         
        return true;
    }
}
