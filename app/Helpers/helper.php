<?php
use Carbon\Carbon;
use App\Models\City;
use App\Models\Reach;
use App\Models\State;
use App\Models\Wishlist;
use App\Models\AgentMarkup;
use App\Models\OfflineRoom;
use App\Models\ProductMarkup;
use App\Libraries\Safeencryption;
use App\Models\WalletTransaction;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use App\Models\OfflineRoomChildPrice;
use App\Models\Order;
use App\Models\Order_Room;
use App\Models\OrderHotelRoom;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Session\Session;


if (!function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
       return 'dashboard';
    }
}



// Global helpers file with misc functions.
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}





if (!function_exists('common')) {

    /**

     * Access (lol) the Access:: facade as a simple function.

     */

    function common()

    {

        return app('common');

    }

}



if (!function_exists('report_multiple_by_100')) {

    /**

     * Access (lol) the Access:: facade as a simple function.

     */

    function report_multiple_by_100($value, $isNotRound = 1)

    {

        return $isNotRound ? $value * 100 : round($value * 100);

    }

}



if (!function_exists('permission_redirect')) {

    /**

     * Access (lol) the Access:: facade as a simple function.

     */

    function permission_redirect()

    {

        return redirect()->route('dashboard')->with('error', "You do not have permission!");

    }

}



if (!function_exists('_P')) {

    function _P($data)

    {

        echo "<pre>";

        print_r($data);

        // exit;

    }

}



if (!function_exists('FolderExists')) {
    function FolderExists($user_id)
    {
        if (!Storage::exists('/upload/' . $user_id)) {
            return Storage::makeDirectory('/upload/' . $user_id, 0775, true);
        }
        return true;
    }
}



if (!function_exists('makeDirectory')) {

    function makeDirectory($path, $id)

    {

        if (!Storage::exists('/' . $path . '/' . $id)) {

            return Storage::makeDirectory('/' . $path . '/' . $id, 0775, true);

        }



        return true;

    }

}



if (!function_exists('FileUpload')) {

    /**

     * FileUpload return file name

     */

    function FileUpload($file, $FolderName = 'upload')

    {

        $file->storeAs($FolderName, $file->hashName());

        return $file->hashName();

    }

}





if (!function_exists('getCountryStates')) {

    /**

     * getCountryState return state lists

     */

    function getCountryStates($country_id)

    {

        return State::where('country_id', $country_id)->where('status', 1)->get();

    }

}



if (!function_exists('getStateCities')) {

    /**

     * getCountryState return cities lists

     */

    function getStateCities($country_id)

    {

        return City::where('country_id', $country_id)->where('status', 1)->get();

    }

}





if (!function_exists('getStateCitiesByState')) {

    /**

     * getCountryState return cities lists

     */

    function getStateCitiesByState($state_id)
    {
        return City::where('state_id', $state_id)->where('status', 1)->get();
    }
}

if (!function_exists('getStateWiseCity')) {
    /**
     * getCountryState return cities lists
     */
    function getStateWiseCity($state_id)
    {

        return City::where('state_id', $state_id)->where('status', 1)->get();

    }

}





if (!function_exists('createAgentCode')) {

    /**

     * createAgentCode return agent code

     */

    function createAgentCode($id)

    {

        $agent_code = 'CA' . date('y') . '000';

        if ($id < 10) {

            $id = '0' . $id;

        }

        return 'CA' . date('y') . $id;

    }

}





if (!function_exists('numberFormat')) {

    /**

     * numberFormat return number with two decimals

     */

    function numberFormat($amount, $currency = '')

    {

        return ($currency) ? $currency . ' ' . number_format((float)$amount, 2, '.', '') : number_format((float)$amount, 2, '.', '');

    }

}



if (!function_exists('dateFormat')) {
    /**
     * numberFormat return number with two decimals
     */
    function dateFormat($date, $format = NULL)
    {
        if ($format) {
            return date($format, strtotime($date));
        } else {
            return date("d M, Y h:i:s A", strtotime($date));
        }
    }
}

if (!function_exists('formatdate')) {

    /**

     * numberFormat return number with two decimals

     */

    function formatdate($date, $format = NULL)

    {

        if ($format) {

            return date($format, strtotime($date));

        } else {

            return date("d/m/Y", strtotime($date));

        }

    }

}





if (!function_exists('calculateBalance')) {

    /**

     * calculateBalance return Balance

     */

    function calculateBalance($agent_id, $type, $amount)

    {

        $letest = WalletTransaction::where('agent_id', $agent_id)->latest()->first();
        if (isset($letest->balance)) {
        if ($type == 0) {

            if ($letest->balance >= $amount) {

                return  numberFormat($letest->balance - $amount);

            } else {

                return redirect()->route('agents.index')->with('error', "Please enter less then balance amount");

            }

        } else if ($type == 1) {

            return  numberFormat($letest->balance + $amount);

        }
        } else {
            return  numberFormat($amount);
        }
        return redirect()->route('agents.index')->with('error', "HB Credit type not found");

    }

}





if (!function_exists('availableBalance')) {

    /**

     * availableBalance return Balance

     */

    function availableBalance($agent_id, $currency = '')

    {

        $letest = WalletTransaction::where('agent_id', $agent_id)->orderBy('id', 'DESC')->latest()->first();

        if (isset($letest->balance) &&  $letest->balance > 0) {
            return  numberFormat($letest->balance, $currency);

        } else {

            return  numberFormat(0);

        }

    }

}

