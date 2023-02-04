<?php

namespace Activities\Handler;

use Activities\DTO\ActivityDTO;
use DTL\OpenApi\Attributes as Api;

class ActivitiesHandler
{
    #[Api\Description('Return all activities for the authenticated user')]
    #[Api\Path('/v1/activities/{uuid}')]
    #[Api\Param('uuid', 'UUID of the activity', in: Api\ParamIn::PATH, required: true)]
    #[Api\Response(200)]
    public function getActivity(string $uuid): ActivityDTO
    {
        return new ActivityDTO($uuid);
    }
}
