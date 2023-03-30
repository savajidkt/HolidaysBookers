<?php

namespace App\Http\Controllers\Admin\Packages;

use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\Package;
use App\Models\Currency;
use App\Models\MealPlan;
use App\Models\RoomType;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Repositories\PackageRepository;
use App\Http\Requests\Package\EditRequest;
use App\Http\Requests\Package\CreateRequest;

class PackagesController extends Controller
{
    /** \App\Repository\AgentRepository $agentRepository */
    protected $packageRepository;
    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository       = $packageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $user = auth()->user();   
        // dd($user->can('agents-create'));

        if ($request->ajax()) {

            $data = Package::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('package_name', function (Package $package) {
                    return $package->package_name ?? '-';
                })->addColumn('package_code', function (Package $package) {
                    return $package->package_code;
                })->addColumn('city', function (Package $package) {
                    return $package->city_name;
                })->addColumn('country', function (Package $package) {
                    return $package->country_name;
                    //return implode(',',$package->packagecountry->pluck('name')->toArray());                    
                })->addColumn('valid_from', function (Package $package) {
                    return $package->valid_from;
                })->addColumn('valid_till', function (Package $package) {
                    return $package->valid_till;
                })->editColumn('status', function (Package $package) {
                    return $package->status_name;
                })->addColumn('action', function ($row) {
                    return $row->action;
                })->rawColumns(['action', 'status'])->make(true);
        }
        return view('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new Package;
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $offlinehotel    =  OfflineHotel::where('hotel_type', OfflineHotel::OFFLINE)->where('status', OfflineHotel::ACTIVE)->get();
        $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
        return view('admin.packages.create', ['model' => $rawData, 'countries' => $countries, 'cities' => "", 'offlinehotel' => $offlinehotel, 'currencyList' => $currencyList, 'roomTypes' => '', 'mealPlan' => '']);
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
        $this->packageRepository->create($request, $request->all());
        return redirect()->route('packages.index')->with('success', "Packages created successfully!");
    }


    public function show(Request $request, Package $package)
    {
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
        $cities    =  City::whereIn('country_id', $package->packagecountry->pluck('id')->toArray())->get();
        $nationality = Country::where('id', $package->nationality)->first();
        $hotel  = OfflineHotel::where('id', $package->hotel_name_id)->first();
        $roomTypes = RoomType::where('id', $package->room_type_id)->first();
        $mealPlan = MealPlan::where('id', $package->meal_plan_id)->first();

        return view('admin.packages.view', ['model' => $package, 'countries' => $countries, 'cities' => $cities, 'nationality' => $nationality->name, 'hotel' => $hotel, 'roomTypes' => $roomTypes, 'mealPlan' => $mealPlan, 'currencyList' => $currencyList]);
    }


    public function edit(Package $package)
    {
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $offlinehotel    =  OfflineHotel::where('hotel_type', OfflineHotel::OFFLINE)->where('status', OfflineHotel::ACTIVE)->get();
        $cities    =  City::whereIn('country_id', $package->packagecountry->pluck('id')->toArray())->get();
        $currencyList  = Currency::where('status', Currency::ACTIVE)->get(['code', 'name', 'id'])->toArray();
        $rooms  = OfflineRoom::where('hotel_id', $package->hotel_name_id)->pluck('room_type_id')->toArray();
        $roomTypes = RoomType::whereIn('id', $rooms)->pluck('room_type', 'id')->toArray();
        $roomsMeal  = OfflineRoom::where('hotel_id', $package->hotel_name_id)->pluck('meal_plan_id')->toArray();
        $mealPlan = MealPlan::whereIn('id', $roomsMeal)->pluck('name', 'id')->toArray();
        return view('admin.packages.edit', ['model' => $package, 'countries' => $countries, 'cities' => $cities, 'offlinehotel' => $offlinehotel, 'currencyList' => $currencyList, 'roomTypes' => $roomTypes, 'mealPlan' => $mealPlan]);
    }


    /**
     * Method update
     *
     * @param EditRequest $request [explicite description]
     * @param Package $package [explicite description]
     *
     * @return void
     */
    public function update(EditRequest $request, Package $package)
    {
        $this->packageRepository->update($request->all(), $package);
        return redirect()->route('packages.index')->with('success', "Package updated successfully!");
    }

    
       
    /**
     * Method destroy
     *
     * @param Package $package [explicite description]
     *
     * @return void
     */
    public function destroy(Package $package)
    {
        $this->packageRepository->delete($package);
        return redirect()->route('packages.index')->with('success', "Package deleted successfully!");
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
        $package  = Package::find($input['package_id']);
        if ($this->packageRepository->changeStatus($input, $package)) {
            return response()->json([
                'status' => true,
                'message' => 'Package status updated successfully.'
            ]);
        }

        throw new GeneralException('Package status does not change. Please check sometime later.');
    }

    /**
     * Method getCitiesByCountryList
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function getCitiesByCountryList(Request $request): JsonResponse
    {
        $input = $request->all();
        $cities  = City::select('id', 'name')->whereIn('country_id', explode(',', $input['country_id']))->get();
        return response()->json([
            'status' => true,
            'cities' => $cities,
            'message' => ""
        ]);
    }

    public function getRoomTypeByHotel(Request $request): JsonResponse
    {
        $input = $request->all();
        $rooms  = OfflineRoom::where('hotel_id', $input['hotel_name_id'])->pluck('room_type_id')->toArray();
        $roomTypes = RoomType::whereIn('id', $rooms)->pluck('room_type', 'id')->toArray();

        $roomsMeal  = OfflineRoom::where('hotel_id', $input['hotel_name_id'])->pluck('meal_plan_id')->toArray();
        $mealPlan = MealPlan::whereIn('id', $roomsMeal)->pluck('name', 'id')->toArray();


        return response()->json([
            'status' => true,
            'roomTypes' => $roomTypes,
            'mealPlan' => $mealPlan,
            'message' => ""
        ]);
    }
}
