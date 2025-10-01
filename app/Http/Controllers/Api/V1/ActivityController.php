<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\OrganizationResource;
use App\Models\Activity;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

class ActivityController extends Controller
{
    #[Group('Organizations')]
    #[Authenticated]
    #[Endpoint('Список организаций по виду деятельности', <<<'DESC'
    Получить список организаций, относящихся к конкретному виду деятельности.
    DESC)]
    public function organizations(Activity $activity): ResourceCollection
    {
        return OrganizationResource::collection(
            $activity->organizations()->get(),
        );
    }
}
