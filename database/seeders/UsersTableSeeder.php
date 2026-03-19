<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $users = [
            [
                'RoleID' => 1, // Admin
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'PhoneNumber' => '1111111111',
                'IsActive' => 1,
                'LastLogin' => Carbon::now(),
            ],
            [
                'RoleID' => 2, // EntityManager
                'name' => 'Entity Manager',
                'email' => 'manager@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'PhoneNumber' => '2222222222',
                'IsActive' => 1,
                'LastLogin' => Carbon::now(),
            ],
            [
                'RoleID' => 3, // User
                'name' => 'Normal User',
                'email' => 'user@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'PhoneNumber' => '3333333333',
                'IsActive' => 1,
                'LastLogin' => Carbon::now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
