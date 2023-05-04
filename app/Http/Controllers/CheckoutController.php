<?php

namespace App\Http\Controllers;


use App\Models\City;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use App\Models\OfflineRoomPrice;

use App\Libraries\Safeencryption;
use App\Repositories\HotelListingRepository;
use App\Repositories\HotelRoomListingRepository;
use App\Repositories\CheckoutRepository;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $hotelListingRepository;
    protected $hotelRoomListingRepository;
    protected $checkoutRepository;
    public function __construct(HotelListingRepository $hotelListingRepository, HotelRoomListingRepository $hotelRoomListingRepository, CheckoutRepository $checkoutRepository)
    {
        $this->hotelListingRepository       = $hotelListingRepository;
        $this->hotelRoomListingRepository       = $hotelRoomListingRepository;
        $this->checkoutRepository       = $checkoutRepository;
    }

    public function checkout($id)
    {
        try {           
            $SafeencryptionObj = new Safeencryption;
            $requiredParamArr = unserialize($SafeencryptionObj->decode($id));
           
           
            if (is_array($requiredParamArr) && count($requiredParamArr) > 0) {
                $hotelsDetails = $this->hotelListingRepository->hotelDetails($requiredParamArr['hotel_id']);
                //dd($requiredParamArr);

                $offlineRoom = OfflineRoom::find($requiredParamArr['room_id']);
              

                return view('checkout.checkout',['hotelsDetails' => $hotelsDetails, 'offlineRoom' => $offlineRoom, 'requiredParamArr' => $requiredParamArr, 'bookingKey' =>$id]);
            }
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'Internal problem');
        }
        
    }

    public function store(Request $request)
    {
       
        $SafeencryptionObj = new Safeencryption;
        $requiredParamArr = unserialize($SafeencryptionObj->decode($request->bookingKey));
       
        $data = $this->checkoutRepository->create($request->all());
        return redirect()->route('checkout.show',$data)->with('success', 'Your booking created successfully!');
    }


    public function show($id)
    {        
        return view('checkout.thank-you');
    }
}
