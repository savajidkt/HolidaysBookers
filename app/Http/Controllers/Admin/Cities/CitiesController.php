<?php

namespace App\Http\Controllers\Admin\Cities;

use Exception;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Imports\CitiesImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\City\EditRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\City\CreateRequest;

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
    {   $user = auth()->user();
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

        return view('admin.cities.index',['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        permissionCheck('location-create');
        $statesData = [];
        $rawData    = new City;
        $countryData    = Country::where('status',Country::ACTIVE)->get();
        return view('admin.cities.create', ['model' => $rawData, 'countries' => $countryData, 'states' => $statesData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {   permissionCheck('location-create');
        $this->cityRepository->create($request->all());
        return redirect()->route('cities.index')->with('success', __('city/message.created_success'));
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
        permissionCheck('location-edit');
        $statesData = [];
        $countryData    = Country::where('status',Country::ACTIVE)->get();
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
        permissionCheck('location-edit');
        $this->cityRepository->update($request->all(), $city);
        return redirect()->route('cities.index')->with('success', __('city/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        permissionCheck('location-delete');
        $this->cityRepository->delete($city);
        return redirect()->route('cities.index')->with('success', __('city/message.deleted_success'));
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
                'message' => __('city/message.updated_success')
            ]);
        }

        throw new Exception(__('city/message.error'));
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
            'message' => __('city/message.success_state_list')
        ]);
    }

    /**
     * Method getStateList
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function getCitiesList(Request $request): JsonResponse
    {
        $input = $request->all();
        $country  = Country::find($input['country_id']);
        return response()->json([
            'status' => true,
            'cities' => $country->cities,
            'message' => __('city/message.success_city_list')
        ]);
    }

    public function importCities(Request $request): JsonResponse
    {
        Excel::import(new CitiesImport, $request->file);
        return response()->json([
            'status' => true,
            'message' => 'Cities import Successfully.'
        ]);
    }
}
