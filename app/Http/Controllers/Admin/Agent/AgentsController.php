<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\CreateRequest;
use App\Http\Requests\Agent\EditRequest;
use App\Http\Requests\Agent\PDFRequest;
use App\Models\User;
use App\Models\Agent;
use App\Models\CompanyType;
use App\Models\Country;
use App\Models\Reach;
use App\Repositories\AgentRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AgentsController extends Controller
{
    /** \App\Repository\AgentRepository $agentRepository */
    protected $agentRepository;
    public function __construct(AgentRepository $agentRepository)
    {
        $this->agentRepository       = $agentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('agent_code', function (User $user) {
                    return $user->agents->agent_code;
                })
                ->addColumn('agent_company_name', function (User $user) {
                    return $user->agents->agent_company_name;
                })
                ->addColumn('full_name', function (User $user) {
                    return $user->fullName;
                })
                ->addColumn('agent_mobile_number', function (User $user) {
                    return $user->agents->agent_mobile_number;
                })
                ->addColumn('agent_email', function (User $user) {
                    return $user->agents->agent_email;
                })
                ->addColumn('email', function (User $user) {
                    return $user->email;
                })
                ->addColumn('balance', function (User $user) {
                    return 0;
                })
                ->editColumn('status', function (User $user) {
                    return $user->status_name;
                })
                ->orderColumn('full_name', function ($query, $order) {
                    $query->orderByRaw('CONCAT_WS(\' \', first_name, last_name) ' . $order);
                })
                ->addColumn('action', function ($row) {
                    return $row->agents->action;
                })->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.agent.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        //
        $rawData    = new User;
        $companyType    = CompanyType::where('status', 1)->get();
        $countries    =  Country::where('status', 1)->get();
        $reach    =  Reach::where('status', 1)->get();

        return view('admin.agent.create', ['model' => $rawData, 'companies' => $companyType, 'reach' => $reach, 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->agentRepository->create($request->all());
        return redirect()->route('agents.index')->with('success', "User created successfully!");
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
     * @param \App\Models\Agent $agent [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Agent $agent)
    {
        $companyType    = CompanyType::where('status', 1)->get();
        $countries    =  Country::where('status', 1)->get();
        $reach    =  Reach::where('status', 1)->get();

        return view('admin.agent.edit', ['model' => $agent, 'companies' => $companyType, 'reach' => $reach, 'countries' => $countries]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\User\EditRequest $request
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->agentRepository->update($request->all(), $user);

        return redirect()->route('agents.index')->with('success', "Agent updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->agentRepository->delete($user);

        return redirect()->route('agents.index')->with('success', "Agent deleted successfully!");
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
        $user  = User::find($input['user_id']);
        if ($this->agentRepository->changeStatus($input, $user)) {
            return response()->json([
                'status' => true,
                'message' => 'Agent status updated successfully.'
            ]);
        }

        throw new Exception('Agent status does not change. Please check sometime later.');
    }

    function invoice_num($input, $pad_len = 7, $prefix = null)
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
}
