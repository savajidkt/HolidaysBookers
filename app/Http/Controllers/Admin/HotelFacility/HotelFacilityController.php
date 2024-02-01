<?php

namespace App\Http\Controllers\Admin\HotelFacility;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelFacility\CreateRequest;
use App\Http\Requests\HotelFacility\EditRequest;
use App\Models\HotelFacility;
use App\Repositories\HotelFacilityRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class HotelFacilityController extends Controller
{
    protected $hotelfacilityRepository;
    public function __construct(HotelFacilityRepository $hotelfacilityRepository)
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
            $data = HotelFacility::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (HotelFacility $hotelfacility) {
                    return $hotelfacility->name;
                })
                ->editColumn('type', function (HotelFacility $hotelfacility) {
                    return $hotelfacility->type_name;
                })
                ->editColumn('status', function (HotelFacility $hotelfacility) {
                    return $hotelfacility->status_name;
                })
                ->addColumn('action', function (HotelFacility $hotelfacility) {
                    return $hotelfacility->action;
                })
                ->rawColumns(['action', 'type', 'status'])->make(true);
        }        
        return view('admin.facility.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new HotelFacility;
        return view('admin.facility.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
       

        $icon = "";
        if($request->hasfile('icon'))
        {
            $file = $request->file('icon');           
            $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/facility-icon/'), $fileName);
            $icon = $fileName;
        }
        $this->hotelfacilityRepository->create($request->all(), $icon);
        return redirect()->route('hotelfacility.index')->with('success', 'Hotel facility created successfully!');
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
     * @param \App\Models\HotelFacility $facility [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(HotelFacility $hotelfacility)
    {   
        return view('admin.facility.edit', ['model' => $hotelfacility]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\HotelFacility $facility
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, HotelFacility $hotelfacility)
    {
        $icon = "";
        if($request->hasfile('icon'))
        {
            $file = $request->file('icon');           
            $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/facility-icon/'), $fileName);
            $icon = $fileName;
        } else {
            $icon = $hotelfacility->icon;
        }
        $this->hotelfacilityRepository->update($request->all(), $hotelfacility, $icon);

        return redirect()->route('hotelfacility.index')->with('success', 'Hotel facility updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HotelFacility $hotelfacility)
    {
        $this->hotelfacilityRepository->delete($hotelfacility);
        return redirect()->route('hotelfacility.index')->with('success', 'Hotel facility deleted successfully!');
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
        $facility  = HotelFacility::find($input['facility_id']);
        // dd($user);
        if ($this->hotelfacilityRepository->changeStatus($input, $facility)) {
            return response()->json([
                'status' => true,
                'message' => 'Hotel facility status updated successfully!'
            ]);
        }

        throw new Exception('Hotel facility status does not change. Please check sometime later.');
    }   
}
