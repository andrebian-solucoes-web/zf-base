<?php

namespace BaseApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class CpfViewHelper
 * @package BaseApplication\View\Helper
 */
class CpfViewHelper extends AbstractHelper
{
    public function __invoke($string)
    {
        $cpf = substr($string, 0, 3) . '.' . substr($string, 3, 3);
        $cpf .= '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);

        return $cpf;
    }
}
