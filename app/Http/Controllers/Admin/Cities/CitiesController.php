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
use App\Imports\RezliveCitiesImport;
use Illuminate\Support\Facades\Storage;
use App\Jobs\RezliveCityCodeUpdate;
use Illuminate\Support\LazyCollection;

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
        $user = auth()->user();
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
                ->filterColumn('state_id', function ($query, $keyword) {
                    $query->whereHas('state', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    });
                })
                ->editColumn('country_id', function (City $city) {
                    return $city->state->country->name;
                })
                ->filterColumn('country_id', function ($query, $keyword) {
                    $query->whereHas('state.country', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    });
                })
                ->editColumn('status', function (City $city) {
                    return $city->status_name;
                })
                ->addColumn('action', function (City $city) {
                    return $city->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.cities.index', ['user' => $user]);
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
        $countryData    = Country::where('status', Country::ACTIVE)->get();
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
        permissionCheck('location-create');
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
        $countryData    = Country::where('status', Country::ACTIVE)->get();
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
        if (isset($input['country_id'])) {
            $country  = Country::find($input['country_id']);
            return response()->json([
                'status' => true,
                'cities' => $country->cities,
                'message' => __('city/message.success_city_list')
            ]);
        } else if (isset($input['state_id'])) {
            $state  = State::find($input['state_id']);
            return response()->json([
                'status' => true,
                'cities' => $state->cities,
                'message' => __('city/message.success_city_list')
            ]);
        }
    }

    public function importCities(Request $request): JsonResponse
    {
        Excel::import(new CitiesImport, $request->file);
        return response()->json([
            'status' => true,
            'message' => 'Cities import Successfully.'
        ]);
    }
    public function importRezliveCities(Request $request)
    {die;
        ini_set('memory_limit', '-1');
        $lazyCollection = LazyCollection::make(function () {

            $csvName = 'app/csv/cities-80-100.csv';
                $handle = fopen(storage_path($csvName), 'r');
                while (($line = fgetcsv($handle, 4096)) !== false) {
                    $dataString = implode(",", $line);
                    $row = explode(';', $dataString);
                    yield $row;
                }
                fclose($handle);
        })
    ->skip(1)
    ->chunk(50)
    ->each(function (LazyCollection $chunk) {
    $records = $chunk->map(function ($row) {
                    $firstCol = explode('|',$row[0]);                   
                    
                    $cityName = $firstCol[1]; // City Name
                    $country_id = 0;
                    
                    
                    if(count($firstCol)>2){
                        $cityCode = $firstCol[2]; // City Code
                        $contryCode = str_replace(",","",$firstCol[3]); // Contry Code
                        $country = Country::where('code',$contryCode)->first();
                        if($country){
                            $country_id = $country->id;
                        }else{
                            $country_id = 246;
                        }
                        
                      
                    }else{
                        $SecCol = explode('|', $row[1]);
                        if(count($SecCol)>1){
                            $cityCode = $SecCol[1];
                            $contryCode = str_replace(",","",$SecCol[2]); // Contry Code
                            $country = Country::where('code',$contryCode)->first();
                            if($country){
                                $country_id = $country->id;
                            }else{
                                $country_id = 246;
                            }
                        }else{
                            $ThirdCol = explode('|', $row[2]); 
                            $cityCode = $ThirdCol[1];
                            $contryCode = str_replace(",","",$ThirdCol[2]); // Contry Code
                            $country = Country::where('code',$contryCode)->first();
                            if($country){
                                $country_id = $country->id;
                            }else{
                                $country_id = 246;
                            }
                        }

                    }

                    return  [
                        'country_id'    => $country_id ?? NULL,
                        'name'      => $cityName,
                        'country_id'      => $country_id,
                        'rezlive_city_code'=> $cityCode,
                        'status'=>1
                    ];

    })->toArray();
    //dd($records);
    //RezliveHotel::create($records);
    DB::table('cities')->insert($records);
    });
    
        // $file = storage_path('app/cities.csv');
        // if (($handle = fopen($file, "r")) === FALSE)
        // {
        //     echo "readJobsFromFile: Failed to open file [$file]\n";
        //     die;
        // }

        // $header=true;
        // $fieldArray=[];
        // $index=0;
        // while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        // {
        //     if($index !=0){
        //         $firstCol = explode('|', $data[0]);
        //         $cityName = $firstCol[1]; // City Name

        //         if(count($firstCol)>2){
        //             $cityCode = $firstCol[2]; // City Code
        //         }else{
        //             $SecCol = explode('|', $data[1]);
        //             if(count($SecCol)>1){
        //                 $cityCode = $SecCol[1];
        //             }else{
        //                 $ThirdCol = explode('|', $data[2]); 
        //                 $cityCode = $ThirdCol[1];
        //             }

        //         }


        //        $city = City::where('name','LIKE','%'.$cityName.'%')->first();
        //        if($city){
        //             $city->update(['rezlive_city_code'=>$cityCode]);
        //        }else{
        //             $fieldArray[]= $cityName;
        //             $city->update(['rezlive_failed'=>1]);
        //        }
        //     }
        //     $index++;
        // }

        // fclose($handle);

        RezliveCityCodeUpdate::dispatch();
    }
}
