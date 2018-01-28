<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class JsonDecodeViewHelper
 * @package BaseApplication\View\Helper
 */
class JsonDecodeViewHelper extends AbstractHelper
{
    public function __invoke($string)
    {
        return json_decode($string);
    }
}
