<?php

namespace Activities\Entity;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class OauthClientRepository implements ClientRepositoryInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getClientEntity($clientIdentifier): OauthClient
    {
        return new OauthClient($this->userRepository->mustFind($clientIdentifier));
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        return false;
    }
}
