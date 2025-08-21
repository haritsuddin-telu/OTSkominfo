<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::all();
        return view('RolePermission', compact('roles', 'permissions', 'users'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return redirect()->route('role.permission')->with('success', 'Role added');
    }

    public function destroyRole($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('role.permission')->with('success', 'Role deleted');
    }

    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return redirect()->route('role.permission')->with('success', 'Permission added');
    }

    public function destroyPermission($id)
    {
        Permission::findOrFail($id)->delete();
        return redirect()->route('role.permission')->with('success', 'Permission deleted');
    }

    public function assignPermissionToRole(Request $request)
    {
        $request->validate(['role' => 'required', 'permission' => 'required']);
        $role = Role::findByName($request->role);
        $role->givePermissionTo($request->permission);
        return redirect()->route('role.permission')->with('success', 'Permission assigned to role');
    }

    public function assignRoleToUser(Request $request)
    {
        $request->validate(['user_id' => 'required', 'role' => 'required']);
        $user = User::findOrFail($request->user_id);
        $user->assignRole($request->role);
        return redirect()->route('role.permission')->with('success', 'Role assigned to user');
    }
}
