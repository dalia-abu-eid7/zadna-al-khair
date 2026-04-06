<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تعريف الأدوار الثلاثة الأساسية للنظام
        $roles = [
            [
                'RoleID' => 1,
                'RoleName' => 'Admin',
                'Description' => 'Administrator with full access'
            ],
            [
                'RoleID' => 2,
                'RoleName' => 'Charity',
                'Description' => 'Charity association users'
            ],
            [
                'RoleID' => 3,
                'RoleName' => 'Restaurant',
                'Description' => 'Restaurant and Chef users'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['RoleID' => $role['RoleID']],
                [
                    'RoleName' => $role['RoleName'],
                    'Description' => $role['Description']
                ]
            );
        }
    }
}
