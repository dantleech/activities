<?php

namespace Activities\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:OauthScopeRepository::class)]
class OauthScope implements ScopeEntityInterface
{
    public function __construct(
        #[ORM\Id()]
        #[ORM\Column()]
        public string $identifier
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'identifier' => $this->identifier,
        ];
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
