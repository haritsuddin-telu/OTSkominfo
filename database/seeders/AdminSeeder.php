<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ganti email dan password sesuai kebutuhan
        $admin = User::firstOrCreate(
            [ 'email' => 'admin@admin.com' ],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );
        // Assign role admin jika belum
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
