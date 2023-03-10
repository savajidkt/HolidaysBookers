<?php

namespace App\Http\Controllers\Admin\OfflineRooms;

use Exception;
use App\Models\User;
use App\Models\Country;
use App\Models\OfflineRoom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\OfflineRoomRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\OfflineRoom\EditRequest;
use App\Http\Requests\OfflineRoom\CreateRequest;
use App\Models\Amenity;
use App\Models\OfflineHotel;
use App\Models\RoomType;

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
                })->addColumn('room_type', function (OfflineRoom $room) {
                    return $room->roomtype->room_type;
                })->addColumn('total_adult', function (OfflineRoom $room) {
                    return $room->total_adult;
                })->addColumn('total_cwb', function (OfflineRoom $room) {
                    return $room->total_cwb;
                })->addColumn('total_cnb', function (OfflineRoom $room) {
                    return $room->total_cnb;
                })->editColumn('status', function (OfflineRoom $room) {
                    return $room->status_name;
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
        return view('admin.offline-rooms.create', ['model' => $rawData, 'HotelsList' => $HotelsList, 'HotelsRoomType' => $HotelsRoomType, 'HotelsAmenities' => $HotelsAmenities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->offlineRoomRepository->create($request->all());
        return redirect()->route('offlinerooms.index')->with('success', 'Offline Room created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, OfflineRoom $offlineRoom)
    {
        echo "Show Room Dettails"; exit;
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('admin.offline-rooms.view', ['model' => $offlineRoom, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\OfflineRoom $offlineRoom [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(OfflineRoom $offlineRoom)
    {
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('admin.offline-rooms.edit', ['model' => $offlineRoom, 'countries' => $countries]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\OfflineRoom\EditRequest $request
     * @param \App\Models\OfflineRoom $offlineRoom
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, OfflineRoom $offlineRoom)
    {
        $this->offlineRoomRepository->update($request->all(), $offlineRoom);

        return redirect()->route('offlinerooms.index')->with('success', 'Offline Room updated successfully!');
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
}
