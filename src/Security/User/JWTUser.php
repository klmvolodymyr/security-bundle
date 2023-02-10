<?php

namespace SecurityBundle\Security\User;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class JWTUser implements JWTUserInterface
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    public function __construct(string $userId, string $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }

    public static function createFromPayload($username, array $payload)
    {
        return new self($username, $payload['userId']);
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
    }
}