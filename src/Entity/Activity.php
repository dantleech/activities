<?php

namespace Activities\Entity;

use Activities\DTO\ActivityNewDTO;
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
        #[ORM\Column()]
        public string $title,
    ) {
        $this->uuid = Uuid::uuid4();
    }

    public static function fromNewActivity(ActivityNewDTO $newActivity)
    {
        return new self(
            title: $newActivity->title
        );
    }
}
