<?php

namespace App\Http\Controllers\Admin\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CreateRequest;
use App\Http\Requests\City\EditRequest;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Repositories\CityRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CitiesController extends Controller
{
    protected $cityRepository;
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository       = $cityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = City::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (City $city) {
                    return $city->name;
                })
                ->editColumn('state_id', function (City $city) {
                    return $city->state->name;
                })
                ->editColumn('country_id', function (City $city) {
                    return $city->state->country->name;
                })
                ->editColumn('status', function (City $city) {
                    return $city->status_name;
                })
                ->addColumn('action', function (City $city) {
                    return $city->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $statesData = [];
        $rawData    = new City;
        $countryData    = Country::all();
        return view('admin.cities.create', ['model' => $rawData, 'countries' => $countryData, 'states' => $statesData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->cityRepository->create($request->all());
        return redirect()->route('cities.index')->with('success', "City created successfully!");
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
     * @param \App\Models\City $city [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(City $city)
    {
        $statesData = [];
        $countryData    = Country::all();
        $statesData    = $city->state->country->states;
        
        return view('admin.cities.edit', ['model' => $city, 'countries' => $countryData, 'states' => $statesData]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\City $city
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, City $city)
    {
        $this->cityRepository->update($request->all(), $city);

        return redirect()->route('cities.index')->with('success', "City updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $this->cityRepository->delete($city);
        return redirect()->route('cities.index')->with('success', "City deleted successfully!");
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
        $city  = City::find($input['city_id']);
        // dd($user);
        if ($this->cityRepository->changeStatus($input, $city)) {
            return response()->json([
                'status' => true,
                'message' => 'City status updated successfully.'
            ]);
        }

        throw new Exception('City status does not change. Please check sometime later.');
    }

    /**
     * Method getStateList
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function getStateList(Request $request): JsonResponse
    {
        $input = $request->all();
        $country  = Country::find($input['country_id']);
        return response()->json([
            'status' => true,
            'states' => $country->states,
            'message' => 'Get state list successfully.'
        ]);
    }
}
