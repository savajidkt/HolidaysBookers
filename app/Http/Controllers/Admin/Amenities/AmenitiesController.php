<?php

namespace App\Http\Controllers\Admin\Amenities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Amenity\CreateRequest;
use App\Http\Requests\Amenity\EditRequest;
use App\Models\Amenity;
use App\Repositories\AmenityRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AmenitiesController extends Controller
{
    protected $amenityRepository;
    public function __construct(AmenityRepository $amenityRepository)
    {
        $this->amenityRepository       = $amenityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Amenity::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('amenity_name', function (Amenity $amenity) {
                    return $amenity->amenity_name;
                })
                ->editColumn('type', function (Amenity $amenity) {
                    return $amenity->type_name;
                })
                ->editColumn('status', function (Amenity $amenity) {
                    return $amenity->status_name;
                })
                ->addColumn('action', function (Amenity $amenity) {
                    return $amenity->action;
                })
                ->rawColumns(['action', 'type','status'])->make(true);
        }

        return view('admin.amenities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new Amenity;
        return view('admin.amenities.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->amenityRepository->create($request->all());
        return redirect()->route('amenities.index')->with('success', "Amenity Type created successfully!");
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
     * @param \App\Models\Amenity $amenity [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Amenity $amenity)
    {
        return view('admin.amenities.edit', ['model' => $amenity]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Amenity $amenity
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Amenity $amenity)
    {
        $this->amenityRepository->update($request->all(), $amenity);

        return redirect()->route('amenities.index')->with('success', "Amenity Type updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amenity $amenity)
    {
        $this->amenityRepository->delete($amenity);
        return redirect()->route('amenities.index')->with('success', "Amenity Type deleted successfully!");
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
        $amenity  = Amenity::find($input['amenity_type_id']);
        // dd($user);
        if ($this->amenityRepository->changeStatus($input, $amenity)) {
            return response()->json([
                'status' => true,
                'message' => 'Amenity Type status updated successfully.'
            ]);
        }

        throw new Exception('Amenity Type status does not change. Please check sometime later.');
    }
}