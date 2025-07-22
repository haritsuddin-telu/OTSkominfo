<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function createRole(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        return response()->json($role);
    }

    public function createPermission(Request $request)
    {
        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission);
    }

    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);
        return response()->json(['message' => 'Role assigned']);
    }

    public function givePermissionToRole(Request $request)
    {
        $role = Role::findByName($request->role);
        $role->givePermissionTo($request->permission);
        return response()->json(['message' => 'Permission given to role']);
    }
}
