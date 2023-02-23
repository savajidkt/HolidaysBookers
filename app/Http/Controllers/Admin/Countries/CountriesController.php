<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CreateRequest;
use App\Http\Requests\Country\EditRequest;
use App\Models\Country;
use App\Repositories\CountryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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

        return view('admin.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
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
}
