<?php

namespace Activities\DTO;

use Activities\Model\ActivityType;
use DateTimeImmutable;


class ActivityNewDTO
{
    public function __construct(
        public string $title,
        public DateTimeImmutable $date,
        public ActivityType $type,
        public ?int $distance,
        public ?int $time,
    ) {
    }
}
