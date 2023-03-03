<?php

namespace App\Http\Controllers\Admin\WalletTransactions;

use Exception;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\WalletTransactionRepository;
use App\Http\Requests\WalletTransaction\CreateHBCreditRequest;

class WalletTransactionsController extends Controller
{
    protected $walletTransactionRepository;
    public function __construct(WalletTransactionRepository $walletTransactionRepository)
    {
        $this->walletTransactionRepository       = $walletTransactionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Agent $agent)
    {
        if ($request->ajax()) {
            $data = $agent->wallettransactions;
            //$data = WalletTransaction::select('*')->where('agent_id',$request->id);
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('transaction_type', function (WalletTransaction $wallettransaction) {
                    return $wallettransaction->transaction_type;
                })
                ->editColumn('pnr', function (WalletTransaction $wallettransaction) {
                    return $wallettransaction->pnr;
                })
                ->editColumn('type', function (WalletTransaction $wallettransaction) {
                    return $wallettransaction->type_name;
                })
                ->addColumn('amount', function (WalletTransaction $wallettransaction) {
                    return numberFormat($wallettransaction->amount, '₹');
                })
                ->addColumn('created_at', function (WalletTransaction $wallettransaction) {
                    return dateFormat($wallettransaction->created_at);
                })
                ->rawColumns(['action', 'type'])->make(true);
        }


        return view('admin.wallet-transactions.index',['model' =>$agent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new WalletTransaction;
        return view('admin.wallet-transactions.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->walletTransactionRepository->create($request->all());
        return redirect()->route('wallettransactions.index')->with('success', __('wallettransaction/message.created_success'));
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
     * @param \App\Models\WalletTransaction $wallettransaction [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(WalletTransaction $wallettransaction)
    {
        return view('admin.wallet-transactions.edit', ['model' => $wallettransaction]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\WalletTransaction $wallettransaction
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, WalletTransaction $wallettransaction)
    {
        $this->walletTransactionRepository->update($request->all(), $wallettransaction);

        return redirect()->route('wallettransactions.index')->with('success', __('wallettransaction/message.updated_success'));
    }



    public function updateHBCredit(CreateHBCreditRequest $request, WalletTransaction $wallettransaction)
    {
        $input = $request->all();
        $agent  = Agent::find($input['HBCredit_user_id']);
       // $user  = $agent->user->id;
        $input['user_id'] = $agent->user->id;
        $balance = calculateBalance($agent->id, $input['type'], $input['amount']);
        
        if ($balance) {
            $input['balance'] = $balance;
            $this->walletTransactionRepository->updateCredit($input, $wallettransaction);
        }

        return redirect()->route('agents.index')->with('success', "Agent HB credit updated successfully!");
    }
}
