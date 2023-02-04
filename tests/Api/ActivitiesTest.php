<?php

namespace Activities\Tests\Api;

use Activities\DTO\ActivityNewDTO;
use Activities\Tests\IntegrationTestCase;

class ActivitiesTest extends IntegrationTestCase
{
    public function testAddAndGetActivity(): void
    {
        $activity = $this->apiClient()->activities()->add(
            new ActivityNewDTO('my activity')
        );

        self::assertEquals('my activity', $activity->title);

        $activity = $this->apiClient()->activities()->get(
            $activity->uuid
        );

        self::assertEquals('my activity', $activity->title);
    }
}
