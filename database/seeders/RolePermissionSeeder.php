<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $pegawaiRole = Role::firstOrCreate(['name' => 'pegawai']);


        // Create permissions
        $editPermission = Permission::firstOrCreate(['name' => 'edit data']);
        $viewPermission = Permission::firstOrCreate(['name' => 'view data']);
        $deletePermission = Permission::firstOrCreate(['name' => 'delete data']);
        $createPermission = Permission::firstOrCreate(['name' => 'create data']);
        $viewlogPermission = Permission::firstOrCreate(['name' => 'view log']);
    $manageRolePermission = Permission::firstOrCreate(['name' => 'manage role permission']);
    $viewDashboardPermission = Permission::firstOrCreate(['name' => 'view dashboard']);
    $accessOtsPermission = Permission::firstOrCreate(['name' => 'access ots']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            $editPermission,
            $viewPermission,
            $deletePermission,
            $createPermission,
            $viewlogPermission,
            $manageRolePermission,
            $viewDashboardPermission
            
        ]);
        $pegawaiRole->givePermissionTo([$viewPermission, $accessOtsPermission]);

        // Assign admin role to first user
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}