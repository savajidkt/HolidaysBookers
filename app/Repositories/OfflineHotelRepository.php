<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Support\Str;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\ForgotPasswordEvent;
use App\Exceptions\GeneralException;
use App\Models\City;
use App\Models\Country;
use App\Models\HotelImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\RegisterdEmailNotification;

class OfflineHotelRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return OfflineHotel
     */
    public function create(Request $request, array $data): OfflineHotel
    {
       
        $HotelArr = [
            'hotel_name'    => $data['hotel_name'],
            'hotel_country'  => $data['hotel_country'],
            'hotel_city'    => $data['hotel_city'],
            'category'      => $data['category'],
            'hotel_group_id'    => $data['hotel_group_id'],
            'phone_number'    => $data['phone_number'],
            'fax_number'    => $data['fax_number'],
            'hotel_address'    => $data['hotel_address'],
            'hotel_pincode'    => $data['hotel_pincode'],
            'hotel_email'    => $data['hotel_email'],
            'property_type_id'    => $data['property_type_id'],
            'hotel_review'    => $data['hotel_review'],
            'hotel_latitude'    => $data['hotel_latitude'],
            'hotel_longitude'    => $data['hotel_longitude'],
            'cancel_days'    => $data['cancel_days'],            
            'hotel_description'    => html_entity_decode($data['hotel_description']),
            'cancellation_policy'    => '',//html_entity_decode($data['cancellation_policy']),
            'front_office_first_name'         => $data['front_office_first_name'],
            'front_office_designation'         => $data['front_office_designation'],
            'front_office_contact_number'         => $data['front_office_contact_number'],
            'front_office_email'         => $data['front_office_email'],
            'sales_first_name'         => $data['sales_first_name'],
            'sales_designation'         => $data['sales_designation'],
            'sales_contact_number'         => $data['sales_contact_number'],
            'sales_email'         => $data['sales_email'],
            'reservation_first_name'         => $data['reservation_first_name'],
            'reservation_designation'         => $data['reservation_designation'],
            'reservation_contact_number'         => $data['reservation_contact_number'],
            'reservation_email'         => $data['reservation_email'],
            'status'    => OfflineHotel::ACTIVE,
        ];

        $OfflineHotel = OfflineHotel::create($HotelArr);
        $OfflineHotel->hotelamenity()->attach($data['hotel_amenities']);
        $OfflineHotel->hotelfreebies()->attach($data['hotel_freebies']);

        if (isset($data['subFacility']) && is_array($data['subFacility']) && count($data['subFacility']) > 0) {
            $hotelincludefacilityArr = [];             
            foreach ($data['subFacility'] as $key => $facility) {   
                if( is_array($facility) && count($facility) > 0 ){
                    foreach ($facility as $subkey => $subfacility) {   
                        $hotelincludefacilityArr[] = array(
                            'hotel_id' => $OfflineHotel->id,
                            'facility_id'=>$key,
                            'facilities_id' =>$subkey,        
                        );
                    }
                }        
            }               
            $OfflineHotel->hotelincludefacility()->attach($hotelincludefacilityArr);               
        }

        $images = [];

        if( isset($request->hotel_gallery_image) ){

        
        foreach ($request->hotel_gallery_image as $file) {
            $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/upload/')."/Hotel/". $OfflineHotel->id."/gallery/", $fileName);
            $images[] = ['file_path' => $fileName];
        }
        $OfflineHotel->images()->createMany($images);
    }

    if( isset($request->hotel_image) ){
        if ($request->hotel_image) {
            foreach ($request['hotel_image'] as $files) {
                $Filename = $files->getClientOriginalName();
                $files->move(storage_path('app/upload/') . "/Hotel/" . $OfflineHotel->id . "/", $Filename);
            }
            $OfflineHotel->update(['hotel_image_location' => $Filename]);
        }
    }
        //$user->notify(new RegisterdEmailNotification($password,$user));
        
        return $OfflineHotel;
    }


    /**
     * Method uploadDoc
     *
     * @param $data $data [explicite description]
     * @param $filename $filename [explicite description]
     *
     * @return void
     */
    public function uploadDoc($data, $filename, $user_id)
    {
        if (strlen($data[$filename]) > 0) {
            FolderExists($user_id);
            return FileUpload($data[$filename], 'upload/' . $user_id);
        } else {
            return "";
        }
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param OfflineHotel $offlinehotel [explicite description]
     *
     * @return OfflineHotel
     * @throws Exception
     */
    public function update(Request $request, array $data, OfflineHotel $offlinehotel): OfflineHotel
    {
        $HotelArr = [
            'hotel_name'    => $data['hotel_name'],
            'hotel_country'  => $data['hotel_country'],
            'hotel_city'    => $data['hotel_city'],
            'category'      => $data['category'],
            'hotel_group_id'    => $data['hotel_group_id'],
            'phone_number'    => $data['phone_number'],
            'fax_number'    => $data['fax_number'],
            'hotel_address'    => $data['hotel_address'],
            'hotel_pincode'    => $data['hotel_pincode'],
            'hotel_email'    => $data['hotel_email'],
            'property_type_id'    => $data['property_type_id'],
            'hotel_review'    => $data['hotel_review'],
            'hotel_latitude'    => $data['hotel_latitude'],
            'hotel_longitude'    => $data['hotel_longitude'],
            'cancel_days'    => $data['cancel_days'],
            'hotel_description'    => html_entity_decode($data['hotel_description']),
            'cancellation_policy'    => "",//html_entity_decode($data['cancellation_policy']),
            'front_office_first_name'         => $data['front_office_first_name'],
            'front_office_designation'         => $data['front_office_designation'],
            'front_office_contact_number'         => $data['front_office_contact_number'],
            'front_office_email'         => $data['front_office_email'],
            'sales_first_name'         => $data['sales_first_name'],
            'sales_designation'         => $data['sales_designation'],
            'sales_contact_number'         => $data['sales_contact_number'],
            'sales_email'         => $data['sales_email'],
            'reservation_first_name'         => $data['reservation_first_name'],
            'reservation_designation'         => $data['reservation_designation'],
            'reservation_contact_number'         => $data['reservation_contact_number'],
            'reservation_email'         => $data['reservation_email'],
        ];

        $offlinehotel->update($HotelArr);

        if (isset($data['hotel_amenities'])) {
            $offlinehotel->hotelamenity()->detach();
            $offlinehotel->hotelamenity()->attach($data['hotel_amenities']);
        }
        
        if (isset($data['hotel_freebies'])) {
            $offlinehotel->hotelfreebies()->detach();
            $offlinehotel->hotelfreebies()->attach($data['hotel_freebies']);
        }
        

        if (isset($data['subFacility']) && is_array($data['subFacility']) && count($data['subFacility']) > 0) {
            $hotelincludefacilityArr = [];             
            foreach ($data['subFacility'] as $key => $facility) {   
                if( array_key_exists($key, $data['facilities'])){
                    if( is_array($facility) && count($facility) > 0 ){
                        foreach ($facility as $subkey => $subfacility) {   
                            $hotelincludefacilityArr[] = array(
                                'hotel_id' => $offlinehotel->id,
                                'facility_id'=>$key,
                                'facilities_id' =>$subkey,        
                            );
                        }
                    } 
                }  

            }   
            $offlinehotel->hotelincludefacility()->detach();     
            $offlinehotel->hotelincludefacility()->attach($hotelincludefacilityArr);               
        }


        $images = [];
        if ($request->hotel_gallery_image) {
            foreach ($request->hotel_gallery_image as $file) {
                $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/upload/') . "/Hotel/" . $offlinehotel->id . "/gallery/", $fileName);
                $images[] = ['file_path' => $fileName];
            }
            $offlinehotel->images()->createMany($images);
        }
        

        if ($request->hotel_image) {
            foreach ($request->hotel_image as $files) {
                $Filename = $files->getClientOriginalName();
                $files->move(storage_path('app/upload/') . "/Hotel/" . $offlinehotel->id . "/", $Filename);
            }
            $offlinehotel->update(['hotel_image_location' => $Filename]);
        }



        return $offlinehotel;
        throw new Exception('Offline Hotel update failed.');
    }

    /**
     * Method delete
     *
     * @param OfflineHotel $offlinehotel [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(OfflineHotel $offlinehotel): bool
    {
        if ($offlinehotel->forceDelete()) {
            return true;
        }

        throw new Exception('Offline Hotel delete failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, OfflineHotel $offlinehotel): bool
    {
        $offlinehotel->status = !$input['status'];
        return $offlinehotel->save();
    }

    public function hotel_destroy(Request $request)
    {
        $filename =  $request->get('filename');
        HotelImage::where('filename', $filename)->delete();
        $path = public_path('uploads/gallery/') . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success' => $filename]);
    }

    public function rezliveHotelSave(array $hotel)
    {
        $HotelAmenities = explode(',',$hotel['HotelAmenities']);
        $country = Country::where('name', 'like', '%'.$hotel['Country'].'%')->first();
        $city = City::where('name', 'like', '%'.$hotel['City'].'%')->first();
        $hotelArray['hotel_country'] = $country->id;
        $hotelArray['hotel_city'] = $city->id;
        $hotelArray['hotel_code'] = $hotel['HotelId'];
        $hotelArray['hotel_name'] = $hotel['HotelName'];
        $hotelArray['category'] = $hotel['Rating'];
        $hotelArray['phone_number'] = $hotel['Phone'];
        $hotelArray['fax_number'] = $hotel['Fax'];
        $hotelArray['hotel_address'] = $hotel['HotelAddress'];
        $hotelArray['hotel_pincode'] = $hotel['HotelPostalCode'];
        $hotelArray['hotel_image_location'] = $hotel['MainImage'];
        $hotelArray['hotel_description'] = $hotel['Description'];
        $hotelArray['hotel_email'] = $hotel['Email'];
        $hotelArray['hotel_latitude'] = $hotel['Latitude'];
        $hotelArray['hotel_longitude'] = $hotel['Longitude'];
        $hotelArray['api_hotel_amenities'] = $hotel['HotelAmenities'];
        $hotelArray['hotel_type'] = 2;
        return $hotelArray;
    }
}
