<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity;
use Carbon\Carbon;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = [
            [
                'EntityName' => 'Charity Center 1',
                'EntityType' => 'NGO',
                'LicenseNumber' => '123456',
                'Address' => 'City A',
                'ContactPerson' => 'John Doe',
                'ContactEmail' => 'entity1@example.com',
                'Status' => 'Active',
                'ActivatedByUserID' => 1, // Admin
                'ActivationDate' => Carbon::now(),
            ],
            [
                'EntityName' => 'Charity Center 2',
                'EntityType' => 'NGO',
                'LicenseNumber' => '654321',
                'Address' => 'City B',
                'ContactPerson' => 'Jane Smith',
                'ContactEmail' => 'entity2@example.com',
                'Status' => 'Active',
                'ActivatedByUserID' => 1, // Admin
                'ActivationDate' => Carbon::now(),
            ],
        ];

        foreach ($entities as $entity) {
            Entity::updateOrCreate(
                ['EntityName' => $entity['EntityName']],
                $entity
            );
        }
    }
}
