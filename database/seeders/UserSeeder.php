<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // $users = [
        //     [
        //         'name' => 'Super Admin',
        //         'email' => 'superadmin@inventory.com',
        //         'role' => 'superadmin',
        //         'status' => 'active',
        //         'password' => Hash::make('password'),
        //     ],
        //     [
        //         'name' => 'Admin',
        //         'email' => 'admin@inventory.com',
        //         'role' => 'admin',
        //         'status' => 'active',
        //         'password' => Hash::make('password'),
        //     ],
        //     [
        //         'name' => 'Employee',
        //         'email' => 'employee@inventory.com',
        //         'role' => 'employee',
        //         'status' => 'active',
        //         'password' => Hash::make('password'),
        //     ],
        //     [
        //         'name' => 'User',
        //         'email' => 'user@inventory.com',
        //         'role' => 'user',
        //         'status' => 'active',
        //         'password' => Hash::make('password'),
        //     ],
        // ];

        // foreach ($users as &$user) {
        //     $user['user_name'] = '@' . strtolower(str_replace(' ', '', $user['name'])) . '_' . rand(0, 9999);
        // }

        // DB::table('users')->insert($users);
    }
}
