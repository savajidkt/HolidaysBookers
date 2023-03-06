<?php

namespace App\Http\Controllers\Admin\AgentMarkups;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentMarkup\CreateRequest;
use App\Http\Requests\AgentMarkup\EditRequest;
use App\Models\AgentMarkup;
use App\Repositories\AgentMarkupRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AgentMarkupsController extends Controller
{
    protected $agentMarkupRepository;
    public function __construct(AgentMarkupRepository $agentMarkupRepository)
    {
        $this->agentMarkupRepository       = $agentMarkupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $user = auth()->user();
        if ($request->ajax()) {
            $data = AgentMarkup::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (AgentMarkup $agentmarkup) {
                    return $agentmarkup->name;
                })
                ->editColumn('percentage', function (AgentMarkup $agentmarkup) {
                    return $agentmarkup->percentage;
                })
                ->editColumn('status', function (AgentMarkup $agentmarkup) {
                    return $agentmarkup->status_name;
                })
                ->addColumn('action', function (AgentMarkup $agentmarkup) {
                    return $agentmarkup->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.agent-markups.index',['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        permissionCheck('agent-markup-create');
        $rawData    = new AgentMarkup;
        return view('admin.agent-markups.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {   
        permissionCheck('agent-markup-create');
        $this->agentMarkupRepository->create($request->all());
        return redirect()->route('agentmarkups.index')->with('success', __('agent-markup/message.created_success'));
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
     * @param \App\Models\AgentMarkup $agentmarkup [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(AgentMarkup $agentmarkup)
    {
        permissionCheck('agent-markup-edit');
        return view('admin.agent-markups.edit', ['model' => $agentmarkup]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\AgentMarkup $agentmarkup
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, AgentMarkup $agentmarkup)
    {
        permissionCheck('agent-markup-edit');
        $this->agentMarkupRepository->update($request->all(), $agentmarkup);
        return redirect()->route('agentmarkups.index')->with('success', __('agent-markup/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentMarkup $agentmarkup)
    {   
        permissionCheck('agent-markup-delete');
        $this->agentMarkupRepository->delete($agentmarkup);
        return redirect()->route('agentmarkups.index')->with('success', __('agent-markup/message.deleted_success'));
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
        $agentmarkup  = AgentMarkup::find($input['agent_markup_id']);
        // dd($user);
        if ($this->agentMarkupRepository->changeStatus($input, $agentmarkup)) {
            return response()->json([
                'status' => true,
                'message' => __('agent-markup/message.status_updated_success')
            ]);
        }

        throw new Exception(__('agent-markup/message.error'));
    }
}
