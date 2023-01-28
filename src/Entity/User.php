<?php

namespace Activities\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[Entity]
class User
{
    #[Id]
    #[Column(type: "uuid")]
    private UuidInterface $uuid;

    public function __construct(
        #[Column()]
        public string $username
    ) {
        $this->uuid = Uuid::uuid4();
    }
}
