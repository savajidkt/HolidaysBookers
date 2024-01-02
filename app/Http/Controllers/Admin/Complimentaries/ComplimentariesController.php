<?php

namespace App\Http\Controllers\Admin\Complimentaries;

use App\Http\Controllers\Controller;
use App\Models\Complimentary;
use App\Repositories\ComplimentaryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComplimentariesController extends Controller
{
    protected $complimentaryRepository;
    public function __construct(ComplimentaryRepository $complimentaryRepository)
    {
        $this->complimentaryRepository       = $complimentaryRepository;
    }

    public function addComplimentaryPlanPopup(Request $request): JsonResponse
    {
      
      if(isset($request->action) && $request->action == "update"){
        
        $this->complimentaryRepository->addComplimentaryPopupUpdate($request->all());
      } else if(isset($request->action) && $request->action == "add"){
        
        $this->complimentaryRepository->addComplimentaryPopup($request->all());
      }
        
        return response()->json([
            'status' => true,
            'responce' => Complimentary::where('hotel_id', $request->hotel_id)->with('mealplans')->get(),
            'message' => ''
        ]);
    }

    public function addComplimentaryPlanListPopup(Request $request): JsonResponse
    {     
        
        return response()->json([
            'status' => true,
            'responce' => Complimentary::where('hotel_id', $request->hotel_id)->with('mealplans')->get(),
            'message' => ''
        ]);
    }
    public function addComplimentaryPlanListEditPopup(Request $request): JsonResponse
    {     
        
        return response()->json([
            'status' => true,
            'responce' => Complimentary::where('hotel_id', $request->hotel_id)->where('id', $request->id)->get(),
            'message' => ''
        ]);
    }
    public function addComplimentaryPlanListDeletePopup(Request $request): JsonResponse
    {     
       if(strlen($request->hotel_id) && strlen($request->hotel_id) > 0){
        Complimentary::where('hotel_id', $request->hotel_id)->where('id', $request->id)->delete();        
       }
        return response()->json([
            'status' => true,
            'responce' => Complimentary::where('hotel_id', $request->hotel_id)->with('mealplans')->get(),
            'message' => ''
        ]);
    }
}
