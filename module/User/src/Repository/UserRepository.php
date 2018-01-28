<?php

namespace User\Repository;

use Application\Repository\AbstractApplicationRepository;

/**
 * Class UserRepository
 * @package User\Entity
 */
class UserRepository extends AbstractApplicationRepository
{
    /**
     * @param $username
     * @param $password
     *
     * @return null
     */
    public function findByEmailAndPassword($username, $password)
    {
        $user = $this->findOneBy(['username' => $username, 'active' => true]);
        $result = null;

        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $result = $user;
            }
        }

        return $result;
    }
}
