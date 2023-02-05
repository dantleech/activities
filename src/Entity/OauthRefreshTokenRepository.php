<?php

namespace Activities\Entity;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * @extends EntityRepository<OauthRefreshToken>
 */
class OauthRefreshTokenRepository extends EntityRepository implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken(): OauthRefreshToken
    {
        return new OauthRefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $this->getEntityManager()->persist($refreshTokenEntity);
        $this->getEntityManager()->flush();
    }

    public function revokeRefreshToken($tokenId): void
    {
        $token = $this->find($tokenId);
        if (!$token) {
            return;
        }
        $this->getEntityManager()->remove($token);
        $this->getEntityManager()->flush();
    }

    public function isRefreshTokenRevoked($tokenId): bool
    {
        return $this->find($tokenId) ? false : true;
    }
}
