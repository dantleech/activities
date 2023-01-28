<?php

namespace Activities\Activities\Model;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Activity
{
    public UuidInterface $uuid;
    public string $title;
    public DateTimeImmutable $date;
    public ActivityType $type;
    public int $distance;
    public int $time;

    public ?Event $race;
    public Route $route;
}
