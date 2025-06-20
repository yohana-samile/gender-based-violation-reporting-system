<?php

namespace App\Http\Controllers\Gbv\Access;
use App\Http\Controllers\Controller;
use App\Models\Access\Permission;

class PermissionController extends  Controller
{
    public function __construct() {
        $this->middleware('access.routeNeedsPermission:manage_role_and_permissions,all_functions', [
            'only' => ['index']
        ]);
    }

    public function index()
    {
        return view('pages.access.permission.index');
    }

    public function getAllForDt()
    {
        $permissions = Permission::getAllPermissions();
        return response(['data' => $permissions]);
    }
}
