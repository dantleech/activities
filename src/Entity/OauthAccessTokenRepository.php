<?php

namespace Activities\Entity;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * @extends EntityRepository<OauthAccessToken>
 */
class OauthAccessTokenRepository extends EntityRepository implements AccessTokenRepositoryInterface
{
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null): OauthAccessToken
    {
        $token = new OauthAccessToken();
        $token->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $token->addScope($scope);
        }
        return $token;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $this->getEntityManager()->persist($accessTokenEntity);
        $this->getEntityManager()->flush();
    }

    public function revokeAccessToken($tokenId): void
    {
        $token = $this->find($tokenId);
        if (!$token) {
            return;
        }
        $this->getEntityManager()->remove($token);
        $this->getEntityManager()->flush();
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
        return $this->find($tokenId) ? false : true;
    }
}
