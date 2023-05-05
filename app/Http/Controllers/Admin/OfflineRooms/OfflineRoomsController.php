<?php

namespace App\Http\Controllers\Admin\OfflineRooms;

use Exception;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\RoomType;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;
use App\Models\OfflineRoomGallery;
use Illuminate\Http\Request;
use App\Models\OfflineRoomPrice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\OfflineRoomRepository;
use App\Http\Requests\OfflineRoom\EditRequest;
use App\Http\Requests\OfflineRoom\CreateRequest;
use App\Models\Currency;
use App\Models\Freebies;
use App\Models\MealPlan;
use App\Models\OfflineRoomChildPrice;

class OfflineRoomsController extends Controller
{
    protected $offlineRoomRepository;
    public function __construct(OfflineRoomRepository $offlineRoomRepository)
    {
        $this->offlineRoomRepository       = $offlineRoomRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OfflineRoom::where('type', OfflineRoom::OFFLINE);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hotel_name', function (OfflineRoom $room) {
                    return $room->hotel->hotel_name;
                })->filterColumn('hotel_name', function ($query, $keyword) {
                    $query->whereHas('hotel', function ($query) use ($keyword) {
                        $query->where('hotel_name', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('room_type', function (OfflineRoom $room) {
                    return $room->roomtype->room_type;
                })->filterColumn('room_type', function ($query, $keyword) {
                    $query->whereHas('roomtype', function ($query) use ($keyword) {
                        $query->where('room_type', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('occ_sleepsmax', function (OfflineRoom $room) {
                    return $room->occ_sleepsmax;
                })->filterColumn('occ_sleepsmax', function ($query, $keyword) {
                    $query->where('occ_sleepsmax', 'LIKE', '%' . $keyword . '%');
                })->addColumn('occ_num_beds', function (OfflineRoom $room) {
                    return $room->occ_num_beds;
                })->filterColumn('occ_num_beds', function ($query, $keyword) {
                    $query->where('occ_num_beds', 'LIKE', '%' . $keyword . '%');
                })->addColumn('occ_max_adults', function (OfflineRoom $room) {
                    return $room->occ_max_adults;
                })->filterColumn('occ_max_adults', function ($query, $keyword) {
                    $query->where('occ_max_adults', 'LIKE', '%' . $keyword . '%');
                })->addColumn('status', function (OfflineRoom $room) {
                    return $room->status_name;
                })->filterColumn('status', function ($query, $keyword) {
                    $query->where('status', '=', $keyword);
                })->addColumn('action', function ($row) {
                    return $row->action;
                })->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.offline-rooms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new OfflineRoom;
        $HotelsList  = OfflineHotel::where('hotel_type', OfflineHotel::OFFLINE)->pluck('hotel_name', 'id')->toArray();
        $HotelsRoomType  = RoomType::where('status', RoomType::ACTIVE)->pluck('room_type', 'id')->toArray();
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::ROOM)->pluck('amenity_name', 'id')->toArray();
        $HotelsRoomMealPlan  = MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray();
        $HotelsFreebies  = Freebies::where('status', Freebies::ACTIVE)->where('type', Freebies::ROOM)->pluck('name', 'id')->toArray();
        return view('admin.offline-rooms.create', ['model' => $rawData, 'HotelsList' => $HotelsList, 'HotelsRoomType' => $HotelsRoomType, 'HotelsAmenities' => $HotelsAmenities, 'offlinehotel' => "", 'HotelsRoomMealPlan' => $HotelsRoomMealPlan, 'HotelsFreebies' => $HotelsFreebies]);
    }

    public function roomCreate(OfflineHotel $offlinehotel)
    {
        $rawData    = new OfflineRoom;
        $HotelsList  = OfflineHotel::where('hotel_type', OfflineHotel::OFFLINE)->pluck('hotel_name', 'id')->toArray();
        $HotelsRoomType  = RoomType::where('status', RoomType::ACTIVE)->pluck('room_type', 'id')->toArray();
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::ROOM)->pluck('amenity_name', 'id')->toArray();
        $HotelsRoomMealPlan  = MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray();
        $HotelsFreebies  = Freebies::where('status', Freebies::ACTIVE)->where('type', Freebies::ROOM)->pluck('name', 'id')->toArray();
        return view('admin.offline-rooms.create', ['model' => $rawData, 'HotelsList' => $HotelsList, 'HotelsRoomType' => $HotelsRoomType, 'HotelsAmenities' => $HotelsAmenities, 'offlinehotel' => $offlinehotel, 'HotelsRoomMealPlan' => $HotelsRoomMealPlan, 'HotelsFreebies' => $HotelsFreebies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->offlineRoomRepository->create($request, $request->all());
        return redirect()->route('offlinerooms.index')->with('success', 'Offline Room created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OfflineRoom $offlineroom)
    {
        $amenitiesName = implode(' | ', $offlineroom->roomamenity()->pluck('amenity_name')->toArray());
        $freebiesName = implode(' | ', $offlineroom->roomfreebies()->pluck('name')->toArray());
        return view('admin.offline-rooms.view', ['model' => $offlineroom, 'amenitiesName' => $amenitiesName, 'freebiesName' => $freebiesName]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\OfflineRoom $offlineroom [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(OfflineRoom $offlineroom)
    {
        $HotelsList  = OfflineHotel::where('hotel_type', OfflineHotel::OFFLINE)->pluck('hotel_name', 'id')->toArray();
        $HotelsRoomType  = RoomType::where('status', RoomType::ACTIVE)->pluck('room_type', 'id')->toArray();
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::ROOM)->pluck('amenity_name', 'id')->toArray();
        $HotelsAmenitiesIDS  = $offlineroom->roomamenity()->pluck('amenity_id')->toArray();

        $HotelsRoomMealPlan  = MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray();
        $HotelsFreebies  = Freebies::where('status', Freebies::ACTIVE)->where('type', Freebies::ROOM)->pluck('name', 'id')->toArray();
        $HotelsFreebiesIDs  = $offlineroom->roomfreebies()->pluck('freebies_id')->toArray();
        return view('admin.offline-rooms.edit', ['model' => $offlineroom, 'HotelsList' => $HotelsList, 'HotelsRoomType' => $HotelsRoomType, 'HotelsAmenities' => $HotelsAmenities, 'HotelsAmenitiesIDS' => $HotelsAmenitiesIDS, 'HotelsRoomMealPlan' => $HotelsRoomMealPlan, 'HotelsFreebies' => $HotelsFreebies, 'HotelsFreebiesIDs' => $HotelsFreebiesIDs]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\OfflineRoom\EditRequest $request
     * @param \App\Models\OfflineRoom $offlineRoom
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, OfflineRoom $offlineroom)
    {

        $this->offlineRoomRepository->update($request, $request->all(), $offlineroom);
        return response()->json([
            'status' => true,
            'message' => 'Offline Room updated successfully!'
        ]);
        //return redirect()->route('offlinerooms.index')->with('success', 'Offline Room updated successfully!');
    }


    /**
     * Method destroy
     *
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return void
     */
    public function destroy(OfflineRoom $offlineroom)
    {
        $this->offlineRoomRepository->delete($offlineroom);
        return redirect()->route('offlinerooms.index')->with('success', 'Offline Room deleted successfully!');
    }

    /**
     * Method changeStatus
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $input = $request->all();
        $offlineroom  = OfflineRoom::find($input['offline_room_id']);
        if ($this->offlineRoomRepository->changeStatus($input, $offlineroom)) {
            return response()->json([
                'status' => true,
                'message' => 'Offline Room status updated successfully!'
            ]);
        }
        throw new Exception('Offline Room status does not change. Please check sometime later.');
    }


    /**
     * Method viewPrice
     *
     * @param Request $request [explicite description]
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return void
     */
    public function viewPrice(Request $request, OfflineRoom $offlineroom)
    {
        if ($request->ajax()) {
            $data = OfflineRoomPrice::where('room_id', $offlineroom->id)->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hotel_name', function (OfflineRoomPrice $price) {
                    return $price->room->hotel->hotel_name;
                })->addColumn('room_type', function (OfflineRoomPrice $price) {
                    return $price->room->roomtype->room_type;
                })->addColumn('price_type', function (OfflineRoomPrice $price) {
                    return $price->price_type_name;
                })->addColumn('from_date', function (OfflineRoomPrice $price) {
                    if ($price->from_date && $price->to_date) {
                        return $price->from_date . ' <strong> to </strong> ' . $price->to_date;
                    } else if ($price->from_date) {
                        return $price->from_date;
                    } else if ($price->to_date) {
                        return $price->to_date;
                    } else {
                        return '';
                    }
                })->addColumn('booking_start_date', function (OfflineRoomPrice $price) {
                    if ($price->booking_start_date && $price->booking_end_date) {
                        return $price->booking_start_date . '<strong> to </strong>' . $price->booking_end_date;
                    } else if ($price->booking_start_date) {
                        return $price->booking_start_date;
                    } else if ($price->booking_end_date) {
                        return $price->booking_end_date;
                    } else {
                        return '';
                    }
                })->addColumn('action', function ($row) {
                    return $row->action;
                })->rawColumns(['action', 'price_type', 'booking_start_date', 'from_date'])->make(true);
        }

        return view('admin.offline-rooms.offline-room-price.index', ['model' => $offlineroom]);
    }

    /**
     * Method createPrice
     *
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return void
     */
    public function createPrice(OfflineRoom $offlineroom)
    {
        $roomPrice = new OfflineRoomPrice();
        $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
        $HotelsRoomMealPlan  = MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray();
        return view('admin.offline-rooms.offline-room-price.create', ['pricemodel' => $roomPrice, 'model' => $offlineroom, 'currencyList' => $currencyList, 'HotelsRoomMealPlan' => $HotelsRoomMealPlan]);
    }

    /**
     * Method storePrice
     *
     * @param Request $request [explicite description]
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return void
     */
    public function storePrice(Request $request, OfflineRoom $offlineroom)
    {
        if ($request->save == "save and new") {

            $this->offlineRoomRepository->createPrice($request->all(), $offlineroom);

            $roomPrice = new OfflineRoomPrice();
            $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
            $HotelsRoomMealPlan  = MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray();

            $TravelDate = explode(' to ', $request->start_date);
            $BookingDate = explode(' to ', $request->booking_start_date);

            $request['from_date'] = isset($TravelDate[0]) ? $TravelDate[0] : '';
            $request['to_date'] = isset($TravelDate[1]) ? $TravelDate[1] : '';
            $request['booking_from_date'] = isset($BookingDate[0]) ? $BookingDate[0] : '';
            $request['booking_to_date'] = isset($BookingDate[1]) ? $BookingDate[1] : '';

            return view('admin.offline-rooms.offline-room-price.createNew', ['pricemodel' => $roomPrice, 'model' => $offlineroom, 'currencyList' => $currencyList, 'HotelsRoomMealPlan' => $HotelsRoomMealPlan, 'requestData' => $request->all()]);
        } else {
            $this->offlineRoomRepository->createPrice($request->all(), $offlineroom);
            return redirect()->route('view-room-price', $offlineroom)->with('success', 'Offline Room Price created successfully!');
        }
    }

    /**
     * Method editPrice
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function editPrice($id)
    {
        $roomPrice = OfflineRoomPrice::find($id);
        $OfflineRoom = $roomPrice->room;
        $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
        $HotelsRoomMealPlan  = MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray();
        return view('admin.offline-rooms.offline-room-price.edit', ['pricemodel' => $roomPrice, 'model' => $OfflineRoom, 'currencyList' => $currencyList, 'HotelsRoomMealPlan' => $HotelsRoomMealPlan]);
    }

    /**
     * Method updatePrice
     *
     * @param Request $request [explicite description]
     * @param OfflineRoomPrice $offlineroomprice [explicite description]
     *
     * @return void
     */
    public function updatePrice(Request $request, OfflineRoomPrice $offlineroomprice)
    {
        $offlineroom =  $offlineroomprice->room;
        $this->offlineRoomRepository->updatePrice($request->all(), $offlineroomprice);
        return redirect()->route('view-room-price', $offlineroom)->with('success', 'Offline Room Price updated successfully!');
    }

    /**
     * Method destroyPrice
     *
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return void
     */
    public function destroyPrice(OfflineRoomPrice $offlineroomprice)
    {
        $offlineroom =  $offlineroomprice->room;
        $this->offlineRoomRepository->deletePrice($offlineroomprice);
        return redirect()->route('view-room-price', $offlineroom)->with('success', 'Offline Room Price deleted successfully!');
    }

    /**
     * Method deleteRoomImage
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function deleteRoomImage(Request $request)
    {

        $filename = str_replace(url(Storage::url('app/upload/Hotel/')), '', $request->filename);
        $filesname =  explode('/', $filename);
        if (is_array($filesname) && count($filesname) > 0) {
            $image = OfflineRoom::where('id', $filesname[3])->where('room_image', $filesname[4]);
            if ($image->update(['room_image' => ''])) {
                return response()->json([
                    'status' => true,
                    'message' => 'Offline room image deleted successfully!'
                ]);
            }
            throw new Exception('Offline room image does not deleted. Please check sometime later.');
        }
    }

    /**
     * Method deleteRoomGalleryImage
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function deleteRoomGalleryImage(Request $request)
    {

        $filename = str_replace(url(Storage::url('app/upload/Hotel/')), '', $request->filename);
        $filesname =  explode('/', $filename);
        if (is_array($filesname) && count($filesname) > 0) {
            $gallery = OfflineRoomGallery::where('room_id', $filesname[3])->where('images', $filesname[5]);
            if ($gallery->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Offline room gallery image deleted successfully!'
                ]);
            }
            throw new Exception('Offline room gallery image does not deleted. Please check sometime later.');
        }
    }


    public function hotelWiseRooms(Request $request)
    {
        // $data = OfflineHotel::find($id);

        if ($request->ajax()) {
            $data = OfflineRoom::where('hotel_id', $request->hotel_id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hotel_name', function (OfflineRoom $room) {
                    return $room->hotel->hotel_name;
                })->filterColumn('hotel_name', function ($query, $keyword) {
                    $query->whereHas('hotel', function ($query) use ($keyword) {
                        $query->where('hotel_name', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('room_type', function (OfflineRoom $room) {
                    return $room->roomtype->room_type;
                })->filterColumn('room_type', function ($query, $keyword) {
                    $query->whereHas('roomtype', function ($query) use ($keyword) {
                        $query->where('room_type', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('total_adult', function (OfflineRoom $room) {
                    return $room->total_adult;
                })->filterColumn('total_adult', function ($query, $keyword) {
                    $query->where('total_adult', 'LIKE', '%' . $keyword . '%');
                })->addColumn('total_cwb', function (OfflineRoom $room) {
                    return $room->total_cwb;
                })->filterColumn('total_cwb', function ($query, $keyword) {
                    $query->where('total_cwb', 'LIKE', '%' . $keyword . '%');
                })->addColumn('total_cnb', function (OfflineRoom $room) {
                    return $room->total_cnb;
                })->filterColumn('total_cnb', function ($query, $keyword) {
                    $query->where('total_cnb', 'LIKE', '%' . $keyword . '%');
                })->editColumn('status', function (OfflineRoom $room) {
                    return $room->status_name;
                })->addColumn('action', function ($row) {
                    return $row->action;
                })->rawColumns(['action', 'status'])->make(true);
        }
        //return view('admin.offline-rooms.create');
    }


    public function showPrice(Request $request, OfflineRoomPrice $offlineroomprice)
    {
        $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
        return view('admin.offline-rooms.offline-room-price.view', ['model' => $offlineroomprice, 'currencyList' => $currencyList]);
    }

    public function deleteChild(Request $request): JsonResponse
    {
        $input = $request->all();
        $offlineroomchildprice  = OfflineRoomChildPrice::find($input['id']);
        if ($this->offlineRoomRepository->deleteChild($offlineroomchildprice)) {
            return response()->json([
                'status' => true,
                'message' => 'Offline Room child remove successfully!'
            ]);
        }
        throw new Exception('Offline Room child does not remove. Please check sometime later.');
    }
}
