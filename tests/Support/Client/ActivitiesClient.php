<?php

namespace Activities\Tests\Support\Client;

use Activities\DTO\ActivityDTO;
use Activities\DTO\ActivityNewDTO;

final class ActivitiesClient
{
    public function __construct(private RequestHandler $handler)
    {
    }

    public function add(ActivityNewDTO $activity): ActivityDTO
    {
        return $this->handler->post(sprintf('/v1/activities'), ActivityDTO::class, $activity);
    }

    public function get(string $uuid): ?ActivityDTO
    {
        return $this->handler->get(sprintf('/v1/activities/%s', $uuid), ActivityDTO::class);
    }
}
