<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

class OrganizationService
{
    public function getOrganizationsByActivityName(string $activityName): Builder
    {
        $activities = Activity::search($activityName)->get();

        $activityIds = collect();
        foreach ($activities as $activity) {
            $activityIds = $activityIds->merge($this->collectActivityIds($activity));
        }

        $activityIds = $activityIds->unique()->values()->toArray();

        return Organization::whereHas('activities', function ($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->with(['building', 'activities']);
    }

    private function collectActivityIds(Activity $activity): array
    {
        $ids = [$activity->id];

        if ($activity->children->isNotEmpty()) {
            foreach ($activity->children as $child) {
                $ids = array_merge($ids, $this->collectActivityIds($child));
            }
        }

        return $ids;
    }
}
