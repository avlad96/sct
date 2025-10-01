<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrganizationByActivitySearchRequest;
use App\Http\Requests\Api\V1\OrganizationSearchRequest;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $service,
    ) {}

    #[Group('Organizations')]
    #[Authenticated]
    #[Endpoint('Список организаций', <<<'DESC'
    Получить список всех организаций.
    DESC)]
    public function index(): ResourceCollection
    {
        return OrganizationResource::collection(Organization::with('building')->get());
    }

    #[Group('Search')]
    #[Authenticated]
    #[Endpoint('Поиск организаций по названию', <<<'DESC'
    Найти организации по названию.
    DESC)]
    public function search(OrganizationSearchRequest $request): ResourceCollection
    {
        $data = $request->validated();

        $organizations = Organization::search($data['name'])->get();
        $organizations->load('building');

        return OrganizationResource::collection($organizations);
    }

    #[Group('Search')]
    #[Authenticated]
    #[Endpoint('Поиск организаций по виду деятельности', <<<'DESC'
    Найти организации, относящиеся к указанному виду деятельности или его дочерним категориям.
    DESC)]
    public function searchByActivity(OrganizationByActivitySearchRequest $request): ResourceCollection
    {
        $data = $request->validated();

        $organizations = $this->service->getOrganizationsByActivityName($data['name'])->get();

        return OrganizationResource::collection($organizations);
    }

    #[Group('Organizations')]
    #[Authenticated]
    #[Endpoint('Информация об организации', <<<'DESC'
    Получить подробную информацию об организации.
    DESC)]
    public function show(Organization $organization): OrganizationResource
    {
        $organization->load('building', 'activities', 'phones');

        return new OrganizationResource($organization);
    }
}
