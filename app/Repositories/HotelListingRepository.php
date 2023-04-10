<?php

namespace App\Repositories;

use App\Models\OfflineHotel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelListingRepository
{



    public function hotelLists($request)
    {        
        $hotels = OfflineHotel::with(['rooms.price'])->where(function ($query) use ($request) {
            if (strlen($request->hotel_amenities) > 0) {
                $query->whereHas('hotelamenity', function ($query) use ($request) {
                    $query->whereIn('amenities_id', explode(', ', $request->hotel_amenities));
                });
            }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_country_id) > 0) {
                    $query->where('hotels.hotel_country', '=', $request->requested_country_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_city_id) > 0) {
                    $query->where('hotels.hotel_city', '=', $request->requested_city_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->star) > 0) {
                    $query->where('hotels.category', '<=', $request->star);
                }
            })
            ->paginate(10);
        
        return $hotels;
    }

    public function hotelCount($request)
    {
        return OfflineHotel::where(function ($query) use ($request) {
            if (strlen($request->hotel_amenities) > 0) {
                $query->whereHas('hotelamenity', function ($query) use ($request) {
                    $query->whereIn('amenities_id', explode(', ', $request->hotel_amenities));
                });
            }
        })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_country_id) > 0) {
                    $query->where('hotels.hotel_country', '=', $request->requested_country_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_city_id) > 0) {
                    $query->where('hotels.hotel_city', '=', $request->requested_city_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->star) > 0) {
                    $query->where('hotels.category', '<=', $request->star);
                }
            })
            ->count();
    }
}
