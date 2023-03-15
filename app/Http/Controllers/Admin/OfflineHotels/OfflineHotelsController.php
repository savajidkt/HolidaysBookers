<?php

namespace App\Http\Controllers\Admin\OfflineHotels;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OfflineHotel;
use App\Models\Reach;
use App\Models\Country;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use App\Exports\ExportAgents;
use App\Imports\OfflineHotelsImport;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportFailedAgents;
use Illuminate\Support\Facades\App;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\OfflineHotelRepository;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Agent\EditRequest;
use App\Http\Requests\Agent\CreateRequest;
use App\Http\Requests\Agent\UpdatePasswordRequest;
use App\Models\Amenity;
use App\Models\HotelGroup;
use App\Models\PropertyType;

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

            $data = OfflineHotel::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hotel_name', function (OfflineHotel $hotel) {
                    return $hotel->hotel_name;
                })->addColumn('category', function (OfflineHotel $hotel) {
                    return $hotel->category;
                })->addColumn('city', function (OfflineHotel $hotel) {
                    return $hotel->city->name;
                })->editColumn('state', function (OfflineHotel $hotel) {
                    return $hotel->state->name;
                })->addColumn('country', function (OfflineHotel $hotel) {
                    return $hotel->country->name;
                })->addColumn('phone_number', function (OfflineHotel $hotel) {
                    return $hotel->phone_number;
                })->addColumn('hotel_email', function(OfflineHotel $hotel){
                    return $hotel->hotel_email;
                })->addColumn('hotel_review', function (OfflineHotel $hotel) {
                    return $hotel->hotel_review;
                })->editColumn('status', function (OfflineHotel $hotel) {
                    return $hotel->status_name;
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
            '1'=>'1 Star',
            '2'=>'2 Star',
            '3'=>'3 Star',
            '4'=>'4 Star',
            '5'=>'5 Star',
        ];
        $HotelsAmenities  = Amenity::where('status', Amenity::ACTIVE)->where('type', Amenity::HOTEL)->pluck('amenity_name', 'id')->toArray();
        return view('admin.offline-hotels.create', ['model' => $rawData,'hotelGroups'=>$hotelGroups,'propertyTypes'=>$propertyTypes, 'categories' =>$categories,'countries' => $countries,'HotelsAmenities'=>$HotelsAmenities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {  
        dd($request->all());
        $this->offlineHotelRepository->create($request->all());
        return redirect()->route('offlinehotels.index')->with('success', "Hotel created successfully!");
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
     * @param \App\Models\Agent $agent [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Agent $agent)
    {
        $companyType    = CompanyType::where('status', CompanyType::ACTIVE)->get();
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $reach    =  Reach::where('status', Reach::ACTIVE)->get();

        return view('admin.offline-hotels.edit', ['model' => $agent, 'companies' => $companyType, 'reach' => $reach, 'countries' => $countries]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Agent\EditRequest $request
     * @param \App\Models\Agent $agent
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Agent $agent)
    {
        $this->agentRepository->update($request->all(), $agent);

        return redirect()->route('offlinehotels.index')->with('success', "Agent updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $this->agentRepository->delete($agent);
        return redirect()->route('offlinehotels.index')->with('success', "Agent deleted successfully!");
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
        $user  = User::find($input['user_id']);
        if ($this->agentRepository->changeStatus($input, $user)) {
            return response()->json([
                'status' => true,
                'message' => 'Agent status updated successfully.'
            ]);
        }

        throw new GeneralException('Agent status does not change. Please check sometime later.');
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
                    <li><b>Skip Agents : </b> '.count($details['skip']).'</li>
                    <li><b>Imported Agents : </b>'.$details['sucess']. '</li>
                    <li><b>Total Agents : </b>'.$details['total'].'</li>
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
}
