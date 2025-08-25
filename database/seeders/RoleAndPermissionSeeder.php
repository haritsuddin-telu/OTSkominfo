<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // ADMIN
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $manageRolePermission = Permission::firstOrCreate(['name' => 'manage role permission']);
        $viewDashboard = Permission::firstOrCreate(['name' => 'view dashboard']);
        $adminRole->givePermissionTo([$manageRolePermission, $viewDashboard]);
        $user = User::first();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        // PEGAWAI
        $pegawaiRole = Role::firstOrCreate(['name' => 'pegawai']);
        $accessOts = Permission::firstOrCreate(['name' => 'access ots']);
        $pegawaiRole->givePermissionTo($accessOts);
        $user2 = User::skip(1)->first();
        if ($user2 && !$user2->hasRole('pegawai')) {
            $user2->assignRole('pegawai');
        }
    }
}
