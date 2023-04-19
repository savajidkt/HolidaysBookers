<?php

namespace App\Http\Controllers\Admin\Countries;

use Exception;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Imports\CountriesImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\CountryRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Country\EditRequest;
use App\Http\Requests\Country\CreateRequest;
use App\Http\Requests\Country\ImportRequest;
use App\Models\City;
use Illuminate\Support\LazyCollection;

class CountriesController extends Controller
{
    protected $countryRepository;
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository       = $countryRepository;
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
            $data = Country::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Country $country) {
                    return $country->name;
                })
                ->editColumn('code', function (Country $country) {
                    return $country->code;
                })
                ->editColumn('phone_code', function (Country $country) {
                    return $country->phone_code;
                })
                ->editColumn('nationality', function (Country $country) {
                    return $country->nationality;
                })
                ->editColumn('status', function (Country $country) {
                    return $country->status_name;
                })
                ->addColumn('action', function (Country $country) {
                    return $country->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.countries.index',['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {      
        permissionCheck('location-create');
        $rawData    = new Country;
        return view('admin.countries.create', ['model' => $rawData]);
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
        $this->countryRepository->create($request->all());
        return redirect()->route('countries.index')->with('success', __('country/message.created_success'));
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
     * @param \App\Models\Country $country [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Country $country)
    {
        permissionCheck('location-edit');
        return view('admin.countries.edit', ['model' => $country]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Country $country
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Country $country)
    {
        permissionCheck('location-edit');
        $this->countryRepository->update($request->all(), $country);
        return redirect()->route('countries.index')->with('success', __('country/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        permissionCheck('location-delete');
        $this->countryRepository->delete($country);
        return redirect()->route('countries.index')->with('success', __('country/message.deleted_success'));
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
        $country  = Country::find($input['country_type_id']);
        // dd($user);
        if ($this->countryRepository->changeStatus($input, $country)) {
            return response()->json([
                'status' => true,
                'message' => __('country/message.status_updated_success')
            ]);
        }

        throw new Exception(__('country/message.error'));
    }



        
    /**
     * Method importCountries
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function importCountries(Request $request): JsonResponse
    {      
        Excel::import(new CountriesImport, $request->file);        
        return response()->json([
            'status' => true,
            'message' => 'Countries import Successfully.'
        ]);
    }
    public function importRezliveCountry(){
        $lazyCollection = LazyCollection::make(function () {

            $csvName = 'app/csv/countries.csv';
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
                    $data = explode('|',$row[0]);
                    
                    $counrtyID = $data[0];
                    $countryName = $data[1] ?? NULL;
                    $countryCode = $data[2] ?? NULL;
                    return  [
                        'id'    => $counrtyID ?? NULL,
                        'name'      => $countryName,
                        'code'      => substr($countryCode, 0, -1),
                    ];

    })->toArray();
    //dd($records);
    //RezliveHotel::create($records);
    DB::table('countries')->insert($records);
    });
    }
            
}
