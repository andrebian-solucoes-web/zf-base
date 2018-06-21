<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 23:39
 */

namespace Test\User\Auth;

use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Auth\Adapter;
use User\Entity\User;
use Zend\Authentication\Result;

/**
 * Class AdapterTest
 * @package Test\User\Auth
 *
 * @group User
 * @group Auth
 */
class AdapterTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);
        $adapter = new Adapter($entityManager);

        $adapter->setUsername('test@teste.com');
        $adapter->setPassword('1234456');

        $this->assertNotNull($adapter->getPassword());
        $this->assertNotNull($adapter->getUsername());
    }

    public function testAuthenticate()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findByEmailAndPassword')->andReturn(new User());

        $adapter = new Adapter($entityManager);
        $adapter->setUsername('test@teste.com');
        $adapter->setPassword('1234456');

        $result = $adapter->authenticate();

        $this->assertNotNull($result);
        $this->assertInstanceOf(Result::class, $result);
    }
}
