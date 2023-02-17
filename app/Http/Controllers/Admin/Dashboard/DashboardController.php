<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    

    public function index(Request $request)
    {
        
        return view('admin.dashboard.index');
    }

    public function getDashboardData(Request $request): JsonResponse
    {

        $data = $request->all();
        //$data = [];
        $completed = $this->questionRepository->getTotalCompletedSurveys($data);
        $pending = $this->questionRepository->getTotalPendingSurveys($data);
        $percentage = (int) (100 * $completed) / ($completed + $pending);
        $survey_results = [
            'completed'     =>   $completed,
            'pending'       =>   $pending,
            'percentage'    =>   number_format((float)$percentage, 2, '.', '')
        ];
        $recent_activity= $this->questionRepository->getSubmitedSurveys($data);
        return response()->json([
            'status'        => true,
            'message'       => 'Request created successfully.',
            'survey_results'       => $survey_results,
            'dataActivity'          => view('admin.dashboard.recent-activity', [
            'recent_activity'        => $recent_activity
            ])->render()
        ]);
    }
}
