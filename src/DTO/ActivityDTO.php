<?php

namespace Activities\DTO;

use Activities\Entity\Activity;
use Activities\Model\ActivityType;
use DateTimeImmutable;

class ActivityDTO
{
    public function __construct(
        public string $uuid,
        public string $title,
        public DateTimeImmutable $date,
        public ActivityType $type,
        public int $distance,
        public int $time,
    ) {
    }

    public static function fromEntity(Activity $activity): self
    {
        return new self(
            $activity->uuid,
            $activity->title,
            $activity->date,
            $activity->type,
            $activity->distance,
            $activity->time,
        );
    }
}
