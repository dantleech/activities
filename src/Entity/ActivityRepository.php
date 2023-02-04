<?php

namespace Activities\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @extends EntityRepository<Activity>
 */
class ActivityRepository extends EntityRepository
{
    public function add(Activity $activity): void
    {
        $this->getEntityManager()->persist($activity);
        $this->getEntityManager()->flush();
    }
}
