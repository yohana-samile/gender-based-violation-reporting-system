<?php

namespace App\Http\Controllers\Gbv\Access;
use App\Http\Controllers\Controller;
use App\Models\Access\Role;
use App\Repositories\Access\PermissionRepository;
use App\Repositories\Access\RoleRepository;
use Illuminate\Http\Request;


class RoleController extends  Controller
{
    protected $role_repo;
    public function __construct() {
        $this->role_repo = new RoleRepository();
        $this->middleware('access.routeNeedsPermission:manage_role_and_permissions,all_functions', [
            'only' => ['index', 'create', 'store', 'edit', 'update', 'delete']
        ]);
    }

    public function index()
    {
        return view('pages.access.role.index');
    }

    public function create()
    {
        $data['permissions'] = app(PermissionRepository::class)->getAll();
        $data['role'] = null;

        return view('pages.access.role.create', $data);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $status = 200;
        $message = "Role created successfully";

        $validator = \Validator::make($input, [
            'description' => 'required|max:250',
            'name' => 'required|unique:roles',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
            'isactive' => 'nullable',
            'isadmin' => 'nullable',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Invalid input',
                'errors' => $validator->errors()->all()
            ], 422);
        }
        try {
            $role = $this->role_repo->store($input);
            if (isset($input['permissions'])){
                $role->permissions()->sync($input['permissions']);
            }

            return response([
                'status' => $status,
                'message' => $message,
            ], $status);
        }
        catch (\Exception $e) {
            \Log::debug("Server Error", [$e->getMessage()]);
            $status = 500;
            $message = "Server Error, Try again later or contact administrator";
        }

        return response([
            'status' => $status,
            'message' => $message,
        ], $status);
    }

    public function edit($roleUid)
    {
        $role = Role::getRoleByUid($roleUid);
        $data['permissions'] = app(PermissionRepository::class)->getAll();
        $data['rolePermissions'] = $role->permissions->pluck('id')->toArray();
        $data['role'] = $role;

        return view('pages.access.role.edit', $data);
    }


    public function update(Request $request, $roleUid)
    {
        $input = $request->all();
        $role = Role::getRoleByUid($roleUid);
        $status = 200;
        $message = "Role updated successfully";
        \Log::debug("request array ", [$input]);

        try {
            $role = $this->role_repo->update($input, $role);
            if (isset($input['permissions'])){
                $role->permissions()->sync($input['permissions']);
            }
            else{
                $role->permissions()->sync([]);
            }
            return response([
                'status' => $status,
                'message' => $message,
            ], $status);
        }
        catch (\Exception $e) {
            \Log::debug("Server Error", [$e->getMessage()]);
            $status = 500;
            $message = "Server Error, Try again later or contact administrator";
        }

        return response([
            'status' => $status,
            'message' => $message,
        ], $status);
    }

    public function profile($roleUid) {
        $role = Role::getRoleByUid($roleUid);
        $data['permissions'] = app(PermissionRepository::class)->getPermissionsByRole($role);
        $data['role'] = $role;
        return view('pages.access.role.profile.profile', $data);
    }

    public function show(Role $role)
    {
        return $this->profile($role);
    }

    public function delete($roleUid)
    {
        $role = Role::getRoleByUid($roleUid);
        $status = 200;
        $message = "Role deleted successfully";

        try {
            $response = $this->role_repo->delete($role);
            if ($response === false){
                return response([
                    'status' => 403,
                    'message' => "Role deletion failed",
                ], 403);
            }

            return response([
                'status' => $status,
                'message' => $message,
            ], $status);
        }
        catch (\Exception $e) {
            \Log::debug("Server Error", [$e->getMessage()]);
            $status = 500;
            $message = "Server Error, Try again later or contact administrator";
        }

        return response([
            'status' => $status,
            'message' => $message,
        ], $status);
    }

    public function users($roleUid)
    {
        $role = Role::getRoleByUid($roleUid);
        $users = $role->users()->with('roles', 'permissions')->get();

        return view('pages.access.role.users', [
            'role' => $role,
            'users' => $users,
        ]);
    }

    public function getAllForDt()
    {
        return response(['data' => $this->role_repo->getAllForDt()]);
    }
}
