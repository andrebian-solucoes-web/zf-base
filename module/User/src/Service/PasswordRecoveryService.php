<?php

namespace User\Service;

use BaseApplication\Mail\Mail;
use DateTime;
use Doctrine\ORM\EntityManager;
use User\Entity\PasswordRecoveryToken;
use User\Entity\User;
use Zend\ServiceManager\ServiceManager;

/**
 * Class PasswordRecoveryService
 * @package User\Service
 */
class PasswordRecoveryService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->entityManager = $serviceManager->get(EntityManager::class);
    }

    /**
     * @param $email
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function startRecoverPassword($email)
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'username' => $email,
            'active' => true
        ]);

        if ($user) {
            $this->deactivatePreviousTokens($user);
            $token = uniqid();
            $passwordRecoveryToken = new PasswordRecoveryToken([
                'user' => $user,
                'token' => $token,
            ]);
            $this->entityManager->persist($passwordRecoveryToken);
            $this->entityManager->flush();

            /** @var Mail $emailService */
            $emailService = $this->serviceManager->get(Mail::class);

            $data = [
                'name' => $user->getName(),
                'recoveryLink' => '/admin/user/recovery-password-action?email=' . $email . '&token=' . $token
            ];

            $config = $this->serviceManager->get('config');
            $from = $config['mail']['connection_config']['from'];

            $emailService->setTo($email)
                ->setFrom($from)
                ->setSubject('Recuperação de senha')
                ->setPage('password-recovery')
                ->setData($data)
                ->prepare();

            if ($emailService->send()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     */
    private function deactivatePreviousTokens(User $user)
    {
        $previousTokens = $this->entityManager->getRepository(PasswordRecoveryToken::class)->findBy([
            'active' => true,
            'user' => $user
        ]);

        if ($previousTokens) {
            /** @var PasswordRecoveryToken $previousToken */
            foreach ($previousTokens as $previousToken) {
                $previousToken->setActive(false)->setModified(new DateTime());
                $this->entityManager->persist($previousToken);
            }
        }
    }
}
