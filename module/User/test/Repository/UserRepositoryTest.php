<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 23:30
 */

namespace Test\User\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Repository\UserRepository;

/**
 * Class UserRepositoryTest
 * @package Test\User\Repository
 *
 * @group User
 * @group Repository
 */
class UserRepositoryTest extends TestCase
{
    public function testFindByEmailAndPassword()
    {
        $mockery = new Mockery();
        $classMap = new ClassMetadata(User::class);

        $user = new User([
            'username' => 'test@test.com',
            'password' => '123456'
        ]);

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('findOneBy')->andReturn($user);
        $entityManager->shouldReceive('getUnitOfWork')->andReturn($entityManager);
        $entityManager->shouldReceive('getEntityPersister')->andReturn($entityManager);
        $entityManager->shouldReceive('load')->andReturn($user);

        $userRepository = new UserRepository($entityManager, $classMap);

        $result = $userRepository->findByEmailAndPassword('test@test.com', '123456');

        $this->assertNotNull($result);
    }
}
