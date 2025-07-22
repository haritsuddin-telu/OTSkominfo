<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserTableController extends Controller
{
     public function index()
    {
        $users = User::with('roles')->get();
        return view('table', compact('users'));
    }

    public function edit($id)
    {
    $user = User::findOrFail($id);
    $roles = Role::all(); // Ambil semua role
    return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));

         if ($request->has('role')) {
        $user->syncRoles([$request->role]); // Ganti role sesuai input
    }
        return redirect()->route('users.index')->with('success', 'User updated!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted!');
    }
}
