<?php

namespace App\Http\Controllers\Customer;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{

    public function index()
    {         
        $pagename = "wishlist";
        $user = auth()->user();
        $wishlist = Wishlist::where('user_id', '=', $user->id)           
            ->where('type', '=', 'hotel')
            ->paginate(10);   
               
        return view('customer.wishlist.index', ['pagename' => $pagename,'wishlist'=>$wishlist]);
    }
}
