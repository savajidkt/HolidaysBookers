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
            'hotel_state'    => $data['hotel_state'],
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
            'hotel_description'    => $data['hotel_description'],
            'cancellation_policy'    => $data['cancellation_policy'],
            'status'    => OfflineHotel::ACTIVE,
        ];

        $OfflineHotel = OfflineHotel::create($HotelArr);
        $OfflineHotel->hotelamenity()->attach($data['hotel_amenities']);
        $images = [];

        foreach ($request->hotel_gallery_image as $file) {
            $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/upload/') . "/Hotel/" . $OfflineHotel->id . "/gallery/", $fileName);
            $images[] = ['file_path' => $fileName];
        }
        $OfflineHotel->images()->createMany($images);

        if ($request->hotel_image) {
            foreach ($request['hotel_image'] as $files) {
                $Filename = $files->getClientOriginalName();
                $files->move(storage_path('app/upload/') . "/Hotel/" . $OfflineHotel->id . "/", $Filename);
            }
            $OfflineHotel->update(['hotel_image_location' => $Filename]);
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
            'hotel_state'    => $data['hotel_state'],
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
            'hotel_description'    => $data['hotel_description'],
            'cancellation_policy'    => $data['cancellation_policy'],
        ];

        $offlinehotel->update($HotelArr);

        if (isset($data['hotel_amenities'])) {
            $offlinehotel->hotelamenity()->detach();
            $offlinehotel->hotelamenity()->attach($data['hotel_amenities']);
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
    public function changeStatus(array $input, User $user): bool
    {
        $user->status = !$input['status'];
        return $user->save();
    }

    public function resetSurveyTime(array $input, UserSurvey $userSurvey): bool
    {
        return $userSurvey->delete();
    }

    /**
     * Method demoformcreate
     *
     * @param array $data [explicite description]
     * @param User $user [explicite description]
     *
     * @return User
     * @throws Exception
     */
    public function demoformcreate(array $data): User
    {
        $user = auth()->user();
        $data = [
            'gender'    => $data['gender'],
            'other_text'    => $data['other_text'] ?? null,
            'age'     => $data['age'],
            'ethnicity'     => $data['ethnicity'],
            'job_level'     => $data['job_level'],
            'years'       => $data['years']
        ];


        if ($user->update($data)) {
            return $user;
        }

        throw new Exception('User update failed.');
    }

    public function hotel_destroy(Request $request)
    {
        $filename =  $request->get('filename');
        Gallery::where('filename', $filename)->delete();
        $path = public_path('uploads/gallery/') . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success' => $filename]);
    }
}
