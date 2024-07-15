<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@inventory.com',
                'role' => 'superadmin',
                'status' => 'active',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@inventory.com',
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Employee',
                'email' => 'employee@inventory.com',
                'role' => 'employee',
                'status' => 'active',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'User',
                'email' => 'user@inventory.com',
                'role' => 'user',
                'status' => 'active',
                'password' => Hash::make('password'),
            ],
        ];

        // Insert users into database
        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'user_name' => $userData['name'], // Modify as needed for username generation
                'password' => $userData['password'],
                'role' => $userData['role'],
                'status' => $userData['status'],
                'provider' => 'local', // Assuming local provider for seeded users
                'provider_id' => null,
                'provider_token' => null,
                'email_verified_at' => now(),
            ]);
        }



        // DB::table('users')->insert($users);
    }
}
