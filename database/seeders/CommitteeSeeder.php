<?php

namespace Database\Seeders;

use App\Models\Committee;
use Illuminate\Database\Seeder;

class CommitteeSeeder extends Seeder
{
    /**
     * Seed the committees table with default values.
     */
    public function run(): void
    {
        foreach (Committee::defaultCommittees() as $data) {
            Committee::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description']]
            );
        }
    }
}

