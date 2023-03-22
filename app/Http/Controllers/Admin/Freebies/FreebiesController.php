<?php

namespace App\Http\Controllers\Admin\Freebies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Freebies\CreateRequest;
use App\Http\Requests\Freebies\EditRequest;
use App\Models\Freebies;
use App\Repositories\FreebiesRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FreebiesController extends Controller
{
    protected $freebiesRepository;
    public function __construct(FreebiesRepository $freebiesRepository)
    {
        $this->freebiesRepository       = $freebiesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Freebies::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Freebies $freebies) {
                    return $freebies->name;
                })
                ->editColumn('type', function (Freebies $freebies) {
                    return $freebies->type_name;
                })
                ->editColumn('status', function (Freebies $freebies) {
                    return $freebies->status_name;
                })
                ->addColumn('action', function (Freebies $freebies) {
                    return $freebies->action;
                })
                ->rawColumns(['action', 'type', 'status'])->make(true);
        }

        
        return view('admin.freebies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new Freebies;
        return view('admin.freebies.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->freebiesRepository->create($request->all());
        return redirect()->route('freebies.index')->with('success', 'Freebies created successfully!');
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
     * @param \App\Models\Freebies $freebies [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Freebies $freeby)
    {       
        return view('admin.freebies.edit', ['model' => $freeby]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Freebies $freebies
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Freebies $freeby)
    {
        $this->freebiesRepository->update($request->all(), $freeby);

        return redirect()->route('freebies.index')->with('success', 'Freebies updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Freebies $freeby)
    {
        $this->freebiesRepository->delete($freeby);
        return redirect()->route('freebies.index')->with('success', 'Freebies deleted successfully!');
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
        $freebies  = Freebies::find($input['freebies_id']);
        // dd($user);
        if ($this->freebiesRepository->changeStatus($input, $freebies)) {
            return response()->json([
                'status' => true,
                'message' => 'Freebies status updated successfully!'
            ]);
        }

        throw new Exception('Freebies status does not change. Please check sometime later.');
    }

    public function addFreebiesPopup(Request $request): JsonResponse
    {
        $this->freebiesRepository->addFreebiesPopup($request->all());
        $type = (isset($request->type)) ? $request->type : Freebies::ROOM;
        return response()->json([
            'status' => true,
            'responce' => Freebies::where('status', Freebies::ACTIVE)->where('type', $type)->pluck('name', 'id')->toArray(),
            'message' => ''
        ]);
    }
}
