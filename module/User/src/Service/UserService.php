<?php

namespace User\Service;

use BaseApplication\Service\BaseService;
use DateTime;
use User\Entity\User;

/**
 * Class UserService
 * @package User\Service
 */
class UserService extends BaseService
{
    /**
     * @param $userId
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function updateLastLogin($userId)
    {
        /** @var User $user */
        $user = $this->entityManager->find(User::class, $userId);
        $user->setLastLogin(new DateTime());
        $this->entityManager->flush();

        return true;
    }
}