if (!function_exists('permissionCheck')) {



    function permissionCheck($permission)

    {

        $user = auth()->user();

        if (!$user->can($permission)) {

            throw new GeneralException('Access Denide!');

        }

    }

}



if (!function_exists('excelDateConvert')) {



    function excelDateConvert($date)

    {

        $excel_date = $date;

        $date_unix_date = ($excel_date - 25569) * 86400;

        $_date_excel_date = 25569 + ($date_unix_date / 86400);

        return Carbon::parse(($_date_excel_date - 25569) * 86400)->format('Y-m-d');

    }

}





if (!function_exists('forLoopByNumber')) {



    function forLoopByNumber($start, $end, $selected = null, $extra = null, $extraArr = null)

    {

        $optionDropdown = "";

        for ($i = $start; $i <= $end; $i++) {

            if ($selected == $i) {

                $optionDropdown .= '<option value="' . $i . '" selected>' . $i . ' ' . $extra . '</option>';

            } else {

                $optionDropdown .= '<option value="' . $i . '">' . $i . ' ' . $extra . '</option>';

            }

        }

        if (is_array($extraArr) && count($extraArr) > 0) {

            foreach ($extraArr as $key => $value) {

                if ($selected == $i) {

                    $optionDropdown .= '<option value="' . $value . '" selected>' . $value . ' ' . $extra . '</option>';

                } else {

                    $optionDropdown .= '<option value="' . $value . '">' . $value . ' ' . $extra . '</option>';

                }

            }

        }

        return $optionDropdown;

    }

}



if (!function_exists('getSelectedCurrency')) {



    function getSelectedCurrency($currency, $select = null)

    {

        if (is_array($currency) && count($currency) > 0) {

            foreach ($currency as $key => $value) {

                if ($value['id'] ==  $select) {

                    return $value['name'] . ' (' . $value['code'] . ')';

                }

            }

        }

        return '';

    }

}





if (!function_exists('rezeliveHotels')) {



    function rezeliveHotels($config)

    {



        set_time_limit(0);

        $str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>

<HotelFindRequest>

    <Authentication>

        <AgentCode>' . $config->agent_code . '</AgentCode>

        <UserName>' . $config->username . '</UserName>

        <Password>' . $config->password . '</Password>

    </Authentication>

    <Booking>

        <ArrivalDate>01/04/2023</ArrivalDate>

        <DepartureDate>05/04/2023</DepartureDate>

        <CountryCode>ID</CountryCode>

        <City>326</City>

        <GuestNationality>IN</GuestNationality>

        <HotelRatings>

            <HotelRating>1</HotelRating>

            <HotelRating>2</HotelRating>

            <HotelRating>3</HotelRating>

            <HotelRating>4</HotelRating>

            <HotelRating>5</HotelRating>

        </HotelRatings>

        <Rooms>

            <Room>

                <Type>Room-1</Type>

                <NoOfAdults>2</NoOfAdults>

                <NoOfChilds>0</NoOfChilds>

            </Room>

        </Rooms>

    </Booking>

</HotelFindRequest>';



        file_put_contents("xml/resquest" . time() . ".xml", $str);

        $url = $config->api_url . "findhotel";



        $ch = curl_init();

        //set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "XML=" . urlencode($str));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=UTF8'));

        $result = curl_exec($ch);



        if ($result === false) {

            echo 'Curl error: ' . curl_error($ch);

        }

        //curl_close($ch);

        // print_r($result);

        // die;

        //$result = str_replace("world","Peter","Hello world!");

        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);



        $json = json_encode($xml);

        $arr = json_decode($json, true);

        echo "

<pre>";

        print_r($arr);

        exit;

    }

}



if (!function_exists('rezeliveGetHotelsDetails')) {



    function rezeliveGetHotelsDetails($config, $hotel_code)

    {



        set_time_limit(0);

        $str = '<HotelDetailsRequest>

        <Authentication>

        <AgentCode>' . $config->agent_code . '</AgentCode>

            <UserName>' . $config->username . '</UserName>

            <Password>' . $config->password . '</Password>

        </Authentication>

        <Hotels>

        <HotelId>' . $hotel_code . '</HotelId>

        </Hotels></HotelDetailsRequest>';



        file_put_contents("xml/resquest" . time() . ".xml", $str);

        $url = $config->api_url . "gethoteldetails";

        //http://test.xmlhub.com/testpanel.php/action/gethoteldetails

        $ch = curl_init();

        //set the url, number of POST vars, POST data 

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "XML=" . urlencode($str));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset=UTF8'));

        $result = curl_exec($ch);



        if ($result === false) {

            echo 'Curl error: ' . curl_error($ch);

        }

        //curl_close($ch); 

        //    print_r($result);

        //    die;

        //$result = str_replace("world","Peter","Hello world!");

        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);



        $json = json_encode($xml);

        $arr = json_decode($json, true);

        return $arr;

    }

}





if (!function_exists('getLoginUserDetails')) {



    function getLoginUserDetails()

    {

        if (Auth::guard('admin')->check()) {

            return 0;

        } elseif (Auth::guard('user')->check()) {

            return 1;

        }

    }

}



