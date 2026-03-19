<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['RoleName' => 'Admin', 'Description' => 'Administrator with full access'],
            ['RoleName' => 'EntityManager', 'Description' => 'Manages entities and donations'],
            ['RoleName' => 'User', 'Description' => 'Regular user'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['RoleName' => $role['RoleName']],
                ['Description' => $role['Description']]
            );
        }
    }
    }

