<?php

namespace Activities\Entity;

use Doctrine\ORM\EntityRepository;
use RuntimeException;

/**
 * @extends EntityRepository<User>
 */
class UserRepository extends EntityRepository
{
    public function add(User $activity): void
    {
        $this->getEntityManager()->persist($activity);
        $this->getEntityManager()->flush();
    }

    public function mustFind(string $id): User
    {
        $user = $this->find($id);
        if (null === $user) {
            throw new RuntimeException(sprintf(
                'Could not find user with ID "%s"',
                $id
            ));
        }
        return $user;
    }
}
