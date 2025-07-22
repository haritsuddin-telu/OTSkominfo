<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = [
            [
                'name' => 'haris',
                'email' => 'haris@mail.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'hendri',
                'email' => 'hendri@mail.com',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'renata',
                'email' => 'renata@mail.com',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($pegawai as $data) {
            $user = User::create($data);
            $user->assignRole('pegawai');
        }
    }
}
