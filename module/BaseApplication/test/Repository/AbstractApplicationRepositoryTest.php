<?php

namespace Test\BaseApplication\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Entity\Role;
use User\Entity\User;
use User\Repository\UserRepository;

/**
 * Class AbstractApplicationRepositoryTest
 * @package Test\BaseApplication\Repository
 */
class AbstractApplicationRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function countActive()
    {
        $mockery = new Mockery();
        $classMap = new ClassMetadata(User::class);

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getConfiguration')->andReturn($entityManager);
        $entityManager->shouldReceive('getDefaultQueryHints')->andReturn($entityManager);
        $entityManager->shouldReceive('isSecondLevelCacheEnabled')->andReturn(false);
        $entityManager->shouldReceive('getQueryCacheImpl')->andReturn($entityManager);
        $entityManager->shouldReceive('createQuery')->andReturn($entityManager);
        $entityManager->shouldReceive('getSingleScalarResult')->andReturn(1);

        $userRepository = new UserRepository($entityManager, $classMap);

        $this->assertEquals(1, $userRepository->countActive());
    }

    /**
     * @test
     */
    public function search()
    {
        $mockery = new Mockery();
        $classMap = new ClassMetadata(User::class);

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('createQueryBuilder')->andReturn($entityManager);
        $entityManager->shouldReceive('select')->andReturn($entityManager);
        $entityManager->shouldReceive('from')->andReturn($entityManager);
        $entityManager->shouldReceive('where')->andReturn($entityManager);
        $entityManager->shouldReceive('setParameter')->andReturn($entityManager);
        $entityManager->shouldReceive('expr')->andReturn($entityManager);
        $entityManager->shouldReceive('literal')->andReturn($entityManager);
        $entityManager->shouldReceive('like')->andReturn($entityManager);
        $entityManager->shouldReceive('andWhere')->andReturn($entityManager);
        $entityManager->shouldReceive('getQuery')->andReturn($entityManager);
        $entityManager->shouldReceive('add')->andReturn($entityManager);
        $entityManager->shouldReceive('getResult')->andReturn([new User(['name' => 'Andre'])]);

        $userRepository = new UserRepository($entityManager, $classMap);

        $this->assertNotNull($userRepository->search(
            [
                'name' => 'Andre',
                'role' => new Role(['id' => 1])
            ],
            ['name' => 'ASC']
        ));
    }
}
