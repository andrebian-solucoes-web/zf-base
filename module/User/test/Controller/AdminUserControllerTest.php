<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 15/06/18
 * Time: 00:01
 */

namespace Test\User\Controller;

use User\Controller\AdminUserController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class AdminUserControllerTest
 * @package Test\User\Controller
 *
 * @group User
 * @group Controller
 */
class AdminUserControllerTest extends AbstractHttpControllerTestCase
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

//        $serviceManager = $this->getApplicationServiceLocator();
//        $serviceManager->setAllowOverride(true);
//        $serviceManager->setService(EntityManager::class, $entityManager);
    }

    public function testIndexAction()
    {
        $this->dispatch('/admin/userr', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('User');
        $this->assertControllerName(AdminUserController::class);
        $this->assertMatchedRouteName('admin-user');
    }
}
