<?php

namespace App\Http\Controllers\Admin\Reachus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reach\CreateRequest;
use App\Http\Requests\Reach\EditRequest;
use App\Models\Reach;
use App\Repositories\ReachRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReachusController extends Controller
{
    protected $reachRepository;
    public function __construct(ReachRepository $reachRepository)
    {
        $this->reachRepository       = $reachRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Reach::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Reach $reach) {
                    return $reach->name;
                })
                ->editColumn('show_other_textbox', function (Reach $reach) {
                    return $reach->show_other_textbox_name;
                })
                ->editColumn('status', function (Reach $reach) {
                    return $reach->status_name;
                })
                ->addColumn('action', function (Reach $reach) {
                    return $reach->action;
                })
                ->rawColumns(['action', 'status', 'show_other_textbox'])->make(true);
        }

        return view('admin.reach.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new Reach;
        return view('admin.reach.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        $this->reachRepository->create($request->all());
        return redirect()->route('reachus.index')->with('success', __('reach-us/message.created_success'));
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
     * @param \App\Models\Reach $reachu [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Reach $reachu)
    {
        return view('admin.reach.edit', ['model' => $reachu]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Reach $reachu
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Reach $reachu)
    {
        $this->reachRepository->update($request->all(), $reachu);

        return redirect()->route('reachus.index')->with('success', __('reach-us/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reach $reachu)
    {
        $this->reachRepository->delete($reachu);
        return redirect()->route('reachus.index')->with('success', __('reach-us/message.deleted_success'));
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
        $reach  = Reach::find($input['reach_id']);
        // dd($user);
        if ($this->reachRepository->changeStatus($input, $reach)) {
            return response()->json([
                'status' => true,
                'message' => __('reach-us/message.status_updated_success')
            ]);
        }

        throw new Exception(__('reach-us/message.error'));
    }
}
