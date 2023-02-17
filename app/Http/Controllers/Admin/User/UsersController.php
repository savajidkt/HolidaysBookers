<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\EditRequest;
use App\Http\Requests\User\PDFRequest;
use App\Models\User;
use App\Models\UserSurvey;
use App\Models\UserSurveyAnswer;
use App\Repositories\CompanyRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class UsersController extends Controller
{
    /** \App\Repository\UserRepository $userRepository */
    protected $userRepository;
    /** \App\Repository\CompanyRepository $companyRepository */
    protected $companyRepository;
    /** \App\Repository\ProjectRepository $projectRepository */
    protected $projectRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository, ProjectRepository $projectRepository)
    {
        $this->userRepository       = $userRepository;
        $this->companyRepository    = $companyRepository;
        $this->projectRepository    = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('full_name', function (User $user) {
                    return $user->fullName;
                })
                ->editColumn('user_status', function (User $user) {
                    return $user->status_name;
                })
                ->editColumn('survey_status', function (User $user) {

                    return $user->survey ? $user->survey->survey_status : '<a href="javascript:void(0)" class=""><span class="badge badge-danger">Incomplete</span></a>';
                })
                ->orderColumn('full_name', function ($query, $order) {
                    $query->orderByRaw('CONCAT_WS(\' \', first_name, last_name) ' . $order);
                })
                ->addColumn('action', function ($row) {
                    return $row->action;
                })->rawColumns(['action', 'user_status', 'survey_status'])->make(true);
        }

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        //

        $rawData    = new User;
        $companies  = $this->companyRepository->getCompany();
        $projects   = $this->projectRepository->getProject();
        return view('admin.user.create', ['model' => $rawData, 'companies' => $companies, 'projects' => $projects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->userRepository->create($request->all());

        return redirect()->route('users.index')->with('success', "User created successfully!");
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
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(User $user)
    {
        $companies  = $this->companyRepository->getCompany();
        $projects   = $this->projectRepository->getProject();
        return view('admin.user.edit', ['model' => $user, 'companies' => $companies, 'projects' => $projects]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\User\EditRequest $request
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, User $user)
    {
        $this->userRepository->update($request->all(), $user);

        return redirect()->route('users.index')->with('success', "User updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->userRepository->delete($user);

        return redirect()->route('users.index')->with('success', "User deleted successfully!");
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
        $user  = User::find($input['user_id']);
        // dd($user);
        if ($this->userRepository->changeStatus($input, $user)) {
            return response()->json([
                'status' => true,
                'message' => 'User status updated successfully.'
            ]);
        }

        throw new Exception('User status does not change. Please check sometime later.');
    }

    public function resetSurveyTime(Request $request): JsonResponse
    {
        $input = $request->all();
        $userSurvey  = UserSurvey::where('user_id', $input['user_id'])->first();
        //dd($userSurvey);
        if ($userSurvey) {
            $this->userRepository->resetSurveyTime($input, $userSurvey);
        }
        return response()->json([
            'status' => true,
            'message' => 'User survey time reset successfully.'
        ]);

        throw new Exception('User status does not change. Please check sometime later.');
    }

    /**
     * Method generatePDF
     *
     * @param int $id [explicite description]
     * @param PDFRequest $request [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(int $id, PDFRequest $request)
    {
        $userSurvey  = UserSurvey::where('user_id', $id)->where('status', UserSurvey::COMPLETED)->first();
        // $userSurveyAnswer = UserSurveyAnswer::select([
        //     DB::raw("SUM(establishing_report_point) AS esMax"),
        //     DB::raw("SUM(understanding_others_point) AS undMax"),
        //     DB::raw("SUM(embracing_individual_differences_point) AS embracingMax"),
        //     DB::raw("SUM(developing_trust_point) AS developingMax"),
        //     DB::raw("SUM(cultivating_influence_point) AS cultiInfluMax"),
        //     DB::raw("SUM(lacking_self_awareness_point) AS lackingSelfMax"),
        //     DB::raw("SUM(lacking_social_awareness_point) AS lackingSocialMax"),
        //     DB::raw("SUM(self_serving_point) AS selfServingMax"),
        //     DB::raw("SUM(breaking_trust_point) AS breakingTrustMax"),
        //     DB::raw("SUM(poor_management_of_emotions_point) AS poorMax"),
        //     'user_survey_id'
        // ])->groupBy('user_survey_id');

        // $survey = UserSurvey::select([
        //     'esMax',
        //     'undMax',
        //     'embracingMax',
        //     'developingMax',
        //     'cultiInfluMax',
        //     'lackingSelfMax',
        //     'lackingSocialMax',
        //     'selfServingMax',
        //     'breakingTrustMax',
        //     'poorMax',
        //     'id',
        //     'user_id',
        //     'status'
        // ])->leftJoinSub($userSurveyAnswer, 'calculation', function ($join) {
        //     $join->on('calculation.user_survey_id', '=', 'user_surveys.id');
        // })->where('status', UserSurvey::COMPLETED)->get();

        // get max value from all users

        // $esMax = $survey->max('esMax');
        // $undMax = $survey->max('undMax');
        // $embracingMax = $survey->max('embracingMax');
        // $developingMax = $survey->max('developingMax');
        // $cultiInfluMax = $survey->max('cultiInfluMax');
        // $lackingSelfMax = $survey->max('lackingSelfMax');
        // $lackingSocialMax = $survey->max('lackingSocialMax');
        // $selfServingMax = $survey->max('selfServingMax');
        // $breakingTrustMax = $survey->max('breakingTrustMax');
        // $poorMax = $survey->max('poorMax');

        //selected user get total
        // $ri_points            =  $userSurvey->questions->sum('ri_points');
        // $esTotal            =  $userSurvey->questions->sum('establishing_report_point');
        // $undTotal           = $userSurvey->questions->sum('understanding_others_point');
        // $embracingTotal     = $userSurvey->questions->sum('embracing_individual_differences_point');
        // $developingTotal    = $userSurvey->questions->sum('developing_trust_point');
        // $cultiInfluTotal    = $userSurvey->questions->sum('cultivating_influence_point');
        // $lackingSelfTotal   = $userSurvey->questions->sum('lacking_self_awareness_point');
        // $lackingSocialTotal = $userSurvey->questions->sum('lacking_social_awareness_point');
        // $selfServingTotal   = $userSurvey->questions->sum('self_serving_point');
        // $breakingTrustTotal = $userSurvey->questions->sum('breaking_trust_point');
        // $poorTotal          = $userSurvey->questions->sum('poor_management_of_emotions_point');

        // percentage calculation

        $ri_points          =  round($userSurvey->ri_points * 100,0);
        $esPer              =  round($userSurvey->establishing_report * 100,0);
        $undPer             =  round($userSurvey->understanding_others * 100,0);
        $embracingPer       =  round($userSurvey->embracing_individual_differences * 100,0);
        $developingPer      =  round($userSurvey->developing_trust * 100,0);
        $cultiInfluPer      =  round($userSurvey->cultivating_influence * 100,0);
        $lackingSelfPer     =  round($userSurvey->lacking_self_awareness * 100,0);
        $lackingSocialPer   =  round($userSurvey->lacking_social_awareness * 100,0);
        $selfServingPer     =  round($userSurvey->self_serving * 100,0);
        $breakingTrustPer   =  round($userSurvey->breaking_trust * 100,0);
        $poorPer            =  round($userSurvey->poor_management_of_emotions * 100,0);

        $hightArrayPer =max($esPer,$undPer,$embracingPer,$developingPer,$cultiInfluPer);
        //echo common()->formatSql($latestPosts);die;
        $data = [
            'user_id'                               => $userSurvey->user_id,
            'survey_id'                             => $this->invoice_num($userSurvey->id, 6, ''),
            'full_name'                             => $userSurvey->user->full_name,
            'date'                                  => Carbon::parse($userSurvey->updated_at)->format('m/d/Y'),
            'ri_points'                             => $ri_points,
            'establishing_report_per'               => $esPer,
            'understanding_others_per'              => $undPer,
            'embracing_individual_differences_per'  => $embracingPer,
            'developing_trust_per'                  => $developingPer,
            'cultivating_influence_per'             => $cultiInfluPer,
            'lacking_self_awareness_per'            => $lackingSelfPer,
            'lacking_social_awareness_per'          => $lackingSocialPer,
            'self_serving_per'                      => $selfServingPer,
            'breaking_trust_per'                    => $breakingTrustPer,
            'poor_management_of_emotions_per'       => $poorPer,
            'hightArrayPer'                        =>$hightArrayPer

        ];

        $html = view('admin.pdf-reports.front-page', $data)->render();
        //$html = view('admin.pdf-reports.chart', $data)->render();
        //echo $html; die;
        $pdf = SnappyPdf::loadHTML($html);

        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 4000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('lowquality', false);
        return $pdf->download('survey-report-' . $userSurvey->user_id .'.pdf');
    }

    function invoice_num($input, $pad_len = 7, $prefix = null)
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }

    public function reportExcelExport(User $user)
    {
        //$user->loadMissing(['survey','survey_answers']);
        $id= $user->id;
        return Excel::download(new ReportsExport($user), 'survey-reports-'.$id.'.xlsx');
    }

    public function percentagerankCalculate($valueSet, $lastValue)
    {

        $valueSet    = $valueSet;
        $value        = $lastValue;
        $significance    = 3;

        foreach ($valueSet as $key => $valueEntry) {
            if (!is_numeric($valueEntry)) {
                unset($valueSet[$key]);
            }
        }
        sort($valueSet, SORT_NUMERIC);
        $valueCount = count($valueSet);
        if ($valueCount == 0) {
            return 0;
        }

        $valueAdjustor = $valueCount - 1;
        if (($value < $valueSet[0]) || ($value > $valueSet[$valueAdjustor])) {
            return 0;
        }

        $pos = array_search($value, $valueSet);
        if ($pos === False) {
            $pos = 0;
            $testValue = $valueSet[0];
            while ($testValue < $value) {
                $testValue = $valueSet[++$pos];
            }
            --$pos;
            $pos += (($value - $valueSet[$pos]) / ($testValue - $valueSet[$pos]));
        }

        return  round($pos / $valueAdjustor, $significance);
    }
}
