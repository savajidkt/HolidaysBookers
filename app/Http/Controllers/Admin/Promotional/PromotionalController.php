<?php

namespace App\Http\Controllers\Admin\Promotional;

use App\Http\Controllers\Controller;
use App\Models\Promotional;
use App\Repositories\PromotionalRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromotionalController extends Controller
{
    protected $promotionalRepository;
    public function __construct(PromotionalRepository $promotionalRepository)
    {
        $this->promotionalRepository       = $promotionalRepository;
    }

    public function addPromotionalPlanPopup(Request $request): JsonResponse
    {
      
      if(isset($request->action) && $request->action == "update"){        
        $this->promotionalRepository->addPromotionalPopupUpdate($request->all());
      } else if(isset($request->action) && $request->action == "add"){        
        $this->promotionalRepository->addPromotionalPopup($request->all());
      }
        
        return response()->json([
            'status' => true,
            'responce' => Promotional::where('hotel_id', $request->hotel_id)->where('room_id', $request->room_id)->get(),
            'message' => ''
        ]);
    }

    public function addPromotionalPlanListPopup(Request $request): JsonResponse
    {     
       // dd($request->all());
        return response()->json([
            'status' => true,
            'responce' => Promotional::where('hotel_id', $request->hotel_id)->where('room_id', $request->room_id)->get(),
            'message' => ''
        ]);
    }
    public function addPromotionalPlanListEditPopup(Request $request): JsonResponse
    {     
        
        return response()->json([
            'status' => true,
            'responce' => Promotional::where('hotel_id', $request->hotel_id)->where('id', $request->id)->get(),
            'message' => ''
        ]);
    }
    public function addPromotionalPlanListDeletePopup(Request $request): JsonResponse
    {     
        
       if(strlen($request->hotel_id) && strlen($request->hotel_id) > 0){
        Promotional::where('hotel_id', $request->hotel_id)->where('id', $request->id)->delete();        
       }
        return response()->json([
            'status' => true,
            'responce' => Promotional::where('hotel_id', $request->hotel_id)->where('room_id', $request->room_id)->get(),
            'message' => ''
        ]);
    }
}