if (!function_exists('getChildCount')) {



    function getChildCount($data)

    {

        $returnChildArr = [];

        $returnChildArr['child_age_1'] = 0;

        $returnChildArr['child_age_2'] = 0;

        $returnChildArr['child_younger'] = 0;

        $returnChildArr['child_older'] = 0;



        if (isset($data['child']) && $data['child'] == 1) {

            if (is_array($data['child_age']) && count($data['child_age']) > 0) {

                $returnChildArr['child_age_1'] = isset($data['child_age'][0]) ? $data['child_age'][0] : 0;

            }

        } else if (isset($data['child']) && $data['child'] == 2) {

            if (is_array($data['child_age']) && count($data['child_age']) > 0) {

                $returnChildArr['child_age_1'] = isset($data['child_age'][0]) ? $data['child_age'][0] : 0;

                $returnChildArr['child_age_2'] = isset($data['child_age'][1]) ? $data['child_age'][1] : 0;

            }

        } else if (isset($data['child']) && $data['child'] > 2) {

            if (is_array($data['child_age']) && count($data['child_age']) > 0) {

                $returnChildArr['child_younger'] = isset($data['child_age'][0]) ? $data['child_age'][0] : 0;

                $returnChildArr['child_older'] = isset($data['child_age'][1]) ? $data['child_age'][1] : 0;

            }

        }

        return $returnChildArr;

    }

}



if (!function_exists('getCharacterOfString')) {



    function getCharacterOfString($string)

    {

        $words = explode(" ", $string);

        $acronym = "";



        foreach ($words as $w) {

            $acronym .= mb_substr($w, 0, 1);

        }

        return $acronym;

    }

}





if (!function_exists('getIDProofName')) {



    function getIDProofName($id)

    {

        if ($id == 1) {

            return 'Aadhaar Card';

        } else if ($id == 2) {

            return 'Passport';

        } else if ($id == 3) {

            return 'Driving Licence';

        } else if ($id == 4) {

            return 'Voters ID Card';

        } else if ($id == 5) {

            return 'PAN Card';

        } else if ($id == 6) {

            return 'Other';

        }

        return '';

    }

}





if (!function_exists('getOrderStatus')) {



    function getOrderStatus($status)

    {

        if ($status == 1) {

            return 'Processed';

        } else if ($status == 2) {

            return 'Confirmed';

        } else if ($status == 3) {

            return 'Cancelled';

        }

        return '';

    }

}



if (!function_exists('getOrderBookedBy')) {



    function getOrderBookedBy($id)

    {



        if ($id == 1) {

            return 'Agent';

        } else if ($id == 2) {

            return 'Customer';

        } else if ($id == 3) {

            return 'Vendor';

        } else if ($id == 4) {

            return 'Corporate';

        }

        return '';

    }

}





if (!function_exists('dateDiffInDays')) {
    function dateDiffInDays($date1, $date2)
    {
        // Calculating the difference in timestamps
        $diff = strtotime($date2) - strtotime($date1);
        // 1 day = 24 hours
        // 24 * 60 * 60 = 86400 seconds
        return abs(round($diff / 86400));
    }

}



function get_day_wise_children_price($room_price_id, $param)

{



    $searchGuestRoomCount = getSearchCookies('searchGuestRoomCount');

    $searchGuestChildCount = getSearchCookies('searchGuestChildCount');

    $searchGuestAdultCount = getSearchCookies('searchGuestAdultCount');

    $searchGuestArr = getSearchCookies('searchGuestArr');



    $chilldPrice = 0;

    if ($searchGuestChildCount > 0) {



        foreach ($searchGuestArr as $key => $child) {



            if ($child->child > 0) {

                foreach ($child->childAge as $key1 => $value) {

                    $roomChildPrice = OfflineRoomChildPrice::query();

                    // $roomChildPrice = $roomChildPrice->where(function ($query) use ($value) {

                    //     $query->whereRaw("'" . $value->age . "' between min_age and max_age");

                    // });

                    $roomChildPrice = $roomChildPrice->where('price_id', $room_price_id)->get();

                    if ($value->cwb == 'yes') {

                        $childPrice = $roomChildPrice->sum('cwb_price');

                    } else {

                        $childPrice = $roomChildPrice->sum('cnb_price');

                    }

                }

            }

        }

    }

    return $childPrice;

}

function getChildrenPrice($searchGuestArr, $price)
{
   $childPrice = 0;
   foreach ($searchGuestArr as $key => $room) {
        if (is_array($room->childAge) && count($room->childAge)) {
            foreach ($room->childAge as $key1 => $room1) {
                if ($room1->cwb == "yes") {
                    $childPrice = $childPrice + $price->price_p_n_cwb;
                } else {
                    if(($room1->age >= 0 && $room1->age<= 4)){
                        $childPrice = $childPrice + $price->price_p_n_cob;
                    }
                    if(($room1->age >= 5 && $room1->age <= 12)){
                        $childPrice = $childPrice + $price->price_p_n_cob_5_12;
                    }
                    if(($room1->age>= 13 && $room1->age<= 18)){
                        $childPrice = $childPrice + $price->price_p_n_cob_13_18;
                    }

                }
            }
        }
    }
    return $childPrice;
}
function getChildrenPromoPrice($searchGuestArr, $price)
{
    $childPrice = 0;
   foreach ($searchGuestArr as $key => $room) {
        if (is_array($room->childAge) && count($room->childAge)) {
            foreach ($room->childAge as $key1 => $room1) {
                if ($room1->cwb == "yes") {
                    $childPrice = $childPrice + $price['child_with_bed'];
                } else {
                    if(($room1->age == 0 && $room1->age<= 4)){
                        $childPrice = $childPrice + $price['child_with_no_bed_0_4'];
                    }
                    if(($room1->age >= 5 && $room1->age <= 12)){
                        $childPrice = $childPrice + $price['child_with_no_bed_5_12'];
                    }
                    if(($room1->age>= 13 && $room1->age<= 18)){
                        $childPrice = $childPrice + $price['child_with_no_bed_13_18'];
                    }
                }
            }
        }
    }
    return $childPrice;
}



