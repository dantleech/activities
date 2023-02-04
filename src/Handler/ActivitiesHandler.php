<?php

namespace Activities\Handler;

use Activities\DTO\ActivityDTO;
use DTL\OpenApi\Attributes as Api;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class ActivitiesHandler
{
    #[Api\Description('Return all activities for the authenticated user')]
    #[Api\Path('/v1/activities/{uuid}')]
    #[Api\Param('uuid', 'UUID of the activity', required: true)]
    #[Api\Response(code: 200, type: 'ListResponseDTO<ActivityDTO>')]
    public function getActivity(ServerRequestInterface $request): ActivityDTO
    {
        $context = RouteContext::fromRequest($request);
        $uuid = $context->getRoute()->getArgument('uuid');

        return new ActivityDTO($uuid);
    }
}
