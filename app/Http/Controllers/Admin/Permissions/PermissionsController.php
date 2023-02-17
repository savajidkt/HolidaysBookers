<?php
namespace App\Http\Controllers\Admin\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\CreateRequest;
use App\Http\Requests\Permission\EditRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\PermissionRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    protected $permissionRepository;
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function (Permission $permission) {
                    return $permission->name;
                })
                ->editColumn('slug', function (Permission $permission) {
                    return $permission->slug;
                })
                ->addColumn('action', function (Permission $permission) {
                    return $permission->action;
                })->rawColumns(['action'])->make(true);
        }

        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $rawData    = new Permission;
        return view('admin.permissions.create', ['model' => $rawData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $this->permissionRepository->create($request->all());
        return redirect()->route('permissions.index')->with('success', "Permissions created successfully!");
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
     * @param \App\Models\Permission $permission [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', ['model' => $permission]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Permission $permission
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Permission $permission)
    {
        $this->permissionRepository->update($request->all(), $permission);

        return redirect()->route('permissions.index')->with('success', "Permission updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permissions)
    {
        $this->permissionRepository->delete($permissions);
        return redirect()->route('permissions.index')->with('success', "Permissions deleted successfully!");
    }

}
