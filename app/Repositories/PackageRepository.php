<?php

namespace App\Repositories;

use Exception;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PackageItineraries;

class PackageRepository
{

    public function create(Request $request, array $data): Package
    {        
        $package_validity = explode(' to ', $data['package_validity']);
        $packageArr = [
            'package_name'    => $data['package_name'],
            'package_code'    => $data['package_code'],
            'valid_from'    => ($package_validity[0]) ? $package_validity[0] : '',
            'valid_till'    => ($package_validity[1]) ? $package_validity[1] : '',
            'nationality'    => $data['nationality'],
            'rate_per_adult'    => $data['rate_per_adult'],
            'rate_per_child_cwb'    => $data['rate_per_child_cwb'],
            'rate_per_child_cnb'    => $data['rate_per_child_cnb'],
            'rate_per_infant'    => $data['rate_per_infant'],
            'minimum_pax'    => $data['minimum_pax'],
            'maximum_pax'    => $data['maximum_pax'],
            'cancel_day'    => $data['cancel_day'],
            'highlights'    => $data['highlights'],
            'terms_and_conditions'    => $data['terms_and_conditions'],
            'status'    => Package::ACTIVE,
        ];
        $package =  Package::create($packageArr);
        if (isset($request->terms_and_conditions_pdf)) {
            $filename = $this->uploadDoc($data, 'terms_and_conditions_pdf', $package->id);
            if ($filename) {
                $package->update(array('terms_and_conditions_pdf' => $filename));
            }
        }

        $package->origincity()->attach($data['origin_city_arr']);
        $package->inclusion()->attach($data['inclusion_arr']);
        $package->exclusion()->attach($data['exclusion_arr']);
        $package->packagecity()->attach($data['city_id']);
        $package->packagecountry()->attach($data['country_id']);


        if (isset($data['packages']) && is_array($data['packages']) && count($data['packages']) > 0) {
            $PackageItineraries = [
                'package_id'     => $package->id
            ];
            foreach ($data['packages'] as $key => $value) {
                $PackageItineraries['heading'] = $value['heading'];
                $PackageItineraries['display_order'] = $value['display_order'];
                $PackageItineraries['description'] = $value['description'];
                PackageItineraries::create($PackageItineraries);
            }
        }

        $images = [];
        if ($request->package_gallery_image) {
            foreach ($request->package_gallery_image as $file) {
                $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/upload/') . "/packages/" . $package->id . "/gallery/", $fileName);
                $images[] = ['images_path' => $fileName];
            }
        }
        $package->packageimages()->createMany($images);
        return $package;
    }


    /**
     * Method uploadDoc
     *
     * @param $data $data [explicite description]
     * @param $filename $filename [explicite description]
     *
     * @return void
     */
    public function uploadDoc($data, $filename, $pack_id)
    {
        if (strlen($data[$filename]) > 0) {
            return FileUpload($data[$filename], 'upload/packages/' . $pack_id);
        } else {
            return "";
        }
    }

    public function update(array $data, Package $package): Package
    {         
        
        $package_validity = explode(' to ', $data['package_validity']);
        $packageArr = [
            'package_name'    => $data['package_name'],
            'package_code'    => $data['package_code'],
            'valid_from'    => ($package_validity[0]) ? $package_validity[0] : '',
            'valid_till'    => ($package_validity[1]) ? $package_validity[1] : '',
            'nationality'    => $data['nationality'],
            'rate_per_adult'    => $data['rate_per_adult'],
            'rate_per_child_cwb'    => $data['rate_per_child_cwb'],
            'rate_per_child_cnb'    => $data['rate_per_child_cnb'],
            'rate_per_infant'    => $data['rate_per_infant'],
            'minimum_pax'    => $data['minimum_pax'],
            'maximum_pax'    => $data['maximum_pax'],
            'cancel_day'    => $data['cancel_day'],
            'highlights'    => $data['highlights'],
            'terms_and_conditions'    => $data['terms_and_conditions'],
            'status'    => Package::ACTIVE,
        ];

        if ($package->update($packageArr)) {

            if (isset($data['terms_and_conditions_pdf'])) {
                $filename = $this->uploadDoc($data, 'terms_and_conditions_pdf', $package->id);
                if ($filename) {
                    $package->update(array('terms_and_conditions_pdf' => $filename));
                }
            }
            //dd($data['origin_city_arr']);
            $package->origincity()->detach();
            $package->origincity()->attach($data['origin_city_arr']);

            //dd($data['inclusion_arr']);
            $package->inclusion()->detach();
            $package->inclusion()->attach($data['inclusion_arr']);

            //dd($data['exclusion_arr']);
            $package->exclusion()->detach();
            $package->exclusion()->attach($data['exclusion_arr']);

            $package->packagecity()->detach();
            $package->packagecity()->attach($data['city_id']);

            $package->packagecountry()->detach();
            $package->packagecountry()->attach($data['country_id']);

            if (is_array($data['packages']) && count($data['packages']) > 0) {
                foreach ($data['packages'] as $key => $value) {
                    
                    $PackageItineraries['heading'] = $value['heading'];
                    $PackageItineraries['display_order'] = $value['display_order'];
                    $PackageItineraries['description'] = $value['description'];

                    if (!isset($value['edit_id']) || strlen($value['edit_id']) == 0 || $value['edit_id'] == "" || $value['edit_id'] == NULL) {                       
                        $PackageItineraries['package_id'] = $package->id;                        
                        PackageItineraries::create($PackageItineraries);
                    } else {                        
                        PackageItineraries::where('id', $value['edit_id'])->where('package_id', $value['edit_package_id'])->update($PackageItineraries);
                    }
                }
            }

            $images = [];
            if (isset($data['package_gallery_image'])) {
                foreach ($data['package_gallery_image'] as $file) {
                    $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $file->move(storage_path('app/upload/') . "/packages/" . $package->id . "/gallery/", $fileName);
                    $images[] = ['images_path' => $fileName];
                }
            }

            $package->packageimages()->createMany($images);
        }
        

        return $package;
        throw new Exception('Package update failed.');
    }


    /**
     * Method delete
     *
     * @param Package $package [explicite description]
     *
     * @return bool
     */
    public function delete(Package $package): bool
    {
        if ($package->forceDelete()) {
            return true;
        }
        throw new Exception('Package delete failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     * @param Package $package [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Package $package): bool
    {
        $package->status = !$input['status'];
        return $package->save();
    }
}
