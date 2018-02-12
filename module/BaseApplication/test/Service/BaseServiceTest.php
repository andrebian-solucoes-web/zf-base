<?php

namespace Test\BaseApplication\Service;

use BaseApplication\Service\BaseService;
use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit_Framework_TestCase;
use Test\BaseApplication\Service\Dummy\DummyEntity;
use Test\BaseApplication\Service\Dummy\DummyService;
use Zend\ServiceManager\ServiceManager;

/**
 * Class BaseServiceTest
 * @package Test\BaseApplication\Service
 */
class BaseServiceTest extends PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        parent::setUp();

        $mockery = new Mockery();
        $this->serviceManager = $mockery->mock(ServiceManager::class);

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getReference')->andReturn(new DummyEntity());
        $entityManager->shouldReceive('find')->andReturn(new DummyEntity());
        $entityManager->shouldReceive('persist')->andReturn($entityManager);
        $entityManager->shouldReceive('remove')->andReturn($entityManager);
        $entityManager->shouldReceive('flush')->andReturn($entityManager);

        $this->serviceManager->shouldReceive('get')
            ->withArgs([EntityManager::class])
            ->andReturn($entityManager);
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->serviceManager = null;
    }

    /**
     * @test
     */
    public function delete()
    {
        $dummy = new DummyService($this->serviceManager);
        $this->assertTrue($dummy->delete(1));
    }

    /**
     * @test
     */
    public function inactivate()
    {
        $dummy = new DummyService($this->serviceManager);
        $this->assertTrue($dummy->inactivate(1));
    }

    /**
     * @test
     */
    public function activate()
    {
        $dummy = new DummyService($this->serviceManager);
        $this->assertTrue($dummy->activate(1));
    }

    /**
     * @test
     */
    public function save()
    {
        $dummy = new DummyService($this->serviceManager);
        $this->assertNotNull($dummy->save(['id' => 1]));
        $this->assertInstanceOf(DummyEntity::class, $dummy->save(['modified' => new \DateTime()], true));
    }
}