if (!function_exists('selectRoomBooking')) {



    function selectRoomBooking($paramArr, $isArray = false)

    {



        $SafeencryptionObj = new Safeencryption;

        $id = "";



        if ($isArray) {

            return $SafeencryptionObj->encode(serialize($paramArr));

        }



        if (is_array($paramArr) && count($paramArr) > 0) {

            $string = "";

            foreach ($paramArr as $key => $value) {

                $string .= $key . "=" . $value . "&";

            }

            $string = trim($string, '&');



            $id = $SafeencryptionObj->encode($string);

        }

        return $id;

    }

}





if (!function_exists('getSearchCookies')) {



    function getSearchCookies($name)

    {

        if (isset($_COOKIE[$name])) {

            return json_decode($_COOKIE[$name]);

        }

        return false;

    }

}





if (!function_exists('isWishlist')) {



    function isWishlist($id, $type)

    {

        $user = auth()->user();

        if (isset($user->id)) {

            $user = Wishlist::where('user_id', '=', $user->id)

                ->where('hotel_id', '=', $id)

                ->where('type', '=', $type)

                ->first();

            if ($user === null) {

                return '';

            } else {

                return 'active';

            }

        }

        return '';

    }

}



if (!function_exists('passengerArr')) {



    function passengerArr($data, $is_serialize = false)

    {

        $result = [];

        if (is_array($data['adult']) && count($data['adult']) > 0) {

            foreach ($data['adult'] as $key => $value) {

                if (is_array($value) && count($value) > 0 && $key == "title") {

                    foreach ($value as $key1 => $value1) {

                        $tempArr = [];

                        $tempArr['title'] = ($data['adult']['title'][$key1]) ? $data['adult']['title'][$key1] : '';

                        $tempArr['firstname'] = ($data['adult']['firstname'][$key1]) ? $data['adult']['firstname'][$key1] : '';

                        $tempArr['lastname'] = ($data['adult']['lastname'][$key1]) ? $data['adult']['lastname'][$key1] : '';

                        $tempArr['id_proof'] = ($data['adult']['id_proof'][$key1]) ? $data['adult']['id_proof'][$key1] : '';

                        $tempArr['id_proof_no'] = ($data['adult']['id_proof_no'][$key1]) ? $data['adult']['id_proof_no'][$key1] : '';

                        $tempArr['phonenumber'] = isset($data['adult']['phonenumber'][$key1]) ? $data['adult']['phonenumber'][$key1] : '';

                        $result[] = $tempArr;

                    }

                }

            }

        }

        if (is_array($data['child']) && count($data['child']) > 0) {

            foreach ($data['child'] as $key => $value) {

                if (is_array($value) && count($value) > 0 && $key == "title") {

                    foreach ($value as $key1 => $value1) {

                        $tempArr = [];

                        $tempArr['title'] = ($data['child']['title'][$key1]) ? $data['child']['title'][$key1] : '';

                        $tempArr['firstname'] = ($data['child']['firstname'][$key1]) ? $data['child']['firstname'][$key1] : '';

                        $tempArr['lastname'] = ($data['child']['lastname'][$key1]) ? $data['child']['lastname'][$key1] : '';

                        $tempArr['id_proof'] = ($data['child']['id_proof'][$key1]) ? $data['child']['id_proof'][$key1] : '';

                        $tempArr['id_proof_no'] = ($data['child']['id_proof_no'][$key1]) ? $data['child']['id_proof_no'][$key1] : '';

                        $result[] = $tempArr;

                    }

                }

            }

        }

        if ($is_serialize) {

            return serialize($result);

        }

        return $result;

    }

}



if (!function_exists('getAgentRoomPrice')) {



    function getAgentRoomPrice($price, $hotelsDetails)

    {



        $calculateAmount = 0;

        $user = auth()->user();

        //1=Offline, 2=API 

        if ($hotelsDetails['hotel']['hotel_type'] == 1) {



            // Admin Product Markup in (%)

            $productMarkupArr = getProductWiseMarkup($hotelsDetails, 'Offline Hotel');

            // Admin Agent Markup

            $agentmarkupArr = getAgentWiseMarkup($hotelsDetails, $user, 'Offline Hotel');

            // Agent Global Markup

            $agentglobalmarkupArr = getAgentGlobalWiseMarkup($hotelsDetails, $user, 'Offline Hotel');



            $calculateAmount = getFinalAmount($price, $productMarkupArr, $agentmarkupArr, $agentglobalmarkupArr);

        }



        return $calculateAmount;

    }

}



if (!function_exists('getProductWiseMarkup')) {



    function getProductWiseMarkup($hotelsDetails, $productName)

    {

        $returnArr = [];

        $returnArr['type'] = '';

        $returnArr['amount'] = 0;

        $returnArr['percentage'] = 0;



        if ($hotelsDetails['hotel']['hotel_type'] == 1) {

            $productmarkup = ProductMarkup::where('name', '=', $productName)

                ->where('status', '=', '1')

                ->first();

            if ($productmarkup->percentage > 0) {

                $returnArr['type'] = 'percentage';

                $returnArr['percentage'] = $productmarkup->percentage;

            }

        }



        return $returnArr;

    }

}



