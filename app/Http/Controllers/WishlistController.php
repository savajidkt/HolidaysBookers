<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Repositories\WishlistRepository;

class WishlistController extends Controller
{

    protected $wishlistRepository;
    
    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository       = $wishlistRepository;
        
    }

    public function store(Request $request)
    {

        $user = Wishlist::where('user_id', '=', $request->user_id)
            ->where('hotel_id', '=', $request->hotel_id)
            ->where('type', '=', $request->type)
            ->first();

        if ($user === null) {
            $this->wishlistRepository->create($request->all());
            return response()->json([
                'status' => true,
                'class' => 'active',
                'message' => 'Wishlist added successfully!'
            ]);
        } else {            
            $this->wishlistRepository->delete($request->all());
            return response()->json([
                'status' => true,
                'class' => '',
                'message' => 'Wishlist removed successfully!'
            ]);
        }
    }
}
