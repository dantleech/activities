<?php

namespace Activities\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
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
        #[ManyToOne(targetEntity: User::class)]
        #[JoinColumn(name: 'user_uuid', referencedColumnName: 'uuid')]
        public User $user,
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
