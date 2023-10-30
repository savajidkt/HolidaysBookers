<?php

namespace App\Http\Controllers\Admin\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\EditRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    protected $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository       = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $user = auth()->user();
        if ($request->ajax()) {
            $data = Role::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function (Role $role) {
                    return $role->name;
                })
                ->editColumn('slug', function (Role $role) {
                    return $role->slug;
                })
                ->editColumn('status', function (Role $role) {
                    return $role->status_name;
                })
                ->addColumn('action', function (Role $role) {
                    return $role->action;
                })->rawColumns(['action','status'])->make(true);
        }

        return view('admin.roles.index',['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {   permissionCheck('role-create');
        $rawData    = new Role;
        $permissions    =  Permission::all()->groupBy('module');
        return view('admin.roles.create', ['model' => $rawData,'permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {   permissionCheck('role-create');
        $this->roleRepository->create($request->all());
        return redirect()->route('roles.index')->with('success', "Role created successfully!");
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
     * @param \App\Models\Role $role [explicite description]
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Role $role)
    {
        permissionCheck('role-edit');
        $permissions    =  Permission::all()->groupBy('module');
        return view('admin.roles.edit', ['model' => $role,'permissions'=>$permissions]);
    }

    /**
     * Method update
     *
     * @param \App\Http\Requests\Admin\EditRequest $request
     * @param \App\Models\Role $role
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(EditRequest $request, Role $role)
    {   permissionCheck('role-edit');
        $this->roleRepository->update($request->all(), $role);
        return redirect()->route('roles.index')->with('success', "Role updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {   permissionCheck('role-delete');
        $this->roleRepository->delete($role);
        return redirect()->route('roles.index')->with('success', "Role deleted successfully!");
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
        $role  = Role::find($input['user_id']);
        // dd($user);
        if ($this->roleRepository->changeStatus($input, $role)) {
            return response()->json([
                'status' => true,
                'message' => 'Role status updated successfully.'
            ]);
        }

        throw new Exception('Role status does not change. Please check sometime later.');
    }
}
