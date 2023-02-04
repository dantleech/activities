<?php

namespace Activities\Entity;

use Activities\DTO\ActivityNewDTO;
use Activities\Model\ActivityType;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public readonly UuidInterface $uuid;

    final public function __construct(
        #[ORM\Column()]
        public string $title,
        #[ORM\Column()]
        public DateTimeImmutable $date,
        #[ORM\Column()]
        public ActivityType $type,
        #[ORM\Column()]
        public int $distance,
        #[ORM\Column()]
        public int $time,
    ) {
        $this->uuid = Uuid::uuid4();
    }

    public static function fromNewActivity(ActivityNewDTO $newActivity): Activity
    {
        return new self(
            title: $newActivity->title,
            date: $newActivity->date,
            type: $newActivity->type,
            distance: $newActivity->distance,
            time: $newActivity->time,
        );
    }
}
