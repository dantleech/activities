<?php

namespace Activities\Handler;

use Activities\DTO\ActivityDTO;
use Activities\Entity\ActivityRepository;
use DTL\OpenApi\Attributes as Api;
use Ramsey\Uuid\Uuid;

class ActivitiesHandler
{
    public function __construct(private ActivityRepository $repository) {
    }
    #[Api\Description('Return specific activity for authenticated user')]
    #[Api\Path('/v1/activities/{uuid}')]
    #[Api\Param('uuid', 'UUID of the activity', in: Api\ParamIn::PATH, required: true)]
    #[Api\Response(200)]
    public function getActivity(string $uuid): ?ActivityDTO
    {
        $activity = $this->repository->find(Uuid::uuid4($uuid));

        if (!$activity) {
            return null;
        }

        return new ActivityDTO($uuid);
    }
}
