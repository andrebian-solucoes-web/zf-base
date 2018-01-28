<?php

namespace User\View\Helper;

use User\Helper\UserIdentity;
use Zend\View\Helper\AbstractHelper;

/**
 * Class UserIdentity
 * @package User\View\Helper
 */
class UserIdentityViewHelper extends AbstractHelper
{
    public function __invoke($namespace = 'Application')
    {
        $userIdentity = new UserIdentity();

        return $userIdentity->getIdentity($namespace);
    }
}
