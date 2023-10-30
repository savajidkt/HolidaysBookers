<?php

namespace App\Http\Controllers\Admin\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\CreateRequest;
use App\Http\Requests\api\EditRequest;
use App\Models\Api;
use App\Repositories\ApiRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ApisController extends Controller
{
    protected $apiRepository;
    public function __construct(ApiRepository $apiRepository)
    {
        $this->apiRepository       = $apiRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $user = auth()->user();
        if ($request->ajax()) {

            $data = Api::select('*')->where('status',Api::ACTIVE);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Api $api) {
                    return $api->name;
                })
                ->editColumn('api_url', function (Api $api) {
                    return $api->api_url;
                })
                ->editColumn('status', function (Api $api) {
                    return $api->status_name;
                })
                ->addColumn('action', function (Api $api) {
                    return $api->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.apis.index',['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        permissionCheck('api-create');
        $rawData    = new Api;
        return view('admin.apis.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        permissionCheck('api-create');
        $this->apiRepository->create($request->all());
        return redirect()->route('apis.index')->with('success', __('api/message.created_success'));
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
     * @param \App\Models\Api $api [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Api $api)
    {
        permissionCheck('api-edit');
        return view('admin.apis.edit', ['model' => $api]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Api $api
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Api $api)
    {
        permissionCheck('api-edit');
        $this->apiRepository->update($request->all(), $api);
        return redirect()->route('apis.index')->with('success', __('api/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Api $api)
    {
        permissionCheck('api-delete');
        $this->apiRepository->delete($api);
        return redirect()->route('apis.index')->with('success', __('api/message.deleted_success'));
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
        $api  = Api::find($input['api_id']);
        if ($this->apiRepository->changeStatus($input, $api)) {
            return response()->json([
                'status' => true,
                'message' => __('api/message.status_updated_success')
            ]);
        }

        throw new Exception(__('api/message.error'));
    }    
}
