<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 15/06/18
 * Time: 00:01
 */

namespace Test\User\Controller;

use Doctrine\ORM\EntityManager;
use Mockery;
use User\Controller\AdminPasswordRecoveryController;
use User\Controller\PasswordRecoveryController;
use User\Entity\PasswordRecoveryToken;
use User\Entity\User;
use User\Service\PasswordRecoveryService;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class PasswordRecoveryControllerTest
 * @package Test\User\Controller
 *
 * @group User
 * @group Controller
 */
class PasswordRecoveryControllerTest extends AbstractHttpControllerTestCase
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

        $passwordRecoveryToken = new PasswordRecoveryToken([
            'user' => new User([
                'username' => 'test@test.com'
            ])
        ]);

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findOneBy')->andReturn($passwordRecoveryToken);
        $entityManager->shouldReceive('persist')->andReturn($passwordRecoveryToken);
        $entityManager->shouldReceive('flush')->andReturn($passwordRecoveryToken);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService(EntityManager::class, $entityManager);

        $passwordService = $mockery->mock(PasswordRecoveryService::class);
        $passwordService->shouldReceive('startRecoverPassword')->andReturn(true);

        $serviceManager->setService(PasswordRecoveryService::class, $passwordService);
    }

    public function testIndexActionGet()
    {
        $this->dispatch('/password-recovery', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('password-recovery');
    }

    public function testIndexActionPost()
    {
        $this->dispatch('/password-recovery', 'POST', ['email' => 'test@test.com']);
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('password-recovery');
    }

    public function testRecoverPasswordActionGetInvalidEmail()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findOneBy')->andReturn(new PasswordRecoveryToken([
            'user' => new User([
                'username' => 'test2@test.com'
            ])
        ]));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService(EntityManager::class, $entityManager);

        $this->dispatch('/recovery-password-action?email=test@test.com&token=12345', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('recovery-password-action');
    }

    public function testRecoverPasswordActionGetInvalidToken()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);

        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findOneBy')->andReturn(false);

        $serviceManager->setService(EntityManager::class, $entityManager);

        $this->dispatch('/recovery-password-action?email=test@test.com&token=12345', 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('recovery-password-action');
    }

    public function testRecoverPasswordActionPostWithoutAllParams()
    {
        $this->dispatch('/recovery-password-action?email=test@test.com&token=12345', 'POST', [
            'password' => '123467'
        ]);
        $this->assertResponseStatusCode(302);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('recovery-password-action');
    }

    public function testRecoverPasswordActionPost()
    {
        $this->dispatch('/recovery-password-action?email=test@test.com&token=12345', 'POST', [
            'password' => '123467',
            'password-confirmation' => '123467'
        ]);

        $this->assertResponseStatusCode(302);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('recovery-password-action');
    }

    public function testErrorAction()
    {
        $this->dispatch('/password-recovery-error', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('User');
        $this->assertControllerName(PasswordRecoveryController::class);
        $this->assertMatchedRouteName('password-recovery-error');
    }
}
