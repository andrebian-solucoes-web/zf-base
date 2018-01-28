<?php

namespace User\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

/**
 * Class UserIdentity
 * @package User\Helper
 */
class UserIdentity
{
    /**
     * @param $namespace
     * @return bool|mixed|null
     */
    public function getIdentity($namespace)
    {
        $response = false;

        $sessionStorage = new SessionStorage($namespace);
        $authService = new AuthenticationService();

        $authService->setStorage($sessionStorage);

        if ($authService->hasIdentity()) {
            $response = $authService->getIdentity();
        }

        return $response;
    }
}
