<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ContactNotification;
use Illuminate\Notifications\Notification;
use App\Http\Requests\Contact\CreateRequest;
use Illuminate\Support\Facades\Notification as FacadesNotification;

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
        $contact = new Contact();        
        $contact->notify(new ContactNotification($request->all()));               
        return redirect()->route('contact-us')->with('success', 'Thank you for contact us. we will contact you shortly.');
    }
}
