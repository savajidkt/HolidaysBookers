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

class RezliveCityCodeUpdate implements ShouldQueue
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
        $file = storage_path('app/cities.csv');
        if (($handle = fopen($file, "r")) === FALSE)
        {
            echo "readJobsFromFile: Failed to open file [$file]\n";
            die;
        }

        $header=true;
        $fieldArray=[];
        $index=0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($index !=0){
                $firstCol = explode('|', $data[0]);
                $cityName = $firstCol[1]; // City Name
                if(count($firstCol)>2){
                    $cityCode = $firstCol[2]; // City Code
                }else{
                    $SecCol = explode('|', $data[1]);
                    if(count($SecCol)>1){
                        $cityCode = $SecCol[1];
                    }else{
                        $ThirdCol = explode('|', $data[2]); 
                        $cityCode = $ThirdCol[1];
                    }
                    
                }


               $city = City::where('name','LIKE','%'.$cityName.'%')->first();
               if($city){
                    $city->update(['rezlive_city_code'=>$cityCode,'rezlive_failed'=>1]);
               }else{
                    //$fieldArray[]= $cityName;
                    // $dataSave = [
                    //     'rezlive_failed'=>1
                    // ];
            
                    //$city->update($dataSave);
               }
            }
            $index++;
        }

        fclose($handle);

    }
}
