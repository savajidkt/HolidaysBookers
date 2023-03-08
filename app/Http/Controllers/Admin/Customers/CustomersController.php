<?php

namespace App\Http\Controllers\Admin\Customers;

use Exception;
use App\Models\User;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
                })->addColumn('mobile_number', function (User $user) {
                    return $user->customers->mobile_number;
                })->filterColumn('mobile_number', function ($query, $keyword) {
                    $query->whereHas('customers', function ($query) use ($keyword) {
                        $query->where('mobile_number', 'LIKE', '%' . $keyword . '%');
                    });
                })->editColumn('status', function (User $user) {
                    return $user->status_name;
                })->addColumn('action', function ($row) {
                    return $row->customers->action;
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
        return view('admin.customers.create', ['model' => $rawData, 'countries' => $countries]);
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
    public function show(Request $request, Customer $customer)
    {
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('admin.customers.view', ['model' => $customer, 'countries' => $countries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Customer $customer)
    {
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('admin.customers.edit', ['model' => $customer, 'countries' => $countries]);
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
}