if (!function_exists('getAgentWiseMarkup')) {



    function getAgentWiseMarkup($hotelsDetails, $user, $productName)

    {

        $returnArr = [];

        $returnArr['type'] = '';

        $returnArr['amount'] = 0;

        $returnArr['percentage'] = 0;



        if ($hotelsDetails['hotel']['hotel_type'] == 1) {

            if ($user->agents->agentsmarkup) {

                $returnArr['type'] = 'percentage';

                $returnArr['percentage'] = $user->agents->agentsmarkup->offline_hotel;

            }

        }



        return $returnArr;

    }

}

if (!function_exists('getAgentGlobalWiseMarkup')) {



    function getAgentGlobalWiseMarkup($hotelsDetails, $user, $productName)

    {

        $returnArr = [];

        $returnArr['type'] = '';

        $returnArr['amount'] = 0;

        $returnArr['percentage'] = 0;



        if ($hotelsDetails['hotel']['hotel_type'] == 1) {

            if ($user->agents->agent_global_markups_type == 1) {

                $returnArr['type'] = 'percentage';

                $returnArr['percentage'] = $user->agents->agent_global_markup;

            } else if ($user->agents->agent_global_markups_type == 2) {

                $returnArr['type'] = 'fix';

                $returnArr['amount'] = $user->agents->agent_global_markup;

            }

        }



        return $returnArr;

    }

}



if (!function_exists('getFinalAmount')) {



    function getFinalAmount($price, $productMarkupArr, $agentmarkupArr, $agentglobalmarkupArr)

    {

      


        $returnArr = [];

        $returnArr['originAmount'] = $price;

        $returnArr['productMarkupAmount'] = 0;

        $returnArr['agentMarkupAmount'] = 0;

        $returnArr['finalAmount'] = 0;

        if (is_array($productMarkupArr)) {

            if ($productMarkupArr['type'] == "percentage") {

                $returnArr['productMarkupAmount'] = (float) $price * (float) $productMarkupArr['percentage'] / 100;

            } else {

                $returnArr['productMarkupAmount'] = $productMarkupArr['amount'];

            }

        }

        if (is_array($agentmarkupArr)) {

            if ($agentmarkupArr['type'] == "percentage") {

                $returnArr['agentMarkupAmount'] = (float) $price * (float) $agentmarkupArr['percentage'] / 100;

            } else {

                $returnArr['agentMarkupAmount'] = $agentmarkupArr['amount'];

            }

        }

        if (is_array($agentglobalmarkupArr)) {

            if ($agentglobalmarkupArr['type'] == "percentage") {

                $returnArr['agentGlobalMarkupAmount'] = (float) $price * (float) $agentglobalmarkupArr['percentage'] / 100;

            } else {

                $returnArr['agentGlobalMarkupAmount'] = $agentglobalmarkupArr['amount'];

            }

        }
        $returnArr['finalAmount'] = (float) $price + (float) $returnArr['productMarkupAmount'] + (float) $returnArr['agentMarkupAmount'] + (float) $returnArr['agentGlobalMarkupAmount'];
        
        return $returnArr;

    }

}



if (!function_exists('getFinalAmountOLD')) {



    function getFinalAmountOLD($price, $productMarkupArr, $agentmarkupArr)

    {



        $returnArr = [];

        $returnArr['originAmount'] = $price['price_p_n_twin_sharing'];

        $returnArr['productMarkupAmount'] = 0;

        $returnArr['agentMarkupAmount'] = 0;

        $returnArr['finalAmount'] = 0;

        if (is_array($productMarkupArr)) {

            if ($productMarkupArr['type'] == "percentage") {

                $returnArr['productMarkupAmount'] = $price['price_p_n_twin_sharing'] * $productMarkupArr['percentage'] / 100;

            } else {

                $returnArr['productMarkupAmount'] = $productMarkupArr['amount'];

            }

        }

        if (is_array($agentmarkupArr)) {

            if ($agentmarkupArr['type'] == "percentage") {

                $returnArr['agentMarkupAmount'] = $price['price_p_n_twin_sharing'] * $agentmarkupArr['percentage'] / 100;

            } else {

                $returnArr['agentMarkupAmount'] = $agentmarkupArr['amount'];

            }

        }

        $returnArr['finalAmount'] = $price['price_p_n_twin_sharing'] + $returnArr['productMarkupAmount'] + $returnArr['agentMarkupAmount'];

        return $returnArr;

    }

}





if (!function_exists('globalCurrency')) {



    function globalCurrency()

    {

        //return 'INR ';
        return '₹';

    }

}





if (!function_exists('getBookingCart')) {



    function getBookingCart($key)

    {

        $session = new Session();

        return $session->get($key);

    }

}



if (!function_exists('setBookingCart')) {

    function setBookingCart($key, $value)

    {

        $session = new Session();

        return $session->set($key, $value);

    }

}



if (!function_exists('getRoomDetailsByRoomID')) {

    function getRoomDetailsByRoomID($id)

    {

        return OfflineRoom::find($id);

    }

}



if (!function_exists('getFinalAmountChackOut')) {

    function getFinalAmountChackOut()

    {

        $amountFinal = 0;

        $data = getBookingCart('bookingCart');

        if (is_array($data) && count($data) > 0) {
            foreach ($data as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                $amountFinal = $amountFinal + $value['finalAmount'];

            }

        }
            }
        }
        return numberFormat($amountFinal);

    }

}



