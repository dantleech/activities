<?php

namespace Activities\Entity;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use RuntimeException;

#[ORM\Entity(repositoryClass: OauthAccessTokenRepository::class)]
class OauthAccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    #[ORM\Id()]
    #[ORM\Column()]
    public string $identifier;

    #[ORM\Column()]
    public DateTimeImmutable $expiry;

    #[ORM\Column()]
    public string $userIdentifier;

    /** @var ScopeEntityInterface[] */
    #[ORM\ManyToMany(targetEntity: OauthScope::class)]
    #[ORM\JoinTable(name: 'oauth_access_token_scope')]
    #[ORM\JoinColumn(name: 'oauth_access_token_id', referencedColumnName: 'identifier')]
    #[ORM\InverseJoinColumn(name: 'scope_id', referencedColumnName: 'identifier')]
    public array $scopes = [];

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'uuid')]
    private ?User $user = null;

    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    public function setExpiryDateTime(DateTimeImmutable $dateTime): void
    {
        $this->expiry = $dateTime;
    }

    public function setUserIdentifier($identifier): void
    {
        if (!is_string($identifier)) {
            throw new RuntimeException(
                'Expected string for user identifier, did not get one',
                $identifier
            );
        }

        $this->userIdentifier = $identifier;
    }

    public function setClient(ClientEntityInterface $client): void
    {
        if (!$client instanceof OauthClient) {
            throw new RuntimeException('Was not passed expected ClientEntityInterface instance, this should not happen');
        }
        $this->user = $client->user;
    }

    public function addScope(ScopeEntityInterface $scope): void
    {
        $this->scopes[] = $scope;
    }

    public function getClient(): ClientEntityInterface
    {
        return new OauthClient($this->user);
    }

    public function getExpiryDateTime(): DateTimeImmutable
    {
        return $this->expiry;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    /**
     * @return ScopeEntityInterface[]
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
