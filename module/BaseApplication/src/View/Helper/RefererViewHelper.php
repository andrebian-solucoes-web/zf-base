<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class RefererViewHelper
 * @package BaseApplication\View\Helper
 */
class RefererViewHelper extends AbstractHelper
{
    public function __invoke()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }

        return '/';
    }
}
