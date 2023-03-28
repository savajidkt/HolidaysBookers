<?php

namespace App\Http\Controllers\Admin\ApiHotels;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Reach;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\HotelGroup;
use App\Models\CompanyType;
use App\Models\OfflineHotel;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Exports\ExportAgents;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\ExportFailedAgents;
use Illuminate\Support\Facades\App;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Imports\OfflineHotelsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Models\Freebies;
use App\Models\HotelImage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Traits\GlobalTrait;

class ApiHotelsController extends Controller
{
    use GlobalTrait;
    
    public $settings;

    public function __construct()
    {
        $this->settings = $this->getAllSettings(5);
    }

    public function rezliveHotels()
    {
        rezeliveHotels($this->settings);
        dd($this->settings);
    }
   
    public function show(OfflineHotel $offlinehotel)
    {
       
    }
}
