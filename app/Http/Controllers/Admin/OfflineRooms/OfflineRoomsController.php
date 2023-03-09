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
            $data = User::with('customers')->where('user_type', User::CUSTOMER);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function (User $user) {
                    return $user->fullName;
                })->filterColumn('full_name', function ($query, $keyword) {
                    $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('email', function (User $user) {
                    return $user->email;
                })->filterColumn('email', function ($query, $keyword) {
                    $sql = "email  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('mobile_number', function (User $user) {
                    return $user->customers->mobile_number;
                })->filterColumn('mobile_number', function ($query, $keyword) {
                    $query->whereHas('customers', function ($query) use ($keyword) {
                        $query->where('mobile_number', 'LIKE', '%' . $keyword . '%');
                    });
                })->editColumn('status', function (User $user) {
                    return $user->status_name;
                })->addColumn('action', function ($row) {
                    return $row->customers->action;
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
        return view('admin.offline-rooms.create', ['model' => $rawData]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfflineRoom $offlineRoom)
    {
        $this->offlineRoomRepository->delete($offlineRoom);
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
        $user  = User::find($input['user_id']);
        // dd($user);
        if ($this->offlineRoomRepository->changeStatus($input, $user)) {
            return response()->json([
                'status' => true,
                'message' => 'Offline Room status updated successfully!'
            ]);
        }

        throw new Exception('Offline Room status does not change. Please check sometime later.');
    }
}
