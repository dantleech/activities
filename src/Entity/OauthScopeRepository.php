<?php

namespace Activities\Entity;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * @extends EntityRepository<OauthAccessToken>
 */
class OauthScopeRepository extends EntityRepository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier): ?OauthAccessToken
    {
        return $this->find($identifier);
    }

    /**
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null): array
    {
        return [];
    }
}
