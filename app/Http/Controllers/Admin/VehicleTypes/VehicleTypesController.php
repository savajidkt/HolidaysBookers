<?php

namespace App\Http\Controllers\Admin\VehicleTypes;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleType\CreateRequest;
use App\Http\Requests\VehicleType\EditRequest;
use App\Models\VehicleType;
use App\Repositories\VehicleTypeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VehicleTypesController extends Controller
{
    protected $vehicleTypeRepository;
    public function __construct(VehicleTypeRepository $vehicleTypeRepository)
    {
        $this->vehicleTypeRepository       = $vehicleTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleType::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('vehicle_name', function (VehicleType $vehicletype) {
                    return $vehicletype->vehicle_name;
                })
                ->editColumn('no_of_seats', function (VehicleType $vehicletype) {
                    return $vehicletype->no_of_seats;
                })
                ->editColumn('status', function (VehicleType $vehicletype) {
                    return $vehicletype->status_name;
                })
                ->addColumn('action', function (VehicleType $vehicletype) {
                    return $vehicletype->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.vehicle-types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new VehicleType;
        return view('admin.vehicle-types.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->vehicleTypeRepository->create($request->all());
        return redirect()->route('vehicletypes.index')->with('success', "Vehicle Type created successfully!");
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
     * @param \App\Models\VehicleType $vehicletype [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(VehicleType $vehicletype)
    {
        return view('admin.vehicle-types.edit', ['model' => $vehicletype]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\VehicleType $vehicletype
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, VehicleType $vehicletype)
    {
        $this->vehicleTypeRepository->update($request->all(), $vehicletype);

        return redirect()->route('vehicletypes.index')->with('success', "Vehicle Type updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleType $vehicletype)
    {
        $this->vehicleTypeRepository->delete($vehicletype);
        return redirect()->route('vehicletypes.index')->with('success', "Vehicle Type deleted successfully!");
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
        $vehicletype  = VehicleType::find($input['vehicle_type_id']);
        // dd($user);
        if ($this->vehicleTypeRepository->changeStatus($input, $vehicletype)) {
            return response()->json([
                'status' => true,
                'message' => 'Vehicle Type status updated successfully.'
            ]);
        }

        throw new Exception('Vehicle Type status does not change. Please check sometime later.');
    }
}
