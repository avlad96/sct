<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\OrganizationByActivitySearchRequest;
use App\Http\Requests\Api\V1\OrganizationSearchRequest;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationController extends Controller
{
    public function __construct(
        protected OrganizationService $service,
    ) {}

    public function index(): ResourceCollection
    {
        return OrganizationResource::collection(Organization::with('building')->get());
    }

    public function search(OrganizationSearchRequest $request): ResourceCollection
    {
        $data = $request->validated();

        $organizations = Organization::search($data['name'])->get();
        $organizations->load('building');

        return OrganizationResource::collection($organizations);
    }

    public function searchByActivity(OrganizationByActivitySearchRequest $request): ResourceCollection
    {
        $data = $request->validated();

        $organizations = $this->service->getOrganizationsByActivityName($data['name'])->get();

        return OrganizationResource::collection($organizations);
    }

    public function show(Organization $organization): OrganizationResource
    {
        $organization->load('building', 'activities', 'phones');

        return new OrganizationResource($organization);
    }
}
