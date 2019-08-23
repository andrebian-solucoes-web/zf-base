<?php

namespace BaseApplication\Repository;

/**
 * Interface AuthenticableInterface
 * @package BaseApplication\Repository
 */
interface AuthenticableInterface
{
    /**
     * @param $email
     * @param $password
     * @return \BaseApplication\Entity\AuthenticableInterface
     */
    public function findByEmailAndPassword($email, $password);
}
