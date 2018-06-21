<?php
/**
 * Created by PhpStorm.
 * User: andrebian
 * Date: 20/06/18
 * Time: 22:33
 */

namespace Test\User\Service;

use BaseApplication\Mail\Mail;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Mockery;
use PHPUnit\Framework\TestCase;
use User\Entity\PasswordRecoveryToken;
use User\Entity\User;
use User\Service\PasswordRecoveryService;
use Zend\ServiceManager\ServiceManager;

/**
 * Class PasswordRecoveryServiceTest
 * @package Test\User\Service
 *
 * @group User
 * @group Service
 */
class PasswordRecoveryServiceTest extends TestCase
{
    public function testStartRecoveryPasswordFail()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('findOneBy')->andReturn(null);

        $emailService = $mockery->mock(Mail::class);

        $serviceManager = $mockery->mock(ServiceManager::class);
        $serviceManager->shouldReceive('get')->withArgs([EntityManager::class])
            ->andReturn($entityManager);
        $serviceManager->shouldReceive('get')->withArgs([Mail::class])
            ->andReturn($emailService);


        $service = new PasswordRecoveryService($serviceManager);

        $this->assertFalse($service->startRecoverPassword('test@test.com'));
    }

    public function testStartRecoveryPasswordSuccess()
    {
        $mockery = new Mockery();

        $entityManager = $mockery->mock(EntityManager::class);
        $entityManager->shouldReceive('getRepository')->andReturn($entityManager);
        $entityManager->shouldReceive('persist')->andReturn($entityManager);
        $entityManager->shouldReceive('flush')->andReturn($entityManager);
        $entityManager->shouldReceive('findOneBy')->andReturn(new User([
            'username' => 'test@test.com'
        ]));

        $previousTokens = new ArrayCollection();
        $previousTokens->add(new PasswordRecoveryToken());
        $entityManager->shouldReceive('findBy')->andReturn($previousTokens);

        $emailService = $mockery->mock(Mail::class);
        $emailService->shouldReceive('setTo')->andReturn($emailService);
        $emailService->shouldReceive('setFrom')->andReturn($emailService);
        $emailService->shouldReceive('setSubject')->andReturn($emailService);
        $emailService->shouldReceive('setPage')->andReturn($emailService);
        $emailService->shouldReceive('setData')->andReturn($emailService);
        $emailService->shouldReceive('prepare')->andReturn($emailService);
        $emailService->shouldReceive('send')->andReturn(true);

        $serviceManager = $mockery->mock(ServiceManager::class);
        $serviceManager->shouldReceive('get')->withArgs([EntityManager::class])
            ->andReturn($entityManager);
        $serviceManager->shouldReceive('get')->withArgs([Mail::class])
            ->andReturn($emailService);

        $config = [
            'mail' => [
                'connection_config' => [
                    'from' => 'test@test.com.br'
                ]
            ]
        ];

        $serviceManager->shouldReceive('get')->withArgs(['config'])->andReturn($config);


        $service = new PasswordRecoveryService($serviceManager);

        $this->assertTrue($service->startRecoverPassword('test@test.com'));
    }
}
