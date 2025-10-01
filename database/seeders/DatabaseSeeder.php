<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ActivitySeeder::class,
        ]);

        $buildings = Building::factory()->count(10)->create();

        foreach ($buildings as $building) {
            $organizations = Organization::factory(rand(1, 3))->create(['building_id' => $building->id]);

            foreach ($organizations as $org) {
                OrganizationPhone::factory(rand(1, 3))->create(['organization_id' => $org->id]);
            }
        }

        $this->call([
            ActivityOrganizationSeeder::class,
        ]);
    }
}
