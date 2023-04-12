<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\Contact\CreateRequest;

class ContactUsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        return view('contact');
    }

    public function submitForm(CreateRequest $request)
    {                               
        return redirect()->route('contact-us')->with('success', 'Thank you for contact us. we will contact you shortly.');
    }
}
