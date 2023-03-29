<?php

namespace App\Http\Controllers\Admin\Packages;

use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\Package;
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
                })->addColumn('maximum_pax', function (Package $package) {
                    return $package->maximum_pax;
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
        //
        $rawData    = new Package;
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('admin.packages.create', ['model' => $rawData, 'countries' => $countries, 'cities' => ""]);
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
        $cities    =  City::whereIn('country_id', $package->packagecountry->pluck('id')->toArray())->get();
        $nationality = Country::where('id', $package->nationality)->first();
        return view('admin.packages.view', ['model' => $package, 'countries' => $countries, 'cities' => $cities, 'nationality' => $nationality->name]);
    }


    public function edit(Package $package)
    {
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $cities    =  City::whereIn('country_id', $package->packagecountry->pluck('id')->toArray())->get();
        return view('admin.packages.edit', ['model' => $package, 'countries' => $countries, 'cities' => $cities]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $this->packageRepository->delete($agent);
        return redirect()->route('packages.index')->with('success', "Agent deleted successfully!");
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
            'message' => __('city/message.success_city_list')
        ]);
    }
}
