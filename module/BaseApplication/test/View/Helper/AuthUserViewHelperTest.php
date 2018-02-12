<?php

namespace Test\BaseApplication\View\Helper;

use BaseApplication\View\Helper\AuthUserViewHelper;
use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit_Framework_TestCase;
use User\Assets\SessionNamespace;
use User\Auth\Adapter;
use User\Entity\User;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

/**
 * Class AuthUserViewHelperTest
 * @package Test\BaseApplication\View\Helper
 */
class AuthUserViewHelperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function invoke()
    {
        // Performing login previously
        $auth = new AuthenticationService();
        $sessionStorage = new SessionStorage(SessionNamespace::NAME);
        $auth->setStorage($sessionStorage);

        $mockery = new Mockery();
        $user = new User([
            'username' => 'user@email.com',
            'name' => 'Andre'
        ]);

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findByEmailAndPassword')->andReturn($user);


        /** @var Adapter $authAdapter */
        $authAdapter = new Adapter($entityManager);
        $authAdapter->setUsername('user@email.com')->setPassword('12345');

        $result = $auth->authenticate($authAdapter);
        if ($result->isValid()) {
            $authUser = $auth->getIdentity()['user'];
            $sessionStorage->write($authUser);
        }

        $viewHelper = new AuthUserViewHelper();

        $this->assertNotNull($viewHelper());
        $this->assertInternalType('array', $viewHelper());
        $this->assertArrayHasKey('name', $viewHelper());
        $this->assertEquals('Andre', $viewHelper()['name']);
    }
}
