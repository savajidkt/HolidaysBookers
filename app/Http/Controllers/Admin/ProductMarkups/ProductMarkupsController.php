<?php

namespace App\Http\Controllers\Admin\ProductMarkups;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductMarkup\CreateRequest;
use App\Http\Requests\ProductMarkup\EditRequest;
use App\Models\ProductMarkup;
use App\Repositories\ProductMarkupRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductMarkupsController extends Controller
{
    protected $productMarkupRepository;
    public function __construct(ProductMarkupRepository $productMarkupRepository)
    {
        $this->productMarkupRepository       = $productMarkupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = ProductMarkup::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (ProductMarkup $productmarkup) {
                    return $productmarkup->name;
                })
                ->editColumn('percentage', function (ProductMarkup $productmarkup) {
                    return $productmarkup->percentage;
                })
                ->editColumn('status', function (ProductMarkup $productmarkup) {
                    return $productmarkup->status_name;
                })
                ->addColumn('action', function (ProductMarkup $productmarkup) {
                    return $productmarkup->action;
                })
                ->rawColumns(['action', 'status'])->make(true);
        }

        return view('admin.product-markups.index',['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        permissionCheck('product-markup-create');
        $rawData    = new ProductMarkup;
        return view('admin.product-markups.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        permissionCheck('product-markup-create');
        $this->productMarkupRepository->create($request->all());
        return redirect()->route('productmarkups.index')->with('success', __('product-markup/message.created_success'));
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
     * @param \App\Models\ProductMarkup $productmarkup [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(ProductMarkup $productmarkup)
    {
        permissionCheck('product-markup-edit');
        return view('admin.product-markups.edit', ['model' => $productmarkup]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\ProductMarkup $productmarkup
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, ProductMarkup $productmarkup)
    {
        permissionCheck('product-markup-edit');
        $this->productMarkupRepository->update($request->all(), $productmarkup);
        return redirect()->route('productmarkups.index')->with('success', __('product-markup/message.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductMarkup $productmarkup)
    {
        permissionCheck('product-markup-delete');
        $this->productMarkupRepository->delete($productmarkup);
        return redirect()->route('productmarkups.index')->with('success', __('product-markup/message.deleted_success'));
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
        $productmarkup  = ProductMarkup::find($input['product_markup_id']);
        // dd($user);
        if ($this->productMarkupRepository->changeStatus($input, $productmarkup)) {
            return response()->json([
                'status' => true,
                'message' => __('product-markup/message.status_updated_success')
            ]);
        }

        throw new Exception(__('product-markup/message.error'));
    }
}
