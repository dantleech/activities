<?php

namespace Activities\Tests\Api;

use Activities\DTO\ActivityNewDTO;
use Activities\Model\ActivityType;
use Activities\Tests\IntegrationTestCase;
use DateTimeImmutable;

class ActivitiesTest extends IntegrationTestCase
{
    public function testAddAndGetActivity(): void
    {
        $activity = $this->apiClient()->activities()->add(
            new ActivityNewDTO(
                title: 'my activity',
                date: new DateTimeImmutable('2023-01-01T00:00:00+00:00'),
                type: ActivityType::RUN,
                distance: 100,
                time: 3600,
            )
        );

        self::assertEquals('my activity', $activity->title);

        $activity = $this->apiClient()->activities()->get(
            $activity->uuid
        );

        self::assertEquals('my activity', $activity->title);
    }
}
