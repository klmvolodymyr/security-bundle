<?php
declare(strict_types=1);

namespace SecurityBundle\Security\Authentication\Token;

// use ManageTeam\DTO\Profile\AbstractProfileDTO;
// use ManageTeamBundle\Service\SDKProfileService;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class MTJWTToken extends JWTUserToken
{
    /**
     * @var SDKProfileService
     */
    private $profileService;

    /**
     * @param array              $roles
     * @param UserInterface|null $user
     * @param null               $rawToken
     * @param null               $providerKey
     * @param SDKProfileService  $profileService
     */
    public function __construct(
        array $roles = [],
        UserInterface $user = null,
        $rawToken = null,
        $providerKey = null,
        SDKProfileService $profileService
    ) {
        parent::__construct($roles, $user, $rawToken, $providerKey);
        $this->profileService = $profileService;
    }

    /**
     * @param string $profileId
     *
     * @return bool
     */
    public function isProfileBelongsToUser(string $profileId): bool
    {
        foreach ($this->getProfiles() as $profile) {

            if ($profileId === $profile->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return AbstractProfileDTO[]
     */
    public function getProfiles(): array
    {
        return $this->profileService->getProfiles($this->getUser()->getUserId());
    }

    /**
     * @param string $game
     * @param string $type
     *
     * @return AbstractProfileDTO
     *
     * @throws AccessDeniedHttpException
     */
    public function getProfile(string $game, string $type): AbstractProfileDTO
    {
        try {
            return $this->profileService->getProfile($this->getUser()->getUserId(), $game, $type);
        } catch (NotFoundHttpException $ex) {
            throw new AccessDeniedHttpException(sprintf('user.not_have_%s_profile', str_replace('-', '_', $type)));
        }
    }
}