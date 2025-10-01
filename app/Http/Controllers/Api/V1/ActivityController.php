<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Activity;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityController extends Controller
{
    public function organizations(Activity $activity): ResourceCollection
    {
        return OrganizationResource::collection(
            $activity->organizations()->get(),
        );
    }
}
