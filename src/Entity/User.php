<?php

namespace Activities\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public UuidInterface $uuid;

    public function __construct(
        #[ORM\Column()]
        public string $username
    ) {
        $this->uuid = Uuid::uuid4();
    }
}
