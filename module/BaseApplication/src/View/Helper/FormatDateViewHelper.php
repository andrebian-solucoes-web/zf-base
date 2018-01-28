<?php

namespace BaseApplication\View\Helper;

use DateTime;
use Zend\View\Helper\AbstractHelper;

/**
 * Class FormatDateViewHelper
 * @package BaseApplication\View\Helper
 */
class FormatDateViewHelper extends AbstractHelper
{
    public function __invoke($datetimeString, $pattern = 'd/m/Y')
    {
        $datetime = new DateTime($datetimeString);

        return $datetime->format($pattern);
    }
}
