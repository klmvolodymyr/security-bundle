<?php

namespace SecurityBundle\TestCase\Traits;

use VolodymyrKlymniuk\SfFunctionalTest\FunctionalTest\Tester\ApiTester;
use SecurityBundle\Security\User\JWTUser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method ApiTester createTester()
 */
trait SecurityTrait
{
    /**
     * @param string $userId
     *
     * @return string
     */
    public function getAuthToken(string $userId = '1'): string
    {
        $user = new JWTUser($userId, $userId);
        $jwtManager = $this->getContainer()->get('jwt_token_manager');

        return $jwtManager->create($user);
    }

    /**
     * @dataProvider checkPermissionFailedProvider
     *
     * @param string $path
     * @param string $method
     * @param array  $data
     */
    public function testCheckPermissionFailed(string $path, string $method = Request::METHOD_GET, array $data = [])
    {
        $this
            ->createTester()
            ->setExpectedStatusCode(Response::HTTP_UNAUTHORIZED)
            ->sendRequest($method, $path, $data);
    }

    /**
     * @return ContainerInterface
     */
    abstract public function getContainer(): ContainerInterface;
}