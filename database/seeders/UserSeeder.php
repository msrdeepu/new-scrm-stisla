<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@inventory.com',
                'role' => 'superadmin',
                'status' => 'active',
                'password' => bcrypt('password'),


            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@inventory.com',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('password'),


            ],
            [
                'name' => 'Employee',
                'username' => 'employee',
                'email' => 'employee@inventory.com',
                'role' => 'employee',
                'status' => 'active',
                'password' => bcrypt('password'),


            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@inventory.com',
                'role' => 'user',
                'status' => 'active',
                'password' => bcrypt('password'),


            ],

        ]);
    }
}
