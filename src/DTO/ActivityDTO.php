<?php

namespace Activities\DTO;

use Activities\Entity\Activity;

class ActivityDTO
{
    public function __construct(
        public string $uuid,
        public string $title
    ) {
    }

    public static function fromEntity(Activity $activity): self
    {
        return new self(
            $activity->uuid,
            $activity->title
        );
    }
}
