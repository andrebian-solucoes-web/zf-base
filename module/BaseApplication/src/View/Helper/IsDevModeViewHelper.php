<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class IsDevModeViewHelper
 * @package BaseApplication\View\Helper
 */
class IsDevModeViewHelper extends AbstractHelper
{
    public function __invoke()
    {
        return 'cli-server' == php_sapi_name();
    }
}
