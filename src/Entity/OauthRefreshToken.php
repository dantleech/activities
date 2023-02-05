<?php

namespace Activities\Entity;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:OauthRefreshTokenRepository::class)]
class OauthRefreshToken implements RefreshTokenEntityInterface
{
    #[ORM\Id()]
    #[ORM\Column()]
    public string $identifier;

    #[ORM\Column()]
    public DateTimeImmutable $expiry;

    #[ORM\ManyToOne(targetEntity: OauthAccessToken::class)]
    #[ORM\JoinColumn(name: 'accessToken', referencedColumnName: 'identifier')]
    private AccessTokenEntityInterface $accessToken;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getExpiryDateTime(): DateTimeImmutable
    {
        return $this->expiry;
    }

    public function setExpiryDateTime(DateTimeImmutable $dateTime): void
    {
        $this->expiry = $dateTime;
    }

    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): AccessTokenEntityInterface
    {
        return $this->accessToken;
    }
}
