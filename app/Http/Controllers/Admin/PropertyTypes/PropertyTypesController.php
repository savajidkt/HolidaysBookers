<?php

namespace App\Http\Controllers\Admin\PropertyTypes;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyType\CreateRequest;
use App\Http\Requests\PropertyType\EditRequest;
use App\Models\PropertyType;
use App\Repositories\PropertyTypeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PropertyTypesController extends Controller
{
    protected $propertyTypeRepository;
    public function __construct(PropertyTypeRepository $propertyTypeRepository)
    {
        $this->propertyTypeRepository       = $propertyTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PropertyType::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('property_name', function (PropertyType $propertytype) {
                    return $propertytype->property_name;
                })
                ->editColumn('status', function (PropertyType $propertytype) {
                    return $propertytype->status_name;
                })
                ->addColumn('action', function (PropertyType $propertytype) {
                    return $propertytype->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.property-types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new PropertyType;
        return view('admin.property-types.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->propertyTypeRepository->create($request->all());
        return redirect()->route('propertytypes.index')->with('success', __('propertytype/message.created_success'));
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
     * @param \App\Models\PropertyType $propertytype [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(PropertyType $propertytype)
    {
        return view('admin.property-types.edit', ['model' => $propertytype]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\PropertyType $propertytype
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, PropertyType $propertytype)
    {
        $this->propertyTypeRepository->update($request->all(), $propertytype);

        return redirect()->route('propertytypes.index')->with('success', __('propertytype/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyType $propertytype)
    {
        $this->propertyTypeRepository->delete($propertytype);
        return redirect()->route('propertytypes.index')->with('success', __('propertytype/message.deleted_success'));
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
        $propertytype  = PropertyType::find($input['property_type_id']);
        // dd($user);
        if ($this->propertyTypeRepository->changeStatus($input, $propertytype)) {
            return response()->json([
                'status' => true,
                'message' => __('propertytype/message.status_updated_success')
            ]);
        }

        throw new Exception(__('propertytype/message.error'));
    }
}