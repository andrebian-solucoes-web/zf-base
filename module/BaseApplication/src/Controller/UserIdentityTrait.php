<?php

namespace BaseApplication\Controller;

use User\Assets\SessionNamespace;
use User\Entity\User;
use User\Helper\UserIdentity;

/**
 * Trait UserIdentityTrait
 * @package BaseApplication\Controller
 */
trait UserIdentityTrait
{
    use EntityManagerTrait;

    /**
     * @return null|object|User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getLoggedUser()
    {
        $userIdentity = new UserIdentity();
        $userData = $userIdentity->getIdentity(SessionNamespace::NAME);
        $user = $this->getEntityManager()->find(User::class, $userData['id']);

        return $user;
    }
}
