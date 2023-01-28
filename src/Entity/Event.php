<?php

namespace Activities\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable()]
class Event
{
    public function __construct(
        #[Column]
        public int $participants,
        #[Column]
        public int $position,
    ) {
    }
}
