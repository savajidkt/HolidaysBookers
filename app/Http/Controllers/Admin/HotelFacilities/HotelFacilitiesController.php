<?php

namespace App\Http\Controllers\Admin\HotelFacilities;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelFacilities\CreateRequest;
use App\Http\Requests\HotelFacilities\EditRequest;
use App\Models\HotelFacilities;
use App\Repositories\HotelFacilitiesRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HotelFacilitiesController extends Controller
{
    protected $hotelfacilityRepository;
    public function __construct(HotelFacilitiesRepository $hotelfacilityRepository)
    {
        $this->hotelfacilityRepository       = $hotelfacilityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {

            $data = HotelFacilities::select('*')->where('facility_id',$request->facility_id);
            return DataTables::of($data)
                ->addIndexColumn()                
                ->editColumn('name', function (HotelFacilities $hotelfacilities) {
                    return $hotelfacilities->name;
                })               
                ->editColumn('status', function (HotelFacilities $hotelfacilities) {
                    return $hotelfacilities->status_name;
                })
                ->addColumn('action', function (HotelFacilities $hotelfacilities) {
                    return $hotelfacilities->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        
        return view('admin.facilities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(Request $request)
    {     
        $rawData    = new HotelFacilities;
        return view('admin.facilities.create', ['model' => $rawData,'facility_id'=>$request->facility_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {        
        $returnData = $this->hotelfacilityRepository->create($request->all());
        
       return redirect()->route('hotelfacility.edit', $returnData->facility_id)->with('success', 'Hotel facilities created successfully!');
       
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
     * @param \App\Models\HotelFacilities $hotelfacility [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, HotelFacilities $hotelfacility)
    {   
        return view('admin.facilities.edit', ['model' => $hotelfacility, 'facility_id'=> $hotelfacility->facility_id]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\HotelFacilities $hotelfacility
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, HotelFacilities $hotelfacility)
    {
        
        $returnData = $this->hotelfacilityRepository->update($request->all(), $hotelfacility);
        return redirect()->route('hotelfacility.edit', $returnData->facility_id)->with('success', 'Hotel facilities updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HotelFacilities $hotelfacility)
    {        
        $returnData = $this->hotelfacilityRepository->delete($hotelfacility);
        return redirect()->route('hotelfacility.edit', $returnData->facility_id)->with('success', 'Hotel facilities created successfully!');        
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
        $hotelfacilities  = HotelFacilities::find($input['facilities_id']);
        // dd($user);
        if ($this->hotelfacilityRepository->changeStatus($input, $hotelfacilities)) {
            return response()->json([
                'status' => true,
                'message' => 'Hotel facilities status updated successfully!'
            ]);
        }

        throw new Exception('Hotel facilities status does not change. Please check sometime later.');
    }

  
}
