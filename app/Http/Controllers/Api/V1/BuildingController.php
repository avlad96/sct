<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\BuildingRadiusSearchRequest;
use App\Http\Resources\Api\V1\BuildingResource;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Building;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BuildingController extends Controller
{
    public function organizations(Building $building): ResourceCollection
    {
        return OrganizationResource::collection(
            $building->organizations()->get(),
        );
    }

    public function searchByRadius(BuildingRadiusSearchRequest $request): ResourceCollection
    {
        $data = $request->validated();
        $radius = $data['radius'] ?? 1000;

        $results = Building::searchByRadius($data['lat'], $data['lon'], $radius)->get();
        $results->load('organizations');

        return BuildingResource::collection($results);
    }
}
