<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas Bengkel',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );
    }
}
