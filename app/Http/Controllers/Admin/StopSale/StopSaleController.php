<?php

namespace App\Http\Controllers\Admin\StopSale;

use App\Http\Controllers\Controller;
use App\Models\StopSale;
use App\Repositories\StopSaleRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StopSaleController extends Controller
{
    protected $stopSaleRepository;
    public function __construct(StopSaleRepository $stopSaleRepository)
    {
        $this->stopSaleRepository       = $stopSaleRepository;
    }

    public function addStopSalePlanPopup(Request $request): JsonResponse
    {

      if(isset($request->action) && $request->action == "update"){        
        $this->stopSaleRepository->addStopSalePopupUpdate($request->all());
      } else if(isset($request->action) && $request->action == "add"){        
        $this->stopSaleRepository->addStopSalePopup($request->all());
      }
        
        return response()->json([
            'status' => true,
            'responce' => StopSale::where('hotel_id', $request->hotel_id)->get(),
            'message' => ''
        ]);
    }

    public function addStopSalePlanListPopup(Request $request): JsonResponse
    {    
        
        return response()->json([
            'status' => true,
            'responce' => StopSale::where('hotel_id', $request->hotel_id)->get(),
            'message' => ''
        ]);

    }
    public function addStopSalePlanListEditPopup(Request $request): JsonResponse
    {     
        
        return response()->json([
            'status' => true,
            'responce' => StopSale::where('hotel_id', $request->hotel_id)->where('id', $request->id)->get(),
            'message' => ''
        ]);
    }
    public function addStopSalePlanListDeletePopup(Request $request): JsonResponse
    {     
       if(strlen($request->hotel_id) && strlen($request->hotel_id) > 0){
        StopSale::where('hotel_id', $request->hotel_id)->where('id', $request->id)->delete();        
       }
        return response()->json([
            'status' => true,
            'responce' => StopSale::where('hotel_id', $request->hotel_id)->get(),
            'message' => ''
        ]);
    }
}
