<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyType\CreateRequest;
use App\Http\Requests\CompanyType\EditRequest;
use App\Models\CompanyType;
use App\Repositories\CompanyTypeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    protected $companyTypeRepository;
    public function __construct(CompanyTypeRepository $companyTypeRepository)
    {
        $this->companyTypeRepository       = $companyTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CompanyType::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('company_type', function (CompanyType $companytype) {
                    return $companytype->company_type;
                })
                ->editColumn('status', function (CompanyType $companytype) {
                    return $companytype->status_name;
                })
                ->addColumn('action', function (CompanyType $companytype) {
                    return $companytype->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.company-types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new CompanyType;
        return view('admin.company-types.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        
        $this->companyTypeRepository->create($request->all());
        return redirect()->route('companytypes.index')->with('success', __('companytype/message.created_success'));
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
     * @param \App\Models\CompanyType $companytype [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(CompanyType $companytype)
    {
        return view('admin.company-types.edit', ['model' => $companytype]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\CompanyType $companytype
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, CompanyType $companytype)
    {
        $this->companyTypeRepository->update($request->all(), $companytype);

        return redirect()->route('companytypes.index')->with('success', __('companytype/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyType $companytype)
    {
        $this->companyTypeRepository->delete($companytype);
        return redirect()->route('companytypes.index')->with('success', __('companytype/message.deleted_success'));
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
        $companytype  = CompanyType::find($input['company_type_id']);
        // dd($user);
        if ($this->companyTypeRepository->changeStatus($input, $companytype)) {
            return response()->json([
                'status' => true,
                'message' => __('companytype/message.status_updated_success')
            ]);
        }

        throw new Exception(__('companytype/message.error'));
    }
}
