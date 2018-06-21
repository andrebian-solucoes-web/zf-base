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
use User\Fixture\LoadRole;

/**
 * Class LoadRoleTest
 * @package Test\User\Fixture
 *
 * @group User
 * @group Fixture
 */
class LoadRoleTest extends TestCase
{
    public function testLoad()
    {
        $mockery = new Mockery();
        $objectManager = $mockery->mock(EntityManager::class);
        $objectManager->shouldReceive('persist')->andReturn($objectManager);
        $objectManager->shouldReceive('flush')->andReturn($objectManager);

        $fixture = new LoadRole();
        $this->assertNull($fixture->load($objectManager));
    }

    public function testGetOrder()
    {
        $fixture = new LoadRole();
        $this->assertEquals(0, $fixture->getOrder());
    }
}