if (!function_exists('getOriginAmountChackOut')) {

    function getOriginAmountChackOut($data)

    {

       

        $amountOrigin = 0;



        if (is_array($data['cartData']) && count($data['cartData']) > 0) {
            foreach ($data['cartData'] as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                $amountOrigin = $amountOrigin + $value['originAmount'];

            }

        }

        

    }

}
        return floatval(numberFormat($amountOrigin));
    }
}

if (!function_exists('getHotelID')) {

    function getHotelID($data)

    {

        $amountOrigin = 0;



        if (is_array($data['cartData']) && count($data['cartData']) > 0) {

            foreach ($data['cartData'] as $key => $value) {

                return $value['hotel_id'];

            }

        }

        return false;

    }

}



if (!function_exists('getGuestLeadDetails')) {

    function getGuestLeadDetails($data)

    {

        $guestArr = [];

        $roomCount = getSearchCookies('searchGuestRoomCount');

        if ($roomCount > 0) {

            for ($i = 1; $i <= $roomCount; $i++) {



                if (is_array($data['room_' . $i]['adult']) && count($data['room_' . $i]['adult']) > 0) {

                    foreach ($data['room_' . $i]['adult'] as $key => $value) {

                        $guestArr['name'] = $data['room_' . $i]['adult']['firstname'][0] . ' ' . $data['room_' . $i]['adult']['lastname'][0];

                        $guestArr['phone'] = $data['room_' . $i]['adult']['phonenumber'][0];

                        return $guestArr;

                    }

                }

            }

        }

        return $guestArr;

    }

}



if (!function_exists('getGuestAllDetails')) {

    function getGuestAllDetails($data)

    {

        $guestArr = [];

        $roomCount = getSearchCookies('searchGuestRoomCount');

        if ($roomCount > 0) {

            for ($i = 1; $i <= $roomCount; $i++) {



                if (is_array($data['room_' . $i]['adult']) && count($data['room_' . $i]['adult']) > 0) {

                    foreach ($data['room_' . $i]['adult'] as $key => $value) {

                        $guestArrs = [];

                        $guestArrs['name'] = $data['room_' . $i]['adult']['firstname'][0] . ' ' . $data['room_' . $i]['adult']['lastname'][0];

                        $guestArrs['phone'] = $data['room_' . $i]['adult']['phonenumber'][0];

                        $guestArr[] = $guestArrs;

                    }

                }

            }

        }

        return $guestArr;

    }

}





if (!function_exists('paymentMethodName')) {

    function paymentMethodName($id)

    {

        if ($id == 1) {

            return 'Pay On time limit';

        } else if ($id == 2) {

            return 'Pay using wallet';

        } else if ($id == 3) {

            return 'Pay On Online payment';

        }

        return '';

    }

}



if (!function_exists('idProofName')) {

    function idProofName($id)

    {



        if ($id == 0) {

            return 'None';

        } else if ($id == 1) {

            return 'Aadhaar Card';

        } else if ($id == 2) {

            return 'Passport';

        } else if ($id == 3) {

            return 'Driving Licence';

        } else if ($id == 4) {

            return 'Voters ID Card';

        } else if ($id == 5) {

            return 'PAN Card';

        } else if ($id == 6) {

            return 'Other';

        }

        return '';

    }

}



if (!function_exists('getPaymentStatus')) {

    function getPaymentStatus($status)

    {

        if ($status == 1) {

            return '<span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-yellow-4 text-yellow-3">Processed</span>';

        } else if ($status == 2) {

            return '<span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-blue-1-05 text-blue-1">Confirmed</span>';

        } else if ($status == 3) {

            return '<span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-red-3 text-red-2">Cancelled</span>';

        } else if ($status == 4) {

            return '<span class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-blue-1-05 text-blue-1">Vouchered</span>';

        }

        return '';

    }

}

if (!function_exists('getOrderHistoryAction')) {

    function getOrderHistoryAction($id, $order)

    {

        $action = '';

        $action .= '<a href="' . route('agent.view-booking-history', $id) . '" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a> ';

        $action .= '<a href="' . route('agent-invoice-download', $order) . '" class="edit btn btn-info btn-sm" data-toggle="tooltip" data-original-title="Download Invoice" data-animation="false"><i class="fa fa-cloud-download" aria-hidden="true"></i></a> ';

        return $action;

    }

}





if (!function_exists('orderStatusByID')) {

    function orderStatusByID($status)

    {

        if ($status == 'processed') {

            return 1;

        } else if ($status == 'confirmed') {

            return 2;

        } else if ($status == 'cancelled') {

            return 3;

        } else if ($status == 'vouchered') {

            return 4;

        }

    }

}





if (!function_exists('orderRoomIDByAdultChild')) {

    function orderRoomIDByAdultChild($id)

    {

        return Order_Room::find($id);

    }

}

if (!function_exists('chidWithBed')) {

    function chidWithBed($passengerData)

    {

        if (count($passengerData->child->childBed) > 0) {

            return 'Yes';

        }

        return 'No';

    }

}



if (!function_exists('getChildAge')) {

    function getChildAge($data)

    {

        $ageString = "";

        if (count($data) > 0) {

            foreach ($data as $key => $value) {

                $ageString .= $value->child_age . ",";

            }

        }



        return trim($ageString, ',');

    }

}





