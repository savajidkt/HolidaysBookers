<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\City;
use App\Models\Country;
use App\Models\OfflineHotel;
use App\Models\RezliveHotel;

class RezliveHotelsImports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = storage_path('app/hotels.csv');
        if (($handle = fopen($file, "r")) === FALSE)
        {
            echo "readJobsFromFile: Failed to open file [$file]\n";
            die;
        }

        $header=true;
        $fieldArray=[];
        $index=0;
        while (($hotels = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            $HotelArr = [];
                // echo '<pre>';
                // print_r($hotels[0]);
                // echo '</pre>';
                
            if($index>0){
                $data = explode('|',$hotels[0]);
                $hotelCode = $data[0];
                $hotelName = $data[1]; 
                $hotelCity = $data[2]; 
                $CityId = $data[3]; 
                $CountryId = $data[5]; 
                $CountryCode = $data[4]; 
                $Rating = $data[6]; 
                $HotelAddress = $data[7]; 
                // $HotelPostalCode = $data[8]; 
                // $Latitude = $data[9]; 
                // $Longitude = $data[10]; 
                // $Desc = $data[11];
                $country = Country::where('code',$CountryCode)->first();
                $city = City::where('name',$hotelCity)->first();
                $HotelArr = [
                    'hotel_name'    => $hotelName,
                    'hotel_country'  => $country->id,
                    'hotel_city'    => $city->id ?? NULL,
                    'hotel_code'      => $hotelCode,
                    'hotel_address'    =>$HotelAddress,
                    'hotel_review'    =>$Rating,
                    'CityId'=>$CityId,
                    'CountryId'=>$CountryId
                ];
        
                RezliveHotel::create($HotelArr);
                
            }
            
            $index++;
        }

        fclose($handle);
    }
}
