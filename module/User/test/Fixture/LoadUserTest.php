<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 22:21
 */

namespace Test\User\Fixture;

use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Entity\Role;
use User\Fixture\LoadUser;

/**
 * Class LoadUserTest
 * @package Test\User\Fixture
 *
 * @group User
 * @group Fixture
 */
class LoadUserTest extends TestCase
{
    public function testLoad()
    {
        $mockery = new Mockery();
        $objectManager = $mockery->mock(EntityManager::class);
        $objectManager->shouldReceive('getRepository')->andReturn($objectManager);
        $objectManager->shouldReceive('persist')->andReturn($objectManager);
        $objectManager->shouldReceive('flush')->andReturn($objectManager);

        $role = new Role(['name' => 'Admin']);
        $objectManager->shouldReceive('findOneBy')->andReturn($role);

        $fixture = new LoadUser();
        $this->assertNull($fixture->load($objectManager));
    }

    public function testGetOrder()
    {
        $fixture = new LoadUser();
        $this->assertEquals(1, $fixture->getOrder());
        $this->assertEquals(1, $fixture->getOrder());
    }
}
