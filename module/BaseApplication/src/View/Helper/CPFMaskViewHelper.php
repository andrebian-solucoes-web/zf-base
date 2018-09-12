<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 07/09/18
 * Time: 11:30
 */

namespace BaseApplication\View\Helper;

use BaseApplication\Filter\CPFMaskFilter;
use Zend\View\Helper\AbstractHelper;

class CPFMaskViewHelper extends AbstractHelper
{
    public function __invoke($cpf)
    {
        return (new CPFMaskFilter())->filter($cpf);
    }
}
