<?php

namespace BaseApplication\View\Helper;

use User\Assets\SessionNamespace;
use User\Helper\UserIdentity;
use Zend\View\Helper\AbstractHelper;

/**
 * Class AuthUserViewHelper
 * @package BaseApplication\View\Helper
 */
class AuthUserViewHelper extends AbstractHelper
{
    /**
     * @return bool|mixed|null
     */
    public function __invoke()
    {
        $userIdentity = new UserIdentity();
        return $userIdentity->getIdentity(SessionNamespace::NAME);
    }
}
