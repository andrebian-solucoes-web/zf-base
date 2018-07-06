<?php

namespace Test\BaseApplication\Controller;

use BaseApplication\Controller\IndexController;
use Doctrine\ORM\EntityManager;
use Mockery;
use User\Entity\User;
use User\Service\UserService;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class IndexControllerTest
 * @package Test\BaseApplication\Controller
 *
 * @group BaseApplication
 * @group Controller
 */
class IndexControllerTest extends AbstractHttpControllerTestCase
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

        $user = new User();

        $mockery = new Mockery();
        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findBy')->andReturn([$user]);
        $entityManager->shouldReceive('find')->andReturn($user);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService(EntityManager::class, $entityManager);

        $userService = $mockery->mock(UserService::class);
        $userService->shouldReceive('activate')->andReturn(true);
        $userService->shouldReceive('inactivate')->andReturn(true);
        $userService->shouldReceive('delete')->andReturn(true);
        $userService->shouldReceive('save')->andReturn(true);

        $serviceManager->setService(UserService::class, $userService);
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/index/index', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testInvalidRouteDoesNotCrash()
    {
        $this->dispatch('/invalid/route', 'GET');
        $this->assertResponseStatusCode(404);
    }

    public function testShowInactive()
    {
        $this->dispatch('/index/showInactive', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testView()
    {
        $this->dispatch('/index/view/1', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testActivate()
    {
        $this->dispatch('/index/activate/1', 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testInactivate()
    {
        $this->dispatch('/index/inactivate/1', 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testDelete()
    {
        $this->dispatch('/index/delete/1', 'POST');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testAddPost()
    {
        $this->dispatch('/index/add', 'POST', [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => '123456'
        ]);
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testAddGet()
    {
        $this->dispatch('/index/add', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testAddPostInvalidData()
    {
        $this->dispatch('/index/add', 'POST', [
            'name' => 'test',
            'email' => '',
            'password' => '123456'
        ]);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testEditGet()
    {
        $this->dispatch('/index/edit/1', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testEditPost()
    {
        $this->dispatch('/index/edit/1', 'POST', [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => '123456'
        ]);
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }

    public function testEditPostInvalidData()
    {
        $this->dispatch('/index/edit/1', 'POST', [
            'name' => 'test',
            'email' => '',
            'password' => '123456'
        ]);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('baseapplication');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('default');
    }
}
