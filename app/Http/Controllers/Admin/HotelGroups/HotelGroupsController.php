<?php

namespace App\Http\Controllers\Admin\HotelGroups;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelGroup\CreateRequest;
use App\Http\Requests\HotelGroup\EditRequest;
use App\Models\HotelGroup;
use App\Repositories\HotelGroupRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HotelGroupsController extends Controller
{
    protected $hotelGroupRepository;
    public function __construct(HotelGroupRepository $hotelGroupRepository)
    {
        $this->hotelGroupRepository       = $hotelGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HotelGroup::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (HotelGroup $hotelgroup) {
                    return $hotelgroup->name;
                })
                ->editColumn('status', function (HotelGroup $hotelgroup) {
                    return $hotelgroup->status_name;
                })
                ->addColumn('action', function (HotelGroup $hotelgroup) {
                    return $hotelgroup->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.hotel-group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new HotelGroup;
        return view('admin.hotel-group.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->hotelGroupRepository->create($request->all());
        return redirect()->route('hotelgroups.index')->with('success', __('hotel-group/message.created_success'));
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
     * @param \App\Models\HotelGroup $hotelgroup [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(HotelGroup $hotelgroup)
    {
        return view('admin.hotel-group.edit', ['model' => $hotelgroup]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\HotelGroup $hotelgroup
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, HotelGroup $hotelgroup)
    {
        $this->hotelGroupRepository->update($request->all(), $hotelgroup);

        return redirect()->route('hotelgroups.index')->with('success', __('hotel-group/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HotelGroup $hotelgroup)
    {
        $this->hotelGroupRepository->delete($hotelgroup);
        return redirect()->route('hotelgroups.index')->with('success', __('hotel-group/message.deleted_success'));
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
        $hotelgroup  = HotelGroup::find($input['group_id']);
        // dd($user);
        if ($this->hotelGroupRepository->changeStatus($input, $hotelgroup)) {
            return response()->json([
                'status' => true,
                'message' => __('hotel-group/message.status_updated_success')
            ]);
        }
        throw new Exception(__('hotel-group/message.error'));
    }
    
    /**
     * Method addGroupPopup
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function addGroupPopup(Request $request): JsonResponse
    {
        $hotelGroup = $this->hotelGroupRepository->addGroupPopup($request->all());
        return response()->json([
            'status' => true,
            'responce' =>['id'=>$hotelGroup->id,'name'=>$hotelGroup->name],
            'message' => ''
        ]);
    }
    
}