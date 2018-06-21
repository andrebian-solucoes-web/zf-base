<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 23:24
 */

namespace Service;

use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Service\UserService;
use Zend\ServiceManager\ServiceManager;

/**
 * Class UserServiceTest
 * @package Service
 *
 * @group User
 * @group Service
 */
class UserServiceTest extends TestCase
{
    public function testUpdateLastLogin()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('find')->andReturn(new User());
        $entityManager->shouldReceive('flush')->andReturn($entityManager);

        $serviceManager = $mockery->mock(ServiceManager::class);
        $serviceManager->shouldReceive('get')->withArgs([EntityManager::class])
            ->andReturn($entityManager);

        $userService = new UserService($serviceManager);

        $this->assertTrue($userService->updateLastLogin(1));
    }
}
