<?php

namespace App\Http\Controllers\Admin\Agent;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent;
use App\Models\Reach;
use App\Models\Country;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use App\Exports\ExportAgents;
use App\Imports\AgentsImport;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Exports\ExportFailedAgents;
use Illuminate\Support\Facades\App;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\AgentRepository;
use App\Http\Requests\Agent\PDFRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Agent\EditRequest;
use App\Http\Requests\Agent\CreateRequest;
use App\Http\Requests\Agent\EditNewRequest;
use App\Http\Requests\Agent\UpdatePasswordRequest;

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
        // $user = auth()->user();   
        // dd($user->can('agents-create'));
        
        if ($request->ajax()) {

            $data = User::with('agents')->where('user_type', User::AGENT);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('agent_code', function (User $user) {
                    return $user->agents->agent_code ?? '-';
                })->filterColumn('agent_code', function ($query, $keyword) {
                    $query->whereHas('agents', function ($query) use ($keyword) {
                        $query->where('agent_code', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('agent_company_name', function (User $user) {
                    return $user->agents->agent_company_name;
                })->filterColumn('agent_company_name', function ($query, $keyword) {
                    $query->whereHas('agents', function ($query) use ($keyword) {
                        $query->where('agent_company_name', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('full_name', function (User $user) {
                    return $user->fullName;
                })->filterColumn('full_name', function ($query, $keyword) {
                    $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->editColumn('agent_mobile_number', function (User $user) {
                    return $user->agents->agent_mobile_number;
                })->filterColumn('agent_mobile_number', function ($query, $keyword) {
                    $query->whereHas('agents', function ($query) use ($keyword) {
                        $query->where('agent_mobile_number', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('agent_email', function (User $user) {
                    return $user->agents->agent_email;
                })->filterColumn('agent_email', function ($query, $keyword) {
                    $query->whereHas('agents', function ($query) use ($keyword) {
                        $query->where('agent_email', 'LIKE', '%' . $keyword . '%');
                    });
                })->addColumn('email', function (User $user) {
                    return $user->email;
                })->addColumn('balance', function(User $user){
                    //dd($user->agents->getbalance);
                    return (isset($user->agents->getbalance)) ? $user->agents->getbalance->balance : '0';

                })->editColumn('status', function (User $user) {
                    return $user->status_name;
                })->orderColumn('full_name', function ($query, $order) {
                    $query->orderByRaw('CONCAT_WS(\' \', first_name, last_name) ' . $order);
                })->addColumn('action', function ($row) {
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
        $companyType    = CompanyType::where('status', CompanyType::ACTIVE)->get();
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $reach    =  Reach::where('status', Reach::ACTIVE)->get();

        return view('admin.agent.create', ['model' => $rawData, 'companies' => $companyType, 'reach' => $reach, 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
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
        $companyType    = CompanyType::where('status', CompanyType::ACTIVE)->get();
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        $reach    =  Reach::where('status', Reach::ACTIVE)->get();

        return view('admin.agent.edit', ['model' => $agent, 'companies' => $companyType, 'reach' => $reach, 'countries' => $countries]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Agent\EditRequest $request
     * @param \App\Models\Agent $agent
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditNewRequest $request, Agent $agent)
    {
       
        $this->agentRepository->update($request->all(), $agent);

        return redirect()->route('agents.index')->with('success', "Agent updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $this->agentRepository->delete($agent);
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

        throw new GeneralException('Agent status does not change. Please check sometime later.');
    }

    function invoice_num($input, $pad_len = 7, $prefix = null)
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }

    /**
     * Method updatePassword
     *
     * @param UpdatePasswordRequest $request [explicite description]
     * @param Agent $agent [explicite description]
     *
     * @return void
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $input = $request->all();
        $agent  = Agent::find($input['modal_user_id']);
        $user  = $agent->user;
        $this->agentRepository->updatePassword($input, $user);
        return redirect()->route('agents.index')->with('success', "Agent password updated successfully!");
    }

    /**
     * Method importAgents
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function importAgents(Request $request): JsonResponse
    {

        if (session()->has('skip_row')) {
            session()->forget('skip_row');
        }

        Excel::import(new AgentsImport, $request->file);


        $html = false;
        if (session()->has('skip_row')) {
            $details = session()->get('skip_row');
            $skipLink = "";

            if (is_array($details['download_skip_data']) && count($details['download_skip_data']) > 0) {
                $datefile = date('d_m_Y_H_i_s');
                $filename = $datefile . '.xlsx';
                Excel::store(new ExportFailedAgents($details['download_skip_data']), $filename);
                $skipLinks = storage_path($filename);
                $skipLink = "<li><b>Skip Agents Download : </b><a target='_blank' href='" . url('/storage/app') . '/' . $filename . "'>Download</a></li>";
            }
            $html = '<ul>
                    <li><b>Skip Agents : </b> ' . count($details['skip']) . '</li>
                    <li><b>Imported Agents : </b> ' . $details['sucess'] . '</li>
                    <li><b>Total Agents : </b> ' . $details['total'] . '</li>                   
                    ' . $skipLink . '
                </ul>';
        }

        return response()->json([
            'status' => true,
            'message' => 'Agents import Successfully.',
            'html' => $html,
        ]);
    }
    
        
    /**
     * Method agentExcelExport
     *
     * @return void
     */
    public function agentExcelExport()
    {              
       // $id= $user->id;
       $agents    = Agent::all();               
        return Excel::download(new ExportAgents($agents), 'agent-export.xlsx');
    }
}
