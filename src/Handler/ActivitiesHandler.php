<?php

namespace Activities\Handler;

use Activities\DTO\ActivityDTO;
use Activities\DTO\ActivityNewDTO;
use Activities\Entity\Activity;
use Activities\Entity\ActivityRepository;
use DTL\OpenApi\Attributes as Api;

class ActivitiesHandler
{
    public function __construct(private ActivityRepository $repository)
    {
    }

    #[Api\Verbs(['GET'])]
    #[Api\Description('Return specific activity for authenticated user')]
    #[Api\Param('uuid', 'UUID of the activity', in: Api\ParamIn::PATH, required: true)]
    #[Api\Path('/v1/activities/{uuid}')]
    #[Api\Response(200)]
    public function get(string $uuid): ?ActivityDTO
    {
        $activity = $this->repository->find($uuid);

        if (!$activity) {
            return null;
        }

        return new ActivityDTO(
            $activity->uuid->__toString(),
            $activity->title
        );
    }

    #[Api\Verbs(['POST'])]
    #[Api\Description('Add an activity for the authenticated user')]
    #[Api\Path('/v1/activities')]
    #[Api\RequestBody(ActivityNewDTO::class, param: 'newActivity')]
    #[Api\Response(200)]
    public function add(ActivityNewDTO $newActivity): ActivityDTO
    {
        $activity = Activity::fromNewActivity($newActivity);
        $this->repository->add($activity);
        return ActivityDTO::fromEntity($activity);
    }
}
