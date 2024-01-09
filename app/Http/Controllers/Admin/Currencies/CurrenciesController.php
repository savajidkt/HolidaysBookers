<?php

namespace App\Http\Controllers\Admin\Currencies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CreateRequest;
use App\Http\Requests\Currency\EditRequest;
use App\Models\Country;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CurrenciesController extends Controller
{
    protected $currencyRepository;
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository       = $currencyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Currency::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Currency $currency) {
                    return $currency->name;
                })
                ->editColumn('code', function (Currency $currency) {
                    return $currency->code;
                })
                ->editColumn('rate', function (Currency $currency) {
                    return $currency->rate;
                })
                ->editColumn('status', function (Currency $currency) {
                    return $currency->status_name;
                })
                ->addColumn('action', function (Currency $currency) {
                    return $currency->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {        
        $rawData    = new Currency;
        return view('admin.currencies.create', ['model' => $rawData, 'countries' => Country::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->currencyRepository->create($request->all());
        return redirect()->route('currencies.index')->with('success', 'Currency created successfully!');
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
     * Method edit
     *
     * @param Currency $currency [explicite description]
     *
     * @return void
     */
    public function edit(Currency $currency)
    {        
        
        return view('admin.currencies.edit', ['model' => $currency, 'countries' => Country::all()]);
    }


    /**
     * Method update
     *
     * @param EditRequest $request [explicite description]
     * @param Currency $currency [explicite description]
     *
     * @return void
     */
    public function update(EditRequest $request, Currency $currency)
    {
        $this->currencyRepository->update($request->all(), $currency);
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $this->currencyRepository->delete($currency);
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully!');
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
        $currency  = Currency::find($input['currency_id']);
        // dd($user);
        if ($this->currencyRepository->changeStatus($input, $currency)) {
            return response()->json([
                'status' => true,
                'message' => 'Currency status updated successfully!'
            ]);
        }

        throw new Exception('Currency status does not change. Please check sometime later.');
    }



    public function getAllCurrencies(Request $request): JsonResponse
    {
        
        $currency  = Currency::where('status',1)->get();
        if($currency){ 
            return response()->json([
                'status' => true,
                'data' => $currency,               
                'getdata' =>  getBookingCart('currencySet'),               
            ]);        
        } else {
            return response()->json([
                'status' => false,                
            ]);
        }
       
    }

    public function setCurrencies(Request $request): JsonResponse
    {
       
        $currency  = Currency::find($request->id);
        if($currency){ 
          
            $currencyArr = [];
            $currencyArr['id'] = $currency->id;
            $currencyArr['name'] = $currency->name;
            $currencyArr['code'] = $currency->code;
            $currencyArr['symbol'] = $currency->symbol;
            setBookingCart('currencySet', $currencyArr);
            return response()->json([
                'status' => true,
                'data' => $currency->id,                           
                'code' => $currency->code                             
            ]);        
        } else {
            return response()->json([
                'status' => false,                
            ]);
        }
       
    }
}
