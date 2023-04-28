<?php

use Carbon\Carbon;
use App\Models\City;
use App\Models\Reach;
use App\Models\State;
use App\Libraries\Safeencryption;
use App\Models\WalletTransaction;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use App\Models\OfflineRoomChildPrice;
use Illuminate\Support\Facades\Storage;

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
        exit;
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


if (!function_exists('calculateBalance')) {
    /**
     * calculateBalance return Balance
     */
    function calculateBalance($agent_id, $type, $amount)
    {
        $letest = WalletTransaction::where('agent_id', $agent_id)->latest()->first();
        if ($type == 0) {
            if ($letest->balance >= $amount) {
                return  numberFormat($letest->balance - $amount);
            } else {
                return redirect()->route('agents.index')->with('error', "Please enter less then balance amount");
            }
        } else if ($type == 1) {
            return  numberFormat($letest->balance + $amount);
        }
        return redirect()->route('agents.index')->with('error', "HB Credit type not found");
    }
}


if (!function_exists('availableBalance')) {
    /**
     * availableBalance return Balance
     */
    function availableBalance($agent_id, $currency = '₹')
    {
        $letest = WalletTransaction::where('agent_id', $agent_id)->orderBy('id', 'DESC')->latest()->first();
        if ($letest->balance > 0) {
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
        //    print_r($result);
        //    die;
        //$result = str_replace("world","Peter","Hello world!");
        $xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);

        $json = json_encode($xml);
        $arr = json_decode($json, true);
        echo "<pre>";
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
    $child_age1 = $param['filterObjParamChildAge1'];
    $child_age2 = $param['filterObjParamChildAge2'];

    $child_younger = $param['filterObjParamChildYounger'];
    $child_older = $param['filterObjParamChildOlder'];
    $chilldPrice = 0;

    if ($param['filterObjParamChild'] <= 2) {
        $roomChildPrice = OfflineRoomChildPrice::query();
        $roomChildPrice = $roomChildPrice->where(function ($query) use ($param) {
            $query->whereRaw("'" . $param['filterObjParamChildAge1'] . "' between min_age and max_age");
            if ($param['filterObjParamChildAge2'] > 0) {
                $query->orWhereRaw("'" . $param['filterObjParamChildAge2'] . "' between min_age and max_age");
            }
        });
        $roomChildPrice = $roomChildPrice->where('price_id', $room_price_id)->get();
        $childPrice = $roomChildPrice->sum('cwb_price');
    } else {
        $roomChildPrice = OfflineRoomChildPrice::query();

        $roomChildPrice = $roomChildPrice->where(function ($query) use ($param) {
            if ($param['filterObjParamChildYounger'] > 0) {
                $query->whereRaw(" '6' between min_age and max_age");
            }
            if ($param['filterObjParamChildAge2'] > 0) {
                $query->whereRaw(" '7' between min_age and max_age");
            }
        });


        $roomChildPrice = $roomChildPrice->where('price_id', $room_price_id)->get();

        dd($roomChildPrice);
        die;
    }

    return $childPrice;
}



if (!function_exists('selectRoomBooking')) {

    function selectRoomBooking($paramArr)
    {
       
        $SafeencryptionObj = new Safeencryption;
        $id = "";
        if (is_array($paramArr) && count($paramArr) > 0) {
            $string = "";
            foreach ($paramArr as $key => $value) {
                $string .= $key."=".$value ."&";
            }
            $string = trim($string,'&');
            $id = $SafeencryptionObj->encode($string);            
        }
        return $id;
    }
}
