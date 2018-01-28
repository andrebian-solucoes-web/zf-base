<?php

namespace BaseApplication\View\Helper;

use BrazilianHelper\StateHelper;

/**
 * Class BrazilianStateHelperComboViewHelper
 * @package BaseApplication\View\Helper
 */
class BrazilianStateHelperComboViewHelper
{
    public function __invoke()
    {
        return StateHelper::getHtmlForSelectElement();
    }
}
