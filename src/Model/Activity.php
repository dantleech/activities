<?php

namespace Activities\Model;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
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
        #[ORM\Embedded()]
        public ?Event $race,
    ) {
        $this->uuid = Uuid::uuid4();
    }
}
