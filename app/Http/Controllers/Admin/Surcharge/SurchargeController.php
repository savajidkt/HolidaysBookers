<?php

namespace App\Http\Controllers\Admin\Surcharge;

use App\Http\Controllers\Controller;
use App\Models\Surcharge;
use App\Repositories\SurchargeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SurchargeController extends Controller
{
    protected $surchargeRepository;
    public function __construct(SurchargeRepository $surchargeRepository)
    {
        $this->surchargeRepository       = $surchargeRepository;
    }

    public function addSurchargePlansPopup(Request $request): JsonResponse
    {
      
      if(isset($request->action) && $request->action == "update"){
        
        $this->surchargeRepository->addSurchargesPopupUpdate($request->all());
      } else {
        
        $this->surchargeRepository->addSurchargesPopup($request->all());
      }
        
        return response()->json([
            'status' => true,
            'responce' => Surcharge::where('hotel_id', $request->hotel_id)->get(),
            'message' => ''
        ]);
    }

    public function addSurchargePlanListPopup(Request $request): JsonResponse
    {     
        
        return response()->json([
            'status' => true,
            'responce' => Surcharge::where('hotel_id', $request->hotel_id)->get(),
            'message' => ''
        ]);
    }
    public function addSurchargePlanListEditPopup(Request $request): JsonResponse
    {     
        
        return response()->json([
            'status' => true,
            'responce' => Surcharge::where('hotel_id', $request->hotel_id)->where('id', $request->id)->get(),
            'message' => ''
        ]);
    }
    public function addSurchargePlanListDeletePopup(Request $request): JsonResponse
    {     
       if(strlen($request->hotel_id) && strlen($request->hotel_id) > 0){
        Surcharge::where('hotel_id', $request->hotel_id)->where('id', $request->id)->delete();        
       }
        return response()->json([
            'status' => true,
            'responce' => Surcharge::where('hotel_id', $request->hotel_id)->get(),
            'message' => ''
        ]);
    }
}
