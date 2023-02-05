<?php

namespace Activities\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;

class OauthClient implements ClientEntityInterface
{
    public function __construct(public User $user)
    {
    }

    public function getIdentifier(): string
    {
        return $this->user->uuid->__toString();
    }

    public function getName(): string
    {
        return $this->user->username;
    }

    public function getRedirectUri(): string
    {
        return '';
    }

    public function isConfidential(): bool
    {
        return true;
    }
}
