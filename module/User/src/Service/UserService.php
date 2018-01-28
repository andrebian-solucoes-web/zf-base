<?php

namespace User\Service;

use DateTime;
use Doctrine\ORM\EntityManager;
use User\Entity\User;

/**
 * Class UserService
 * @package User\Service
 */
class UserService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        $user = $this->entityManager->getReference(User::class, $id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param $userId
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
    }
}
