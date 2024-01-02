<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.vendor.index');
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        //
        $rawData    = new User();
        // $companyType    = CompanyType::where('status', CompanyType::ACTIVE)->get();
        // $countries    =  Country::where('status', Country::ACTIVE)->get();
        // $reach    =  Reach::where('status', Reach::ACTIVE)->get();

        return view('admin.vendor.create', ['model' => $rawData]);
    }

}
