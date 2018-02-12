<?php

namespace Test\BaseApplication\Controller;

use BaseApplication\Controller\IndexController;
use BaseApplication\Controller\SearchController;
use Doctrine\ORM\EntityManager;
use Exception;
use Mockery;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class SearchControllerTest
 * @package Test\BaseApplication\Controller
 */
class SearchControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        require_once __DIR__ . '/../../../../config/constants.php';

        parent::setUp();

        $mockery = new Mockery();
        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('search')->andReturn(['test' => 'ok']);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService(EntityManager::class, $entityManager);
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/search?repository=User\\Entity\\User', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(SearchController::class); // as specified in router's controller name alias
        $this->assertControllerClass('SearchController');
        $this->assertMatchedRouteName('search');
    }

    /**
     * @expectedException
     */
    public function testException()
    {
        $this->dispatch('/search?repository=User\\Entity\\Users', 'GET');
    }
}
