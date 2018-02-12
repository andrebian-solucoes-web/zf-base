<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * A JSON decoder to use with Twig Templates
 *
 * Class JsonDecodeViewHelper
 * @package BaseApplication\View\Helper
 */
class JsonDecodeViewHelper extends AbstractHelper
{
    /**
     * @param $string
     * @param bool $associativeArray
     * @return mixed
     */
    public function __invoke($string, $associativeArray = false)
    {
        return json_decode($string, $associativeArray);
    }
}
