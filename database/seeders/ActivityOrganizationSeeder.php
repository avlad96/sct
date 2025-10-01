<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ActivityOrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = Organization::all();
        $rootActivities = Activity::with('children.children')->whereNull('parent_id')->get();

        foreach ($organizations as $org) {
            $assigned = [];
            $this->assignActivities($rootActivities, $assigned);
            $org->activities()->sync(array_unique($assigned));
        }
    }

    private function assignActivities(Collection $activities, array &$assigned): void
    {
        foreach ($activities as $activity) {
            if (in_array($activity->parent_id, $assigned)) {
                continue;
            }

            if (fake()->boolean(25)) {
                $assigned[] = $activity->id;

                continue;
            }

            if ($activity->children->isNotEmpty()) {
                $childrenIds = $activity->children->pluck('id')->toArray();
                $selectedChildren = fake()->randomElements(
                    $childrenIds,
                    rand(0, min(2, count($childrenIds)))
                );
                $selectedChildrenActivities = $activity->children->whereIn('id', $selectedChildren);
                $this->assignActivities($selectedChildrenActivities, $assigned);
            }
        }
    }
}