if (!function_exists('generateUniqueNumber')) {

    function generateUniqueNumber($beforeText = "order", $langth = 4)

    {



        $today = date("Ymdhms");

        return $beforeText . '_' . $today . '' . strtoupper(substr(uniqid(sha1(time())), 0, $langth));

    }

}





if (!function_exists('chilCountwithBedOrNot')) {

    function chilCountwithBedOrNot()

    {

        $childCount = [];

        $childCount['child_with_bed'] = 0;

        $childCount['child_without_bed'] = 0;

        $passengerData = getSearchCookies('searchGuestArr');

       

        if (count($passengerData) > 0) {

            foreach ($passengerData as $key => $value) {

               

                if ($value->child > 0) {

                    if (count($value->childAge) > 0) {

                        foreach ($value->childAge as $key1 => $value1) {

                            if ($value1->cwb == "yes") {

                                $childCount['child_with_bed'] = $childCount['child_with_bed'] + 1;

                            } else if ($value1->cwb == "no") {

                                $childCount['child_without_bed'] = $childCount['child_without_bed'] + 1;

                            }

                        }

                    }

                }

            }

        }

        return $childCount;

    }

}

if (!function_exists('InvoiceNumberGenerator')) {
    function InvoiceNumberGenerator($prefix = NULL)
    {
        $latestNumberData = 1;
        $latestNumberData = Order::latest()->first();

        if ($latestNumberData) {
            $latestNumberData = $latestNumberData->id;
        }

        if (strlen($prefix) > 0) {
            return $prefix.'' . (str_pad($latestNumberData + 1, 4, '0', STR_PAD_LEFT));
        } else {
            return (str_pad($latestNumberData + 1, 4, '0', STR_PAD_LEFT));
        }
    }
}

if (!function_exists('dateFormatNewMethod')) {

    /**

     * numberFormat return number with two decimals

     */

    function dateFormatNewMethod($date)

    {

        
        $timestamp = strtotime($date);
        if ($timestamp === FALSE) {
            $timestamp = strtotime(str_replace('/', '-', $date));
        }
        return date("Y-m-d", $timestamp);
    

    //     $_firstDate = date("m-d-Y", strtotime($date));
    //     return date("Y-m-d",strtotime($_firstDate));

    }
}

if (!function_exists('getCartTotalItem')) {
    function getCartTotalItem()
    {
        $bookingCart = getBookingCart('bookingCart');
       
        $cartItem = 0;
        if (is_array($bookingCart) && count($bookingCart) > 0) {
            foreach ($bookingCart as $bo_key => $bo_value) {
                if ($bo_key == 'hotel') {
                    foreach ($bo_value as $key => $value) {
                        $cartItem = $cartItem + 1;
                    }
                }
            }
        }
        setBookingCart('bookingCartItem', $cartItem);        
        return $cartItem;
    }
}

if (!function_exists('getSearchWiseRommLowestPrice')) {
    function getSearchWiseRommLowestPrice($rooms)
    {
        $searchGuestArr = getSearchCookies('searchGuestArr');
        foreach($searchGuestArr as $search){
            $aultsTotal = $search->adult + $search->child;
           foreach($rooms as $room){
            $room->where('occ_max_adults','>=',$aultsTotal);
            
            dd($room);
          }
        }
        
        dd($searchGuestArr);
    }
}
if (!function_exists('getLowestGuest')) {
    function getLowestGuest()
    {
        $searchGuestArr = getSearchCookies('searchGuestArr');

        
        foreach($searchGuestArr as $key => $value){
            $max_accupancy[] = $value->adult + $value->child;

        }

        return min($max_accupancy);
    }
}
if (!function_exists('getLowestGuestArray')) {
    function getLowestGuestArray()
    {
        $searchGuestArr = getSearchCookies('searchGuestArr');
        foreach($searchGuestArr as $key => $value){
            $max_accupancy[] = $value->adult + $value->child;

        }

        return min($max_accupancy);
    }
}
if (!function_exists('getDateWiseSurcharge')) {
    function getDateWiseSurcharge($hotel,$startDate,$endDate)
    {
         $surCharges = $hotel->surcharges()
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where('surcharge_date_start', '>=', $startDate)
                            ->where('surcharge_date_start', '<', $endDate);
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('surcharge_date_end', '>', $startDate)
                            ->where('surcharge_date_end', '<=', $endDate);
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('surcharge_date_start', '<=', $startDate)
                            ->where('surcharge_date_end', '>=', $endDate);
                    })->orderBy('surcharge_date_start')->get();
            $tempSurcharge = [];
            foreach ($surCharges as $key => $surcharge) {
                $tempArr = [];
                $stDate = DateGTEchecker($surcharge->surcharge_date_start,$startDate);
                $edDate = DateLTEchecker($surcharge->surcharge_date_end,$endDate);
                $tempArr['surcharge_name'] = $surcharge->surcharge_name;
                $tempArr['surcharge_date_start'] = $surcharge->surcharge_date_start;
                $tempArr['surcharge_date_end'] = $surcharge->surcharge_date_end;
                $tempArr['surcharge_price'] = $surcharge->surcharge_price;
                $tempArr['stDate'] = $stDate->format('Y-m-d');
                $tempArr['edDate'] = $edDate->format('Y-m-d');
                $tempArr['days'] = dateDiffInDays($stDate->format('Y-m-d'),$edDate->format('Y-m-d'));
                $tempArr['total_amount'] = $surcharge->surcharge_price * $tempArr['days'];
                $tempSurcharge[] = $tempArr;
            }

        return $tempSurcharge;
    }

}
if (!function_exists('getDateWisePromotional')) {
    function getDateWisePromotional($hotel,$startDate,$endDate)
    {
         $promoCharges = $hotel->prompstionals()
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where('date_validity_start', '>=', $startDate)
                            ->where('date_validity_start', '<', $endDate);
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('date_validity_end', '>', $startDate)
                            ->where('date_validity_end', '<=', $endDate);
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('date_validity_start', '<=', $startDate)
                            ->where('date_validity_end', '>=', $endDate);
                    })->orderBy('date_validity_start')->get();
            $tempPromotional = [];
            foreach ($promoCharges as $key => $promocharge) {
                $tempArr = [];
                $stDate = DateGTEchecker($promocharge->date_validity_start,$startDate);
                $edDate = DateLTEchecker($promocharge->date_validity_end,$endDate);

                $tempArr['single_adult'] = $promocharge->single_adult;
                $tempArr['per_room'] = $promocharge->per_room;
                $tempArr['extra_adult'] = $promocharge->extra_adult;
                $tempArr['child_with_bed'] = $promocharge->child_with_bed;
                $tempArr['child_with_no_bed_0_4'] = $promocharge->child_with_no_bed_0_4;
                $tempArr['child_with_no_bed_5_12'] = $promocharge->child_with_no_bed_5_12;
                $tempArr['child_with_no_bed_13_18'] = $promocharge->child_with_no_bed_13_18;
                $tempArr['date_validity_start'] = $promocharge->date_validity_start;
                $tempArr['date_validity_end'] = $promocharge->date_validity_end;

                $tempArr['stDate'] = $stDate->format('Y-m-d');
                $tempArr['edDate'] = $edDate->format('Y-m-d');
                $tempArr['days'] = dateDiffInDays($stDate->format('Y-m-d'),$edDate->format('Y-m-d'));
                //$tempArr['total_amount'] = $promocharge->surcharge_price * $tempArr['days'];
                $tempPromotional[] = $tempArr;
            }
       
        return $tempPromotional;
    }

}

