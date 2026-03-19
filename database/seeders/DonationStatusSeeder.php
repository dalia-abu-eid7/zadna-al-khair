<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DonationStatus;
class DonationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['StatusName' => 'Pending', 'StatusDescription' => 'Waiting for approval'],
            ['StatusName' => 'Accepted', 'StatusDescription' => 'Donation approved'],
            ['StatusName' => 'Rejected', 'StatusDescription' => 'Donation rejected'],
        ];

        foreach ($statuses as $status) {
            DonationStatus::updateOrCreate(
                ['StatusName' => $status['StatusName']],
                ['StatusDescription' => $status['StatusDescription']]
            );
        }
    }
}
