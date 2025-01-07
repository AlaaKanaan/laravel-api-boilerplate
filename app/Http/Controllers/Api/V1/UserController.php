<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Responsable;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

class UserController extends JsonApiController
{

    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;


    /**
     * get authenticated user
     *
     * @return Responsable
     */
    public function me(): Responsable
    {
        return new DataResponse(request()->user());
    }
}
