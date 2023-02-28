<?php

namespace App\Http\Controllers\Admin\States;

use Exception;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Imports\StatesImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\StateRepository;
use App\Http\Requests\State\EditRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\State\CreateRequest;

class StatesController extends Controller
{
    protected $stateRepository;
    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository       = $stateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = State::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (State $state) {                    
                    return $state->name;
                })
                ->editColumn('code', function (State $state) {
                    return $state->code;
                })
                ->editColumn('country_id', function (State $state) {
                    return $state->country->name;
                })
                ->editColumn('status', function (State $state) {
                    return $state->status_name;
                })
                ->addColumn('action', function (State $state) {
                    return $state->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.states.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new State;
        $countryData    = Country::all();
        return view('admin.states.create', ['model' => $rawData, 'countries' => $countryData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->stateRepository->create($request->all());
        return redirect()->route('states.index')->with('success', __('state/message.created_success'));
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
     * @param \App\Models\State $state [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(State $state)
    {
        $countryData    = Country::all();
        return view('admin.states.edit', ['model' => $state, 'countries' => $countryData]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\State $state
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, State $state)
    {
        $this->stateRepository->update($request->all(), $state);

        return redirect()->route('states.index')->with('success', __('state/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $this->stateRepository->delete($state);
        return redirect()->route('states.index')->with('success', __('state/message.deleted_success'));
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
        $state  = State::find($input['state_id']);
        // dd($user);
        if ($this->stateRepository->changeStatus($input, $state)) {
            return response()->json([
                'status' => true,
                'message' => __('state/message.status_updated_success')
            ]);
        }

        throw new Exception(__('state/message.error'));
    }

    /**
     * Method importStates
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function importStates(Request $request): JsonResponse
    {       
        Excel::import(new StatesImport, $request->file);
        return response()->json([
            'status' => true,
            'message' => 'States import Successfully.'
        ]);
    }
}
