<?php
declare(strict_types=1);

namespace SecurityBundle\Security\Guard;

//use ManageTeamBundle\Service\SDKProfileService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use SecurityBundle\Security\Authentication\Token\DTJWTUserToken;
use Symfony\Component\Security\Core\User\UserInterface;

class MTJWTTokenAuthenticator extends JWTTokenAuthenticator
{
    /**
     * @var SDKProfileService
     */
    private $profileService;

    /**
     * @required
     *
     * @param SDKProfileService $profileService
     *
     * @return self
     */
    public function setProfileService(SDKProfileService $profileService): self
    {
        $this->profileService = $profileService;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function createAuthenticatedToken(UserInterface $user, $providerKey)
    {
        $authToken = parent::createAuthenticatedToken($user, $providerKey);

        return new MTJWTUserToken(
            $authToken->getRoles(),
            $authToken->getUser(),
            $authToken->getCredentials(),
            $authToken->getProviderKey(),
            $this->profileService
        );
    }
}
