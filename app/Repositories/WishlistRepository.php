<?php

namespace App\Repositories;

use App\Models\Wishlist;
use Exception;

class WishlistRepository
{


    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Wishlist
     */
    public function create(array $data): Wishlist
    {
        $dataSave = [
            'user_id'    => $data['user_id'],
            'hotel_id'     => $data['hotel_id'],
            'type'     => $data['type'],
        ];
        $wishlist =  Wishlist::create($dataSave);
        return $wishlist;
    }

     
    /**
     * Method delete
     *
     * @param array $data [explicite description]
     *
     * @return Wishlist
     */
    public function delete(array $data): bool
    {
        
        $wishlist = Wishlist::where('user_id', $data['user_id'])
        ->where('hotel_id', $data['hotel_id'])
        ->where('type', $data['type'])
        ->delete();

        if ($wishlist) {
            return true;
        }

        throw new Exception('Wishlist delete failed!');
    }
    
}
