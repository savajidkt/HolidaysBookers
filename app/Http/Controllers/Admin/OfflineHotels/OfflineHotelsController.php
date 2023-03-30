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
use App\Jobs\RezliveHotelsImports;
use App\Models\City;
use App\Models\Freebies;
use App\Models\HotelImage;
use App\Models\RezliveHotel;
use Illuminate\Database\Eloquent\Builder;
class OfflineHotelsController extends Controller
{
    /** \App\Repository\OfflineHotelRepository $offlineHotelRepository */
    protected $offlineHotelRepository;
    public function __construct(OfflineHotelRepository $offlineHotelRepository)
    {
        $this->offlineHotelRepository       = $offlineHotelRepository;
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
                })->editColumn('hotel_review', function (OfflineHotel $hotel) {
                    return $hotel->hotel_review;
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
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::HOTEL)->pluck('amenity_name', 'id')->toArray();
        $HotelsFreebies  = Freebies::where('status', Freebies::ACTIVE)->where('type', Freebies::HOTEL)->pluck('name', 'id')->toArray();
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
        'HotelsFreebiesIDs' => $HotelsFreebiesIDS
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
        $amenitiesName = implode(' | ', $offlinehotel->hotelamenity()->pluck('amenity_name')->toArray());
        $freebiesName = implode(' | ', $offlinehotel->hotelfreebies()->pluck('name')->toArray());
        return view('admin.offline-hotels.view', ['model' => $offlinehotel, 'amenitiesName' => $amenitiesName, 'freebiesName' => $freebiesName]);
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

        return view('admin.offline-hotels.edit', 
        ['model' => $offlinehotel,
        'hotelGroups' => $hotelGroups,
        'propertyTypes' => $propertyTypes,
        'categories' => $categories,
        'countries' => $countries,
        'HotelsAmenities' => $HotelsAmenities,
        'HotelsAmenitiesIDs' => $HotelsAmenitiesIDS,
        'HotelsFreebies' => $HotelsFreebies,
        'HotelsFreebiesIDs' => $HotelsFreebiesIDS
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
        RezliveHotelsImports::dispatch();

    }
}
