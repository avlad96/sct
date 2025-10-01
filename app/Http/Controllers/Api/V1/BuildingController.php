<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\BuildingRadiusSearchRequest;
use App\Http\Resources\Api\V1\BuildingResource;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Building;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

class BuildingController extends Controller
{
    #[Group('Organizations')]
    #[Authenticated]
    #[Endpoint('Список организаций в здании', <<<'DESC'
    Получить список организаций, находящихся в данном здании.
    DESC)]
    public function organizations(Building $building): ResourceCollection
    {
        return OrganizationResource::collection(
            $building->organizations()->get(),
        );
    }

    #[Group('Search')]
    #[Authenticated]
    #[Endpoint('Поиск организаций по радиусу', <<<'DESC'
    Найти организации, которые находятся в зданиях в заданном радиусе относительно указанной точки на карте.
    DESC)]
    public function searchByRadius(BuildingRadiusSearchRequest $request): ResourceCollection
    {
        $data = $request->validated();
        $radius = $data['radius'] ?? 1000;

        $results = Building::searchByRadius($data['lat'], $data['lon'], $radius)->get();
        $results->load('organizations');

        return BuildingResource::collection($results);
    }
}
