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

    /**
     * @param string $userId
     * @param string $username
     */
    public function __construct(string $userId, string $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromPayload($username, array $payload)
    {
        return new self($username, $payload['userId']);
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
    }
}