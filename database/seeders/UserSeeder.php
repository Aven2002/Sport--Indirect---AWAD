<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Prevent duplication
            [
                'userRole' => 'Admin',
                'username' => 'Admin',
                'password' => Hash::make('admin123'),
                'dob' => '1990-01-01'
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'username' => 'User',
                'password' => Hash::make('user123'),
                'dob' => '1990-01-01'
            ]
                );
    }
}
