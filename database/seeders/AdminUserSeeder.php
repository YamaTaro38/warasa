<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@warasa.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        
        User::create([
            'name' => 'User Demo',
            'email' => 'user@warasa.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}