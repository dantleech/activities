<?php

namespace Activities\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable()]
class Event
{
    #[Column]
    public int $participants;

    #[Column]
    public int $position;
}
