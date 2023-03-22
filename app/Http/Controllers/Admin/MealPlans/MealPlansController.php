<?php

namespace App\Http\Controllers\Admin\MealPlans;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealPlan\CreateRequest;
use App\Http\Requests\MealPlan\EditRequest;
use App\Models\MealPlan;
use App\Repositories\MealPlanRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MealPlansController extends Controller
{
    protected $mealPlanRepository;
    public function __construct(MealPlanRepository $mealPlanRepository)
    {
        $this->mealPlanRepository       = $mealPlanRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = MealPlan::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (MealPlan $mealPlan) {
                    return $mealPlan->name;
                })
                ->editColumn('status', function (MealPlan $mealPlan) {
                    return $mealPlan->status_name;
                })
                ->addColumn('action', function (MealPlan $mealPlan) {
                    return $mealPlan->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.meal-plans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new MealPlan;
        return view('admin.meal-plans.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->mealPlanRepository->create($request->all());
        return redirect()->route('mealplans.index')->with('success', 'Meal plan created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Method edit
     *
     * @param MealPlan $mealplan [explicite description]
     *
     * @return void
     */
    public function edit(MealPlan $mealplan)
    {
        return view('admin.meal-plans.edit', ['model' => $mealplan]);
    }


    /**
     * Method update
     *
     * @param EditRequest $request [explicite description]
     * @param MealPlan $mealplan [explicite description]
     *
     * @return void
     */
    public function update(EditRequest $request, MealPlan $mealplan)
    {
        $this->mealPlanRepository->update($request->all(), $mealplan);
        return redirect()->route('mealplans.index')->with('success', 'Meal plan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MealPlan $mealplan)
    {
        $this->mealPlanRepository->delete($mealplan);
        return redirect()->route('mealplans.index')->with('success', 'Meal plan deleted successfully!');
    }

    /**
     * Method changeStatus
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $input = $request->all();
        $mealPlan  = MealPlan::find($input['meal_plan_id']);
        // dd($user);
        if ($this->mealPlanRepository->changeStatus($input, $mealPlan)) {
            return response()->json([
                'status' => true,
                'message' => 'Meal plan status updated successfully!'
            ]);
        }

        throw new Exception('Meal plan status does not change. Please check sometime later.');
    }


    public function addMealPlansPopup(Request $request): JsonResponse
    {
        $this->mealPlanRepository->addMealPlansPopup($request->all());
        return response()->json([
            'status' => true,
            'responce' => MealPlan::where('status', MealPlan::ACTIVE)->pluck('name', 'id')->toArray(),
            'message' => ''
        ]);
    }
}
