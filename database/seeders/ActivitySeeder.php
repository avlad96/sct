<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $level1 = Activity::factory()->count(5)->create();

        foreach ($level1 as $parent1) {
            if (fake()->boolean()) {
                $level2 = Activity::factory()->count(rand(1, 3))->create([
                    'parent_id' => $parent1->id,
                ]);

                foreach ($level2 as $parent2) {
                    if (fake()->boolean()) {
                        Activity::factory()->count(rand(1, 3))->create([
                            'parent_id' => $parent2->id,
                        ]);
                    }
                }
            }
        }
    }
}
