<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationController extends Controller
{
    public function index(): ResourceCollection
    {
        return OrganizationResource::collection(Organization::with('building')->get());
    }

    public function show(Organization $organization): OrganizationResource
    {
        $organization->load('building', 'activities', 'phones');

        return new OrganizationResource($organization);
    }
}
