<?php

namespace App\Http\Controllers\Admin\RoomTypes;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomType\CreateRequest;
use App\Http\Requests\RoomType\EditRequest;
use App\Models\RoomType;
use App\Repositories\RoomTypeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomTypesController extends Controller
{
    protected $roomTypeRepository;
    public function __construct(RoomTypeRepository $roomTypeRepository)
    {
        $this->roomTypeRepository       = $roomTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = RoomType::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('room_type', function (RoomType $roomtype) {
                    return $roomtype->room_type;
                })
                ->editColumn('status', function (RoomType $roomtype) {
                    return $roomtype->status_name;
                })
                ->addColumn('action', function (RoomType $roomtype) {
                    return $roomtype->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.room-types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new RoomType;
        return view('admin.room-types.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->roomTypeRepository->create($request->all());
        return redirect()->route('roomtypes.index')->with('success', __('roomtype/message.created_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\RoomType $roomtype [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(RoomType $roomtype)
    {
        return view('admin.room-types.edit', ['model' => $roomtype]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\RoomType $roomtype
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, RoomType $roomtype)
    {
        $this->roomTypeRepository->update($request->all(), $roomtype);

        return redirect()->route('roomtypes.index')->with('success', __('roomtype/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $roomtype)
    {
        $this->roomTypeRepository->delete($roomtype);
        return redirect()->route('roomtypes.index')->with('success', __('roomtype/message.deleted_success'));
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
        $roomtype  = RoomType::find($input['room_type_id']);
        // dd($user);
        if ($this->roomTypeRepository->changeStatus($input, $roomtype)) {
            return response()->json([
                'status' => true,
                'message' => __('roomtype/message.status_updated_success')
            ]);
        }

        throw new Exception(__('roomtype/message.error'));
    }
}