if (!function_exists('getDateDiffDays')) {
    function getDateDiffDays($startDate, $endDate)
    {  
        return dateDiffInDays($startDate, $endDate);       
    }

}

if (!function_exists('getDateNormalPrice')) {
    function getDateNormalPrice($startDate, $endDate,$promoDays,$blackDays)
    {   $normalDays =0;
        $allDays = dateDiffInDays($startDate, $endDate);
        if( $allDays >= ($promoDays + $blackDays) ){
            $normalDays = ($allDays - ($promoDays + $blackDays));
        } 
        return $normalDays;
    }

}

if (!function_exists('DateGTEchecker')) {
    function DateGTEchecker($startDate,$endDate)
    {
        $dateToCompare1 = Carbon::createFromFormat('Y-m-d',$startDate);
        if($dateToCompare1->gte($endDate)){
            $returnDate =  $dateToCompare1;
        }else{
            $returnDate =  $endDate;
        }
        return $returnDate;
    }
}
if (!function_exists('DateLTEchecker')) {
    function DateLTEchecker($startDate,$endDate)
    {
        $dateToCompare1 = Carbon::createFromFormat('Y-m-d',$startDate);
        if($dateToCompare1->lte($endDate)){
            $returnDate =  $dateToCompare1;
        }else{
            $returnDate =  $endDate;
        }
        return $returnDate;
    }
}

if (!function_exists('CancellationFeesCalculated')) {
    function CancellationFeesCalculated($roomPriceData, $fromDate)
    {     
        if( $roomPriceData->cancelationpolicies ){
            //dd($roomPriceData->cancelationpolicies);
            
            foreach ($roomPriceData->cancelationpolicies as $key => $value) {
             
                $date = Carbon::createFromFormat('Y-m-d H:i:s', dateFormat( str_replace('/', '-', $fromDate),'Y-m-d H:i:s'));
                $date->subDay($value->before_check_in_days);   
                $endOfDay = $date->endOfDay();            
                if( $value->night_charge < 1 ){
                    echo '<div class="items-center text-green-2">
                    <div class="text-13 pull-left">Until '.$endOfDay->format('g:i A').' on
                        '.$date->format('Y-m-d').'
            </div><div class="text-13 pull-right"><i
            class="fa fa-check-circle text-12"></i>
        Free</div>
    </div>';
                } else {
                    echo '<div class="items-center">
                    <div class="text-13 pull-left">After '.$endOfDay->format('g:i A').' on
                        '.$date->format('Y-m-d').'
                    </div><div class="text-13 pull-right text-danger"> '.$value->night_charge.' '.globalCurrency().'
                    
        </div>
    </div>';
                }
                
            }
        }
            
    }
}

if (!function_exists('getNumberWithComma')) {
    function getNumberWithComma($number, $currency = ""){
        if( strlen($currency) > 0 ){
            return $currency.' '.number_format($number, 2, '.', ',');
        } else {
            return number_format($number, 2, '.', ',');
        }
        
    }
}

if (!function_exists('getNumberWithCommaGlobalCurrency')) {
    function getNumberWithCommaGlobalCurrency($number, $isBack=""){        
        if( strlen($isBack) > 0 ){
            return number_format($number, 2, '.', ',').' '.globalCurrency();
        } else {
            return globalCurrency().' '.number_format($number, 2, '.', ',');
        }
    }
}