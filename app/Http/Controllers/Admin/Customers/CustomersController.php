<?php

namespace App\Http\Controllers\Admin\Customers;

use Exception;

use App\Models\User;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Exports\ExportCustomers;
use App\Imports\CustomersImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportFailedCustomers;
use App\Repositories\CustomerRepository;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Customer\EditRequest;
use App\Http\Requests\Customer\CreateRequest;
use App\Http\Requests\Customer\UpdatePasswordRequest;


class CustomersController extends Controller
{
    protected $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository       = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('customers')->where('user_type', User::CUSTOMER);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function (User $user) {
                    return $user->fullName;
                })->filterColumn('full_name', function ($query, $keyword) {
                    $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->addColumn('email', function (User $user) {
                    return $user->email;
                })->filterColumn('email', function ($query, $keyword) {
                    $sql = "email  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })->editColumn('status', function (User $user) {
                    return $user->status_name;
                })->addColumn('action', function (User $user) {
                    return $user->action;
                })->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new Customer;
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('admin.customers.create', ['model' => $rawData, 'customer' => [], 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        $this->customerRepository->create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        $user  = User::find($id);                
        return view('admin.customers.view', ['model' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, Customer $customer)
    {
        
        $user  = User::find($customer->user_id);
        $countries    =  Country::where('status', Country::ACTIVE)->get();
       // dd($customer->country);
        return view('admin.customers.edit', ['model' => $user, 'customer' => $customer, 'countries' => $countries]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Customer\EditRequest $request
     * @param \App\Models\Customer $customer
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Customer $customer)
    {
        $this->customerRepository->update($request->all(), $customer);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->customerRepository->delete($customer);
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
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
        // dd($user);
        if ($this->customerRepository->changeStatus($input, $user)) {
            return response()->json([
                'status' => true,
                'message' => 'Customer status updated successfully!'
            ]);
        }

        throw new Exception('Customer status does not change. Please check sometime later.');
    }


    /**
     * Method updatePassword
     *
     * @param UpdatePasswordRequest $request [explicite description]
     * @param Customer $customer [explicite description]
     *
     * @return void
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $input = $request->all();
        $customer  = Customer::find($input['modal_user_id']);
        $user  = $customer->user;
        $this->customerRepository->updatePassword($input, $user);
        return redirect()->route('customers.index')->with('success', "Customer password updated successfully!");
    }


    public function importCustomers(Request $request): JsonResponse
    {

        if (session()->has('skip_row')) {
            session()->forget('skip_row');
        }

        Excel::import(new CustomersImport, $request->file);
        
        $html = false;
        if (session()->has('skip_row')) {
            $details = session()->get('skip_row');
            $skipLink = "";

            if (is_array($details['download_skip_data']) && count($details['download_skip_data']) > 0) {
                $datefile = date('d_m_Y_H_i_s');
                $filename = $datefile . '.xlsx';
                Excel::store(new ExportFailedCustomers($details['download_skip_data']), $filename);
                $skipLinks = storage_path($filename);
                $skipLink = "<li><b>Skip Customers Download : </b><a target='_blank' href='" . url('/storage/app') . '/' . $filename . "'>Download</a></li>";
            }
            $html = '<ul>
                    <li><b>Skip Customers : </b> ' . count($details['skip']) . '</li>
                    <li><b>Imported Customers : </b> ' . $details['sucess'] . '</li>
                    <li><b>Total Customers : </b> ' . $details['total'] . '</li>                   
                    ' . $skipLink . '
                </ul>';
        }

        return response()->json([
            'status' => true,
            'message' => 'Customers import Successfully.',
            'html' => $html,
        ]);
    }


    /**
     * Method customerExcelExport
     *
     * @return void
     */
    public function customerExcelExport()
    {
        $customers    = Customer::all();
        return Excel::download(new ExportCustomers($customers), 'customer-export.xlsx');
    }
}
