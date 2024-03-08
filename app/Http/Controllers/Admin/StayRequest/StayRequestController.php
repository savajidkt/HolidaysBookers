<?php

namespace App\Http\Controllers\Admin\StayRequest;

use App\Http\Controllers\Controller;
use App\Models\StayRequest;
use App\Repositories\StayRequestRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class StayRequestController extends Controller
{
    protected $stayRequestRepository;
    public function __construct(StayRequestRepository $stayRequestRepository)
    {
        $this->stayRequestRepository       = $stayRequestRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = StayRequest::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('request', function (StayRequest $stayRequest) {
                    return $stayRequest->request;
                })               
                ->editColumn('status', function (StayRequest $stayRequest) {
                    return $stayRequest->status_name;
                })
                ->addColumn('action', function (StayRequest $stayRequest) {
                    return $stayRequest->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }        
        return view('admin.stay_request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new StayRequest;
        return view('admin.stay_request.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {     
        $this->stayRequestRepository->create($request->all());
        return redirect()->route('stayrequest.index')->with('success', 'Hotel Stay Request created successfully!');
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
     * @param \App\Models\StayRequest $facility [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(StayRequest $stayrequest)
    {           
        return view('admin.stay_request.edit', ['model' => $stayrequest]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\StayRequest $facility
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StayRequest $stayrequest)
    {
        
        $this->stayRequestRepository->update($request->all(), $stayrequest);
        return redirect()->route('stayrequest.index')->with('success', 'Hotel Stay Request updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StayRequest $stayrequest)
    {
         $this->stayRequestRepository->delete($stayrequest);
         return redirect()->route('stayrequest.index')->with('success', 'Hotel Stay Request deleted successfully!');
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
        $facility  = StayRequest::find($input['facility_id']);
        // dd($user);
        if ($this->stayRequestRepository->changeStatus($input, $facility)) {
            return response()->json([
                'status' => true,
                'message' => 'Hotel facility status updated successfully!'
            ]);
        }

        throw new Exception('Hotel facility status does not change. Please check sometime later.');
    }   
}
