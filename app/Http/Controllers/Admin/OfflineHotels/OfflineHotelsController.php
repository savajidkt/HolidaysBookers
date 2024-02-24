<?php

namespace App\Http\Controllers\Admin\OfflineHotels;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Reach;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\HotelGroup;
use App\Models\CompanyType;
use App\Models\OfflineHotel;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Exports\ExportAgents;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\ExportFailedAgents;
use Illuminate\Support\Facades\App;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Imports\OfflineHotelsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Agent\EditRequest;
use App\Repositories\OfflineHotelRepository;
use App\Http\Requests\OfflineHotel\CreateRequest;
use App\Http\Traits\GlobalTrait;
use App\Jobs\RezliveHotelsImports;
use App\Models\City;
use App\Models\Freebies;
use App\Models\HotelFacility;
use App\Models\HotelImage;
use App\Models\HotelIncludedFacilities;
use App\Models\OfflineRoom;
use App\Models\RezliveHotel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class OfflineHotelsController extends Controller
{
    use GlobalTrait;
    
    protected $offlineHotelRepository;
    public $settings;

    public function __construct(OfflineHotelRepository $offlineHotelRepository)
    {
        $this->offlineHotelRepository       = $offlineHotelRepository;
        $this->settings = $this->getAllSettings(1);
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = OfflineHotel::where('hotel_type', OfflineHotel::OFFLINE);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hotel_name', function (OfflineHotel $hotel) {
                    //dd($hotel->hotel_name);
                    return $hotel->hotel_name;
                })->filterColumn('hotel_name', function (Builder $query, $search) {
                    return $query->where('hotel_name', 'like', '%' . $search . '%');

                })->addColumn('category', function (OfflineHotel $hotel) {
                    return $hotel->category.' Star';
                })->filterColumn('category', function ($query, $keyword) {
                    $query->where('category',$keyword);
                })->addColumn('hotel_city', function (OfflineHotel $hotel) {
                    return $hotel->city->name;
                })->filterColumn('hotel_city', function ($query, $keyword) {
                    $query->whereHas('city', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('hotel_country', function (OfflineHotel $hotel) {
                    return $hotel->country->name;
                })->filterColumn('hotel_country', function ($query, $keyword) {
                    $query->whereHas('country', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', '%' . $keyword . '%');
                    });
                })->editColumn('phone_number', function (OfflineHotel $hotel) {
                    return $hotel->phone_number;
                })->editColumn('hotel_email', function (OfflineHotel $hotel) {
                    return $hotel->hotel_email;
                
                })->addColumn('status', function (OfflineHotel $hotel) {
                    return $hotel->statusName;
                })->filterColumn('status', function ($query, $keyword) {
                    $query->where('status',$keyword);
                })->addColumn('action', function ($row) {
                    return $row->action;
                })->rawColumns(['action', 'status'])->make(true);
        }


        return view('admin.offline-hotels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        //
        $rawData    = new OfflineHotel();
        $hotelGroups    = HotelGroup::where('status', HotelGroup::ACTIVE)->get();
        $propertyTypes    = PropertyType::where('status', PropertyType::ACTIVE)->get();
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $categories = [
            '1' => '1 Star',
            '2' => '2 Star',
            '3' => '3 Star',
            '4' => '4 Star',
            '5' => '5 Star',
        ];
        $HotelsAmenitiesIDS = [];
        $HotelsFreebiesIDS = [];
        $HotelFacilityIDS = [];
        $HotelFacilities_IDS = [];
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::HOTEL)->pluck('amenity_name', 'id')->toArray();
        $HotelsFreebies  = Freebies::where('status', Freebies::ACTIVE)->where('type', Freebies::HOTEL)->pluck('name', 'id')->toArray();
        $HotelFacility  = HotelFacility::where('status', '1')->where('type', '1')->orWhere('type', '0')->get();

        return view('admin.offline-hotels.create',
        [
        'model' => $rawData,
        'hotelGroups' => $hotelGroups,
        'propertyTypes' => $propertyTypes,
        'categories' => $categories,
        'countries' => $countries,
        'HotelsAmenities' => $HotelsAmenities,
        'HotelsAmenitiesIDs' => $HotelsAmenitiesIDS,
        'HotelsFreebies' => $HotelsFreebies,
        'HotelsFreebiesIDs' => $HotelsFreebiesIDS,
        'HotelFacility' => $HotelFacility,
        'HotelFacilityIDS' => $HotelFacilityIDS,
        'HotelFacilities_IDS' => $HotelFacilities_IDS,
        ]);
    }

    /**
     * Method store
     *
     * @param CreateRequest $request [explicite description]
     *
     * @return void
     */
    public function store(CreateRequest $request)
    {
        
        $this->offlineHotelRepository->create($request, $request->all());
        return redirect()->route('offlinehotels.index')->with('success', "Hotel created successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OfflineHotel $offlinehotel)
    {
       
        $OfflineRoom = OfflineRoom::where('hotel_id', $offlinehotel->id)->get();
        $amenitiesName = implode(' | ', $offlinehotel->hotelamenity()->pluck('amenity_name')->toArray());
        $freebiesName = implode(' | ', $offlinehotel->hotelfreebies()->pluck('name')->toArray());
        return view('admin.offline-hotels.view', ['model' => $offlinehotel, 'offlineRoom' => $OfflineRoom, 'amenitiesName' => $amenitiesName, 'freebiesName' => $freebiesName]);
    }


    /**
     * Method edit
     *
     * @param OfflineHotel $offlinehotels [explicite description]
     *
     * @return void
     */
    public function edit(OfflineHotel $offlinehotel)
    {
        
        $HotelsAmenitiesIDS = [];
        $HotelsFreebiesIDS = [];
        $HotelFacilityIDS = [];
        $HotelFacilities_IDS = [];
        $hotelGroups    = HotelGroup::where('status', HotelGroup::ACTIVE)->get();
        $propertyTypes  = PropertyType::where('status', PropertyType::ACTIVE)->get();
        $countries      =  Country::where('status', Country::ACTIVE)->get();
        $categories = [
            '1' => '1 Star',
            '2' => '2 Star',
            '3' => '3 Star',
            '4' => '4 Star',
            '5' => '5 Star',
        ];
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::HOTEL)->pluck('amenity_name', 'id')->toArray();
        $HotelsAmenitiesIDS  = $offlinehotel->hotelamenity()->pluck('amenities_id')->toArray();
        $HotelsFreebies  = Freebies::where('status', Freebies::ACTIVE)->where('type', Freebies::HOTEL)->pluck('name', 'id')->toArray();
        $HotelsFreebiesIDS  = $offlinehotel->hotelfreebies()->pluck('freebies_id')->toArray();
        $HotelFacility  = HotelFacility::where('status', '1')->where('type', '1')->orWhere('type', '0')->get();
        $HotelFacilityIDS  = $offlinehotel->hotelincludefacility()->pluck('facility_id')->toArray();
        $HotelFacilities_IDS  = $offlinehotel->hotelincludefacility()->pluck('facilities_id')->toArray();
        
        //$HotelFacilityIDS  = $offlinehotel->hotelincludefacility()->pluck('facilities_id','facility_id')->toArray();

        return view('admin.offline-hotels.edit', 
        ['model' => $offlinehotel,
        'hotelGroups' => $hotelGroups,
        'propertyTypes' => $propertyTypes,
        'categories' => $categories,
        'countries' => $countries,
        'HotelsAmenities' => $HotelsAmenities,
        'HotelsAmenitiesIDs' => $HotelsAmenitiesIDS,
        'HotelsFreebies' => $HotelsFreebies,
        'HotelsFreebiesIDs' => $HotelsFreebiesIDS,
        'HotelFacility' => $HotelFacility,
        'HotelFacilityIDS' => $HotelFacilityIDS,
        'HotelFacilities_IDS' => $HotelFacilities_IDS,
        ]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\OfflineHotel\EditRequest $request
     * @param \App\Models\OfflineHotel $offlinehotel
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, OfflineHotel $offlinehotel)
    {           
        
        $this->offlineHotelRepository->update( $request, $request->all(), $offlinehotel);
        return redirect()->route('offlinehotels.index')->with('success', "Hotel updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfflineHotel $offlinehotel)
    {
        $this->offlineHotelRepository->delete($offlinehotel);
        return redirect()->route('offlinehotels.index')->with('success', "Hotel deleted successfully!");
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
        $user  = OfflineHotel::find($input['hotel_id']);
        if ($this->offlineHotelRepository->changeStatus($input, $user)) {
            return response()->json([
                'status' => true,
                'message' => 'Hotel status updated successfully.'
            ]);
        }

        throw new GeneralException('Hotel status does not change. Please check sometime later.');
    }


    /**
     * Method importOfflineHotels
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function importOfflineHotels(Request $request): JsonResponse
    {

        if (session()->has('skip_row')) {
            session()->forget('skip_row');
        }

        Excel::import(new OfflineHotelsImport, $request->file);


        $html = false;
        if (session()->has('skip_row')) {
            $details = session()->get('skip_row');
            $skipLink = "";

            if (is_array($details['download_skip_data']) && count($details['download_skip_data']) > 0) {
                $datefile = date('d_m_Y_H_i_s');
                $filename = $datefile . '.xlsx';
                Excel::store(new ExportFailedAgents($details['download_skip_data']), $filename);
                $skipLinks = storage_path($filename);
                $skipLink = "<li><b>Skip Agents Download : </b><a target='_blank' href='" . url('/storage/app') . '/' . $filename . "'>Download</a></li>";
            }
            $html = '<ul>
                    <li><b>Skip Agents : </b> ' . count($details['skip']) . '</li>
                    <li><b>Imported Agents : </b>' . $details['sucess'] . '</li>
                    <li><b>Total Agents : </b>' . $details['total'] . '</li>
                    ' . $skipLink . '
                </ul>';
        }

        return response()->json([
            'status' => true,
            'message' => 'Agents import Successfully.',
            'html' => $html,
        ]);
    }


    /**
     * Method agentExcelExport
     *
     * @return void
     */
    public function agentExcelExport()
    {
        // $id= $user->id;
        $agents    = Agent::all();
        return Excel::download(new ExportAgents($agents), 'agent-export.xlsx');
    }



    public function deleteHotelImage(Request $request)
    {
        $filename = str_replace(url(Storage::url('app/upload/Hotel/')), '', $request->filename);
        $filesname =  explode('/', $filename);

        if (is_array($filesname) && count($filesname) > 0) {
            $image = OfflineHotel::where('id', $filesname[1])->where('hotel_image_location', $filesname[2]);
            if ($image->update(['hotel_image_location' => ''])) {
                return response()->json([
                    'status' => true,
                    'message' => 'Offline hotel image deleted successfully!'
                ]);
            }
            throw new Exception('Offline hotel image does not deleted. Please check sometime later.');
        }
    }


    public function deleteHotelGalleryImage(Request $request)
    {

        $filename = str_replace(url(Storage::url('app/upload/Hotel/')), '', $request->filename);
        $filesname =  explode('/', $filename);
        
        if (is_array($filesname) && count($filesname) > 0) {
            $gallery = HotelImage::where('hotel_id', $filesname[1])->where('file_path', $filesname[3]);
            if ($gallery->delete()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Offline hotel gallery image deleted successfully!'
                ]);
            }
            throw new Exception('Offline hotel gallery image does not deleted. Please check sometime later.');
        }
    }
    public function importRezliveHotels(Request $request)
    {
        ini_set('memory_limit', '-1');
        $rezlive = RezliveHotel::limit(10)->get();
        $hotelArray =[];
        $apiConfig = $this->settings;
        foreach($rezlive as $hotel){
            $hotelResult = rezeliveGetHotelsDetails($apiConfig,$hotel->hotel_code);
             $hotelArray[] = $this->offlineHotelRepository->rezliveHotelSave($hotelResult['Hotels']);

        }
        dd($hotelArray);
        die;
           // OfflineHotel::create($hotelArray);
        
         //$file = storage_path('app/csv/H15.csv');
          $lazyCollection = LazyCollection::make(function () {

                for($i=11; $i<=14; $i++){
                    $csvName = 'app/csv/H'.$i.'.csv';
                    $handle = fopen(storage_path($csvName), 'r');
                    while (($line = fgetcsv($handle, 4096)) !== false) {
                        $dataString = implode(",", $line);
                        $row = explode(';', $dataString);
                        yield $row;
                    }
                    fclose($handle);
                }
            })
        ->skip(1)
        ->chunk(100)
        ->each(function (LazyCollection $chunk) {
          $records = $chunk->map(function ($row) {
                        $data = explode('|',$row[0]);
                        $hotelCode = $data[0];
                        $hotelName = $data[1] ?? NULL;
                        return  [
                            // 'hotel_name'    => $hotelName ?? NULL,
                            'hotel_code'      => $hotelCode,
                        ];
    
          })->toArray();
          //dd($records);
          //RezliveHotel::create($records);
          DB::table('rezlive_hotels')->insert($records);
        });
    
    die;
        Excel::filter('chunk')->load(database_path('app/hotels.csv'))->chunk(100, function($results) {
            $index=0;
            foreach ($results as $row) {
                dd($row);
                if($index>0){
                    $data = explode('|',$row[0]);
                    $hotelCode = $data[0];
                    $hotelName = $data[1] ?? NULL; 
                 
                    $HotelArr[] = [
                        'hotel_name'    => $hotelName ?? NULL,
                        'hotel_code'      => $hotelCode,
                    ];
    
                   
                    //RezliveHotel::create($HotelArr);
                    
                }
                $index++;
            }
        });


        if (($handle = fopen($file, "r")) === FALSE)
        {
            echo "readJobsFromFile: Failed to open file [$file]\n";
            die;
        }

        $header=true;
        $fieldArray=[];
        $HotelArr = [];
        $index=0;
        
        while (($hotels = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
           
                // echo '<pre>';
                // print_r($hotels[0]);
                // echo '</pre>';
                
            if($index>0){
                $data = explode('|',$hotels[0]);
                $hotelCode = $data[0];
                $hotelName = $data[1] ?? NULL; 
                // $hotelCity = $data[2] ?? NULL; 
                // $CityId = $data[3] ?? NULL; 
                // $CountryId = $data[5] ?? NULL; 
                // $CountryCode = $data[4] ?? NULL; 
                // $Rating = $data[6] ?? NULL; 
                // $HotelAddress = $data[7] ?? NULL; 
                // $HotelPostalCode = $data[8]; 
                // $Latitude = $data[9]; 
                // $Longitude = $data[10]; 
                // $Desc = $data[11];
                //$country = Country::where('code',$CountryCode)->first();
                //$city = City::where('name',$hotelCity)->first();
                $HotelArr[] = [
                    'hotel_name'    => $hotelName ?? NULL,
                    'hotel_code'      => $hotelCode,
                ];

                // echo '<pre>';
                // print_r($data);
                // echo '</pre>';
                if($index>100000){
                    echo '<pre>';
                    print_r($HotelArr);
                    die;
                    
                }
                //RezliveHotel::create($HotelArr);
                
            }
            
            $index++;
        }
        
        
        fclose($handle);
        die;
        RezliveHotelsImports::dispatch();

    }
}
